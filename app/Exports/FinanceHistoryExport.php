<?php

namespace App\Exports;

use App\Models\Payment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class FinanceHistoryExport implements FromCollection, WithHeadings
{

    public function collection()
    {
        return Payment::with([
                'submission.user',
                'submission.category.budgets',
                'finance'
            ])
            ->latest()
            ->get()
            ->map(function($payment){


                $budget = $payment->submission
                    ->category
                    ->budgets
                    ->where('year', date('Y'))
                    ->first();



                return [

                    'Nomor Pengajuan' =>
                        $payment->submission->submission_number,


                    'Pengaju' =>
                        $payment->submission->user->name,


                    'Kategori' =>
                        $payment->submission->category->name,


                    'Nominal Pengajuan' =>
                        $payment->submission->amount,


                    'Budget Tersedia' =>
                        $budget
                        ? $budget->budget_amount
                        : 0,


                    'Budget Tersisa' =>
                        $budget
                        ? $budget->budget_amount - $budget->used_amount
                        : 0,


                    'Tanggal Pembayaran' =>
                        $payment->created_at
                            ? $payment->created_at->format('d-m-Y H:i:s')
                            : '-',


                    'Status' =>
                        $payment->status,


                    'Finance' =>
                        $payment->finance->name ?? '-',


                    'Catatan' =>
                        $payment->notes ?? '-',


                ];


            });

    }



    public function headings(): array
    {
        return [

            'Nomor Pengajuan',
            'Pengaju',
            'Kategori',
            'Nominal Pengajuan',
            'Budget Tersedia',
            'Budget Tersisa',
            'Tanggal Pembayaran',
            'Status',
            'Finance',
            'Catatan'

        ];
    }

}