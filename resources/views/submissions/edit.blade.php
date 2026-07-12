@extends('layouts.app')

@section('title', 'Edit Pengajuan')

@section('content')

<div class="container py-4">

    <div class="card shadow-sm">

        <div class="card-header">

            <h4 class="mb-0">
                Edit Pengajuan
            </h4>

        </div>

        <div class="card-body">

            <form
                action="{{ route('submissions.update', $submission) }}"
                method="POST"
                enctype="multipart/form-data">

                @csrf
                @method('PUT')

                @include('submissions._form')

            </form>

        </div>

    </div>

</div>

@endsection