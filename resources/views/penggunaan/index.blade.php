@extends('layouts.app')
<!DOCTYPE html>
<html>
<head>
   <title>SIG DARATAN | Prosedur Aplikasi</title>

</head>
<body>

@section('content')
<section class="content-header">
    <h1 class="pull-left">Informasi Aplikasi</h1>
    <h1 class="pull-right"></h1>
</section>
    
    <style type="text/css">
        .rata-tengah {
            text-align: justify;
            font-size: 13px;
            font-weight: bold ;
        }
    </style>

    <div class="content">
           @include('flash::message')
        <div class="clearfix"></div>
            <div class="box box-primary">
                <div class="box-body"> 
                    <div class="col-md-50 m-500">
                       
                        <div class="rata-tengah">
                            <p>Aplikasi website ini berisikan informasi berupa daerah rawan kejahatan di Kecamatan Samarinda Seberang Dan Loa Janan Ilir. Yang disertai dengan parameter yang digunakan pada saat penelitian berlangsung. Data Historis ini diperoleh dari Polsek Samarinda Seberang dan peneliti sudah meminta izin untuk pembuatan website ini. Pembuatan website ini serta pengolahan data yang digunakan kurang lebih sekitar 7 bulan sebagai syarat kelulusan pada semester akhir. Semoga aplikasi ini dapat membantu dan mempermudah masyarakat umum dalam mendapatkan informasi terkait daerah rawan.</p> <br>       
                            <p>Adapun prosedur untuk menggunakan aplikasi ini sebagai berikut :<br>
                                1. Informasi mengenai daerah rawan disajikan dalam bentuk WebGIS, silahkan klik Tombol WebGIS di pojok kanan atas website ini. <br>
                                2. Terdapat parameter dan informasi yang digunakan untuk membangun WebGIS ini, yang terdapat pada menu peta lokasi. <br>
                                3. Button Pencarian pada peta, dapat digunakan untuk mencari daerah yang rawan di Kecamatan Samarinda Seberang dan Loa Janan ilir dengan menginputkan nama kelurahan sesuai dengan nama yang tertera pada peta. Contoh Rapak Dalam. <br>
                                4. Jika menggunakan smartphone saat membuka website ini, silahkan klik tombol <img src="{{asset('toggle.png')}}"style="width: 20px;height: 20px;"> agar informasi legenda dapat ditutup dan dibuka.
                                </p>
                            </div>
                </div>
                        
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection

