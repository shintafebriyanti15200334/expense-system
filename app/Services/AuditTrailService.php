<?php

namespace App\Services;

use App\Models\Approval;
use App\Models\AuditTrail;
use App\Models\Payment;
use App\Models\Submission;
use Illuminate\Support\Facades\Auth;

class AuditTrailService
{
    public static function log(
        string $module,
        string $action,
        ?int $submissionId = null,
        ?string $description = null
    ): void {
        AuditTrail::create([
            'user_id'       => Auth::id(),
            'submission_id' => $submissionId,
            'module'        => $module,
            'action'        => $action,
            'description'   => $description,
            'url'           => request()->fullUrl(),
            'method'        => request()->method(),
            'user_agent'    => request()->userAgent(),
            'ip_address'    => request()->ip(),
        ]);
    }

    public static function submissionCreated(
        Submission $submission
    ): void {
        self::log(
            'Submission',
            'Create',
            $submission->id,
            'Membuat pengajuan '.$submission->submission_number
        );
    }

    public static function submissionUpdated(
        Submission $submission
    ): void {
        self::log(
            'Submission',
            'Update',
            $submission->id,
            'Mengubah pengajuan '.$submission->submission_number
        );
    }

    public static function submissionDeleted(
        Submission $submission
    ): void {
        self::log(
            'Submission',
            'Delete',
            $submission->id,
            'Menghapus pengajuan '.$submission->submission_number
        );
    }

    public static function approved(
        Approval $approval
    ): void {
        self::log(
            'Approval',
            'Approve',
            $approval->submission_id,
            'Approve pengajuan '
            .$approval->submission->submission_number
            .' oleh '
            .$approval->approver->name
        );
    }

    public static function rejected(
        Approval $approval
    ): void {
        self::log(
            'Approval',
            'Reject',
            $approval->submission_id,
            'Reject pengajuan '
            .$approval->submission->submission_number
            .' oleh '
            .$approval->approver->name
        );
    }

    public static function paid(
        Payment $payment
    ): void {
        self::log(
            'Payment',
            'Paid',
            $payment->submission_id,
            'Pembayaran pengajuan '
            .$payment->submission->submission_number
            .' sebesar Rp '
            .number_format(
                $payment->paid_amount,
                0,
                ',',
                '.'
            )
        );
    }

    public static function exported(
        string $type = 'Excel'
    ): void {
        self::log(
            'Report',
            'Export',
            null,
            'Export laporan '.$type
        );
    }

    public static function login(): void
    {
        self::log(
            'Authentication',
            'Login',
            null,
            'User login ke sistem'
        );
    }

    public static function logout(): void
    {
        self::log(
            'Authentication',
            'Logout',
            null,
            'User logout dari sistem'
        );
    }
}