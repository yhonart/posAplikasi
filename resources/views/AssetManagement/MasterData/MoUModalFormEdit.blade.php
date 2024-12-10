<div class="card">
    <div class="card-header border-0">
        <h3 class="card-title font-weight-bold">Edit Satuan {{$editMOU->unit_note}}</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool border-0 elevation-1" data-dismiss="modal"><i class="fa-solid fa-xmark"></i></button>
        </div>
    </div>
    <div class="card-body">
        <form id="FromEditMasterUnit">
            <input type="hidden" name="satuanID" id="satuanID" value="{{$editMOU->idm_unit}}">
            <div class="form-group row">
                <label for="MoUInitial" class="form-label col-md-4 text-right">Kategori Satuan</label>
                <div class="col-md-4">
                    <select name="editInitial" id="editInitial" class="form-control form-control-sm">
                        <option value="0" readonly>{{$editMOU->unit_initial}}</option>
                        <option value="Besar">Besar</option>
                        <option value="Kecil">Kecil</option>
                        <option value="Terkecil">Terkecil</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="MoUName" class="form-label col-md-4 text-right">Nama Satuan</label>
                <div class="col-md-4">
                    <input type="text" name="editUnitName" id="editUnitName" class="form-control form-control-sm" value="{{$editMOU->unit_note}}">
                </div>
            </div>
            <hr>
            <div class="form-group">
                <button type="submit" class="btn btn-success font-weight-bold" id="SubmitUnit">Simpan</button>
            </div>
        </form>
        <div class="row">
            <div class="col-12 red-alert p-2 rounded rounded-2 mb-2 notive-display" style="display:none;">
                <span class="font-weight-bold" id="notiveDisplay"></span>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        let loadSpinner = $(".LOAD-SPINNER"),
            routeIndex = "{{route('MoU')}}",
            tableData = "tableMoU",
            displayData = $("#displayTableMoU"),
            alertNotive = $('.notive-display');

        $("form#FromEditMasterUnit").submit(function(event){
            event.preventDefault();
            $.ajax({
                url: "{{route('MoU')}}/EditMoU/PostEditMoU",
                type: 'POST',
                data: new FormData(this),
                async: true,
                cache: true,
                contentType: false,
                processData: false,
                success: function (data) {                    
                    if (data.warning) {
                        $(".notive-display").fadeIn();
                        $("#notiveDisplay").html(data.warning);
                        alertNotive.removeClass('green-alert').addClass('red-alert');
                    }
                    else{
                        global_style.hide_modal();
                        global_style.load_table(loadSpinner,routeIndex,tableData,displayData);
                        alertNotive.removeClass('red-alert').addClass('green-alert');
                    }
                },                
            });
            return false;
        });
    });
</script>