<?php

namespace App\Http\Controllers;

use App\Models\AuditTrail;
use App\Models\Payment;
use App\Models\Submission;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();
        $role = $user->role->name;

        /*
        |--------------------------------------------------------------------------
        | Statistik Staff
        |--------------------------------------------------------------------------
        */
        if ($role === 'Staff') {

            $totalSubmission = Submission::where(
                'user_id',
                $user->id
            )->count();

            $totalNominal = Submission::where(
                'user_id',
                $user->id
            )->sum('amount');

            $waiting = Submission::where(
                    'user_id',
                    $user->id
                )
                ->whereIn(
                    'status',
                    [
                        Submission::SUBMITTED,
                        Submission::WAITING_SPV,
                        Submission::WAITING_MANAGER,
                        Submission::WAITING_DIRECTOR,
                        Submission::WAITING_FINANCE,
                    ]
                )
                ->count();

            $paid = Submission::where(
                    'user_id',
                    $user->id
                )
                ->where(
                    'status',
                    Submission::PAID
                )
                ->count();

            $rejected = Submission::where(
                    'user_id',
                    $user->id
                )
                ->where(
                    'status',
                    Submission::REJECTED
                )
                ->count();

            $totalDibayar = Payment::whereHas(
                    'submission',
                    function ($q) use ($user) {

                        $q->where(
                            'user_id',
                            $user->id
                        );
                    }
                )
                ->where(
                    'status',
                    'Paid'
                )
                ->sum('paid_amount');
        }

        /*
        |--------------------------------------------------------------------------
        | Admin / SPV / Manager / Director / Finance
        |--------------------------------------------------------------------------
        */
        else {

            $totalSubmission =
                Submission::count();

            $totalNominal =
                Submission::sum('amount');

            $waiting = Submission::whereIn(
                    'status',
                    [
                        Submission::WAITING_SPV,
                        Submission::WAITING_MANAGER,
                        Submission::WAITING_DIRECTOR,
                        Submission::WAITING_FINANCE,
                    ]
                )
                ->count();

            $paid = Submission::where(
                    'status',
                    Submission::PAID
                )
                ->count();

            $rejected = Submission::where(
                    'status',
                    Submission::REJECTED
                )
                ->count();

            $totalDibayar = Payment::where(
                    'status',
                    'Paid'
                )
                ->sum('paid_amount');
        }

        /*
        |--------------------------------------------------------------------------
        | Statistik Chart
        |--------------------------------------------------------------------------
        */
        $chart = [

            'waiting' => $waiting,

            'paid' => $paid,

            'rejected' => $rejected,

        ];

        /*
        |--------------------------------------------------------------------------
        | Approval Terbaru
        |--------------------------------------------------------------------------
        */
        $approvalList = Submission::with([
                'user',
                'category',
            ])
            ->whereIn(
                'status',
                [
                    Submission::WAITING_SPV,
                    Submission::WAITING_MANAGER,
                    Submission::WAITING_DIRECTOR,
                    Submission::WAITING_FINANCE,
                ]
            )
            ->latest()
            ->take(5)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Aktivitas Terakhir
        |--------------------------------------------------------------------------
        */
        $activities = AuditTrail::with(
                'user'
            )
            ->latest()
            ->take(5)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Audit Trail
        |--------------------------------------------------------------------------
        */
        $auditTrails = AuditTrail::with(
                'user'
            )
            ->latest()
            ->take(10)
            ->get();

        return view(
            'dashboard',
            compact(
                'role',
                'totalSubmission',
                'totalNominal',
                'totalDibayar',
                'waiting',
                'paid',
                'rejected',
                'chart',
                'approvalList',
                'activities',
                'auditTrails'
            )
        );
    }
}
