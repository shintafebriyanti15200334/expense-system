<?php

namespace App\Helpers;

use App\Models\Submission;

class NumberHelper
{
    /**
     * Generate Submission Number
     * Format:
     * SUB-20260711-0001
     */
    public static function generateSubmissionNumber(): string
    {
        $today = now()->format('Ymd');

        $lastSubmission = Submission::whereDate('created_at', today())
            ->latest('id')
            ->first();

        $number = 1;

        if ($lastSubmission) {

            $last = explode('-', $lastSubmission->submission_number);

            $number = (int) end($last) + 1;
        }

        return 'SUB-' . $today . '-' . str_pad($number, 4, '0', STR_PAD_LEFT);
    }
}