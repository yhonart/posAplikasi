<div class="card card-info">
    <div class="card-header">
        <h3 class="card-title">Form Dokumen Stock Opname</h3>
    </div>
    <div class="card-body">
        <form id="formDokStockOpname">
            <div class="form-group row">
                <label for="dokNumber" class="col-md-3">No.Dokumen</label>
                <div class="col-md-4">
                    <input type="text" class="form-control form-control-sm" name="dokNumber" id="dokNumber" value="{{$numberDok}}" readonly>
                </div>
            </div>
            <div class="form-group row">
                <label for="dateDok" class="col-md-3">Tgl.Dokumen</label>
                <div class="col-md-4">
                    <input type="text" class="form-control form-control-sm" name="dateDok" id="dateDok">
                </div>
            </div>
            <div class="form-group row">
                <label for="location" class="col-md-3">Lokasi</label>
                <div class="col-md-4">
                    <select name="location" id="location" class="form-control form-control-sm">
                        @foreach($mSite as $ms)
                            <option value="{{$ms->idm_site}}">{{$ms->site_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="description" class="col-md-3">Keterangan</label>
                <div class="col-md-4">
                    <input type="text" class="form-control form-control-sm" name="description" id="description">
                </div>
            </div>
            <div class="form-group">
                <button type="submit" id="btnSaveOpname" class="btn btn-sm btn-success font-weight-bold">Save</button>
            </div>
        </form>
    </div>
</div>

<script>
    $( function() {
        $( "#dateDok" ).datepicker({
            dateFormat: 'yy-mm-dd',
            autoclose: true,
            todayHighlight: true,
        });
        $('#dateDok').datepicker("setDate",new Date());
    } );
    $(document).ready(function(){
        $("form#FormNewCategory").submit(function(event){
            event.preventDefault();
            alertify.confirm("Apakah Benar Anda Akan Menyimpan Dokumen Ini?",
            function(){
                $.ajax({
                    url: "{{route('sales')}}/displayStockOpname/postDokumen",
                    type: 'POST',
                    data: new FormData(this),
                    async: true,
                    cache: true,
                    contentType: false,
                    processData: false,
                    success: function (data) {                    
                        alertify.success('Dokumen Berhasil Tersimpan');
                        loadOpname ();
                    },                
                });
            },
            function(){
                alertify.error('Cancel');
            });      
            
            return false;
        });

        function loadOpname (){
            $("#displayStockOpname").load("{{route('sales')}}/displayStockOpname");
        }
    });
</script>