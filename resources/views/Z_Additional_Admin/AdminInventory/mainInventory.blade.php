<section class="container">    
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 elevation-1 collapsed-card text-xs">
                <div class="card-header border-0">
                    <button type="button" class="btn btn-info btn-sm font-weight-bold" data-card-widget="collapse"> <i class="fa-solid fa-filter"></i> Filter Item</button>                    
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

<section class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-purple table-responsive text-xs">
                <div class="card-header">
                    <h3 class="card-title">Inventory</h3>
                </div>
                <div class="card-body">
                    <div id="divTableInv"></div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    $(document).ready(function() {
        let productVal = '0',
            categoryVal = '0';

        loadInventory (productVal,categoryVal);  

        function loadInventory (productVal,categoryVal){
            $.ajax({
                type : 'get',
                url : "{{route('sales')}}/mainStock/dataResultInv/"+ productVal + "/" + categoryVal,
                success : function(response){
                    $("#divTableInv").html(response);
                }
            });
        }
    });
</script>