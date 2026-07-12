<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class FinancePaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function rules(): array
    {
        return [

            'payment_date' => [
                'required',
                'date',
            ],

            'notes' => [
                'nullable',
                'string',
                'max:1000',
            ],

        ];
    }

    public function messages(): array
    {
        return [

            'payment_date.required'
                => 'Tanggal pembayaran wajib diisi.',

            'payment_date.date'
                => 'Format tanggal pembayaran tidak valid.',
        ];
    }
}