<?php

namespace App\Services;

use App\Models\Approval;
use App\Models\Budget;
use App\Models\Submission;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ApprovalService
{
    private const SPV_LIMIT = 5000000;
    private const DIRECTOR_LIMIT = 10000000;


    /**
     * Membuat approval pertama
     */
    public function createInitialApproval(
        Submission $submission
    ): void {

        DB::transaction(function () use ($submission) {


            /*
            |--------------------------------------------------------------------------
            | PO Produk atau > 10 Juta
            | Director -> Finance
            |--------------------------------------------------------------------------
            */

            if (
                $submission->category->name === 'PO Produk'
                ||
                $submission->amount > self::DIRECTOR_LIMIT
            ) {


                $director = $this->getUserByRole(
                    'Director'
                );


                Approval::create([

                    'submission_id' => $submission->id,
                    'approver_id'   => $director->id,
                    'level'         => 'Director',
                    'status'        => 'Pending',

                ]);


                $submission->update([

                    'status' =>
                        Submission::WAITING_DIRECTOR,

                ]);


                return;

            }




            /*
            |--------------------------------------------------------------------------
            | > 5 Juta - 10 Juta
            | Manager -> Director -> Finance
            |--------------------------------------------------------------------------
            */


            if (
                $submission->amount > self::SPV_LIMIT
            ) {


                $manager = $this->getUserByRole(
                    'Manager'
                );


                Approval::create([

                    'submission_id' => $submission->id,
                    'approver_id'   => $manager->id,
                    'level'         => 'Manager',
                    'status'        => 'Pending',

                ]);



                $submission->update([

                    'status' =>
                        Submission::WAITING_MANAGER,

                ]);


                return;

            }





            /*
            |--------------------------------------------------------------------------
            | <= 5 Juta
            | SPV -> Director -> Finance
            |--------------------------------------------------------------------------
            */


            $spv = $this->getUserByRole(
                'SPV'
            );


            Approval::create([

                'submission_id' => $submission->id,
                'approver_id'   => $spv->id,
                'level'         => 'SPV',
                'status'        => 'Pending',

            ]);



            $submission->update([

                'status' =>
                    Submission::WAITING_SPV,

            ]);


        });

    }





    /**
     * Approve Submission
     */
    public function approve(
        Approval $approval,
        ?string $notes = null
    ): void {


        DB::transaction(function () use (
            $approval,
            $notes
        ) {



            $approval->update([

                'status' =>
                    'Approved',

                'notes' =>
                    $notes,

                'approved_at' =>
                    Carbon::now(),

            ]);




            $approval->load([

                'submission.category',
                'approver'

            ]);




            $submission =
                $approval->submission;




            AuditTrailService::approved(
                $approval
            );





            switch ($approval->level) {


                case 'SPV':

                    $this->afterSPV(
                        $submission
                    );

                    break;



                case 'Manager':

                    $this->afterManager(
                        $submission
                    );

                    break;



                case 'Director':

                    $this->finishApproval(
                        $submission
                    );

                    break;


            }


        });


    }







    /**
     * Reject Submission
     */
    public function reject(
        Approval $approval,
        ?string $notes = null
    ): void {


        DB::transaction(function () use (
            $approval,
            $notes
        ) {



            $approval->update([

                'status' =>
                    'Rejected',

                'notes' =>
                    $notes,

                'approved_at' =>
                    Carbon::now(),

            ]);




            $approval->load([

                'submission',
                'approver'

            ]);




            $approval
                ->submission
                ->update([

                    'status' =>
                        Submission::REJECTED,

                ]);





            AuditTrailService::rejected(
                $approval
            );



        });


    }







    /**
     * Setelah SPV approve
     * lanjut Director
     */
    private function afterSPV(
        Submission $submission
    ): void {


        $director =
            $this->getUserByRole(
                'Director'
            );



        Approval::create([

            'submission_id' =>
                $submission->id,

            'approver_id' =>
                $director->id,

            'level' =>
                'Director',

            'status' =>
                'Pending',

        ]);




        $submission->update([

            'status' =>
                Submission::WAITING_DIRECTOR,

        ]);

    }







    /**
     * Setelah Manager approve
     * lanjut Director
     */
    private function afterManager(
        Submission $submission
    ): void {



        $director =
            $this->getUserByRole(
                'Director'
            );




        Approval::create([

            'submission_id' =>
                $submission->id,

            'approver_id' =>
                $director->id,

            'level' =>
                'Director',

            'status' =>
                'Pending',

        ]);





        $submission->update([

            'status' =>
                Submission::WAITING_DIRECTOR,

        ]);


    }







    /**
     * Cari user berdasarkan role
     */
    private function getUserByRole(
        string $roleName
    ): User {


        return User::whereHas(
            'role',
            function ($q) use ($roleName) {


                $q->where(
                    'name',
                    $roleName
                );


            }
        )->firstOrFail();


    }








    /**
     * Cek Budget
     * Hanya validasi, tidak mengurangi
     */
    private function checkBudget(
        Submission $submission
    ): bool {


        $budget = Budget::where(
                'category_id',
                $submission->category_id
            )
            ->where(
                'year',
                now()->year
            )
            ->first();



        if (!$budget) {

            return false;

        }




        $remaining =
            $budget->budget_amount
            -
            $budget->used_amount;




        return $remaining >= $submission->amount;


    }








    /**
     * Approval selesai
     * Kirim ke Finance
     */
    private function finishApproval(
        Submission $submission
    ): void {


        if (
            !$this->checkBudget(
                $submission
            )
        ) {



            $submission->update([

                'status' =>
                    Submission::REJECTED,

            ]);





            AuditTrailService::log(

                'Budget',

                'Rejected',

                $submission->id,

                'Pengajuan otomatis ditolak karena budget tidak mencukupi.'

            );



            return;

        }





        /*
        |--------------------------------------------------------------------------
        | IMPORTANT:
        | Jangan kurangi budget disini
        |
        | Budget dipotong ketika Finance melakukan pembayaran
        | di FinanceService::processPayment()
        |--------------------------------------------------------------------------
        */



        $submission->update([

            'status' =>
                Submission::WAITING_FINANCE,

        ]);





        AuditTrailService::log(

            'Approval',

            'Finish',

            $submission->id,

            'Approval selesai dan diteruskan ke Finance.'

        );


    }


}