<div class="card">
    <div class="card-header">
        <h3 class="text-title">Edit Limit Kredit Pelanggan</h3>
    </div>
    <div class="card-body">
        <dl class="row">
            <dt class="col-md-3">Nama Toko/Pelanggan</dt>
            <dd class="col-md-4">: {{$selectCustomer->customer_store}}</dd>
        </dl>
        <dl class="row">
            <dt class="col-md-3">Alamat</dt>
            <dd class="col-md-4">: {{$selectCustomer->city}}. {{$selectCustomer->address}}</dd>
        </dl>
        <dl class="row">
            <dt class="col-md-3">Tipe Pelanggan</dt>
            <dd class="col-md-4">: {{$selectCustomer->group_name}}</dd>
        </dl>
        <form id="formEditLimit">
            <input type="hidden" name="idCus" id="idCus" value="{{$selectCustomer->idm_customer}}">
            <dl class="row">
                <dt class="col-md-3">Kredit Limit</dt>
                <dd class="col-md-4">
                    <input type="text" class="form-control form-control-sm price-tag" name="kreditLimit" id="kreditLimit" value="{{$selectCustomer->kredit_limit}}">
                </dd>
            </dl>
            <div class="row">
                <div class="col-md-6">
                    <button type="submit" class="btn btn-success btn-sm font-weight-bold" id="btnEditLimit">Simpan</button>
                    <button type="button" class="btn btn-warning btn-sm font-weight-bold" id="btnCloseModal" data-dismiss="modal">Tutup</button>
                    <span class="text-danger font-weight-bold" id="pleaseWait" style="display: none;">Please Wait ....</span>
                </div>
            </div>
        </form>
        <div class="row">
            <div class="col-md-12">
                <span class="text-danger" id="spanNotifWarning"></span>
            </div>
        </div>
    </div>
</div>
<script>
    $(function(){
        $('.price-tag').mask('000.000.000', {reverse: true});
    });
    $(document).ready(function(){
        $("form#formEditLimit").submit(function(event){
            event.preventDefault();
            let keyWord = "{{$selectCustomer->idm_customer}}",
                fromDate = '0',
                endDate = '0',
                valAction = '3';

            $("#btnEditLimit").fadeOut('slow');
            $("#pleaseWait").fadeIn('slow');
            $.ajax({
                url: "{{route('Cashier')}}/buttonAction/dataPelunasan/postPelunasan",
                type: 'POST',
                data: new FormData(this),
                async: true,
                cache: true,
                contentType: false,
                processData: false,
                success: function (data) {
                    if (data.warning) {
                        $("#spanNotifWarning").html(data.warning);
                        $("#pleaseWait").fadeOut('slow');
                        $("#btnEditLimit").fadeIn('slow');
                    }
                    else{
                        entryDisplay(keyWord, fromDate, endDate, valAction);
                        $("#spanNotifWarning").html(data.success);
                        // $('body').removeClass('modal-open');
                        // $(".MODAL-GLOBAL").modal('hide'); 
                        // $('.modal-backdrop').remove();
                    }
                }
            });
        });

        function entryDisplay(keyWord, fromDate, endDate, valAction){  
            $("#reloadDisplay").fadeIn("slow");
            $.ajax({
                type : 'get',
                url : "{{route('Cashier')}}/buttonAction/dataPelunasan/funcData/"+keyWord+"/"+fromDate+"/"+endDate+"/"+valAction,
                success : function(response){
                    $("#reloadDisplay").fadeOut("slow");
                    $("#divDataPelunasan").html(response);
                }
            });
        }
    });
</script>