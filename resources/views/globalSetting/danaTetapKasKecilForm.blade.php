<div class="card">
    <div class="card-header">
        <h3 class="text-header">Setup Modal Transaksi</h3>
    </div>
    <div class="card-body">
        <form id="formAddModal">
            <div class="form-group row">
                <label for="nominalModal" class="col-md-4">Nominal</label>
                <div class="col-md-4">
                    <input type="text" name="nominal" id="Nominal" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success font-weight-bold">Submit</button>
            </div>
        </form>
    </div>
</div>
<script>
    $(document).ready(function(){
        $("form#formAddModal").submit(function(event){
            event.preventDefault();
            $.ajax({
                url: "{{route('modalKasKecil')}}/formAddModalFix/postModalFixed",
                type: 'POST',
                data: new FormData(this),
                async: true,
                cache: true,
                contentType: false,
                processData: false,
                success: function (data) {                    
                    window.location.reload();
                },                
            });
            return false;
        });
    });
</script>