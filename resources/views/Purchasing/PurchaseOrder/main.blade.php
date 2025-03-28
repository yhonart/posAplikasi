<div class="card elevation-0 border border-info-subtle">
    <div class="card-header" data-card-widget="collapse">
        <h3 class="card-title font-weight-bold">Deskripsi Pembelian</h3>        
    </div>
    <div class="card-body text-xs">        
        <form id="formMainCreatePO">
        <div class="row">
            <div class="col-12 col-md-6">
                <div class="form-group row mb-1">
                    <label class="col-4">Nomor PO</label>
                    <div class="col-4">
                        <input type="text" class="form-control form-control-sm" name="noPO" id="noPO">
                    </div>
                </div>
                <div class="form-group row mb-1">
                    <label class="col-4">Tanggal</label>
                    <div class="col-4">
                        <input type="text" class="form-control form-control-sm" name="noPO" id="noPO">
                    </div>
                </div>
                <div class="form-group row mb-1">
                    <label class="col-4">Nama Supplier</label>
                    <div class="col-4">
                        <input type="text" class="form-control form-control-sm" name="noPO" id="noPO">
                    </div>
                </div>
                <div class="form-group row mb-1">
                    <label class="col-4">No. Surat Jalan</label>
                    <div class="col-4">
                        <input type="text" class="form-control form-control-sm" name="noPO" id="noPO">
                    </div>
                </div>
                <div class="form-group row mb-1">
                    <label class="col-4">Tgl. Surat Jalan</label>
                    <div class="col-4">
                        <input type="text" class="form-control form-control-sm" name="noPO" id="noPO">
                    </div>
                </div>
                <div class="form-group row mb-1">
                    <label class="col-4">Metode Pembayaran</label>
                    <div class="col-2">
                        <input type="text" class="form-control form-control-sm" name="noPO" id="noPO">
                    </div>
                    <label class="col-2 text-right">Tempo</label>
                    <div class="col-2">
                        <input type="number" class="form-control form-control-sm" name="noPO" id="noPO">
                    </div>
                    <label class="col-2">Hari</label>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="form-group row mb-1">
                    <label class="col-4">PPN</label>
                    <div class="col-4">
                        <select name="ppn" id="ppn" class="form-control form-control-sm">
                            <option value="NONPPN">Non PPN</option>
                            <option value="INCLUDE">Include PPN</option>
                            <option value="EXCLUDE">Exclude PPN</option>
                        </select>
                    </div>
                    <div class="col-2">
                        <input type="text" class="form-control form-control-sm" name="percentPPN" id="percentPPN">
                    </div>
                    <label class="col-2">%</label>
                </div>
                <div class="form-group row mb-1">
                    <label class="col-4">No. Faktur Pajak</label>
                    <div class="col-4">
                        <input type="text" class="form-control form-control-sm" name="noPO" id="noPO">
                    </div>
                </div>
                <div class="form-group row mb-1">
                    <label class="col-4">Tgl. Faktur Pajak</label>
                    <div class="col-4">
                        <input type="text" class="form-control form-control-sm" name="noPO" id="noPO">
                    </div>
                </div>
                <div class="form-group row mb-1">
                    <label class="col-4">Keterangan</label>
                    <div class="col-8">
                        <textarea name="keterangan" id="keterangan" class="form-control" height="60px"></textarea>
                    </div>
                </div>
                <div class="form-group row mb-1">
                    <div class="col-4">
                        <button type="submit" class="btn btn-success font-weight-bold elevation-1">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
        </form>
    </div>
</div>
<div class="card">
    <div class="card-body text-xs table-responsive" style="height:400px">
        <div id="tableInputBarang"></div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function loadPageInfo(link){
            $.ajax({
                type : 'get',
                url : "{{route('Purchasing')}}/purchOrder/InputDataPO",
                success : function(response){                
                    $("#tableInputBarang").html(response);
                }
            });
        }
        
    })
</script>