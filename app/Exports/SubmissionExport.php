<?php

namespace App\Exports;

use App\Models\Submission;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Carbon\Carbon;

class SubmissionExport implements FromCollection, WithHeadings
{
    public function collection(): Collection
    {
        return Submission::with([
            'user',
            'category'
        ])
        ->get()
        ->map(function ($submission) {

            return [

                'Nomor Pengajuan' => $submission->submission_number,

                'Tanggal' => $submission->submission_date
                    ? Carbon::parse($submission->submission_date)->format('d-m-Y')
                    : '-',

                'Pengaju' => $submission->user?->name ?? '-',

                'Kategori' => $submission->category?->name ?? '-',

                'Nominal' => $submission->amount,

                'Status' => ucfirst($submission->status),

            ];
        });
    }


    public function headings(): array
    {
        return [
            'Nomor Pengajuan',
            'Tanggal',
            'Pengaju',
            'Kategori',
            'Nominal',
            'Status',
        ];
    }
}