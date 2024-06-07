<div class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1 class="m-0">Asset List</h1>
        </div><!-- /.col -->
    </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <a class="btn btn-info" href="{{route('AllAssets')}}/NewAsset" target="_blank"><i class="fa-solid fa-circle-plus"></i> Add Asset</a>
                <a class="btn btn-info" href="{{route('AllAssets')}}/AddCategory" target="_blank"><i class="fa-solid fa-arrows-rotate"></i> Load Data</a>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        @include('Global.global_spinner')
                        <div id="displayTableCategory"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>