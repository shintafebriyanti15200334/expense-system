@csrf

<div class="row">

    <div class="col-md-6 mb-3">

        <label class="form-label">
            Tanggal Pengajuan
        </label>

        <input
            type="date"
            name="submission_date"
            class="form-control @error('submission_date') is-invalid @enderror"
            value="{{ old(
                'submission_date',
                isset($submission)
                    ? \Carbon\Carbon::parse($submission->submission_date)->format('Y-m-d')
                    : date('Y-m-d')
            ) }}">


        @error('submission_date')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror

    </div>



    <div class="col-md-6 mb-3">

        <label class="form-label">
            Kategori
        </label>


        <select
            name="category_id"
            class="form-select @error('category_id') is-invalid @enderror">


            <option value="">
                -- Pilih Kategori --
            </option>


            @foreach($categories as $category)

                <option
                    value="{{ $category->id }}"
                    @selected(
                        old(
                            'category_id',
                            $submission->category_id ?? ''
                        ) == $category->id
                    )>

                    {{ $category->name }}

                </option>

            @endforeach


        </select>


        @error('category_id')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror


    </div>

</div>



<div class="mb-3">


    <label class="form-label">
        Nilai Pengajuan
    </label>


    <input
        type="text"
        id="amount"
        name="amount"
        class="form-control @error('amount') is-invalid @enderror"
        value="{{ old(
            'amount',
            isset($submission)
                ? number_format($submission->amount,0,',','.')
                : ''
        ) }}"
        placeholder="Contoh : 3.000.000">


    @error('amount')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror


</div>



<div class="mb-3">


    <label class="form-label">
        Deskripsi
    </label>


    <textarea
        name="description"
        rows="5"
        class="form-control @error('description') is-invalid @enderror"
        placeholder="Masukkan deskripsi pengajuan">{{ old(
            'description',
            $submission->description ?? ''
        ) }}</textarea>


    @error('description')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror


</div>




{{-- Lampiran Lama --}}

@if(isset($submission) && $submission->attachments->count())


<div class="mb-3">


    <label class="form-label">
        Lampiran Saat Ini
    </label>


    <div class="border rounded p-3 bg-light">


        @foreach($submission->attachments as $file)


            <div class="mb-2">


                <a href="{{ asset('storage/'.$file->file_path) }}"
                   target="_blank"
                   class="btn btn-outline-primary btn-sm">


                    <i class="bi bi-paperclip me-1"></i>

                    {{ $file->file_name }}


                </a>


            </div>


        @endforeach


    </div>


</div>


@endif






{{-- Upload Multiple File --}}


<div class="mb-3">


<label class="form-label">

    {{ isset($submission) 
        ? 'Tambah Lampiran Baru' 
        : 'Lampiran' }}

</label>



<input
    type="file"
    name="attachments[]"
    multiple
    class="form-control @error('attachments') is-invalid @enderror"
    accept=".pdf,.jpg,.jpeg,.png">



<small class="text-muted">

    Bisa upload lebih dari satu file.
    <br>

    Format:
    PDF / JPG / JPEG / PNG

    <br>

    Maksimal 5 MB per file.

</small>



@error('attachments')

<div class="invalid-feedback">

    {{ $message }}

</div>

@enderror



@error('attachments.*')

<div class="text-danger small">

    {{ $message }}

</div>

@enderror



</div>







<div class="d-flex justify-content-between">


<a href="{{ route('submissions.index') }}"
   class="btn btn-secondary">


    <i class="bi bi-arrow-left me-1"></i>

    Kembali


</a>



<button type="submit"
        class="btn btn-primary">


    <i class="bi bi-save me-1"></i>

    Simpan


</button>



</div>







<script>

document.addEventListener('DOMContentLoaded', function () {


    const amount =
        document.getElementById('amount');



    amount.addEventListener('input', function(e){


        let value =
            e.target.value.replace(/\D/g,'');



        e.target.value =
            new Intl.NumberFormat('id-ID')
            .format(value);



    });



    amount.closest('form')
        .addEventListener('submit', function(){


            amount.value =
                amount.value.replace(/\./g,'');



        });



});


</script>