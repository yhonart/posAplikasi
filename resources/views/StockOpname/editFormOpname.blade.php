<form class="form" id="formUpdateOpname">
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label>Nomor Dokumen</label>
                <input type="text" name="noStockOpname" id="noStockOpname" class="form-control form-control-sm" value="{{$docOpname2->number_so}}" readonly>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>Tgl. Dokumen</label>
                <input type="text" name="filterTanggal" id="filterTanggal" class="form-control form-control-sm" value="{{$docOpname2->date_so}}">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>Lokasi</label>
                <select class="form-control form-control-sm" name="pilihLokasi">
                    <option value="{{$docOpname2->loc_so}}">{{$docOpname2->site_name}}</option>
                    @foreach($mLoc as $mS)
                        <option value="{{$mS->idm_site}}">{{$mS->site_name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>Keterangan</label>
                <textarea class="form-control" rows="4" placeholder="Enter ..." name="description" id="description">{{$docOpname2->description}}</textarea>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <button type="submit" class="btn btn-success font-weight-bold "><i class="fa-solid fa-check"></i> Update Dokumen</button>
            <button type="button" class="btn btn-warning font-weight-bold " id="btnClose"><i class="fa-solid fa-circle-xmark"></i> Tutup Dokumen</button>
        </div>
    </div>
</form>
<script>
    $( function() {
        $( "#filterTanggal" ).datepicker({
            dateFormat: 'yy-mm-dd',
            autoclose: true,
            todayHighlight: true,
        });
        $('#filterTanggal').datepicker("setDate",new Date());
    } );
    $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        $("form#formUpdateOpname").submit(function(event){
            event.preventDefault();
            $.ajax({
                url: "{{route('stockOpname')}}/submitUpdateStockOpname",
                type: 'POST',
                data: new FormData(this),
                async: true,
                cache: true,
                contentType: false,
                processData: false,
                success: function (data) {
                    alertify.success('Success updated');
                }
            });
            return false;
        });
        
        $('#btnClose').on('click', function (e) {
            let loadDiv = "listInputBarang";
            e.preventDefault();
            loadDisplay(loadDiv);
        });
        
        function loadDisplay(loadDiv){
            $.ajax({
                type : 'get',
                url : "{{route('stockOpname')}}/"+loadDiv,
                success : function(response){
                    $('#displayOpname').html(response);
                }
            });
        }
    });
</script>