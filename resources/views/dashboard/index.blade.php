@extends('layouts.app')

@section('content')

<div class="container">

    <h2>Dashboard</h2>

    <hr>

    <h4>Selamat datang</h4>

    <p>{{ auth()->user()->name }}</p>

    <p>{{ auth()->user()->role->name }}</p>

</div>

@endsection