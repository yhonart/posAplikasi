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
<script>(g=>{var h,a,k,p="The Google Maps JavaScript API",c="google",l="importLibrary",q="__ib__",m=document,b=window;b=b[c]||(b[c]={});var d=b.maps||(b.maps={}),r=new Set,e=new URLSearchParams,u=()=>h||(h=new Promise(async(f,n)=>{await (a=m.createElement("script"));e.set("libraries",[...r]+"");for(k in g)e.set(k.replace(/[A-Z]/g,t=>"_"+t[0].toLowerCase()),g[k]);e.set("callback",c+".maps."+q);a.src=`https://maps.${c}apis.com/maps/api/js?`+e;d[q]=f;a.onerror=()=>h=n(Error(p+" could not load."));a.nonce=m.querySelector("script[nonce]")?.nonce||"";m.head.append(a)}));d[l]?console.warn(p+" only loads once. Ignoring:",g):d[l]=(f,...n)=>r.add(f)&&u().then(()=>d[l](f,...n))})
        ({key: "AIzaSyBWATSqbKPi6KunkVey74s45OojCu6Ws04", v: "weekly"});</script>
<script>
    let latVal = {{$detailCus->latitude}};
    let longVal = {{$detailCus->longtitude}};
    let map;
    function initMap() {
    const chicago = new google.maps.LatLng(longVal, latVal);
    const map = new google.maps.Map(document.getElementById("map"), {
        center: chicago,
        zoom: 3,
    });
    const coordInfoWindow = new google.maps.InfoWindow();

    coordInfoWindow.setContent(createInfoWindowContent(chicago, map.getZoom()));
    coordInfoWindow.setPosition(chicago);
    coordInfoWindow.open(map);
    map.addListener("zoom_changed", () => {
        coordInfoWindow.setContent(createInfoWindowContent(chicago, map.getZoom()));
        coordInfoWindow.open(map);
    });
    }

    const TILE_SIZE = 256;

    function createInfoWindowContent(latLng, zoom) {
    const scale = 1 << zoom;
    const worldCoordinate = project(latLng);
    const pixelCoordinate = new google.maps.Point(
        Math.floor(worldCoordinate.x * scale),
        Math.floor(worldCoordinate.y * scale),
    );
    const tileCoordinate = new google.maps.Point(
        Math.floor((worldCoordinate.x * scale) / TILE_SIZE),
        Math.floor((worldCoordinate.y * scale) / TILE_SIZE),
    );
    return [
        "LatLng: " + latLng,
        "Zoom level: " + zoom,
        "World Coordinate: " + worldCoordinate,
        "Pixel Coordinate: " + pixelCoordinate,
        "Tile Coordinate: " + tileCoordinate,
    ].join("<br>");
    }

    // The mapping between latitude, longitude and pixels is defined by the web
    // mercator projection.
    function project(latLng) {
    let siny = Math.sin((latLng.lat() * Math.PI) / 180);

    // Truncating to 0.9999 effectively limits latitude to 89.189. This is
    // about a third of a tile past the edge of the world tile.
    siny = Math.min(Math.max(siny, -0.9999), 0.9999);
    return new google.maps.Point(
        TILE_SIZE * (0.5 + latLng.lng() / 360),
        TILE_SIZE * (0.5 - Math.log((1 + siny) / (1 - siny)) / (4 * Math.PI)),
    );
    }

    window.initMap = initMap;
</script>


@endsection