<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Patient;
use App\Http\Requests\StoreAppointmentRequest;
use App\Http\Requests\UpdateAppointmentRequest;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\AppointmentConfirmation;
use Illuminate\Support\Facades\Log;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = Appointment::where('doctorID', auth()->id())
                                   ->with('patient')
                                   ->orderBy('date', 'asc')
                                   ->get();
        return view('transactions.index', compact('appointments'));
    }

    public function create()
    {
        $patients = Patient::where('createdBy', auth()->id())->get();
        return view('transactions.create', compact('patients'));
    }
    public function store(StoreAppointmentRequest $request)
    {
        $data = $request->validated();
        $this->checkTimeConflicts(Carbon::parse($data['date']));

        $data['doctorID'] = auth()->id();
        
        Appointment::create($data);

        return redirect()->route('appointments.index')
                         ->with('success', 'Appointment scheduled successfully.');
    }

    public function edit(Appointment $appointment)
    {
        if ($appointment->doctorID !== auth()->id()) abort(403);
        $patients = Patient::where('createdBy', auth()->id())->get();
        return view('transactions.edit', compact('appointment', 'patients'));
    }

    public function update(UpdateAppointmentRequest $request, Appointment $appointment)
    {
        if ($appointment->doctorID !== auth()->id()) abort(403);
        
        $data = $request->validated();
        $newDate = Carbon::parse($data['date']);

        // Check conflicts only if date changed
        if ($appointment->date != $newDate) {
            $this->checkTimeConflicts($newDate, $appointment->id);
            // If date changed, set status to Delayed (per requirements)
            $data['status'] = 'Delayed';
        }

        $appointment->update($data);

        return redirect()->route('appointments.index')->with('success', 'Appointment updated successfully.');
    }

    public function destroy(Appointment $appointment)
    {
        if ($appointment->doctorID !== auth()->id()) abort(403);
        
        // Set status to Canceled instead of deleting, to keep record
        $appointment->update(['status' => 'Canceled']);
        
        return redirect()->route('appointments.index')->with('success', 'Appointment canceled successfully.');
    }

    /**
     * Check for overlap: No appointment within +/- 10 mins of requested time.
     */
    private function checkTimeConflicts(Carbon $date, $ignoreId = null)
    {
        $startBuffer = $date->copy()->subMinutes(10);
        $endBuffer = $date->copy()->addMinutes(10);

        $conflict = Appointment::where('doctorID', auth()->id())
            ->where('id', '!=', $ignoreId)
            ->where('status', '!=', 'Canceled') // Ignore canceled ones
            ->whereBetween('date', [$startBuffer, $endBuffer])
            ->exists();

        if ($conflict) {
            throw ValidationException::withMessages([
                'date' => 'There is another appointment within 10 minutes of this time.'
            ]);
        }
    }
}