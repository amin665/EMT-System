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
        $todayAppointments = Appointment::where('doctorID', $user->id)
                                        ->whereDate('date', today())
                                        ->get();

        return view('transactions.dashboard', compact('totalPatients', 'todayAppointments'));
    }
}