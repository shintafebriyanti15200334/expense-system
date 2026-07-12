<?php

namespace App\Http\Controllers;

use App\Exports\ApprovalHistoryExport;
use App\Http\Requests\ApprovalRequest;
use App\Models\Approval;
use App\Services\ApprovalService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;

class ApprovalController extends Controller
{
    protected ApprovalService $approvalService;

    public function __construct(
        ApprovalService $approvalService
    ) {
        $this->approvalService = $approvalService;
    }

    /**
     * Approval pending.
     */
    public function index(
        Request $request
    ): View {

        $query = Approval::with([
                'submission.user',
                'submission.category',
            ])
            ->where(
                'approver_id',
                Auth::id()
            );

        if ($request->filled('status')) {

            $query->where(
                'status',
                $request->status
            );
        }

        $approvals = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'approvals.index',
            compact('approvals')
        );
    }

    /**
     * History approval.
     */
    public function history(
        Request $request
    ): View {

        $approvals = Approval::with([
                'submission.user',
                'submission.category',
                'approver'
            ])

            ->where(
                'approver_id',
                Auth::id()
            )

            ->when(
                $request->status,
                function ($query, $status) {

                    $query->where(
                        'status',
                        $status
                    );
                }
            )

            ->when(
                $request->level,
                function ($query, $level) {

                    $query->where(
                        'level',
                        $level
                    );
                }
            )

            ->when(
                $request->date,
                function ($query, $date) {

                    $query->whereDate(
                        'approved_at',
                        $date
                    );
                }
            )

            ->when(
                $request->search,
                function ($query, $search) {

                    $query->whereHas(
                        'submission',
                        function ($q) use ($search) {

                            $q->where(
                                'submission_number',
                                'like',
                                "%{$search}%"
                            );
                        }
                    );
                }
            )

            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'approvals.history',
            compact('approvals')
        );
    }

    /**
     * Detail approval.
     */
    public function show(
        Approval $approval
    ): View {

        $this->authorizeApproval(
            $approval
        );

        $approval->load([
            'submission.user',
            'submission.category',
            'submission.attachments',
        ]);

        return view(
            'approvals.show',
            compact('approval')
        );
    }

    /**
     * Approve.
     */
    public function approve(
        ApprovalRequest $request,
        Approval $approval
    ): RedirectResponse {

        $this->authorizeApproval(
            $approval
        );

        $this->approvalService->approve(
            $approval,
            $request->validated('notes')
        );

        return redirect()
            ->route(
                'approvals.index'
            )
            ->with(
                'success',
                'Pengajuan berhasil di-approve.'
            );
    }

    /**
     * Reject.
     */
    public function reject(
        ApprovalRequest $request,
        Approval $approval
    ): RedirectResponse {

        $this->authorizeApproval(
            $approval
        );

        $this->approvalService->reject(
            $approval,
            $request->validated('notes')
        );

        return redirect()
            ->route(
                'approvals.index'
            )
            ->with(
                'success',
                'Pengajuan berhasil ditolak.'
            );
    }

    /**
     * Export Excel.
     */
    public function exportHistoryExcel()
    {
        return Excel::download(
            new ApprovalHistoryExport(
                Auth::id()
            ),
            'history_approval.xlsx'
        );
    }

    /**
     * Export PDF.
     */
    public function exportHistoryPdf()
    {
        $approvals = Approval::with([
                'submission.user',
                'submission.category',
                'approver'
            ])
            ->where(
                'approver_id',
                Auth::id()
            )
            ->latest()
            ->get();

        $pdf = Pdf::loadView(
            'approvals.history-pdf',
            compact('approvals')
        );

        return $pdf->download(
            'history_approval.pdf'
        );
    }

    /**
     * Authorization.
     */
    private function authorizeApproval(
        Approval $approval
    ): void {

        $userId = Auth::id();

        if ($userId === null) {
            abort(401);
        }

        if (
            $approval->approver_id !== $userId
        ) {
            abort(
                403,
                'Anda tidak memiliki akses.'
            );
        }
    }
}