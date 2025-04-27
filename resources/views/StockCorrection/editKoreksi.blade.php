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
                                        <th width="10%">Lokasi</th>
                                        <th width="10%">Satuan</th>
                                        <th width="10%">D/K</th>
                                        <th width="10%">Qty</th>
                                        <th>Stok Awal</th>
                                        <th>Perbaikan</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <form id="formInputEditKoreksi">
                                        <tr>
                                            <td>#</td>
                                            <td class="p-0">
                                                <select class="form-control form-control-sm val-reset" name="product" id="product">
                                                    <option value="0">..</option>
                                                    @foreach($mProduct as $mP)
                                                        <option value="{{$mP->idm_data_product}}">{{$mP->product_name}}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td class="p-0">
                                                <select class="form-control form-control-sm val-reset form-control-border rounded-0 " name="location" id="location">
                                                    <option value="0">..</option>
                                                    @foreach($mSite as $site)
                                                        <option value="{{$site->idm_site}}">{{$site->site_name}}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td class="p-0">
                                                <select class="form-control form-control-sm val-reset form-control-border rounded-0" name="satuan" id="satuan">
                                                    <option value="0"></option>
                                                </select>
                                            </td>
                                            <td class="p-0">
                                                <select class="form-control form-control-sm val-reset form-control-border rounded-0" name="t_type" id="t_type">
                                                    <option value="D">Debit</option>
                                                    <option value="K">Kredit</option>
                                                </select>
                                            </td>
                                            <td class="p-0">
                                                <input type="number" class="form-control form-control-sm val-reset form-control-border rounded-0" name="qty" id="qty" autocomplate="off">
                                            </td>
                                            <td class="p-0">
                                                <input type="number" class="form-control form-control-sm val-reset form-control-border rounded-0" name="lastStock" id="lastStock" readonly>
                                            </td>
                                            <td class="p-0">
                                                <input type="text" class="form-control form-control-sm val-reset form-control-border rounded-0" name="tPerbaikan" id="tPerbaikan" readonly>
                                            </td>
                                            <td>
                                                <button class="btn btn-default  btn-sm elevation-1" id="addItemKorek"><i class="fa-solid fa-check"></i></button>
                                            </td>
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
    $(function(){
        $('#product').select2({
            width: 'resolve'
        });
        $("#product").focus();
        loadListData();
    })
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