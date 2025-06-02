@extends('layouts.frontpage')
@section('content')
<style>
    /* Gaya untuk memastikan peta ditampilkan dengan benar */
    #map {
        height: 400px; /* Atur tinggi peta */
        width: 100%;  /* Atur lebar peta */
    }
</style>
<div class="content mt-1">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-md-12">
                <a href="#" class="btn btn-info btn-flat">Daftar Kunjungan</a>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-md-12">
                <div id="map"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-body shadow border-0">
                    <dl class="row">
                        <dt class="col-md-4">Nama Toko</dt>
                        <dd class="col-md-4">{{$detailCus->store_name}}</dd>
                    </dl>
                </div>
            </div>
        </div>
</div>

<script>
    let map;
    let latVal = {{$detailCus->latitude}};
    let longVal = {{$detailCus->longtitude}};

    function initMap() {
        // Longitude dan Latitude yang ingin Anda tampilkan
        const lokasiSaya = { lat: latVal, lng: longVal }; 
        map = new google.maps.Map(document.getElementById("map"), {
            center: lokasiSaya, // Posisikan peta di lokasi yang ditentukan
            zoom: 20,          // Atur level zoom (semakin tinggi, semakin dekat)
        });       
    }   
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB41DRUbKWJHPxaFjMAwdrzWzbVKartNGg&callback=initMap&loading=async"></script>

@endsection