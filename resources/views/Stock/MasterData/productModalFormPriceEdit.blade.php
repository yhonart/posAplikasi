<div class="card">
    <div class="card-header border-0">
        <h3 class="card-title font-weight-bold">Pengaturan Harga Utama</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool border-0 elevation-1" data-dismiss="modal"><i class="fa-solid fa-circle-xmark"></i></button>
        </div>
    </div>
    <div class="card-body"> 
        <div class="row">
            <div class="col-12">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Ukuran</th>
                            <th>Satuan</th>
                            <th>Harga Beli</th>
                            <th>Harga Jual</th>
                            <th>stock</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>  
    </div>
</div>
<script>
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('.price-text').mask('000.000.000',{reverse: true});
        let alertNotive = $('.notive-display');

        $("form#FormAddProductPrice").submit(function(event){
            event.preventDefault();
            $.ajax({
                url : "{{route('Stock')}}/ProductMaintenance/PostNewProductPrice",
                type : 'POST',
                data : new FormData(this),
                async : true,
                cache : true,
                contentType : false,
                processData : false,
                success : function (data) {
                    $(".notive-display").fadeIn();
                    $("#notiveDisplay").html(data.success);
                    alertNotive.removeClass('red-alert').addClass('green-alert');
                }
            })
        })
    });
</script>