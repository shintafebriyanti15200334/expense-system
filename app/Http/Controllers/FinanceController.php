<?php

namespace App\Http\Controllers;


use App\Models\Submission;
use App\Services\FinanceService;
use App\Http\Requests\FinancePaymentRequest;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Models\Budget;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\FinanceHistoryExport;
use Barryvdh\DomPDF\Facade\Pdf;


class FinanceController extends Controller
{

    protected FinanceService $financeService;


    public function __construct(
        FinanceService $financeService
    ) {

        $this->financeService =
            $financeService;
    }



    public function index(Request $request): View
    {

        // Pembayaran yang menunggu Finance
        $submissions = Submission::with([
            'user',
            'category',
            'category.budgets'
        ])
            ->where(
                'status',
                Submission::WAITING_FINANCE
            )
            ->latest()
            ->paginate(10);


        // History pembayaran
        $payments = Payment::with([
            'submission',
            'finance'
        ])

            ->when($request->date, function ($query) use ($request) {

                $query->whereDate(
                    'payment_date',
                    $request->date
                );
            })


            ->when($request->status, function ($query) use ($request) {

                $query->where(
                    'status',
                    $request->status
                );
            })


            ->when($request->search, function ($query) use ($request) {

                $query->whereHas('submission', function ($q) use ($request) {

                    $q->where(
                        'submission_number',
                        'like',
                        '%' . $request->search . '%'
                    );
                });
            })


            ->latest()
            ->paginate(10);


        return view(
            'finance.index',
            compact(
                'submissions',
                'payments',
            )
        );
    }

    public function history(Request $request): View
    {

     $payments = Payment::with([
        'submission.user',
        'submission.category.budgets',
        'finance'
    ])

    ->when($request->date, function($query) use ($request){

        $query->whereDate(
            'payment_date',
            $request->date
        );

    })

    ->when($request->status, function($query) use ($request){

        $query->where(
            'status',
            $request->status
        );

    })

    ->when($request->search, function($query) use ($request){

        $query->whereHas('submission', function($q) use ($request){

            $q->where(
                'submission_number',
                'like',
                '%'.$request->search.'%'
            );

        });

    })

    ->latest()
    ->paginate(10);


        return view(
            'finance.history',
            compact('payments')
        );
    }

    public function pay(
        FinancePaymentRequest $request,
        Submission $submission
    ): RedirectResponse {


        $this->financeService->processPayment(
            $submission,
            $request->validated()
        );


        return redirect()

            ->route('finance.index')

            ->with(
                'success',
                'Pembayaran berhasil diproses.'
            );
    }

    /**
     * Export Excel.
     */
    public function exportHistoryExcel()
    {
        return Excel::download(
            new FinanceHistoryExport(),
            'history_finance.xlsx'
        );
    }

    /**
     * Export PDF.
     */
    public function exportHistoryPdf()
    {
        $payments = Payment::with([
            'submission.user',
            'submission.category.budgets',
            'finance'
        ])
            ->latest()
            ->get();


        $pdf = Pdf::loadView(
            'finance.history-pdf',
            compact('payments')
        );


        return $pdf->download(
            'history_finance.pdf'
        );
    }
}
