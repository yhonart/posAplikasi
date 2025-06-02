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
    async function initMap() {
        // Request needed libraries.
        // const { Map } = await google.maps.importLibrary("maps");
        const myLatlng = { lat: -25.363, lng: 131.044 };
        map = new google.maps.Map(document.getElementById("map"), {
            zoom: 15,
            center: myLatlng,
        });
    }

    initMap();    
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBWATSqbKPi6KunkVey74s45OojCu6Ws04&callback=initMap"></script>

@endsection