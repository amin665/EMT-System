<?php

namespace App\Ai\Agents;

use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Promptable;

class MedicalTranscriber implements Agent
{
    use Promptable;

    public function instructions(): string
    {
        return "You are a medical transcription assistant. Transcribe the provided audio into clean Arabic text expect medical terms keep them in english. Focus on medical terms like (ضغط الدم، السكري).";
    }

    /**
     * Get the list of messages comprising the conversation so far.
     */
    public function messages(): iterable
    {
        return [];
    }

    /**
     * Get the tools available to the agent.
     *
     * @return Tool[]
     */
    public function tools(): iterable
    {
        return [];
    }
}
