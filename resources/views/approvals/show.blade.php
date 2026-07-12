@extends('layouts.app')

@section('title','Detail Approval')

@section('content')

<div class="container py-4">


    <div class="card shadow-sm mb-4">

        <div class="card-header d-flex justify-content-between align-items-center">

            <h4 class="mb-0">
                Detail Pengajuan
            </h4>

            <a href="{{ route('approvals.index') }}"
               class="btn btn-danger btn-sm">

                Kembali

            </a>

        </div>


        <div class="card-body">


            <table class="table table-bordered">


                <tr>
                    <th width="250">
                        Nomor Pengajuan
                    </th>

                    <td>
                        {{ $approval->submission->submission_number }}
                    </td>
                </tr>


                <tr>
                    <th>
                        Tanggal Pengajuan
                    </th>

                    <td>
                        {{ $approval->submission->submission_date->format('d-m-Y') }}
                    </td>
                </tr>


                <tr>
                    <th>
                        Nama Pengaju
                    </th>

                    <td>
                        {{ $approval->submission->user->name }}
                    </td>
                </tr>


                <tr>
                    <th>
                        Kategori
                    </th>

                    <td>
                        {{ $approval->submission->category->name }}
                    </td>
                </tr>


                <tr>
                    <th>
                        Nominal
                    </th>

                    <td>
                        Rp {{ number_format($approval->submission->amount,0,',','.') }}
                    </td>
                </tr>


                <tr>
                    <th>
                        Deskripsi
                    </th>

                    <td>
                        {!! nl2br(e($approval->submission->description)) !!}
                    </td>
                </tr>


                <tr>
    <th>
        Lampiran
    </th>

    <td>


        @if(
            $approval->submission->attachments &&
            $approval->submission->attachments->count()
        )


            @foreach($approval->submission->attachments as $attachment)


                <div class="mb-2">


                    <a href="{{ asset('storage/'.$attachment->file_path) }}"
                       target="_blank"
                       class="btn btn-primary btn-sm">


                        <i class="bi bi-paperclip me-1"></i>

                        {{ $attachment->file_name }}


                    </a>


                </div>


            @endforeach



        @else


            <span class="text-muted">

                Tidak ada lampiran

            </span>


        @endif


    </td>
</tr>

                <tr>
                    <th>
                        Level Approval
                    </th>

                    <td>

                        <span class="badge bg-info">

                            {{ $approval->level }}

                        </span>

                    </td>
                </tr>


            </table>


        </div>

    </div>



    {{-- FORM APPROVAL --}}

    @if($approval->status === 'Pending')


    <div class="card shadow-sm">


        <div class="card-header">

            <h5 class="mb-0">
                Proses Approval
            </h5>

        </div>


        <div class="card-body">


            <form method="POST">

                @csrf


                <div class="mb-3">


                    <label class="form-label">

                        Catatan Approval

                    </label>


                    <textarea
                        name="notes"
                        class="form-control"
                        rows="4"
                        placeholder="Tambahkan catatan jika diperlukan">{{ old('notes') }}</textarea>


                    @error('notes')

                        <small class="text-danger">

                            {{ $message }}

                        </small>

                    @enderror


                </div>



                <div class="d-flex gap-2">


                    <button
                        type="submit"
                        formaction="{{ route('approvals.approve',$approval) }}"
                        class="btn btn-success">

                        ✓ Approve

                    </button>



                    <button
                        type="submit"
                        formaction="{{ route('approvals.reject',$approval) }}"
                        class="btn btn-danger">

                        ✕ Reject

                    </button>


                </div>


            </form>


        </div>


    </div>


    @else


    <div class="alert alert-secondary">

        Approval sudah diproses.

    </div>


    @endif



</div>

@endsection