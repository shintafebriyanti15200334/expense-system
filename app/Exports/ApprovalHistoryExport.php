<?php

namespace App\Exports;

use App\Models\Approval;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ApprovalHistoryExport implements
    FromCollection,
    WithHeadings
{
    public function collection()
    {
        return Approval::with([
                'submission.user',
                'submission.category',
                'approver'
            ])
            ->where(
                'approver_id',
                Auth::id()
            )
            ->latest()
            ->get()
            ->map(function ($item) {

                return [

                    'No Pengajuan' =>
                        $item->submission?->submission_number,

                    'Pengaju' =>
                        $item->submission?->user?->name,

                    'Kategori' =>
                        $item->submission?->category?->name,

                    'Nominal' =>
                        $item->submission?->amount,

                    'Level' =>
                        $item->level,

                    'Status' =>
                        $item->status,

                    'Catatan' =>
                        $item->notes,

                    'Tanggal Approval' =>
                        optional(
                            $item->approved_at
                        )->format('d-m-Y H:i'),
                ];
            });
    }

    public function headings(): array
    {
        return [

            'No Pengajuan',
            'Pengaju',
            'Kategori',
            'Nominal',
            'Level',
            'Status',
            'Catatan',
            'Tanggal Approval',

        ];
    }
}