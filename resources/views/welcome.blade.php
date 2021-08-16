<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>SIG DARATAN</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">

        <!-- Styles -->
        <style>
            body {
                background-color: #20B2AA;
                /*color: #FFFFFF;*/
                border: 100px;
                font-family: 'Nunito', sans-serif;
                font-weight: bold ;
                font-style: italic ;
                max-height: 100vh;
                margin: 0;
                
            }
            
            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .title {
                font-size: 23px;
                text-align: center;
                font-weight: bold ;
            }

            .links > a {
                color: #000000;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 10px;
                font-weight: bold ;
            }

            .rata-tengah {
            text-align: justify;
            max-width: 1024px;
            font-size: 13px;
            font-weight: bold;
            margin-top: 2rem;
        }
        </style>
    </head>
    <body class="background">

        <div class="flex-center full-height position-ref " >
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>

                    @else
                        <a href="{{ route('peta.index')}}">WebGIS</a>
                        <!-- <a href="{{ route('login') }}">Login</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif -->
                    @endauth
                </div>
            @endif

         
                <div class="title m-b-md">
                    <img src="{{asset('Lambang_Polri.png')}}"style="width: 150px;height: 150px;"> 
                    <br> SISTEM INFORMASI GEOGRAFIS
                    <br> DAERAH RAWAN KEJAHATAN DI KECAMATAN SAMARINDA SEBERANG DAN KECAMATAN LOA JANAN ILIR 
                                        
                <!-- <div class="rata-tengah">
                    <p>Aplikasi website ini berisikan informasi berupa daerah rawan kejahatan di Kecamatan Samarinda Seberang Dan Loa Janan Ilir. Yang disertai dengan parameter yang digunakan pada saat penelitian berlangsung. Data Historis ini diperoleh dari Polsek Samarinda Seberang dan peneliti sudah meminta izin untuk pembuatan website ini. Pembuatan website ini serta pengolahan data yang digunakan kurang lebih sekitar 7 bulan sebagai syarat kelulusan pada semester akhir. Semoga aplikasi ini dapat membantu dan mempermudah masyarakat umum dalam mendapatkan informasi terkait daerah rawan.</p>        
                    <p>Adapun prosedur untuk masuk aplikasi ini sebagai berikut :<br>
                        1. Informasi mengenai daerah rawan disajikan dalam bentuk WebGIS, silahkan klik Tombol WebGIS di pojok kanan atas website ini. <br>
                        2. Terdapat parameter dan informasi yang digunakan untuk membangun WebGIS ini, yang terdapat pada menu peta lokasi. <br>
                        3. Button Pencarian pada peta, dapat digunakan untuk mencari daerah yang rawan di Kecamatan Samarinda Seberang dan Loa Janan ilir dengan menginputkan nama kelurahan sesuai dengan nama yang tertera pada peta. Contoh Rapak Dalam. <br>
                        4. Jika menggunakan smartphone saat membuka website ini, silahkan klik tombol<img src="{{asset('toggle.png')}}"style="width: 20px;height: 20px;"> agar informasi legenda dapat ditutup dan dibuka.
                        </p>
                    </div>
                </div> -->

        </div>
    </body>
</html>
