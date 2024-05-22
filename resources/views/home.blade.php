@extends('layouts.mainlayout')

@section('title', 'Home')

@section('content')

    <h3>Selamat Datang Kembali, {{ Auth::user()->username }}</h3>
    

@endsection
