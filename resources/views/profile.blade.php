<!-- profile.blade.php -->
@extends('layouts.mainlayout')

@section('title','Profile')

@section('content')
    <h3>Selamat Datang Kembali, {{Auth::user()->username}}</h3>
    
@endsection
