<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateSettingRequest;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function edit()
    {
        $user = auth()->user();
        return view('settings.edit', compact('user'));
    }

    public function update(UpdateSettingRequest $request)
    {
        $user = auth()->user();
        $user->update($request->validated());

        return back()->with('success', 'Telegram message template updated successfully.');
    }
}