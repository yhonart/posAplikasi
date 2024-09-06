<form id="formEditMutasi">
    <div class="form-group row">
        <label class="label col-md-3">No. Mutasi</label>
        <div class="col-md-4">
            <input type="text" class="form-control form-control-sm" name="number" id="number" value="{{$tbMutasi->number}}" readonly>
        </div>
    </div>
    <div class="form-group row">
        <label class="label col-md-3">Tgl. Mutasi</label>
        <div class="col-md-4">
            <input type="text" class="form-control form-control-sm" name="tglMutasi" id="tglMutasi" value="{{$tbMutasi->date_moving}}">
        </div>
    </div>
    <div class="form-group row">
        <label class="label col-md-3">Lokasi Asal</label>
        <div class="col-md-3">
            <select class="form-control form-control-sm" name="fromLoc" id="fromLoc">
                <option value="{{$tbMutasi->from_loc}}" readonly>{{$tbMutasi->from_loc}}</option>
                @foreach($mLoc as $ms1)
                    <option value="{{$ms1->site_name}}">{{$ms1->site_name}}</option>
                @endforeach
            </select>
        </div>
        <label class="label col-md-3">Lokasi Tujuan</label>
        <div class="col-md-3">
            <select class="form-control form-control-sm" name="toLoc" id="toLoc">
                <option value="{{$tbMutasi->to_loc}}" readonly>{{$tbMutasi->to_loc}}</option>
                @foreach($mLoc as $ms2)
                    <option value="{{$ms2->site_name}}">{{$ms2->site_name}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label class="label col-md-3">Keterangan</label>
        <div class="col-md-4">
            <input type="text" class="form-control form-control-sm" name="description" id="description" value="{{$tbMutasi->notes}}">
        </div>
    </div>
    <div class="form-group row">
        <button type="submit" class="btn btn-success btn-sm elevation-1" id="btnSbmitUpdate"><i class="fa-solid fa-check"></i> Submit</button>
    </div>
</form>

<script>
    $(document).ready(function(){
        $("form#formEditMutasi").submit(function(event){
            $("#btnSbmitUpdate").hide();
            event.preventDefault();
            $.ajax({
                url: "{{route('mutasi')}}/formEntryMutasi/submitUpdateMutasi",
                type: 'POST',
                data: new FormData(this),
                async: true,
                cache: true,
                contentType: false,
                processData: false,
                success: function (data) {
                    $("#btnSbmitUpdate").show();
                    alertify.success('Update Success');
                    loadDisplayMutasi();
                }
            });
            return false;
        });
    });
    function loadDisplayMutasi(){
        // spinner.fadeIn("slow");
        $.ajax({
            type : 'get',
            url : "{{route('mutasi')}}/formEntryMutasi",
            success : function(response){
                spinner.fadeOut("slow");
                divPanel.fadeIn("slow");
                $('#divPanelMutasi').html(response);
            }
        });
    }
</script>