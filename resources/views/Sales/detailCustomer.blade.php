@extends('layouts.frontpage')
@section('content')
<style>
    /* Gaya untuk memastikan peta ditampilkan dengan benar */
    #map {
        height: 400px; /* Atur tinggi peta */
        width: 100%;  /* Atur lebar peta */
    }
</style>
<?php
$progress = array(
    1=>"Penawaran",
    2=>"Follow Up",
    3=>"Deal",
    4=>"No Deal"
);
?>
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
                    <dl class="row">
                        <dt class="col-md-4">Pemilik Toko</dt>
                        <dd class="col-md-4">{{$detailCus->store_owner}}</dd>
                    </dl>
                    <dl class="row">
                        <dt class="col-md-4">Phone</dt>
                        <dd class="col-md-4">{{$detailCus->phone}}</dd>
                    </dl>
                    <dl class="row">
                        <dt class="col-md-4">Progress</dt>
                        <dd class="col-md-4">{{$progress[$detailCus->progress]}}</dd>
                    </dl>
                    <dl class="row">
                        <dt class="col-md-4">Date Follow Up</dt>
                        <dd class="col-md-4">{{$progress[$detailCus->date_fu]}}</dd>
                    </dl>
                    <dl class="row">
                        <dt class="col-md-4">Foto Toko</dt>
                        <dd class="col-md-4">
                            <img src="{{asset('public/Upload')}}/{{$detailCus->store_name}}/{{$detailCus->picture_store}}" alt="Foto Toko" srcset="" class=" img-thumbnail">
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBWATSqbKPi6KunkVey74s45OojCu6Ws04&callback=initMap&v=weekly" defer ></script>
<script>
    let latVal = {{$detailCus->latitude}};
    let longVal = {{$detailCus->longtitude}};

    // In this example, we center the map, and add a marker, using a LatLng object
    // literal instead of a google.maps.LatLng object. LatLng object literals are
    // a convenient way to add a LatLng coordinate and, in most cases, can be used
    // in place of a google.maps.LatLng object.
    let map;

    function initMap() {
    const mapOptions = {
        zoom: 20,
        center: { lat: latVal, lng: longVal },
        mapTypeId: 'satellite'
    };

    map = new google.maps.Map(document.getElementById("map"), mapOptions);

    const marker = new google.maps.Marker({
        // The below line is equivalent to writing:
        // position: new google.maps.LatLng(-34.397, 150.644)
        position: { lat: latVal, lng: longVal },
        map: map,
    });
    // You can use a LatLng literal in place of a google.maps.LatLng object when
    // creating the Marker object. Once the Marker object is instantiated, its
    // position will be available as a google.maps.LatLng object. In this case,
    // we retrieve the marker's position using the
    // google.maps.LatLng.getPosition() method.
    const infowindow = new google.maps.InfoWindow({
        content: "<p>Marker Location:" + marker.getPosition() + "</p>",
    });

    google.maps.event.addListener(marker, "click", () => {
        infowindow.open(map, marker);
    });
    }

    window.initMap = initMap;
</script>


@endsection