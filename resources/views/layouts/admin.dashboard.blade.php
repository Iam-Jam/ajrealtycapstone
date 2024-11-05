@extends('layouts.admin')

@section('content')
    <div class="container mx-auto">
        <h1 class="text-2xl font-bold mb-4">Admin Dashboard</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <!-- Dashboard Widgets/Cards -->
            <div class="bg-white shadow rounded-lg p-4">
                <h2 class="text-xl font-semibold mb-2">Total Users</h2>
                <p class="text-4xl font-bold">{{ $totalUsers }}</p>
            </div>

            <!-- More Dashboard Widgets/Cards -->
            <!-- ... -->
        </div>

        <!-- Recent Activity or Listings Table -->
        <div class="bg-white shadow rounded-lg mt-8">
            <div class="p-4">
                <h2 class="text-xl font-semibold mb-4">Recent Activity</h2>
                <table class="w-full">
                    <thead>
                        <tr>
                            <th class="px-4 py-2">User</th>
                            <th class="px-4 py-2">Action</th>
                            <th class="px-4 py-2">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($recentActivities as $activity)
                            <tr>
                                <td class="px-4 py-2">{{ $activity->user->name }}</td>
                                <td class="px-4 py-2">{{ $activity->action }}</td>
                                <td class="px-4 py-2">{{ $activity->created_at->format('m/d/Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
