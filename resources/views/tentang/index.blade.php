@extends('layouts.app')
<!DOCTYPE html>
<html>
<head>
   <title>SIG DARATAN | Tentang</title>

</head>
<body>

@section('content')
    <section class="content-header">
        <h1 class="pull-left">Tentang Kami</h1>
        <h1 class="pull-right"></h1>
    </section>
    
    <style type="text/css">
        .rata-kiri {
            text-align: left;
            font-size: 17px;
            font-weight: bold;
        }
        .link {
            text-align: left;
            font-size: 13px;
            font-weight: bold;
        }
        .gambar {
            float: left;
            margin: 5px;
        }
    </style>

    <div class="content">
           @include('flash::message')
        <div class="clearfix"></div>
            <div class="box box-primary">
                <div class="box-body"> 
                    <div class="col-md-90 m-900">
                        <div class="gambar">
                            <img src="{{asset('anisa.jpg')}}" width="250px"></div>
                            <!-- <img src="{{asset('Lambang_Polri.png')}}" width="250px"></div> -->
                        <div class="rata-kiri">
                            <p> Saya Anisa Sundarti dengan NIM H171600574 Jurusan Manajemen Pertanian dari Pogram Studi Teknologi Rekayasa Perangkat Lunak di Politeknik Pertanian Negeri Samarinda sekarang sedang tinggal di Perumahan Pinang Bahari Sebelah Mushola As Shiddiq Kelurahan Gunung Panjang Kecamatan Samarinda Seberang. Tanpa bantuan Allah, kedua orang tua saya, dosen pembimbing dan teman-teman saya, website ini tidak selesai seperti saat ini.</p><br>
                        <div class="link">
                            <p>Kontak Admin : </p>
                            <a href="https://www.instagram.com/_anssund/"><p>
                            <img src="{{asset('ig.jpg')}}"style="width: 55px;height: 45px;"><br>@_anssund </p></a>
                            <a href="https://web.facebook.com/anisa.sundarti"><p>
                            <img src="{{asset('fb.jpg')}}"style="width: 55px;height: 45px;"><br>Anisa Sundarti </p></a>
                            <a href="sundartianisa@gmail.com"><p>
                            <img src="{{asset('Gmail.png')}}"style="width: 45px;height: 45px;"><br>sundartianisa@gmail.com</p></a>
                        </div>
                    </div>
                </div>
            </div>
                </div>
            </div>
        </div>
@endsection

