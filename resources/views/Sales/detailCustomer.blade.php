@extends('layouts.frontpage')
@section('content')
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBWATSqbKPi6KunkVey74s45OojCu6Ws04&callback=initMap"></script>
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
    async function initMap() {
    // Request needed libraries.
    let latVal = "{{$detailCus->latitude}}";
    let longVal = "{{$detailCus->longtitude}}";
    const { Map } = await google.maps.importLibrary("maps");
    const myLatlng = { lat: latVal, lng: longVal };
    const map = new google.maps.Map(document.getElementById("map"), {
        zoom: 20,
        center: myLatlng,
    });
    // Create the initial InfoWindow.
    let infoWindow = new google.maps.InfoWindow({
        content: "Click the map to get Lat/Lng!",
        position: myLatlng,
    });

    infoWindow.open(map);
    // Configure the click listener.
    map.addListener("click", (mapsMouseEvent) => {
        // Close the current InfoWindow.
        infoWindow.close();
        // Create a new InfoWindow.
        infoWindow = new google.maps.InfoWindow({
        position: mapsMouseEvent.latLng,
        });
        infoWindow.setContent(
        JSON.stringify(mapsMouseEvent.latLng.toJSON(), null, 2),
        );
        infoWindow.open(map);
    });
    }

    initMap();
    
</script>
@endsection