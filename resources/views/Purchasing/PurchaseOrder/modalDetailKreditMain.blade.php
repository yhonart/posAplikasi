<div class="row">
<div class="col-12">
    <div class="card card-info card-tabs">
        <div class="card-header p-0 pt-1">
        <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="detailPembayaran" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Detail Pembayaran</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="detailDokInfo" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="false">Detail Dokumen</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="detailItemInfo" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="false">Detail Item</a>
            </li>
        </ul>
        </div>
        <div class="card-body">
        <div class="tab-content" id="custom-tabs-one-tabContent">
            <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                <div id="detailAllFunction"></div>
            </div>
        </div>
        </div>
        <!-- /.card -->
    </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        let id = "{{$id}}",
            noDok = "{{$numberDok->number_dok}}",
            functionDisplay = "modalDetailKreditPembayaran";
        detailAllFunction(functionDisplay, id, noDok)

        function detailAllFunction(functionDisplay, id, noDok){           
            $.ajax({
                type : 'get',
                url : "{{route('Purchasing')}}/"+functionDisplay+"/"+id+"/"+noDok,
                success : function(response){
                    $("#detailAllFunction").html(response);
                }
            });
        }
    })
</script>