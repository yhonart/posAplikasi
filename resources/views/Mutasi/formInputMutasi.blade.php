<div class="row">
    <div class="col-12">
        <div class="card card-body" id="cardNewForm">
            <form id="formEntryMutasi">
                <div class="form-group row">
                    <label class="label col-md-3">No. Mutasi</label>
                    <div class="col-md-4">
                        <input type="text" class="form-control form-control-sm" name="number" id="number" value="{{$number}}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="label col-md-3">Tgl. Mutasi</label>
                    <div class="col-md-4">
                        <input type="text" class="form-control form-control-sm" name="tglMutasi" id="tglMutasi">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="label col-md-3">Lokasi Asal</label>
                    <div class="col-md-3">
                        <select class="form-control form-control-sm" name="fromLoc" id="fromLoc">
                            <option value="0" readonly></option>
                            @foreach($mLoc as $ms1)
                                <option value="{{$ms1->idm_site}}">{{$ms1->site_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <label class="label col-md-3">Lokasi Tujuan</label>
                    <div class="col-md-3">
                        <select class="form-control form-control-sm" name="toLoc" id="toLoc">
                            <option value="0" readonly></option>
                            @foreach($mLoc as $ms2)
                                <option value="{{$ms2->idm_site}}">{{$ms2->site_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="label col-md-3">Keterangan</label>
                    <div class="col-md-4">
                        <input type="text" class="form-control form-control-sm" name="description" id="description">
                    </div>
                </div>
                <div class="form-group row">
                    <button type="submit" class="btn btn-success btn-sm elevation-1 "><i class="fa-solid fa-check"></i> Simpan</button>
                </div>
            </form>
        </div>        
    </div>
</div>

<script>
    $( function() {
        $( "#tglMutasi" ).datepicker({
            dateFormat: 'yy-mm-dd',
            autoclose: true,
            todayHighlight: true,
        });
        $('#tglMutasi').datepicker("setDate",new Date());
    } );
    
    $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
               
        $("form#formEntryMutasi").submit(function(event){
            event.preventDefault();
            $.ajax({
                url: "{{route('mutasi')}}/formEntryMutasi/submitMutasi",
                type: 'POST',
                data: new FormData(this),
                async: true,
                cache: true,
                contentType: false,
                processData: false,
                success: function (data) {
                    $("form#formEntryMutasi")[0].reset();
                    document.getElementById("cardNewForm").style.display = "none";
                    viewTableInput();
                }
            });
            return false;
        });
    });
    
    function viewTableInput() {
        let routeLoad = "formEntryMutasi";        
        $(".LOAD-SPINNER").fadeIn("slow");
        $.ajax({
            type : 'get',
            url : "{{route('mutasi')}}/"+routeLoad,
            success : function(response){
                $(".LOAD-SPINNER").fadeOut("slow");
                $('#displayMutasi').html(response);
            }
        });
    }  
</script>