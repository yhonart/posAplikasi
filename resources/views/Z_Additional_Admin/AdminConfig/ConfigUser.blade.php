<div class="card card-info">
    <div class="card-header">
        <h3 class="card-title">Pengaturan Akun Toko</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="remove">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="row mb-2">
            <div class="col-md-4">
                <button type="button" class="btn btn-sm btn-info font-weight-bold ACTION-CLASS BTN-OPEN-MODAL-GLOBAL-LG" href="{{route('sales')}}/configUser/createAkun">Tambah Akun</button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div id="tableAkunToko"></div>
            </div>
        </div>
    </div>
</div>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(function(){
        $("#tableAkunToko").load("{{route('sales')}}/configUser/tableAkunToko");
    });
</script>