<section class="container">    
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow bg-light text-xs">
                <div class="card-header border-0">
                    <h3 class="card-title">Filtering Item</h3>
                </div>
                <div class="card-body">
                    <form id="formFilterItem">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Produk</label>
                                    <select name="produk" id="produk" class="form-control form-control-sm">
                                        <option value="0"></option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Category</label>
                                    <select name="category" id="category" class="form-control form-control-sm">
                                        <option value="0"></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-sm btn-success font-weight-bold">Cari</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    $(document).ready(function() {
        $('.MORE-INFO').on('click', function (e) {
            e.preventDefault();
            let path = $(this).attr('data-path');
            $("#divContent").load(route_main+'/'+path);
        });
    });
</script>