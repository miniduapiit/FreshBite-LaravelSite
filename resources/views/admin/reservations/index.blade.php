@extends('layouts.admin')

@section('content')
<div class="mb-6 flex items-center justify-between">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Reservations Management</h1>
        <p class="text-gray-600 mt-1">View and manage table reservations</p>
    </div>
    <a href="{{ route('admin.reservations.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-yellow-500 to-orange-500 text-white rounded-lg font-semibold hover:from-yellow-600 hover:to-orange-600 transition-all shadow-lg">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        New Reservation
    </a>
</div>

@if(session('success'))
    <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
        {{ session('success') }}
    </div>
@endif

<div class="bg-white rounded-2xl shadow-sm border border-gray-200">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Customer</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Contact</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Date & Time</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Table</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Guests</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($reservations as $reservation)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-orange-400 to-yellow-500 rounded-full flex items-center justify-center text-white font-semibold">
                                {{ substr($reservation->name, 0, 1) }}
                            </div>
                            <div>
                                <div class="font-medium text-gray-900">{{ $reservation->name }}</div>
                                @if($reservation->user)
                                    <div class="text-xs text-gray-500">Customer ID: #{{ $reservation->user->id }}</div>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm">
                            <div class="text-gray-900">{{ $reservation->email }}</div>
                            <div class="text-gray-500">{{ $reservation->phone }}</div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm">
                            <div class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($reservation->reservation_date)->format('M d, Y') }}</div>
                            <div class="text-gray-500">{{ \Carbon\Carbon::parse($reservation->reservation_time)->format('h:i A') }}</div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 text-sm font-semibold text-gray-900 bg-gray-100 rounded-lg">Table {{ $reservation->table_number }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-1 text-sm text-gray-900">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                            {{ $reservation->guests }}
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <form action="{{ route('admin.reservations.update-status', $reservation->id) }}" method="POST">
                            @csrf
                            <select name="status" onchange="this.form.submit()" class="px-3 py-1 text-xs font-semibold rounded-full border-0 focus:outline-none focus:ring-2 focus:ring-orange-500
                                {{ $reservation->status === 'confirmed' ? 'text-green-800 bg-green-100' : '' }}
                                {{ $reservation->status === 'pending' ? 'text-yellow-800 bg-yellow-100' : '' }}
                                {{ $reservation->status === 'cancelled' ? 'text-red-800 bg-red-100' : '' }}
                                {{ $reservation->status === 'completed' ? 'text-blue-800 bg-blue-100' : '' }}">
                                <option value="pending" {{ $reservation->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="confirmed" {{ $reservation->status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                <option value="completed" {{ $reservation->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ $reservation->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </form>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.reservations.edit', $reservation->id) }}" class="text-blue-600 hover:text-blue-800" title="Edit">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </a>
                            <form action="{{ route('admin.reservations.destroy', $reservation->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this reservation?')" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800" title="Delete">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                        <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <p class="text-lg font-medium">No reservations found</p>
                        <p class="text-sm mt-1">Get started by creating a new reservation</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($reservations->hasPages())
    <div class="px-6 py-4 border-t border-gray-200">
        {{ $reservations->links() }}
    </div>
    @endif
</div>

@if($reservations->count() > 0)
<div class="mt-6 grid grid-cols-1 md:grid-cols-4 gap-4">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
        <div class="text-sm text-gray-600">Total Reservations</div>
        <div class="text-2xl font-bold text-gray-900 mt-1">{{ $reservations->total() }}</div>
    </div>
    <div class="bg-green-50 rounded-xl shadow-sm border border-green-200 p-4">
        <div class="text-sm text-green-600">Confirmed</div>
        <div class="text-2xl font-bold text-green-900 mt-1">{{ $reservations->where('status', 'confirmed')->count() }}</div>
    </div>
    <div class="bg-yellow-50 rounded-xl shadow-sm border border-yellow-200 p-4">
        <div class="text-sm text-yellow-600">Pending</div>
        <div class="text-2xl font-bold text-yellow-900 mt-1">{{ $reservations->where('status', 'pending')->count() }}</div>
    </div>
    <div class="bg-blue-50 rounded-xl shadow-sm border border-blue-200 p-4">
        <div class="text-sm text-blue-600">Completed</div>
        <div class="text-2xl font-bold text-blue-900 mt-1">{{ $reservations->where('status', 'completed')->count() }}</div>
    </div>
</div>
@endif
@endsection
