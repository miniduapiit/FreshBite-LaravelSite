<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;

class AdminReservationController extends Controller
{
    /**
     * Display a listing of reservations
     */
    public function index()
    {
        $reservations = Reservation::with('user')
            ->orderBy('reservation_date', 'desc')
            ->orderBy('reservation_time', 'desc')
            ->paginate(20);

        return view('admin.reservations.index', compact('reservations'));
    }

    /**
     * Show the form for creating a new reservation
     */
    public function create()
    {
        return view('admin.reservations.create');
    }

    /**
     * Store a newly created reservation
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'table_number' => 'required|integer|min:1',
            'guests' => 'required|integer|min:1|max:20',
            'reservation_date' => 'required|date',
            'reservation_time' => 'required',
            'special_requests' => 'nullable|string',
            'status' => 'required|in:pending,confirmed,cancelled,completed'
        ]);

        Reservation::create($request->all());

        return redirect()->route('admin.reservations')->with('success', 'Reservation created successfully!');
    }

    /**
     * Show the form for editing the specified reservation
     */
    public function edit($id)
    {
        $reservation = Reservation::findOrFail($id);
        return view('admin.reservations.edit', compact('reservation'));
    }

    /**
     * Update the specified reservation
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'table_number' => 'required|integer|min:1',
            'guests' => 'required|integer|min:1|max:20',
            'reservation_date' => 'required|date',
            'reservation_time' => 'required',
            'special_requests' => 'nullable|string',
            'status' => 'required|in:pending,confirmed,cancelled,completed'
        ]);

        $reservation = Reservation::findOrFail($id);
        $reservation->update($request->all());

        return redirect()->route('admin.reservations')->with('success', 'Reservation updated successfully!');
    }

    /**
     * Update reservation status
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled,completed'
        ]);

        $reservation = Reservation::findOrFail($id);
        $reservation->status = $request->status;
        $reservation->save();

        return redirect()->back()->with('success', 'Reservation status updated successfully!');
    }

    /**
     * Remove the specified reservation
     */
    public function destroy($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->delete();

        return redirect()->route('admin.reservations')->with('success', 'Reservation deleted successfully!');
    }
}
