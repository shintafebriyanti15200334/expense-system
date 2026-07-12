<?php

namespace App\Exports;

use App\Models\Submission;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SubmissionHistoryExport
    implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Submission::with('category')
            ->where('user_id', Auth::id())
            ->select(
                'submission_number',
                'amount',
                'status',
                'created_at',
                'category_id'
            )
            ->get()
            ->map(function ($item) {

                return [
                    'No Pengajuan'
                        => $item->submission_number,

                    'Kategori'
                        => $item->category->name,

                    'Nominal'
                        => $item->amount,

                    'Status'
                        => $item->status,

                    'Tanggal'
                        => $item->created_at
                            ->format('d-m-Y H:i'),
                ];
            });
    }

    public function headings(): array
    {
        return [
            'No Pengajuan',
            'Kategori',
            'Nominal',
            'Status',
            'Tanggal',
        ];
    }
}