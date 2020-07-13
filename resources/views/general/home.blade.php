@extends('layout_general.index')
@section('content')
<div class="row page-titles m-t-40">
    <div class="col-sm col-md d-flex align-items-center text-center">
        <div>
            <h1 class="text-themecolor welcome-text">Mau Link Bio Keren ?</h1>
            <form method="GET" action="{{ Route('register') }}">
                <button class="btn btn-success m-t-20" style="padding:10px !important" href="https://wrappixel.com/templates/adminpro/">
                    BUAT GRATIS SEKARANG</button>
            </form><br />
            Sudah punya akun ? <a href="{{ Route('login') }}">Masuk</a>
        </div>
    </div>
    <div class="col-sm col-md d-flex ">
        <img class="ml-auto mr-auto home-phone" style="width: 70%" src="{{ asset('assets/images/home_phone.jpg') }}" />
    </div>
</div>
@endsection
