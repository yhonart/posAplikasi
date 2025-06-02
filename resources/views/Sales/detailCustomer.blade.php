@extends('layouts.frontpage')
@section('content')

<div class="content mt-1">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <a href="#" class="btn btn-info btn-flat">Daftar Kunjungan</a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div id="map"></div>
            </div>
        </div>
</div>

<script>
    /**
     * @license
     * Copyright 2019 Google LLC. All Rights Reserved.
     * SPDX-License-Identifier: Apache-2.0
     */
    let map;
    function initMap() {
        // Longitude dan Latitude yang ingin Anda tampilkan
        const lokasiSaya = { lat: -6.1753924, lng: 106.8271528 }; // Contoh: Monas, Jakarta

        // Buat objek peta baru
        map = new google.maps.Map(document.getElementById("map"), {
            center: lokasiSaya, // Posisikan peta di lokasi yang ditentukan
            zoom: 15,          // Atur level zoom (semakin tinggi, semakin dekat)
        });

        // Tambahkan marker ke peta
        new google.maps.Marker({
            position: lokasiSaya, // Posisi marker
            map: map,             // Objek peta
            title: "Lokasi Saya!" // Tooltip saat di-hover
        });
    }   
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBWATSqbKPi6KunkVey74s45OojCu6Ws04&callback=initMap"></script>

@endsection