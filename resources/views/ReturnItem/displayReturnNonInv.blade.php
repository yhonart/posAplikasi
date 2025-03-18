<div class="card card-purple">
    <div class="card-header">
        <h3 class="card-title">Pengembalian Non Invoice</h3>
    </div>
    <div class="card-body">
        @if($countNumberRetur == '0')
            <form id="formCreateDokRetur">
                <div class="form-group row">
                    <label for="numberDokumen" class="col-md-3">No. Dokumen</label>
                    <div class="col-md-4">
                        <input type="text" class="form-control form-control-sm" name="numberDokumen" id="numberDokumen" value="{{$returnNumber}}" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="tglDokumen" class="col-md-3">Tgl. Dokumen</label>
                    <div class="col-md-4">
                        <input type="text" class="form-control form-control-sm datetimepicker-input" name="tglDokumen" id="tglDokumen">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="supplier" class="col-md-3"> Supplier</label>
                    <div class="col-md-4">
                        <select name="supplier" id="supplier" class="form-control form-control-sm">
                            <option value="0"> ==== </option>
                            @foreach($optionSupplier as $ops)
                                <option value="{{$ops->idm_supplier}}">{{$ops->store_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="keterangan" class="col-md-3">Keterangan</label>
                    <div class="col-md-4">
                        <textarea class="form-control from-control-sm" rows="3" name="keterangan" id="keterangan"></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-sm btn-success font-weight-bold"><i class="fa-solid fa-floppy-disk"></i> Simpan</button>
                    </div>
                </div>
            </form>
            <script>
                $(function(){
                    $( ".datetimepicker-input" ).datepicker({
                        dateFormat: 'yy-mm-dd',
                        autoclose: true,
                        todayHighlight: true,
                    });
                });
                $(document).ready(function () {
                    $('#productSubmit').on('click', function(e){
                        e.preventDefault();
                        let data_form = new FormData(document.getElementById("formCreateDokRetur"));
                        $.ajax({
                            url : "{{route('returnItem')}}/returnNonInv/postDokumenReturn",
                            type: 'post',
                            data: data_form,
                            async: true,
                            cache: true,
                            contentType: false,
                            processData: false,
                            success : function (data) {
                                if (data.warning) {
                                    alertify.success(data.warning);
                                }  
                                else{
                                    alertify.success(data.success);
                                    functionLoadNonInvoice ();
                                }                          
                            }
                        })
                    });

                    function functionLoadNonInvoice (){
                        var pageLoad = "returnNonInv";
                        $.ajax({
                            type : 'get',
                            url : "{{route('returnItem')}}/"+dataIndex,
                            success : function(response){
                                $("#displayInfo").html(response);
                            }
                        });
                    } 
                });
            </script>
        @else
            <div id="transaksiReturNonInvoice"></div>
        @endif
    </div>
</div>