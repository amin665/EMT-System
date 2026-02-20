<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Appointment;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Stats for the dashboard
        $totalPatients = Patient::where('createdBy', $user->id)->count();
        $todayAppointmentsQuery = Appointment::where('doctorID', $user->id)
            ->whereDate('date', today())
            ->with('patient')
            ->orderBy('date', 'asc');

        $todayAppointmentsCount = (clone $todayAppointmentsQuery)->count();
        $todayAppointments = $todayAppointmentsQuery->paginate(10);

        return view('transactions.dashboard', compact('totalPatients', 'todayAppointments', 'todayAppointmentsCount'));
    }
}