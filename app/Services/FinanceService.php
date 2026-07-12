<?php

namespace App\Services;

use App\Models\Budget;
use App\Models\Payment;
use App\Models\Submission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Exception;

class FinanceService
{
    protected AuditTrailService $auditTrail;


    public function __construct(
        AuditTrailService $auditTrail
    ) {
        $this->auditTrail = $auditTrail;
    }


    /**
     * Proses pembayaran pengajuan.
     */
    public function processPayment(
        Submission $submission,
        array $data
    ): Payment {


        return DB::transaction(function () use (
            $submission,
            $data
        ) {


            /*
            |----------------------------------------------------------------------
            | Validasi Status
            |----------------------------------------------------------------------
            */

            if (
                $submission->status !==
                Submission::WAITING_FINANCE
            ) {

                throw new Exception(
                    'Pengajuan belum siap dibayar.'
                );

            }



            /*
            |----------------------------------------------------------------------
            | Ambil Budget
            |----------------------------------------------------------------------
            */

            $budget = Budget::where(
                    'category_id',
                    $submission->category_id
                )
                ->where(
                    'year',
                    now()->year
                )
                ->lockForUpdate()
                ->first();



            if (!$budget) {

                throw new Exception(
                    'Budget kategori tidak ditemukan.'
                );

            }



            /*
            |----------------------------------------------------------------------
            | Cek Sisa Budget
            |----------------------------------------------------------------------
            */

            $remaining =
                $budget->budget_amount
                -
                $budget->used_amount;



            if (
                $remaining <
                $submission->amount
            ) {


                $submission->update([

                    'status' =>
                        Submission::REJECTED

                ]);



                $this->auditTrail->log(
                    'Payment',
                    'Rejected',
                    $submission->id,
                    'Pembayaran ditolak karena budget tidak mencukupi untuk pengajuan '
                    . $submission->submission_number
                );



                throw new Exception(
                    'Saldo budget tidak mencukupi.'
                );

            }




            /*
            |----------------------------------------------------------------------
            | Simpan Pembayaran
            |----------------------------------------------------------------------
            */

            $payment = Payment::create([

                'submission_id'
                    => $submission->id,


                'finance_id'
                    => Auth::id(),


                'payment_date'
                    => $data['payment_date'],


                'paid_amount'
                    => $submission->amount,


                'notes'
                    => $data['notes'] ?? null,


                'status'
                    => 'Paid',

            ]);





            /*
            |----------------------------------------------------------------------
            | Update Budget
            |----------------------------------------------------------------------
            */

            $budget->increment(
                'used_amount',
                $submission->amount
            );





            /*
            |----------------------------------------------------------------------
            | Update Status Submission
            |----------------------------------------------------------------------
            */

            $submission->update([

                'status' =>
                    Submission::PAID

            ]);





            /*
            |----------------------------------------------------------------------
            | Audit Trail
            |----------------------------------------------------------------------
            */

            $this->auditTrail->log(
                'Payment',
                'Paid',
                $submission->id,
                'Pembayaran pengajuan '
                . $submission->submission_number
                . ' sebesar Rp '
                . number_format(
                    $submission->amount,
                    0,
                    ',',
                    '.'
                )
            );



            return $payment;


        });

    }

}