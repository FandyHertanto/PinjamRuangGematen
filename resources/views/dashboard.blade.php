@extends('layouts.mainlayout')

@section('title','dashboard')

@section('content')

<h3>Selamat Datang Kembali, {{Auth::user()->username}}</h3>

<div class='row mt-5'>
    <div class='col-lg-4'>
        <div class="card-data rooms">
            <div class="row">
                <div class="col-6"><i class="bi bi-buildings"></i></div>
                <div class="col-6 d-flex flex-column justify-content-center align-items-end">
                    <div class='card-desc'>Ruangan</div>
                    <div class='card-count'>{{$room_count}}</div>
                </div>
            </div>
        </div>
    </div>
    <div class='col-lg-4'>
        <div class="card-data users">
            <div class="row">
                <div class="col-6"><i class="bi bi-people"></i></div>
                <div class="col-6 d-flex flex-column justify-content-center align-items-end">
                    <div class='card-desc'>Pengguna</div>
                    <div class='card-count'>{{$user_count}}</div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
