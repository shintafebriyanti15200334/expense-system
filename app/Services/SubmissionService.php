<?php

namespace App\Services;

use App\Helpers\NumberHelper;
use App\Helpers\UploadHelper;
use App\Models\Submission;
use App\Models\SubmissionAttachment;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SubmissionService
{
    protected ApprovalService $approvalService;

    public function __construct(
        ApprovalService $approvalService
    ) {
        $this->approvalService = $approvalService;
    }

    /**
     * List Submission
     */
    public function getAll(
        array $filters = []
    ): LengthAwarePaginator {

        return Submission::with([
                'category',
                'user',
            ])
            ->where(
                'user_id',
                Auth::id()
            )

            ->when(
                $filters['status'] ?? null,
                function ($query, $status) {

                    $query->where(
                        'status',
                        $status
                    );
                }
            )

            ->when(
                $filters['keyword'] ?? null,
                function ($query, $keyword) {

                    $query->where(function ($q) use ($keyword) {

                        $q->where(
                            'submission_number',
                            'like',
                            "%{$keyword}%"
                        )
                        ->orWhere(
                            'description',
                            'like',
                            "%{$keyword}%"
                        );
                    });
                }
            )

            ->latest()
            ->paginate(10)
            ->withQueryString();
    }

    /**
     * Store Submission
     */
    public function store(
        array $data
    ): Submission {

        return DB::transaction(function () use ($data) {

            $files = $data['attachments'] ?? [];

            unset($data['attachments']);

            $data['submission_number']
                = NumberHelper::generateSubmissionNumber();

            $data['user_id']
                = Auth::id();

            $data['status']
                = Submission::SUBMITTED;

            $submission = Submission::create(
                $data
            );

            /*
            |--------------------------------------------------------------------------
            | Upload Attachment
            |--------------------------------------------------------------------------
            */
            foreach ($files as $file) {

                $path = UploadHelper::uploadSubmission(
                    $file
                );

                SubmissionAttachment::create([
                    'submission_id' => $submission->id,
                    'file_name'     => $file->getClientOriginalName(),
                    'file_path'     => $path,
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | Create Approval
            |--------------------------------------------------------------------------
            */
            $this->approvalService
                ->createInitialApproval(
                    $submission
                );

            /*
            |--------------------------------------------------------------------------
            | Audit Trail
            |--------------------------------------------------------------------------
            */
            AuditTrailService::submissionCreated(
                $submission
            );

            return $submission;
        });
    }

    /**
     * Update Submission
     */
    public function update(
        Submission $submission,
        array $data
    ): Submission {

        return DB::transaction(function () use (
            $submission,
            $data
        ) {

            $files = $data['attachments'] ?? [];

            unset($data['attachments']);

            $submission->update(
                $data
            );

            /*
            |--------------------------------------------------------------------------
            | Upload Attachment Baru
            |--------------------------------------------------------------------------
            */
            foreach ($files as $file) {

                $path = UploadHelper::uploadSubmission(
                    $file
                );

                SubmissionAttachment::create([
                    'submission_id' => $submission->id,
                    'file_name'     => $file->getClientOriginalName(),
                    'file_path'     => $path,
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | Audit Trail
            |--------------------------------------------------------------------------
            */
            AuditTrailService::submissionUpdated(
                $submission
            );

            return $submission->fresh([
                'category',
                'user',
                'attachments',
                'approvals',
                'payment',
            ]);
        });
    }

    /**
     * Delete Submission
     */
    public function delete(
        Submission $submission
    ): void {

        DB::transaction(function () use (
            $submission
        ) {

            /*
            |--------------------------------------------------------------------------
            | Audit sebelum delete
            |--------------------------------------------------------------------------
            */
            AuditTrailService::submissionDeleted(
                $submission
            );

            /*
            |--------------------------------------------------------------------------
            | Delete Attachment
            |--------------------------------------------------------------------------
            */
            foreach (
                $submission->attachments
                as $attachment
            ) {

                UploadHelper::delete(
                    $attachment->file_path
                );

                $attachment->delete();
            }

            /*
            |--------------------------------------------------------------------------
            | Delete Submission
            |--------------------------------------------------------------------------
            */
            $submission->delete();
        });
    }

    /**
     * Detail Submission
     */
    public function find(
        int $id
    ): Submission {

        return Submission::with([
                'category',
                'user',
                'attachments',
                'approvals.approver',
                'payment',
                'auditTrails.user',
            ])
            ->findOrFail($id);
    }
}