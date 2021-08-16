@extends('layouts.app')
<title>SIG DARATAN | Peta Lokasi</title>
@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet-minimap/3.6.1/Control.MiniMap.min.css" integrity="sha512-qm+jY0iQ4Xf5RL79UB75REDLYD0jtvxxVZp2RVIW8sm8RNiHdeN43oksqUPrBIshJtQcVPrAL08ML2Db8fFZiA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin="anonymous"/>
    <link rel="stylesheet" href="{{ asset('leaflet/leaflet.css') }}" />
    <link rel="stylesheet" href="https://labs.easyblog.it/maps/leaflet-compass/src/leaflet-compass.css">

    <style>
        #map {
            width: 100%;
            height: 720px;
            max-width: 100vw;
            max-height: 75vh;
            padding: 0;
            margin-top: 0;
        }

        .legenda-tanam-kota {
            width: 15px;
            height: 13px;
            display: inline-block;
        }

        .semak_belukar {
            background: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAQAAAAECAYAAACp8Z5+AAAAFUlEQVQYV2NkQAOMRAn8Z2BggKsEAA3qAQXsNBkiAAAAAElFTkSuQmCC) repeat, #FF7F50;
        }

        .sawah {
            background: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAUAAAAFCAYAAACNbyblAAAAJUlEQVQYV2NkwAT/GdHE/jMwMDAiC4IFQIpggjABuEq4CqhR/wEbSQcEChQUOwAAAABJRU5ErkJggg==) repeat, #008080;
        }

        .rawa {
            background: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAN0lEQVQoU2NkIAIwEqHmPyFF/xkYGBgJKQJbhEsR2ASYU7ApQlGAzyQU/yCbhGECunU4FYAUAgBp4wYJ31jKswAAAABJRU5ErkJggg==) repeat, #778899;
        }

    </style>
@endsection

