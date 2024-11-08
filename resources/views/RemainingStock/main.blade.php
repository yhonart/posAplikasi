@extends('layouts.sidebarpage')

@section('content')
<div class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1 class="m-0">Kontrol Persediaan/<small>Control Stock</small></h1>
        </div><!-- /.col -->
    </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>

<div class="content">
    <div class="container-fluid"> 
        <div class="row mt-2">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <a class="btn btn-success mb-2 mt-1 " data-toggle="collapse" href="#collapseSatuan" role="button" aria-expanded="false" aria-controls="collapseSatuan">
                            <i class="fa-solid fa-filter"></i> Filtering
                        </a>
                        <div class="collapse" id="collapseSatuan">
                            <div class="card border border-info">
                                <div class="card-body">
                                    <form class="form" id="formFilterBarang">
                                        <div class="form-group row">
                                            <label class="label col-6 col-md-2">Start Tanggal</label>
                                            <div class="col-6 col-md-4">
                                                <input type="text" name="filterTanggal" id="filterTanggal" class="form-control form-control-sm ">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="label col-6 col-md-2">Lokasi</label>
                                            <div class="col-6 col-md-4">
                                                <select class="form-control form-control-sm " name="pilihLokasi" id="pilihLokasi">
                                                    <option value="0">Semua Lokasi</option>
                                                    @foreach($listofSite as $ls)
                                                    <option value="{{$ls->idm_site}}">{{$ls->site_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="label col-6 col-md-2">Kategori Barang</label>
                                            <div class="col-6 col-md-4">
                                                <select class="form-control form-control-sm display-select2" name="fromPilihBarang" id="fromPilihBarang">
                                                    <option value="0">Semua Kategori</option>
                                                    @foreach($category as $cat1)
                                                        <option value="{{$cat1->category_name}}">{{$cat1->category_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <label class="label col-6 col-md-1 text-right">s/d</label>
                                            <div class="col-6 col-md-4">
                                                <select class="form-control form-control-sm display-select2" name="endPilihBarang" id="endPilihBarang">
                                                    <option value="0">Semua Kategori</option>
                                                    @foreach($category as $cat2)
                                                        <option value="{{$cat2->category_name}}">{{$cat2->category_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div id="filterNamaBarang">
                                            <div class="form-group row">
                                                <label class="label col-6 col-md-2">Nama Barang</label>
                                                <div class="col-6 col-md-4">
                                                    <select class="form-control form-control-sm display-select2" name="fromNamaBarang">
                                                        <option value="0">Semua Nama Barang </option>
                                                    </select>
                                                </div>
                                                <label class="label col-6 col-md-1 text-right">s/d</label>
                                                <div class="col-6 col-md-4">
                                                    <select class="form-control form-control-sm display-select2" name="endNamaBarang">
                                                        <option value="0">Semua Nama Barang</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <div class="col-md-3">
                                                <button type="submit" class="btn btn-success font-weight-bold btn-block elevation-1 "><i class="fa-solid fa-magnifying-glass"></i> Cari</button>
                                            </div>
                                            <div class="col-md-3">
                                                <a class="btn btn-primary font-weight-bold btn-block elevation-1 " href="#" id="reloadData"><i class="fa-solid fa-rotate-right"></i> Reload Data</a>
                                            </div>
                                            <!--<div class="col-md-3">-->
                                            <!--    <a class="btn btn-primary font-weight-bold btn-block elevation-1" href="#"><i class="fa-solid fa-file-excel"></i> Cetak Kartu Stock Excel</a>-->
                                            <!--</div>-->
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-12"><hr class="border border-info"></div>
                        </div>
                        
                        <div id="filTeringAll">
                            <div class="form-group row">
                                <div class="col-6 col-md-3">
                                    <label>Scan Barcode</label>
                                    <input type="text" name="scanBarcode" id="scanBarcode" class="form-control form-control-sm" placeholder="Scan Barcode Disini">
                                </div>
                                <div class="col-6 col-md-3">
                                    <label>Option</label>
                                    <select class="form-control form-control-sm" name="filOption" id="filOption">
                                        <option value="1">All</option>
                                        <option value="3">Ready Stock</option>
                                        <option value="2">Total Stock < 100 Unit</option>
                                        <option value="0">Stock 0</option>
                                    </select>
                                </div>
                                <div class="col-6 col-md-3">
                                    <label>Cari Nama Barang</label>
                                    <input type="text" name="keyword" id="keyword" class="form-control form-control-sm" placeholder="Cari Nama Produk">
                                </div>
                                <div class="col-6 col-md-3">
                                    <button class="btn btn-success  btn-sm" style="position:absolute; left:0%; bottom:0%" id="btnDownloadExcel"><i class="fa-solid fa-file-excel"></i> Download Excel</button>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex justify-content-center">
                                    <div class="spinner-border text-danger spinner-border-sm" role="status" style="display:none;" id="spinnerStock">
                                      <span class="sr-only">Loading...</span>
                                    </div>
                                </div>
                                <div class="text-center LOAD-SPINNER text-sm" style="display:none;">    
                                    <span class="spinner-grow spinner-grow-sm" role="status"></span> Please Wait !
                                </div>
                                <div id="displayDataStock"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $( function() {
        $(".display-select2").select2();
        $( "#filterTanggal" ).datepicker({
            dateFormat: 'yy-mm-dd',
            autoclose: true,
            todayHighlight: true,
        });
        $('#filterTanggal').datepicker("setDate",new Date());
    } );
    
    $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        let keyWord = 0,
            timer_cari_equipment = null,
            lokasi = '0',
            filOption = $("#filOption").val();
        searchData(keyWord, filOption, lokasi);
        
        $("#keyword").keyup(function (e){
            e.preventDefault();
            clearTimeout(timer_cari_equipment);
            timer_cari_equipment = setTimeout(function(){
                let keyWord = $("#keyword").val().trim(),
                    lokasi = $("#pilihLokasi").val(),
                    filOption = $("#filOption").val();
                if (keyWord=='') {
                    keyWord = '0';
                }
                // alert (lokasi);
            searchData(keyWord, filOption, lokasi)},700)
        });
        
        $("#filOption").change(function(){
            let filOption = $(this).find(":selected").val(),
                lokasi = $("#pilihLokasi").val(),
                keyWord = $("#keyword").val();
                
            if (keyWord=='') {
                keyWord = '0';
            }
            searchData(keyWord, filOption, lokasi);
        });

        $("#btnDownloadExcel").on('click', function(){
            let filOption = $(this).find(":selected").val(),
                lokasi = $("#pilihLokasi").val(),
                keyWord = $("#keyword").val();
                
            if (keyWord=='') {
                keyWord = '0';
            }
            window.open("{{route('remainingStock')}}/downloadData/"+keyWord+"/"+filOption+"/"+lokasi,"_blank");
        })
        
        function searchData(keyWord, filOption, lokasi){ 
            $(".LOAD-SPINNER").show();
            $.ajax({
                type : 'get',
                url : "{{route('remainingStock')}}/searchByKeyword/"+keyWord+"/"+filOption+"/"+lokasi,
                success : function(response){
                    $(".LOAD-SPINNER").hide();
                    $("#displayDataStock").html(response);
                }
            });
        }
        
        let tanggalVal = $("#filterTanggal").val(),
            fromKategori = $("#fromPilihBarang").find(":selected").val(),
            endKategori = $("#endPilihBarang").find(":selected").val(),
            fromNamaBarang = $("#fromNamaBarang").find(":selected").val(),
            endNamaBarang = $("#endNamaBarang").find(":selected").val(),
            scanBarcode = $("#scanBarcode").val();
            lokasi = $("#pilihLokasi").find(":selected").val(),
            divDisplay = $("#displayDataStock");
            
        let data = {tanggalVal:tanggalVal, fromKategori:fromKategori,endKategori:endKategori,fromNamaBarang:fromNamaBarang,endNamaBarang:endNamaBarang,lokasi:lokasi};
        
        $("#fromPilihBarang").change(function(){
            let fromBarang = $(this).find(":selected").val(),
                endBarang = $("#endPilihBarang").find(":selected").val();
              
            $.ajax({
                type : 'get',
                url : "{{route('remainingStock')}}/filNamaBarang/" + fromBarang + "/" + endBarang,
                success : function(response){ 
                    $("#filterNamaBarang").html(response);
                }
            });
        });
        
        $("#endPilihBarang").change(function(){
            let endBarang = $(this).find(":selected").val(),
                fromBarang = $("#fromPilihBarang").find(":selected").val();
                
            $.ajax({
                type : 'get',
                url : "{{route('remainingStock')}}/filNamaBarang/" + fromBarang + "/" + endBarang,
                success : function(response){ 
                    $("#filterNamaBarang").html(response);
                }
            });
        });
        
        $("#reloadData").on('click', function(){
            location.reload();
        })
        
        $("form#formFilterBarang").submit(function(event){
            event.preventDefault();
            $("#spinnerStock").fadeIn();
            $.ajax({
                url: "{{route('remainingStock')}}/filteringData",
                type: 'POST',
                data: new FormData(this),
                async: true,
                cache: true,
                contentType: false,
                processData: false,
                success: function (data) {
                    divDisplay.html(data);
                    $("#spinnerStock").fadeOut();
                    // $("#filTeringAll").fadeOut();
                }
            });
            return false;
        });
        
        
    });
</script>
@endsection