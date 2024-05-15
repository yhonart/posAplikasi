<div class="row">
    @foreach($dbSystem as $dbs)
        <div class="col-12 col-md-3">            
            <a href="{{route($dbs->link_url)}}">
                <div class="callout callout-info el-zoom">
                    <h5 class="text-success font-weight-bold">{{$dbs->system_name}}</h5>

                    <small class="text-navy">{{$dbs->description}}</small>
                </div>
            </a>
        </div>        
    @endforeach
</div>