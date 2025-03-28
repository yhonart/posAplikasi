<div class="row p-1">
    <div class="col-12">
        <div class="card card-purple">
            <div class="card-header border-0">
                <h3 class="card-title font-weight-bold">Data Stock</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool border-0 elevation-1" data-dismiss="modal"><i class="fa-solid fa-xmark"></i></button>
                </div>
            </div>
            <div class="card-body text-xs">
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <input type="text" class="form-control" id="searchProduct" name="searchProduct" placeholder="Cari Nama Produk"/>                            
                        </div>
                    </div>
                    <div class="col-6">
                        <button type="button" id="btnKoreksi" class="btn btn-info elevation-1 ITEM-KOREKSI" data-koreksi="1">Koreksi Stock</button>
                        <span class="text-info font-weight-bold" style="display:none;" id="displayInfo">Klik pada kolom stock untuk melakukan edit stock</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div id="divDataStock"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    
    $(document).ready(function(){
        let pointOfShow = "0",
            divDataStock = $("#divDataStock"),
            keyword = "0";
        let timer_cari_equipment = null;        
        functDataStock(pointOfShow, keyword);
        
        $("#searchProduct").keyup(function (e){
            e.preventDefault();
            clearTimeout(timer_cari_equipment);
            let dateSelect = $('#datePenjualan').val();
            $("#btnKoreksi").fadeOut();
            $("#displayInfo").fadeIn();
            timer_cari_equipment = setTimeout(function(){
                let keyWord = $("#SearchProduk").val().trim();
                let pointOfShow = "1";
                if (keyWord=='') {
                    keyWord = '0';
                }

            functDataStock(pointOfShow, keyword)},700)
        });

        $('.ITEM-KOREKSI').on('click', function (e) {
            e.preventDefault();
            let pointOfShow = $(this).attr('data-koreksi'),
                keyword = $("#searchProduct").val();

            functDataStock(pointOfShow, keyword);
        });

        function functDataStock(pointOfShow, keyword){        
            $.ajax({
                type : 'get',
                url : "{{route('Cashier')}}/buttonAction/dataStock/funcData/"+pointOfShow+"/"+keyword,
                success : function(response){
                    $("#divDataStock").html(response);
                }
            });
        }
    });
    
    
</script>