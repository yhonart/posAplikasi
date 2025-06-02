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
    /**
 * @license
 * Copyright 2019 Google LLC. All Rights Reserved.
 * SPDX-License-Identifier: Apache-2.0
 */
async function initMap() {
  // Request needed libraries.
  const { Map } = await google.maps.importLibrary("maps");
  const myLatlng = { lat: -6.0416518, lng: 106.0622931 };
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
(g=>{var h,a,k,p="The Google Maps JavaScript API",c="google",l="importLibrary",q="__ib__",m=document,b=window;b=b[c]||(b[c]={});var d=b.maps||(b.maps={}),r=new Set,e=new URLSearchParams,u=()=>h||(h=new Promise(async(f,n)=>{await (a=m.createElement("script"));e.set("libraries",[...r]+"");for(k in g)e.set(k.replace(/[A-Z]/g,t=>"_"+t[0].toLowerCase()),g[k]);e.set("callback",c+".maps."+q);a.src=`https://maps.${c}apis.com/maps/api/js?`+e;d[q]=f;a.onerror=()=>h=n(Error(p+" could not load."));a.nonce=m.querySelector("script[nonce]")?.nonce||"";m.head.append(a)}));d[l]?console.warn(p+" only loads once. Ignoring:",g):d[l]=(f,...n)=>r.add(f)&&u().then(()=>d[l](f,...n))})
        ({key: "AIzaSyBWATSqbKPi6KunkVey74s45OojCu6Ws04", v: "weekly"});
</script>


@endsection