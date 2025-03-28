<div class="row p-1">
    <div class="col-12">
        <div class="card card-body text-xs">
            <form id="formEditKasKasir">
                <input type="hidden" name="idMKasir" value="{{$kasirInfo->idm_kas}}">
                <div class="form-group row">
                    <label for="nameKasir" class="label col-md-4">Nama Kasir</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control form-control-sm" name="nameKasir" id="nameKasir" value="{{$kasirInfo->name}}" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="nameKasir" class="label col-md-4">Nominal</label>
                    <div class="col-md-4">
                        <input type="text" class="form-control form-control-sm" name="nominal" id="nominal" value="{{$kasirInfo->nominal}}">
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success btn-sm ">submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $("form#formEditKasKasir").submit(function(event){
            event.preventDefault();
            $.ajax({
                url: "{{route('setKasKasir')}}/editKasKasir/postEditKasKasir",
                type: 'POST',
                data: new FormData(this),
                async: true,
                cache: true,
                contentType: false,
                processData: false,
                success: function (data) {                    
                    window.location.reload();
                },                
            });
            return false;
        });
    });
</script>