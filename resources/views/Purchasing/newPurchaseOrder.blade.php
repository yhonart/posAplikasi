<?php
//menghitung kas 
//Pengurangan kas modal dengan pengeluaran
$totPengeluaran = $mTrxKasKasir->nominal - $penggunaanDanaKasir->nominal;
$subTotalDana = $totPengeluaran + $penambahanDanaKasir->nominal_modal;
?>

@if($formActive == '0')
    <div class="card card-body">
        <form class="form" id="fromInputPembelian">
            <div class="row">
                <div class="col-12 col-md-3">
                    <div class="form-group row">
                        <div class="col-12">
                            <label class="label">NO. Transaksi</label>
                            <input type="text" name="noTrx" id="noTrx" class="form-control form-control-sm " value="{{$nomor}}" readonly>
                        </div>
                    </div>                    
                    <div class="form-group row">
                        <div class="col-12">
                            <label class="label">Metode Pembayaran</label>
                            <select class="form-control form-control-sm select-2" name="methodPayment" id="methodPayment">
                                <option value="0"></option>                                
                            </select>
                        </div>
                    </div>
                    <div class="form-group row" id="bankTransfer" style="display: none;">
                        <div class="col-12">
                            <label class="label">Bank Transfer</label>
                            <select class="form-control form-control-sm select-2" name="bankAccount" id="bankAccount">
                                <option value="0"> ==== </option>
                                @foreach($bankTransfer as $bt)
                                <option value="{{$bt->idm_payment}}">{{$bt->bank_code}} xxx - {{substr($bt->account_number, 5)}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row" id="dana" style="display: none;">
                        <div class="col-12">
                            <label class="label">Sumber Dana</label>
                            <select class="form-control form-control-sm select-2" name="sumberDana" id="sumberDana">
                                <option value="0|0"> ==== </option>
                                @foreach($danaKasir as $dK)
                                    <option value="{{$dK->created_by}}|{{$dK->totKasir}}">{{$dK->created_by}} : {{number_format($dK->totKasir,'0',',','.')}}</option>
                                @endforeach
                                <option value="DanaKas|{{$subTotalDana}}">Dana Kas {{number_format($subTotalDana,'0',',','.')}}</option>
                                <option value="1|1">Lain-Lain</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-3">
                    <div class="form-group row">
                        <div class="col-12">
                            <label class="label">Supplier</label>
                            <select class="form-control form-control-sm select-2" name="supplier" id="supplier">
                                <option value="0" readonly>Pilih Supplier</option>
                                @foreach($supplier as $s)
                                    <option value="{{$s->idm_supplier}}">{{$s->store_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-12">
                            <label class="label">Tempo [Hari]</label>
                            <input type="text" name="dayKredit" id="dayKredit" class="form-control form-control-sm " placeholder="Abaikan Jika Menggunakan Tunai/Transfer" autocomplete="off">
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-3">
                    <div class="form-group row">
                        <div class="col-12">
                            <label class="label">Nomor Surat Jalan</label>
                            <input type="text" name="noSj" id="noSj" class="form-control form-control-sm " autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-12">
                            <label class="label">No. Faktur</label>
                            <input type="text" name="noFaktur" id="noFaktur" class="form-control form-control-sm " autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-12">
                            <label class="label">Keterangan</label>
                            <input type="text" name="keterangan" id="keterangan" class="form-control form-control-sm " autocomplete="off">
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-3">
                    <div class="form-group row">
                        <div class="col-12">
                            <label class="label">Kirim Melalui</label>
                            <input type="text" name="deliveryBy" id="deliveryBy" class="form-control form-control-sm " autocomplete="off" style="text-transform:uppercase">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-12">
                            <label class="label">Tgl. Faktur</label>
                            <input type="text" name="tglFaktur" id="tglFaktur" class="form-control form-control-sm datetimepicker-input " autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-12">
                            <label class="label">Tgl. Pengiriman</label>
                            <input type="text" name="dateDelivery" id="dateDelivery" class="form-control form-control-sm datetimepicker-input " autocomplete="off">
                        </div>
                    </div>                    
                </div>
            </div>            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group row ml-2">
                        <div class="col-3">
                            <label class="label">Type PPN</label>
                        </div>
                        <div class="col-3">
                            <input type="radio" name="ppn" id="ppn" class="form-check-input mr-2" checked value="1"><label class="form-check-label">Non PPN</label>
                        </div>
                        <div class="col-3">
                            <input type="radio" name="ppn" id="ppn" class="form-check-input mr-2" value="2"><label class="form-check-label">PPN</label>
                        </div>
                        <div class="col-3">
                            <input type="radio" name="ppn" id="ppn" class="form-check-input mr-2" value="3"><label class="form-check-label">Exclude PPN</label>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row ml-2">
                        <div class="col-md-3">
                            <input type="text" class="form-control form-control-sm " name="nomPPN" id="nomPPN">
                        </div>
                        <label class="label col-md-3">%</label>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-success btn-sm btn-block font-weight-bold elevation-2" id="submitPenerimaan">Simpan</button>
                        </div>
                        <div class="col-md-3">
                            <div class="spinner-border text-dark" role="status" id="spinnerSimpan" style="display:none;">
                              <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group row">
                        <div class="col-12">
                            <div class="label" id="point"></div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@else
    <div id="tableInputBarang"></div>
    <script>
        $(function(){
            let dokNumber = "{{$numberPurchase->purchase_number}}";
            $.ajax({
                type : 'get',
                url : "{{route('Purchasing')}}/tableInputBarang/formInput/"+dokNumber,
                success : function(response){
                    $("#tableInputBarang").html(response);
                }
            });
        })
    </script>
@endif
<script>
    $(function() {
        $( ".datetimepicker-input" ).datepicker({
            dateFormat: 'yy-mm-dd',
            autoclose: true,
            todayHighlight: true,
        });
        $('.datetimepicker-input').datepicker("setDate",new Date());
        $("#supplier").select2({
            width: 'resolve'
        });
    });
    
    $(document).ready(function(){
        $("#supplier").change(function(){
            let supplier = $(this).find(":selected").val();
            $.ajax({
                type : 'get',
                url : "{{route('Purchasing')}}/notivePoint/"+supplier,
                success : function(response){
                    $("#point").html(response);
                }
            });

            $.ajax({
                type : 'get',
                url : "{{route('Purchasing')}}/metodePembayaran/" + supplier,
                success : function(response){  
                    $("#methodPayment").html(response);
                }
            });
        });
        $("#methodPayment").change(function(){
            let method = $(this).find(":selected").val();
                
            if (method === '1'){
                $('#dayKredit').val("TUNAI");
                $("#bankTransfer").fadeOut("slow");
            }
            else if (method === '2'){
                $('#dayKredit').val("TRANSFER");
                $("#bankTransfer").fadeIn("slow");
            }
            else if (method === '3'){
                $('#dayKredit').val("10").focus().select();
                $("#bankTransfer").fadeOut("slow");
            }
            else{
                $('#dayKredit').val(method);
                $("#bankTransfer").fadeOut("slow");
            }
        });
        
        let routeIndex = "{{route('Purchasing')}}",
            dataIndex = "addPurchasing",
            panelProductList = $("#divPageProduct");
        $("#batalPenerimaan").on('click', function(e){
            e.preventDefault();
            $("#spinnerDelete").fadeIn();
            var el = $(this);
            var elNo = el.attr("data-no");
            alertify.confirm("Apakah anda yakin ingin menghapus data ini ?",
                function(){
                    $.ajax({
                        type : 'get',
                        url : "{{route('Purchasing')}}/cencelInput/"+elNo,
                        success : function(data){
                            loadData(dataIndex);
                        }
                    });
                    alertify.success('Data berhasil dihapus');
                },
                function(){
                    alertify.error('Membatalkan penghapusan data');
                }).set({title:"Notif Delete Transaksi !"});
              $("#spinnerDelete").fadeOut();
        });
        $("form#fromInputPembelian").submit(function(event){
            $("#submitPenerimaan").fadeOut();
            $("#spinnerSimpan").fadeIn();
            event.preventDefault();
            $.ajax({
                url: "{{route('Purchasing')}}/addPurchasing/postPenerimaan",
                type: 'POST',
                data: new FormData(this),
                async: true,
                cache: true,
                contentType: false,
                processData: false,
                success: function (data) {
                    if(data.warning){
                        alertify.warning(data.warning);
                        $("#submitPenerimaan").fadeIn();
                        $("#spinnerSimpan").fadeOut();
                    }
                    else if(data.success){
                        alertify.success(data.success);
                        $("#submitPenerimaan").fadeIn();
                        $("#spinnerSimpan").fadeOut();
                        loadData(dataIndex);
                    }
                    // tableInputBarang();
                }
            });
            return false;
        });
        
        function loadData(dataIndex){
            $.ajax({
                type : 'get',
                url : "{{route('Purchasing')}}/"+dataIndex,
                success : function(response){
                    $("#divPageProduct").html(response);
                }
            });
        }
    });
    
    
</script>
