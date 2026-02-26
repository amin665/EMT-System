<?php

namespace App\Http\Controllers;

use App\Ai\Agents\MedicalTranscriber;
use Illuminate\Http\Request;
use Laravel\Ai\Ai; // Use the main AI Facade
use Laravel\Ai\Prompts\AgentPrompt;

class TranscriptionController extends Controller
{
    public function transcribe(Request $request)
    {
        $request->validate([
            'audio' => 'required|file|mimes:mp3,wav,m4a,webm|max:10240',
        ]);

        try {
            // We use prompt() and attach the audio file directly.
            // This is how Gemini handles "transcription" in the 2026 SDK.
           $response = (new MedicalTranscriber)->prompt(
                '"Transcribe this medical audio recording in Arabic.keep english terms as they are.Focus on medical terms like (ضغط الدم، السكري، الحساسية). Provide a clean text output.")', 
                attachments: [$request->file('audio')]
            );
            return response()->json([
                'success' => true,
                'text' => (string) $response
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false, 
                'message' => 'Gemini Error: ' . $e->getMessage()
            ], 500);
        }
    }
}