<div class="row">
    <div class="col-md-12">
        <div class="card card-info card-outline">
            <div class="card-header">
                <h3 class="card-title">Edit Koreksi {{$number}}</h3>
            </div>
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-md-12">
                        <div class="d-flex flex-row-reverse">
                            <a href="#" class="btn btn-sm btn-default border-0 text-info font-weight-bold ml-2" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                <i class="fa-regular fa-file"></i> Dok. Transaksi
                            </a>
                            <a href="#" class="btn btn-sm btn-success border-0 font-weight-bold ml-2" id="submitButton">
                                <i class="fa-regular fa-floppy-disk"></i> Simpan Perubahan
                            </a>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-12">
                        <div class="collapse" id="collapseExample">                            
                            <div id="editDocumentOpname"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive" style="height:700px">
                            <table class="table table-sm table-valign-middle" id="tableEditItemKoreksi">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th width="20%">Nama Barang</th>
                                        <th>Lokasi</th>
                                        <th>Satuan</th>
                                        <th>D/K</th>
                                        <th>Qty</th>
                                        <th>Stok Awal</th>
                                        <th>Perbaikan</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <form id="formInputEditKoreksi">
                                        <tr>
                                            <td>#</td>
                                        </tr>
                                    </form>
                                </tbody>
                                <tbody id="locadListKoreksi"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function loadListData(){
        let number = "{{$number}}";
        $.ajax({
            type : 'get',
            url : "{{route('koreksiBarang')}}/listInputBarang/listBarang/"+number,
            success : function(response){
                $('#locadListKoreksi').html(response);
            }
        });
    }
</script>