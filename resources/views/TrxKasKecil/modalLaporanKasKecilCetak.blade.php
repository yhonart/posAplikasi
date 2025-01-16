<div class="card">
    <div class="card-body">
        <form id="formAddModalKas">
            <div class="form-group row">
                <label for="danaTambahan" class="label col-md-3">Nominal</label>
                <div class="col-md-4">
                    <input type="text" class="form-control priceText" name="nominal" id="nominal">
                </div>
            </div>
            <div class="form-group row">
                <label for="danaTambahan" class="label col-md-3">Sumber Dana</label>
                <div class="col-md-4">
                    <select name="sumberDana" id="sumberDana" class="form-control">
                        <option value="0"></option>
                        @foreach($sumberDana as $smbD)
                        <option value="{{$smbD->created_by}}">{{$smbD->created_by}} || {{number_format($smbD->totKasir,'0',',','.')}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="danaTambahan" class="label col-md-3">Selisih</label>
                <div class="col-md-4">
                    <input type="text" class="form-control priceText" name="selisih" id="selisih">
                </div>
            </div>
            <div class="form-group row">
                <label for="danaTambahan" class="label col-md-3">Keterangan</label>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="keterangan" id="keterangan">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-4">
                    <button type="submit" class="btn btn-success" id="submitTambahModal"><i class="fa-solid fa-floppy-disk"></i> Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    $(function(){
        $('.priceText').mask('000.000.000', {
            reverse: true
        });
    });
    $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $("form#formAddModalKas").submit(function(event){
            event.preventDefault();
            $.ajax({
                url: "{{route('kasKecil')}}/addModalKas/postingTambahSaldo",
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