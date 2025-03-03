<form id="formNewCompany" autocomplete="off">
    <div class="form-group row">
        <label class="col-md-4 form-label">Nama Perusahaan</label>
        <div class="col-md-8">
            <input type="text" name="companyName" id="companyName" class="form-control form-control-sm uppercase">
        </div>
    </div>
    <div class="form-group row"`>
        <label class="col-md-4 form-label">Bidang Usaha</label>
        <div class="col-md-8">
            <input type="text" name="companyDesc" id="companyDesc" class="form-control form-control-sm">
        </div>
    </div>
    <div class="form-group row"`>
        <label class="col-md-4 form-label">Alamat</label>
        <div class="col-md-8">
            <input type="text" name="companyAddress" id="companyAddress" class="form-control form-control-sm">
        </div>
    </div>
    <div class="form-group row"`>
        <label class="col-md-4 form-label">Owner/Personal Paraf</label>
        <div class="col-md-8">
            <input type="text" name="owner" id="owner" class="form-control form-control-sm">
        </div>
    </div>
    <div class="form-group row"`>
        <label class="col-md-4 form-label">Telefone</label>
        <div class="col-md-2">
            <input type="text" name="Country" id="Country" class="form-control-plaintext form-control-sm border-bottom" value="ID +62" Disabled>
        </div>
        <div class="col-md-6">
            <input type="text" name="telefone" id="telefone" class="form-control form-control-sm">
        </div>
    </div>
    <div class="form-group row">
        <label for="location" class="col-md-4 form-label">Lokasi</label>
        <div class="col-md-8">
            <select name="location" id="location" class="form-control form-control-sm">
                <option value="0">===</option>
                @foreach($selectLocation as $sl)
                    <option value="{{$sl->location_id}}">{{$sl->location_name}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group row"`>
        <div class="col-md-4">
            <button type="submit" class="btn btn-success font-weight-bold">Save</button>
        </div>        
        <div class="col-md-8">
            <div class="red-alert p-2 rounded rounded-2 notive-display" style="display:none;">
                <span class="font-weight-bold" id="notiveDisplay" ></span>
            </div>
        </div>
    </div>    
</form>
<script>
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        let alertNotive = $('.notive-display'),
            link = "companyDisplay";

        $("form#formNewCompany").submit(function(event){
            event.preventDefault();
            $.ajax({
                url : "{{route('CompanySetup')}}/companyDisplay/postNewCompany",
                type : 'POST',
                data : new FormData(this),
                async : true,
                cache : true,
                contentType : false,
                processData : false,
                success : function (data) {
                    if (data.warning) {
                        $(".notive-display").fadeIn();
                        $("#notiveDisplay").html(data.success);
                        alertNotive.removeClass('green-alert').addClass('red-alert');                        
                    }
                    else{
                        $(".notive-display").fadeIn();
                        $("#notiveDisplay").html(data.success);
                        alertNotive.removeClass('red-alert').addClass('green-alert');
                        $("#DivContent").load("{{route('CompanySetup')}}/"+link);
                    }
                }
            })
        })
    });
</script>