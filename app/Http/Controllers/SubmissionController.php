<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSubmissionRequest;
use App\Http\Requests\UpdateSubmissionRequest;
use App\Models\Category;
use App\Models\Submission;
use App\Services\SubmissionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Exports\SubmissionExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use App\Exports\SubmissionHistoryExport;
use Barryvdh\DomPDF\Facade\Pdf;

class SubmissionController extends Controller
{

    private SubmissionService $submissionService;

    public function __construct(SubmissionService $submissionService)
    {
        $this->submissionService = $submissionService;
    }

    public function index(Request $request): View
    {

        $submissions = $this->submissionService->getAll(
            $request->only([
                'keyword',
                'status',
            ])
        );


        return view(
            'submissions.index',
            compact('submissions')
        );

    }

    public function history(Request $request): View
{
    $submissions = Submission::with([
            'category',
            'approvals.approver',
            'payment'
        ])
        ->where('user_id', Auth::id())

        ->when($request->status, function ($query, $status) {
            $query->where('status', $status);
        })

        ->when($request->date, function ($query, $date) {
            $query->whereDate('created_at', $date);
        })

        ->when($request->search, function ($query, $search) {
            $query->where(function ($q) use ($search) {

                $q->where(
                    'submission_number',
                    'like',
                    "%{$search}%"
                )
                ->orWhere(
                    'description',
                    'like',
                    "%{$search}%"
                );

            });
        })

        ->latest()
        ->paginate(10)
        ->withQueryString();

    return view(
        'submissions.history',
        compact('submissions')
    );
}

    public function create(): View
    {

        $categories = Category::orderBy('name')
            ->get();


        return view(
            'submissions.create',
            compact('categories')
        );

    }

    public function store(
        StoreSubmissionRequest $request
    ): RedirectResponse
    {


        $this->submissionService->store(
            $request->validated()
        );


        return redirect()
            ->route('submissions.index')
            ->with(
                'success',
                'Pengajuan berhasil dibuat.'
            );

    }

    public function show(
        Submission $submission
    ): View
    {


        $submission = Submission::with([

            'user',

            'category',

            'attachments',

            'approvals.approver',

            'payment'

        ])
        ->findOrFail($submission->id);




        return view(
            'submissions.show',
            compact('submission')
        );


    }

    public function edit(
        Submission $submission
    ): View
    {


        $submission = Submission::with([
            'attachments'
        ])
        ->findOrFail($submission->id);



        $categories = Category::orderBy('name')
            ->get();




        return view(
            'submissions.edit',
            compact(
                'submission',
                'categories'
            )
        );


    }

    public function update(
        UpdateSubmissionRequest $request,
        Submission $submission
    ): RedirectResponse
    {



        $this->submissionService->update(

            $submission,

            $request->validated()

        );



        return redirect()
            ->route('submissions.index')
            ->with(
                'success',
                'Pengajuan berhasil diperbarui.'
            );


    }

    public function destroy(
        Submission $submission
    ): RedirectResponse
    {


        $this->submissionService->delete(
            $submission
        );


        return redirect()
            ->route('submissions.index')
            ->with(
                'success',
                'Pengajuan berhasil dihapus.'
            );


    }

public function exportHistoryExcel()
{
    return Excel::download(
        new SubmissionHistoryExport(),
        'history_pengajuan.xlsx'
    );
}

public function exportHistoryPdf()
{
    $submissions = Submission::with([
            'category',
            'approvals.approver',
            'payment'
        ])
        ->where(
            'user_id',
            Auth::id()
        )
        ->latest()
        ->get();

    $pdf = Pdf::loadView(
        'submissions.history-pdf',
        compact('submissions')
    );

    return $pdf->download(
        'history_pengajuan.pdf'
    );
}

}
