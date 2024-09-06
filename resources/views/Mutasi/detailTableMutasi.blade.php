<div class="row">
    <div class="col-12">
        <div class="card card-body border border-info">
            <div class="row mb-2">
                <div class="col-12 col-md-6">
                    <button class="btn btn-primary mb-2 elevation-1 font-weight-bold" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                        Dokumen Mutasi
                    </button>
                    <div class="collapse" id="collapseExample">
                        <div id="divDisplayDokumen"></div>
                    </div>
                </div>
            </div>
            <table class="table table-sm table-valign-middle table-hover">
                <thead>
                    <tr>
                        <th>Nama Barang</th>
                        <th>Satuan</th>
                        <th>Stock</th>
                        <th>Jml. Mutasi</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($listMutasi as $lm)
                        <tr>
                            <td>{{$lm->product_name}}</td>
                            <td>{{$lm->product_satuan}}</td>
                            <td>{{$lm->last_stock}}</td>
                            <td>{{$lm->stock_taken}}</td>
                            <td>{{$lm->notes}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    $(function(){
        let idparam = "{{$idParam}}";
        $.ajax({
            type : 'get',
            url : "{{route('mutasi')}}/formEntryMutasi/editDocMutasi/" + idparam,
            success : function(response){     
                $("#divDisplayDokumen").html(response);
            }
        });
    })
    $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('.btnTerimaBarang').on('click', function () {
            var  paramID = "{{$idParam}}";
            $.ajax({
                type:'get',
                url:"{{route('mutasi')}}/tableDataMutasi/pickup/"+paramID,
                dataType: 'html',
                success:function(response){
                    window.location.reload();
                }
            });
        });
    });
</script>