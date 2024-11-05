<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Property;
use App\Models\User;
use App\Models\ListingAgreement;
use App\Models\PurchaseAgreement;
use App\Models\PropertyDisclosure;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\AppointmentConfirmation;
use App\Mail\AppointmentRescheduled;
use Illuminate\Support\Facades\Auth;
use App\Mail\NewAppointmentNotification;

class AppointmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['create', 'getAvailableTimeSlots']);
    }

    public function create()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please sign up or login to book an appointment.');
        }

        $properties = Property::all();
        return view('appointments.create', compact('properties'));
    }

    public function store(Request $request)
    {
        try {
            // Validate the incoming request
            $validatedData = $request->validate([
                'property_id' => 'required|exists:properties,id',
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'nullable|string|max:20',
                'appointment_date' => 'required|date|after:now',
                'notes' => 'nullable|string|max:1000',
            ]);

            // Parse and format the appointment date
            $validatedData['appointment_date'] = Carbon::parse($validatedData['appointment_date']);

            // Check if the time slot is available
            $existingAppointment = Appointment::where('appointment_date', $validatedData['appointment_date'])
                ->first();

            if ($existingAppointment) {
                return back()
                    ->withInput()
                    ->with('error', 'This time slot is already booked. Please select another time.');
            }

            // Add user information
            $validatedData['user_id'] = Auth::id();
            $validatedData['status'] = 'pending';

            // Create the appointment
            $appointment = Appointment::create($validatedData);

            // Get agents and admin users with proper user_type values
            $agentUsers = User::whereIn('user_type', ['agent1', 'agent2', 'admin'])->get();

            // Send notification emails to agents and admin if they exist
            if ($agentUsers->count() > 0) {
                foreach ($agentUsers as $agent) {
                    try {
                        Mail::to($agent->email)->send(new AppointmentConfirmation($appointment));
                    } catch (\Exception $e) {
                        \Log::error('Failed to send agent notification email: ' . $e->getMessage());
                    }
                }
            }

            // Send confirmation email to the user
            try {
                Mail::to($appointment->email)->send(new AppointmentConfirmation($appointment));
            } catch (\Exception $e) {
                \Log::error('Failed to send appointment confirmation email: ' . $e->getMessage());
            }

            return redirect()->route('home')->with('success', 'Appointment booked successfully!');

        } catch (\Exception $e) {
            \Log::error('Appointment booking error: ' . $e->getMessage());
            return back()
                ->withInput()
                ->with('error', 'Failed to book appointment. Please try again.');
        }
    }


    public function userSubmittedForms()
    {
        $user = Auth::user();

        // Get appointments based on user type
        if (in_array($user->user_type, ['admin', 'agent1', 'agent2'])) {
            // Admin and agents can see all appointments
            $appointments = Appointment::with(['property', 'user'])
                                    ->latest('created_at')
                                    ->paginate(10);
        } else {
            // Regular users only see their own appointments
            $appointments = Appointment::with(['property'])
                                    ->where('user_id', $user->id)
                                    ->latest('created_at')
                                    ->paginate(10);
        }

        return view('user.submitted_forms', compact('appointments'));
    }
    public function updateStatus(Request $request, Appointment $appointment)
    {
        if (!$this->canModifyAppointment($appointment)) {
            return back()->with('error', 'Unauthorized to modify this appointment');
        }

        try {
            $validatedData = $request->validate([
                'status' => 'required|in:pending,confirmed,cancelled,completed'
            ]);

            $appointment->update([
                'status' => $validatedData['status'],
                'updated_at' => now()
            ]);

            // Send status update notification to user
            try {
                Mail::to($appointment->email)->send(new AppointmentRescheduled($appointment));
            } catch (\Exception $e) {
                \Log::error('Failed to send status update email: ' . $e->getMessage());
            }

            // Notify agents and admin of the status change
            if (in_array($validatedData['status'], ['confirmed', 'cancelled'])) {
                $agentUsers = User::whereIn('user_type', ['agent1', 'agent2', 'admin'])->get();
                foreach ($agentUsers as $agent) {
                    try {
                        Mail::to($agent->email)->send(new AppointmentRescheduled($appointment));
                    } catch (\Exception $e) {
                        \Log::error("Failed to send status update to agent {$agent->email}: " . $e->getMessage());
                    }
                }
            }

            return back()->with('success', 'Appointment status updated successfully');
        } catch (\Exception $e) {
            \Log::error('Status update error: ' . $e->getMessage());
            return back()->with('error', 'Failed to update appointment status');
        }
    }

    public function destroy(Appointment $appointment)
    {
        if (Auth::user()->user_type !== 'admin') {
            return back()->with('error', 'Only administrators can delete appointments');
        }

        try {
            // Notify user of deletion
            try {
                Mail::to($appointment->email)->send(NewAppointmentRescheduled($appointment));
            } catch (\Exception $e) {
                \Log::error('Failed to send deletion notification: ' . $e->getMessage());
            }

            $appointment->delete();
            return back()->with('success', 'Appointment deleted successfully');
        } catch (\Exception $e) {
            \Log::error('Appointment deletion error: ' . $e->getMessage());
            return back()->with('error', 'Failed to delete appointment');
        }
    }

    private function canModifyAppointment(Appointment $appointment)
    {
        $user = Auth::user();

        if ($user->user_type === 'admin') return true;
        if (in_array($user->user_type, ['agent1', 'agent2'])) return true;
        return $appointment->user_id === $user->id;
    }

    public function getAvailableTimeSlots(Request $request)
    {
        $date = Carbon::parse($request->date);

        // Get booked slots
        $bookedSlots = Appointment::whereDate('appointment_date', $date->toDateString())
            ->pluck('appointment_date')
            ->map(fn($slot) => Carbon::parse($slot)->format('H:i'))
            ->toArray();

        // Generate available slots (9 AM to 5 PM)
        $availableSlots = [];
        $startTime = Carbon::parse($date)->setHour(9)->setMinute(0);
        $endTime = Carbon::parse($date)->setHour(17)->setMinute(0);

        while ($startTime <= $endTime) {
            $timeSlot = $startTime->format('H:i');
            if (!in_array($timeSlot, $bookedSlots)) {
                $availableSlots[] = $timeSlot;
            }
            $startTime->addHour();
        }

        return response()->json(['success' => true, 'slots' => $availableSlots]);
    }
}
