<script async defer src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initMap"></script>
<div class="row">
    <div class="col-md-12">
        <form id="inputFormKunjungan">
            <div class="form-group row">
                <label for="store" class="col-md-4">Nama Toko</label>
                <div class="col-md-4">
                    <input type="text" class="form-control form-control-sm" name="store" id="store">
                </div>
            </div>
            <div class="form-group row">
                <label for="storeOwner" class="col-md-4">Nama Pemilik Toko</label>
                <div class="col-md-4">
                    <input type="text" class="form-control form-control-sm" name="storeOwner" id="storeOwner">
                </div>
            </div>
            <div class="form-group row">
                <label for="phone" class="col-md-4">No.Telefone Toko</label>
                <div class="col-md-4">
                    <input type="text" class="form-control form-control-sm" name="phone" id="phone">
                </div>
            </div>
            <div class="form-group row">
                <label for="progress" class="col-md-4">Progress</label>
                <div class="col-md-4">
                    <select name="progress" id="progress" class="form-control form-control-sm">
                        <option value="1">Penawaran</option>
                        <option value="2">Follow Up</option>
                        <option value="3">Deal</option>
                        <option value="4">No Deal</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="dateFU" class="col-md-4">Tanggal Follow Up</label>
                <div class="col-md-4">
                    <input type="text" class="form-control form-control-sm" name="dateFU" id="dateFU">
                </div>
            </div>
            <hr>
            <div class="form-group">
                <button type="button" class="btn btn-sm btn-danger" onclick="getLocation()"><i class="fa-solid fa-map-location"></i> Get Location</button>
            </div>
            <div class="form-group row">
                <label for="Latitude" class="col-md-4">Latitude</label>
                <div class="col-md-4">
                    <input type="text" class="form-control form-control-sm" name="Latitude" id="Latitude" readonly>
                </div>
            </div>
            <div class="form-group row">
                <label for="Longitude" class="col-md-4">Longitude</label>
                <div class="col-md-4">
                    <input type="text" class="form-control form-control-sm" name="Longitude" id="Longitude" readonly>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-12">
                    <div id="map"></div>
                </div>
            </div>
            <hr>
            <div class="form-group row">
                <label for="fotoToko" class="col-md-4">Foto Toko</label>
                <div class="col-md-4">
                    <input type="file" class="form-control-file" name="fotoToko" id="fotoToko">
                </div>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success font-weight-bold" id="btnSaveKunjungan"><i class="fa-solid fa-floppy-disk"></i> Simpan</button>
            </div>
        </form>
    </div>
</div>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    const inLatitude = document.getElementById("Latitude");
    const inLongitude = document.getElementById("Longitude");
    const mapDiv = document.getElementById('map');

    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(success, error);
        } else { 
            x.innerHTML = "Geolocation is not supported by this browser.";
        }
    }
    function success(position) {
        inLatitude.value = position.coords.latitude;
        inLongitude.value = position.coords.longitude;
        const map = new google.maps.Map(mapDiv, {
          center: { lat: latitude, lng: longitude },
          zoom: 15,
        });

        new google.maps.Marker({
          position: { lat: latitude, lng: longitude },
          map: map,
        });
    }
    function error(error) {
        switch(error.code) {
            case error.PERMISSION_DENIED:
            x.innerHTML = "User denied the request for Geolocation."
            break;
            case error.POSITION_UNAVAILABLE:
            x.innerHTML = "Location information is unavailable."
            break;
            case error.TIMEOUT:
            x.innerHTML = "The request to get user location timed out."
            break;
            case error.UNKNOWN_ERROR:
            x.innerHTML = "An unknown error occurred."
            break;
        }
    }
    $(document).ready(function(){
        $("form#inputFormKunjungan").submit(function(event){
            event.preventDefault();
            $.ajax({
                url: "{{route('sales')}}/formKunjungan/postNewTransaksi",
                type: 'POST',
                data: new FormData(this),
                async: true,
                cache: true,
                contentType: false,
                processData: false,
                success: function (data) {     
                    $("form#inputFormKunjungan")[0].reset();
                },                
            });
            return false;
        });
    });
</script>