@section('content')
    <section class="content-header">
        <h1 class="pull-left">Peta Daerah Rawan Kejahatan</h1>
    </section>
    <div class="content">
        <div class="row">
            <div class="col-12">
                <div id="map"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">Keterangan :</div>
            <div class="col-12">
                <ul class="list-group" id="get_data" style="max-height: 720px; overflow-y: auto; overflow-x: hidden"></ul>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script>
    @foreach(\App\Models\File::all() as $data)
        @php
            $url = file_get_contents(public_path('storage/' . $data->path));
            echo $data->nama . ' = ' . $url . ';';
            $json = json_encode($url ?? '');
        @endphp
    @endforeach

    // Polygon style property
    function polygonStyle(feature) {
        var warna = {
            "color": "#000000",
            "weight": 0,
            "fillColor": "#000000",
            "fillOpacity": 0,
            "fill": "solid"
        }
        
        if ('Tingkat_Ke' in feature.properties){
            const Tingkat_Ke = {
                "Sangat Rawan": "#FF0000",
                "Rawan": "#FFFF00",
                "Tidak Rawan":"#00FF00"
            };
            warna.weight=1;
            warna.fillOpacity=0.65;
            warna.fillColor = Tingkat_Ke[feature.properties.Tingkat_Ke];
            return warna;
        }
        if ('Status' in feature.properties){
            const Status = {
                1: "#ff1493",
                2: "#ff8c00"

            };
            warna.weight=1;
            warna.fillOpacity=0.65;
            warna.fillColor = Status[feature.properties.Status];
            return warna;
        }
        if ('Skor' in feature.properties){
            const Skor = {
                1: "#a0522d",
                2: "#708090"

            };
            warna.weight=1;
            warna.fillOpacity=0.65;
            warna.fillColor = Skor[feature.properties.Skor];
            return warna;
        }

        if ('NAMOBJ' in feature.properties) {
            const NAMOBJ = {
                "SAMARINDA SEBERANG": "#D928C9",
                "LOA JANAN ILIR": "#998E0A"
            };
            warna.fillColor = "#808080";
            warna.weight += 3;
            warna.color = NAMOBJ[feature.properties.NAMOBJ];
            
            map.on('zoomed', function(){
            var zoomed = map.getZoom();
                console.log(zoomed);
                if (zoomed <= 10){
                    warna.weight-=2;
                }
            });
            return warna;

        }

        if ('T_Lahan_12' in feature.properties) {
            const T_Lahan_12 = {
                "Permukiman": () => warna.fillColor = "#D2691E", //Chocolate
                "Semak Belukar": () => {
                    warna.fillColor = "#FF7F50" //Coral
                    warna.fill = "url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAQAAAAECAYAAACp8Z5+AAAAFUlEQVQYV2NkQAOMRAn8Z2BggKsEAA3qAQXsNBkiAAAAAElFTkSuQmCC)";
                },
                "Sawah": () => {
                    warna.fillColor = "#008080", //Teal
                    warna.fill = "url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAUAAAAFCAYAAACNbyblAAAAJUlEQVQYV2NkwAT/GdHE/jMwMDAiC4IFQIpggjABuEq4CqhR/wEbSQcEChQUOwAAAABJRU5ErkJggg==)";
                },
                "Rawa": () => {
                    warna.fillColor = "#778899", //Light Slate Gray
                    warna.fill = "url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAN0lEQVQoU2NkIAIwEqHmPyFF/xkYGBgJKQJbhEsR2ASYU7ApQlGAzyQU/yCbhGECunU4FYAUAgBp4wYJ31jKswAAAABJRU5ErkJggg==)";
                },
                "Hutan Rakyat": () => warna.fillColor = "#7FFF00", //Chartreuse
                "Perkebunan": () => warna.fillColor = "#006400", //Dark Green
                "Taman Kota": () => warna.fillColor = "#9ACD32", //Yellow Green
            }
            warna.weight = 1;
            warna.fillOpacity = 0.6;
            T_Lahan_12[feature.properties.T_Lahan_12];
            return warna;
        }
    }

    // POP UP PETA
    function onEachFeature(feature, layer) {
        if ('Peristiwa' in feature.properties) {
            layer.bindPopup('<br> Peristiwa : <b>' + feature.properties.Peristiwa.toString()).openPopup();
        }
    }

    // TITIK LEGEND PETA
    function pointToLayer(feature, latlng) {
        var jenisKerja = {
            1: 'green',
            2: 'red',
            3: 'blue',
            4: 'yellow',
        }

        return L.circleMarker(latlng, {
            radius: 6,
            fillColor: jenisKerja[feature.properties.Jenis_Keja],
            color: jenisKerja[feature.properties.Jenis_Keja],
            weight: 1,
            opacity: 1,
            fillOpacity: 0.8
        });
    }

    //definisi warna legenda
    function getLegendaColor(area) {
        return {
            // pencurian
            "Pencurian Biasa (CUBIS)": 'green',
            "Pencurian Bermotor (CURANMOR)": 'red',
            "Pencurian Pemberatan (CURAT)": 'blue',
            "Pencurian dengan Kekerasan (CURAS)": 'yellow',

            // garis jalan
            "Ada Lampu Tidak Nyala": '#CD5C5C',
            "Ada Penerangan Ada Pemukiman": '#FF1493',
            "Tidak Nyala Jarang Pemukiman": '#8B4513',
            "Tidak Ada Penerangan Jarang Pemukiman": '#000080',
            "Tidak Ada Penerangan Ada Pemukiman": '#2F4F4F',
            "Tidak Ada Penerangan Tidak Ada Pemukiman": '#000000',

            // kecamatan
            "Kec. Samarinda Seberang": '#D928C9',
            "Kec. Loa Janan Ilir": '#998E0A',

            tutupan
            "Permukiman": '#D2691E',
            "Semak Belukar": '#FF7F50',
            "Sawah": '#008080',
            "Rawa": '#778899',
            "Hutan Rakyat": '#7FFF00',
            "Perkebunan": '#006400',
            "Taman Kota": '#9ACD32',

            //tutupanlahananalisa
            "Permukiman":'#a0522d',
            "Non Permukiman":'#708090',

            //penerangananalisa
            "Penerangan":'#ff1493',
            "Non Penerangan":'#ff8c00',

            //analisadata2019
            "Sangat Rawan":'#FF0000',
            "Rawan":'#FFFF00',
            "Tidak Rawan":' #00FF00'
        }[area];
    }

    function legendaMaker(labels, div, radius=1000, lebar=10) {
        for (i = 0; i < labels.length; i++) {
            div.innerHTML += '<i style="background:' + getLegendaColor(labels[i]) + '; border-radius:'+radius+'px; width:'+lebar+'px; height:10px; display:inline-block;  ">&nbsp;&nbsp;</i>&nbsp;&nbsp;' + labels[i] + '<br>';
        }
    }

    function getData(features) {
        for (i = 0; i < features.length; i++) {
            var properties = features[i].properties;
            var ul = document.getElementById('get_data');
            var li = document.createElement('li');
            li.setAttribute('class', 'list-group-item');
            li.setAttribute('data-id', features[i].id);
            var kelurahan = document.createElement('h5');
            kelurahan.appendChild(document.createTextNode(properties.Kelurahan));
            var peristiwa = document.createElement('span');
            peristiwa.appendChild(document.createTextNode(properties.Peristiwa));
            peristiwa.setAttribute('class', 'text-primary');
            li.innerHTML += kelurahan.outerHTML + peristiwa.outerHTML;
            ul.appendChild(li);
        }
    }

    tdk_penerangan_jrg_pemukiman.features.forEach((feature) => feature.properties.Name = "tpjp");

    // pemanggil fungsi get data
    getData(data2019.features);

    //munculkan peta
    var map = L.map('map').setView([-0.5521802589467355, 117.11963572862538], 12);

    map.invalidateSize();

    map.addControl(new L.Control.Compass({ position: 'bottomleft', autoActive: true }));

    var tilelayer = L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> Anisa Sundarti'
    }).addTo(map);
    
     var tilelayer1 = L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> Anisa Sundarti'
    });
    var mapLink = '<a href="http://www.esri.com/">Esri Anisa Sundarti</a>';
    var whoLink = 'i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community';

    var satelite = L.tileLayer('http://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
            attribution: '&copy; ' + mapLink + ', ' + whoLink,
            maxZoom: 18,
        });

    //Layer Data Peta
    var dataLayer2019 = L.geoJSON(data2019, {
        onEachFeature: onEachFeature,
        pointToLayer: pointToLayer
    });

    var dataLayer2020 = L.geoJSON(data2020, {
        onEachFeature: onEachFeature,
        pointToLayer: pointToLayer
    });

    var dataLayerLampu1 = L.geoJSON([
        ada_lampu_tdk_nyala,
        ada_penerangan_ada_pemukiman,
        ada_penerangan_jrg_pemukiman,
        tdk_nyala_jrg_pemukiman,
        tdk_penerangan_jrg_pemukiman,
        tdkada_penerangan_ada_pemukiman,
        tdkada_penerangan_tdkada_pemukiman1
    ], {
        style: function(feature) {
            var colors = {
                "TDKN?ALA": '#CD5C5C',
                "TDKNYALA": '#CD5C5C',
                "ADAPNR": '#FF1493',
                "ADAPNRTDKPMKN": '#8B4513',
                "TDKNYALJRJR": '#000080',
                "tpjp": '#2F4F4F',
                "TDKPNRPMUKN": '#800080',
                "TDKPNRSMKI": '#9E1F13',
            }

            return {
                "color": colors[feature.properties.Name],
                "weight": "5",
                "opacity": 0.65
            }
        }
    });
    var legendMarker = L.layerGroup();

    var dataLayerBatas1 = L.geoJSON(batas_kecamatan_fix, { style: polygonStyle });
    var fix_tutupan_lahan = L.geoJSON(tutupan_lahan, { style: polygonStyle });
    var fix_penerangan = L.geoJSON(penerangan, { style: polygonStyle });
    var data_analisa_19 = L.geoJSON(analisadata2019, { style: polygonStyle });
    var data_analisa_20 = L.geoJSON(analisadata2020, { style: polygonStyle });
    var data_gabung = L.geoJSON(gabungan_data, { onEachFeature: onEachFeature,
        pointToLayer: pointToLayer });
    var data_analisa_gabung = L.geoJSON(dataanalisagabung, { style: polygonStyle });

    var dataLayerTutupan = L.geoJSON(tutupanlahanfix, {
        style: polygonStyle,
        onEachFeature: function(feature, layer) {
            if (feature.properties.T_Lahan_12 == "Taman Kota") {
                var center = layer.getBounds().getCenter();
                var marker = L.marker(center, {
                    icon: L.icon({
                        iconUrl: "{{ asset('TAMANKOTA.png') }}",
                        iconSize: [50, 50]
                    })
                });
                var polygonAndItsCenter = L.layerGroup([layer, marker]).addTo(legendMarker);
            }
        }
    });

    //untuk PENDEFINISI legenda
    var titikkasus = L.control({ position: 'topright' });

    titikkasus.onAdd = function(map) {
        var div = L.DomUtil.create('div', 'box box-primary hidden-xs visible-lg-block legenda');
        var labels = [
            "Pencurian Biasa (CUBIS)",
            "Pencurian Bermotor (CURANMOR)",
            "Pencurian Pemberatan (CURAT)",
            "Pencurian dengan Kekerasan (CURAS)"
        ];

        var garisjalan = [
            "Ada Lampu Tidak Nyala",
            "Ada Penerangan Ada Pemukiman",
            "Tidak Nyala Jarang Pemukiman",
            "Tidak Ada Penerangan Jrg Pemukiman",
            "Tidak Ada Penerangan Ada Pemukiman",
            "Tidak Ada Penerangan Tidak Ada Pemukiman"
        ];

        var kecamatan1 = [
            "Kec. Samarinda Seberang",
            "Kec. Loa Janan Ilir"
        ];

        var tutupan1 = [
            "Permukiman",
            "Semak Belukar",
            "Sawah",
            "Rawa",
            "Hutan Rakyat",
            "Perkebunan",
            "Taman Kota"
        ];

        var fix_tutupan_lahan =[
            "Permukiman",
            "Non Permukiman"
        ];

        var fix_penerangan=[
            "Penerangan",
            "Non Penerangan"
        ];

        var data_analisa_19=[
            "Sangat Rawan",
            "Rawan",
            "Tidak Rawan"
        ];


        div.innerHTML = '<div><b>Keterangan :</b></div>';

        // kejahatan
        legendaMaker(labels, div);
        // legendaMarker(garisjalan, div);
        legendaMaker(kecamatan1, div, 0, 15);
        legendaMaker(fix_penerangan, div, 0, 15);
        legendaMaker(fix_tutupan_lahan, div, 0, 15);
        legendaMaker(data_analisa_19, div, 0, 15);

        for (var i = 0; i < tutupan1.length - 1; i++) {
            if (i == 1) {
                div.innerHTML += '<i class="semak_belukar" style=" width:15px; height:10px; display:inline-block; vertical-align:baseline; ">&nbsp;&nbsp;</i>&nbsp;&nbsp;' + tutupan1[i] + '<br>';
            } else if (i == 2) {
                div.innerHTML += '<i class="sawah" style=" width:15px; height:10px; display:inline-block; vertical-align:baseline; ">&nbsp;&nbsp;</i>&nbsp;&nbsp;' + tutupan1[i] + '<br>';
            } else if (i == 3) {
                div.innerHTML += '<i class="rawa" style=" width:15px; height:10px; display:inline-block; vertical-align:baseline; ">&nbsp;&nbsp;</i>&nbsp;&nbsp;' + tutupan1[i] + '<br>';
            } else {
                div.innerHTML += '<i style="background:' + getLegendaColor(tutupan1[i]) + '; width:15px; height:10px; display:inline-block; vertical-align:baseline; ">&nbsp;&nbsp;</i>&nbsp;&nbsp;' + tutupan1[i] + '<br>';
            }
        }
        div.innerHTML += '<img class="legenda-tanam-kota" src="{{ asset('TAMANKOTA.png') }}">' + tutupan1[i] + '<br>';
        return div;
    }
    titikkasus.addTo(map);

    var divHome = L.control({ position: 'topleft' });

    divHome.onAdd = function(map) {
        var divHome = L.DomUtil.create('div');
        divHome.innerHTML += '<button onclick="refresh()" class="btn btn-primary"> <i class="fa fa-home" aria-hidden="true"></i></button>';
        return divHome;
    }
    divHome.addTo(map);

    var divSearch = L.control({ position: 'topleft' });

    divSearch.onAdd = function(map) {
        var divSearch = L.DomUtil.create('div');
        divSearch.innerHTML += '<button onclick="toggleCari()" class="btn btn-primary"> <i class="fa fa-search" aria-hidden="true"></i></button>';
        
        var divCari = L.DomUtil.create('div');
        divCari.setAttribute('id', 'divCari');
        divCari.style.display = "none";

        var formCari = document.createElement('input');
        formCari.setAttribute('type','text');
        formCari.setAttribute('name','cari');
        formCari.setAttribute('id','cari');
        formCari.setAttribute('placeholder','cari');
        formCari.addEventListener('input',cari);
        divCari.appendChild(formCari);
        divSearch.appendChild(divCari);
        return divSearch;
    }
    divSearch.addTo(map);

    var toggle1 = false;
    var toggleSearch = false;
    function toggleCari() {
        var textCari = document.getElementById('divCari');
        toggleSearch = !toggleSearch;
        if (!toggleSearch) {
            textCari.style.display = "none";
        } else {
            textCari.style.display = "block";
        }
    }

    var divToggle = L.control({ position: 'topleft' });

    divToggle.onAdd = function(map) {
        var divToggle1 = L.DomUtil.create('div');
        divToggle1.innerHTML += '<button onclick="ToggleLegenda()" class="btn btn-primary"> <i class="fa fa-caret-square-o-down" aria-hidden="true"></i></button>';
        return divToggle1;
    }
    divToggle.addTo(map);

    function refresh() {
        map.setView([-0.5521802589467355, 117.11963572862538], 12);
    }

    function ToggleLegenda() {
        toggle1 = !toggle1;
        var div = document.getElementsByClassName('legenda')[0];
        if (toggle1) {
            div.classList.remove('visible-lg-block');
            div.classList.remove('hidden-xs');
        } else {
            div.classList.add('visible-lg-block');
            div.classList.add('hidden-xs');
        }
        console.log(div);
    }

    var find = L.geoJSON();
    function cari(e){
        var search = e.target.value;
        map.removeLayer(find);
        find = L.geoJSON(null,{
            onEachFeature : onEachFeature,
            pointToLayer : pointToLayer, 
            filter : function(feature,layer){
                return search.match(feature.properties.Kelurahan);
            }
        }).addTo(map);
        find.addData(data_gabung.toGeoJSON());
    }
    

    //skala peta
    L.control.scale({
        options: {
            metric: true,
            imperial: false,
            updateWhenIdle: false
        }
    }).addTo(map);

    //layer peta
    var petaLayer = {
        'Open Street Map': tilelayer,
        'Google Satelite': satelite
    };

    var baseMaps = {
        'History 2019': dataLayer2019,
        'History 2020': dataLayer2020,
        'Penerangan': dataLayerLampu1,
        'Tutupan Lahan': dataLayerTutupan,
        'Status Penerangan' : fix_penerangan,
        'Tutupan Lahan ' : fix_tutupan_lahan,
        'Daerah Rawan Kejahatan 2019' : data_analisa_19,
        'Daerah Rawan Kejahatan 2020' : data_analisa_20,
        'data gabung' : data_gabung,
        'analisa gabung' : data_analisa_gabung,
        'Legend marker': legendMarker,
        'Batas Administrasi Samarinda Seberang & Loa Janan Ilir': dataLayerBatas1
    };

    L.control.layers(petaLayer, baseMaps, { position: 'topleft' }).addTo(map);

    //mini map
    var miniMap = new L.Control.MiniMap(tilelayer1, {
        centerFixed: [-0.5521802589467355, 117.11963572862538],
        zoomLevelFixed: 9
    }).addTo(map);

    //judul layer data
    var node1 = document.createElement("label");
    var textnode1 = document.createTextNode("Parameter");
    node1.appendChild(textnode1);

    var parameter = document.getElementsByClassName("leaflet-control-layers-overlays")[0];
    parameter.insertBefore(node1, parameter.childNodes[2]);

    var node = document.createElement("label");
    var textnode = document.createTextNode("Peta");
    node.appendChild(textnode);

    document.getElementsByClassName("leaflet-control-layers-overlays")[0].prepend(node);
</script>
@endsection
