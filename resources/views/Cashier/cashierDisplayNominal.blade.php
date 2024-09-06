<div class="input-group row">
    <div class="col-12">
        <h1 class="bg-info p-2 elevation-1"><i class="fa-solid fa-rupiah-sign"></i><span class="float-right">{{number_format($nominalBelanja->billing,0,',','.')}}</span></h1>
    </div>
</div>
<div class="form-group row align-items-end ">
    <label for="tItem" class="form-label col-4">Total Item</label>
    <div class="col-8">
        <input type="text" name="tItem" id="tItem" class="form-control form-control-sm form-control-border" value="{{$countBelanja}}" readonly>
    </div>
</div>