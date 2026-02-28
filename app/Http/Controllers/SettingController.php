<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateSettingRequest;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function edit(Request $request)
    {
        $user = auth()->user();

        if ($request->expectsJson()) {
            return response()->json([
                'status_code' => 200,
                'data' => [
                    'id' => $user->id,
                    'telegram_message_template' => $user->telegram_message_template,
                ],
            ], 200);
        }

        return view('settings.edit', compact('user'));
    }

    public function update(UpdateSettingRequest $request)
    {
        $user = auth()->user();
        $user->update($request->validated());

        if ($request->expectsJson()) {
            return response()->json([
                'status_code' => 200,
                'data' => [
                    'id' => $user->id,
                    'telegram_message_template' => $user->telegram_message_template,
                ],
            ], 200);
        }

        return back()->with('success', 'Telegram message template updated successfully.');
    }
}