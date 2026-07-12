<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSubmissionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Route sudah diproteksi middleware auth + role
        return true;
    }

    /**
     * Validation Rules
     */
    public function rules(): array
    {
        return [

            'submission_date' => [
                'required',
                'date',
                'before_or_equal:today',
            ],

            'category_id' => [
                'required',
                'integer',
                'exists:categories,id',
            ],

            'amount' => [
                'required',
                'numeric',
                'gt:0',
                'max:999999999999.99',
            ],

            'description' => [
                'required',
                'string',
                'min:5',
                'max:1000',
            ],

            'attachment' => [
                'nullable',
                'file',
                'mimes:pdf,jpg,jpeg,png',
                'max:5120',
            ],

        ];
    }

    /**
     * Custom Error Messages
     */
    public function messages(): array
    {
        return [

            'submission_date.required' => 'Tanggal pengajuan wajib diisi.',
            'submission_date.date' => 'Format tanggal pengajuan tidak valid.',
            'submission_date.before_or_equal' => 'Tanggal pengajuan tidak boleh melebihi hari ini.',

            'category_id.required' => 'Kategori wajib dipilih.',
            'category_id.integer' => 'Kategori tidak valid.',
            'category_id.exists' => 'Kategori tidak ditemukan.',

            'amount.required' => 'Nilai pengajuan wajib diisi.',
            'amount.numeric' => 'Nilai pengajuan harus berupa angka.',
            'amount.gt' => 'Nilai pengajuan harus lebih dari Rp0.',
            'amount.max' => 'Nilai pengajuan terlalu besar.',

            'description.required' => 'Deskripsi wajib diisi.',
            'description.string' => 'Deskripsi tidak valid.',
            'description.min' => 'Deskripsi minimal 5 karakter.',
            'description.max' => 'Deskripsi maksimal 1000 karakter.',

            'attachment.file' => 'Lampiran harus berupa file.',
            'attachment.mimes' => 'Lampiran hanya boleh berformat PDF, JPG, JPEG, atau PNG.',
            'attachment.max' => 'Ukuran lampiran maksimal 5 MB.',

        ];
    }

    /**
     * Custom Attribute Names
     */
    public function attributes(): array
    {
        return [

            'submission_date' => 'tanggal pengajuan',

            'category_id' => 'kategori',

            'amount' => 'nilai pengajuan',

            'description' => 'deskripsi',

            'attachment' => 'lampiran',

        ];
    }

    /**
     * Prepare data before validation.
     */
    protected function prepareForValidation(): void
    {
        if ($this->has('amount')) {

            $amount = str_replace(
                ['Rp', '.', ' '],
                '',
                $this->amount
            );

            $amount = str_replace(',', '.', $amount);

            $this->merge([
                'amount' => $amount
            ]);
        }
    }
}