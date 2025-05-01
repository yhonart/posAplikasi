<hr>
@if($keyword <> 0)
    @if($countDataPinjaman == '0')
        <p class="border p-3 rounded-lg font-weight-bold red-alert">Tidak ada data pinjaman untuk pelanggan ini !</p>    
    @else
    <div class="row">
        <div class="col-md-12">
            <div class="form-group row">
                <div class="col-12 col-md-4">
                    <label>Cetak Voucher</label>
                    <select class="form-control form-control-sm" name="noVoucher" id="noVoucher">
                        <option value="0" readonly>Pilih No Pembayaran</option>
                        @foreach($listStruk as $lS)
                        <option value="{{$lS->payment_number}}">{{$lS->payment_number}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
    <p class="text-muted">Input nominal pembayaran di kolom <b>"Pembayaran"</b></p>
    <div class="row">
        <div class="col-md-12">
        <table class="table table-sm table-hover text-xs table-valign-middle" id="tableKreditCus">
            <thead>
                <tr>
                    <th></th>
                    <th>No.<br>Faktur</th>
                    <th>Tgl.<br>Faktur</th>
                    <th>Tgl.<br>Jatuh Tempo</th>
                    <th class="text-right">Kredit</th>
                    <th class="text-right">
                        Pembayaran
                        <br>
                        <small>Gunakan ENTER untuk input nominal.</small>
                    </th>
                    <th></th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody id="userData">
                @foreach($dataPinjaman as $dP)
                    <tr id="{{$dP->idtr_kredit}}">
                        <td>
                            <div class="btn-group">                            
                                <button class="btn btn-info btn-sm BTN-DETAIL border-light" data-id="{{$dP->idtr_kredit}}"><i class="fa-solid fa-magnifying-glass"></i></button>
                            </div>
                        </td>                        
                        <td>{{$dP->from_payment_code}}</td>
                        <td>{{$dP->created_at}}</td>
                        <td>
                            <?php
                                $createdDate = $dP->created_at;
                                $doDate = date('Y-m-d', strtotime($createdDate.'+1 month'));;
                            ?>
                            {{$doDate}}
                        </td>
                        <td>                            
                            <input type="hidden" name="nominalFaktur[]" id="nominalFaktur{{$dP->idtr_kredit}}" value="{{$dP->nom_kredit}}">
                            <input type="text" name="selisihBayar" id="selisihBayar" value="{{number_format($dP->nominal,'0',',','.')}}" class="form-control form-control-sm form-control-border editInput nominal-selisih font-weight-bold text-right" readonly>
                        </td>
                        <td class="p-0">                            
                            @if($dP->nom_payed == $dP->nominal)
                                {{number_format($dP->nom_payed,'0',',','.')}}
                            @elseif($dP->status == '1')   
                                @if($countLastRecord >= '1') 
                                    @foreach($getLastRecord as $glr)               
                                        @if($glr->trx_code == $dP->from_payment_code)
                                            <input type="text" name="bayarPiutang" id="bayarPiutang{{$dP->idtr_kredit}}" class="form-control form-control-sm form-control-border editInput nominal-bayar price-tag font-weight-bold text-danger text-right" autocomplete="off" onchange="saveChangeRecord(this,'tr_kredit_record','total_payment','{{$glr->idtr_kredit_record}}','idtr_kredit_record','1','{{$dP->from_payment_code}}')" value="{{$glr->total_payment}}">
                                        @endif
                                    @endforeach
                                @else                            
                                    <input type="text" name="bayarPiutang" id="bayarPiutang{{$dP->idtr_kredit}}" value="" class="form-control form-control-sm form-control-border editInput nominal-bayar price-tag" autocomplete="off" onchange="saveChangePembayaran(this,'tr_kredit','nom_payed','{{$dP->idtr_kredit}}','idtr_kredit','1')" placeholder="Dibayar : {{number_format($dP->nom_payed,'0',',','.')}}">
                                @endif
                            @else
                                <input type="text" name="bayarPiutang" id="bayarPiutang{{$dP->idtr_kredit}}" value="" class="form-control form-control-sm form-control-border editInput nominal-bayar price-tag" autocomplete="off" onchange="saveChangePembayaran(this,'tr_kredit','nom_payed','{{$dP->idtr_kredit}}','idtr_kredit','1')" placeholder="Dibayar : {{number_format($dP->nom_payed,'0',',','.')}}">
                            @endif

                        </td>
                        <td> 
                            <div class="form-group">
                                <div class="form-check">
                                <input class="form-check-input" type="radio" name="checkHutang" value="{{$dP->idtr_kredit}}">
                                <label class="form-check-label"></label>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if($dP->nom_payed == $dP->nominal)
                                <span class="text-success font-weight-bold">LUNAS</span>
                            @else
                                <input type="text" class="form-control form-control-sm form-control-border editInput keterangan" name="keteranganHtg" id="keteranganHtg" placeholder="Sisa Piutang {{number_format($dP->nom_kredit)}}" readonly>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tbody>
                <tr>
                    <td colspan="4" class="text-right font-weight-bold">Sub Total</td>
                    <td>
                        <input class="form-control form-control-sm form-control-border border-width-3 price-tag font-weight-bold text-right" name="exDisNomKredit" id="exDisNomKredit" value="{{$totalHutang->kredit}}" readonly>
                    </td>
                    <td>
                        <input class="form-control form-control-sm form-control-border border-width-3 price-tag font-weight-bold text-right" name="exDisplayBayar" id="exDisplayBayar" value="{{$sumPayed->sumpayed}}" readonly>
                    </td>
                    <td colspan="2">

                    </td>
                </tr>
            </tbody>
        </table>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card card-body text-xs">
                <form id="formPiutangPelanggan">
                    <input type="hidden" name="periode" value="{{$periode}}">
                    <input type="hidden" name="numbering" value="{{$numbering}}">
                    <input type="hidden" name="idPelanggan" value="{{$keyword}}">
                    <input type="hidden" name="accountCode" value="{{$accountPenjualan->account_code}}">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group row">
                                <label class="label col-4">Kode Akun</label>
                                <div class="col-8">
                                    <select class="form-control form-control-sm" name="kodeAkun">
                                        @foreach($accountCode as  $cc)
                                            <option value="{{$cc->id_account}}">{{$cc->account_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="label col-4">No. Bukti</label>
                                <div class="col-8">
                                    <input class="form-control form-control-sm" name="nomorBukti" id="nomorBukti" value="PBT-{{$periode}}-{{sprintf("%07d",$numbering)}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="label col-4">Tgl. Bukti</label>
                                <div class="col-8">
                                    <input class="form-control form-control-sm" name="tglBukti" id="tglBukti">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="label col-4">Pelanggan</label>
                                <div class="col-8">
                                    <input class="form-control form-control-sm" name="pelanggan" id="pelanggan" value="{{$customerName->customer_store}}" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="label col-4">Keterangan</label>
                                <div class="col-8">
                                    <input class="form-control form-control-sm" name="keterangan" id="keterangan">
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group row">
                                <div class="col-12">
                                    <input type="hidden" class="form-control form-control-sm price-tag from-weight-bold" name="nominalKredit" id="nominalKredit" value="{{$totalHutang->kredit}}">
                                    <input type="hidden" class="form-control form-control-sm price-tag" name="nominalBayar" id="nominalBayar" value="{{$sumPayed->sumpayed}}">
                                    <button type="submit" class="btn btn-success" id="btnSimpan"><i class="fa-regular fa-floppy-disk"></i> Simpan Semua</button>
                                    <button type="submit" class="btn btn-danger" id="btnBatal"><i class="fa-solid fa-circle-xmark"></i> Batalkan Semua</button>
                                    <button type="button" class="btn btn-primary" id="cetakVoucher" style="display: none;"><i class="fa-solid fa-print"></i> Cetak Voucher</button>
                                </div>
                            </div>                
                        </div>
                    </div>        
                </form>
            </div>
        </div>
    </div>
    @endif
@else
<div class="callout callout-info">
    <h5>Info</h5>
    <p>Silahkan pilih nama pelanggan.</p>
</div>
@endif

<script>
    $(function(){
        $('.price-tag').mask('000.000.000', {reverse: true});
        $( "#tglBukti" ).datepicker({
            dateFormat: 'yy-mm-dd',
            autoclose: true,
            todayHighlight: true,
        });
        $('#tglBukti').datepicker("setDate",new Date());
    })
    $(document).ready(function(){  

        $("#cetakVoucher").click(function(){
            let voucherNumber = $("#nomorBukti").val();
            let urlPrint = "{{route('Cashier')}}/dataPelunasan/printPelunasan/"+voucherNumber;
            window.open(urlPrint,'_blank');
        });
        
        var elements = document.getElementsByTagName('tr');
        for (var i = 0; i < elements.length; i++) {
        
          (elements)[i].addEventListener("click", function() {
            const rb = this.querySelector('input[name="checkHutang"]');
            rb.checked = true;
            let selectedValue = rb.value;
          });
        }
        
        $("form#formPiutangPelanggan").submit(function(event){
            let keyWord = "{{$keyword}}",
                fromDate = "{{$fromDate}}",
                endDate = "{{$endDate}}";
            event.preventDefault();
            $.ajax({
                url: "{{route('Cashier')}}/buttonAction/dataPelunasan/postPelunasan",
                type: 'POST',
                data: new FormData(this),
                async: true,
                cache: true,
                contentType: false,
                processData: false,
                success: function (data) {
                    alertify.success("Success!");
                    $("#btnSimpan").fadeOut("slow");
                    $("#tableKreditCus").fadeOut("slow");
                    $("#btnBatal").fadeOut("slow");
                    $("#cetakVoucher").fadeIn("slow");
                    //loadDataPelunasan(keyWord, fromDate, endDate);
                }
            });
            return false;
        });
    })
    
    let keyWord = "{{$keyword}}",
        fromDate = "{{$fromDate}}",
        endDate = "{{$endDate}}",
        actionType = '1',
        numberingPembayaran = $("input[name=numbering]").val();
        if (keyWord === ''){
            keyWord = '0';
        }            
    function saveChangePembayaran(editableObj,tablename,column,id,idKredit,codeTrx){
        $.ajax({
            url: "{{route('Cashier')}}/buttonAction/dataPelunasan/actionData",
            type: "POST",
            data:'tablename='+tablename+'&column='+column+'&editval='+editableObj.value+'&id='+id+'&idKredit='+idKredit+'&codeTrx='+codeTrx+'&keyWord='+keyWord+'&numbering='+numberingPembayaran,
            success: function(data){
                loadDataPelunasan(keyWord, fromDate, endDate, actionType);
            }
        });
    }

    function saveChangeRecord(editableObj,tablename,column,id,idKredit,codeTrx,numberTrx){
        $.ajax({
            url: "{{route('Cashier')}}/buttonAction/dataPelunasan/actionUpdateRecord",
            type: "POST",
            data:'tablename='+tablename+'&column='+column+'&editval='+editableObj.value+'&id='+id+'&idKredit='+idKredit+'&number='+numberTrx,
            success: function(data){
                loadDataPelunasan(keyWord, fromDate, endDate, actionType);
            }
        });
    }
    
    function loadDataPelunasan(keyWord, fromDate, endDate, actionType){        
        $.ajax({
            type : 'get',
            url : "{{route('Cashier')}}/buttonAction/dataPelunasan/funcData/"+keyWord+"/"+fromDate+"/"+endDate+"/"+actionType,
            success : function(response){
                $("#divDataPelunasan").html(response);
            }
        });
    }
</script>