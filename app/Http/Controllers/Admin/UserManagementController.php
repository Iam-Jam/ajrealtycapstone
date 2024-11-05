<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserManagementController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }

    /**
     * Display a listing of all users.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $users = User::latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for editing a user.
     *
     * @param User $user
     * @return \Illuminate\View\View
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified user.
     *
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'user_type' => 'required|in:admin,agent1,agent2,employee,seller,buyer,renter,viewer',
        ]);

        try {
            $user->update($validated);

            Log::info('User updated successfully', [
                'user_id' => $user->id,
                'admin_id' => auth()->id()
            ]);

            return redirect()->route('admin.users.index')
                           ->with('success', 'User updated successfully');
        } catch (\Exception $e) {
            Log::error('Failed to update user', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
                'admin_id' => auth()->id()
            ]);

            return back()->with('error', 'Failed to update user. ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified user.
     *
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user)
    {
        try {
            $user->delete();

            Log::info('User deleted successfully', [
                'deleted_user_id' => $user->id,
                'admin_id' => auth()->id()
            ]);

            return redirect()->route('admin.users.index')
                           ->with('success', 'User deleted successfully');
        } catch (\Exception $e) {
            Log::error('Failed to delete user', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
                'admin_id' => auth()->id()
            ]);

            return back()->with('error', 'Failed to delete user. ' . $e->getMessage());
        }
    }
}
