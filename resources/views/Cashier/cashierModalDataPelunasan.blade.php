<div class="row p-1">
    <div class="col-12">
        <div class="card card-purple">
            <div class="card-header border-0">
                <h3 class="card-title font-weight-bold">Data Pinjaman & Pelunasan</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool border-0 elevation-1" data-dismiss="modal"><i class="fa-solid fa-xmark"></i></button>
                </div>
            </div>
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-4">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa-solid fa-magnifying-glass"></i></span>
                            </div>
                            <input type="text" class="form-control datetimepicker-input" id="searchData" name="searchData" placeholder="Cari Nomor Struk"/>                            
                        </div>
                    </div>
                    <div class="col-4">
                        <button type="button" class="btn btn-primary font-weight-bold elevation-1 btnPelunasan" id="btnPelunasan" data-point="2">Pelunasan Pelanggan</button>
                        <button type="button" class="btn btn-primary font-weight-bold elevation-1 btnListDataSaved" id="btnListDataSaved" data-point="1" style="display:none;">Penjualan Tersimpan</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        @include('Global.global_spinner')
                        <div id="divDataPelunasan"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        let keyWord = 0,
            infoCode = 1;
        searchData(keyWord, infoCode);
        let timer_cari_equipment = null;

        $("#searchData").keyup(function (e){
            e.preventDefault();
            $(".LOAD-SPINNER").fadeIn();
            clearTimeout(timer_cari_equipment);
            timer_cari_equipment = setTimeout(function(){
                let keyWord = $("#searchData").val().trim();
                let infoCode = "1";
                if (keyWord=='') {
                    keyWord = '0';
                }
            searchData(keyWord, infoCode)},700)
        });
        $('.btnPelunasan').click(function() {
            $("#btnPelunasan").fadeOut('slow');
            $("#btnListDataSaved").fadeIn('slow');
            let keyWord = $("#searchData").val(),
                infoCode = "2";
                if (keyWord=='') {
                    keyWord = '0';
                }
            searchData(keyWord, infoCode);
        });

        $('.btnListDataSaved').click(function() {
            $("#btnListDataSaved").fadeOut('slow');
            $("#btnPelunasan").fadeIn('slow');
            let keyWord = $("#searchData").val(),
                infoCode = "1";
                if (keyWord=='') {
                    keyWord = '0';
                }
            searchData(keyWord, infoCode);
        });

        function searchData(keyWord, infoCode){        
            $.ajax({
                type : 'get',
                url : "{{route('Cashier')}}/buttonAction/dataPelunasan/funcData/"+keyWord+"/"+infoCode,
                success : function(response){
                    $(".LOAD-SPINNER").fadeOut();
                    $("#divDataPelunasan").html(response);
                }
            });
        }
    });
</script>