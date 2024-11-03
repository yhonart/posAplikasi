<div class="card card-body" id="cardAddDocCorrection">
    <form class="form" id="formInputKoreksi">
        <div class="form-group row">
            <label class="label col-6 col-md-2">No. Koreksi</label>
            <div class="col-6 col-md-4">
                <input type="text" name="nomorKoreksi" id="nomorKoreksi" class="form-control form-control-sm" value="{{$nKrs}}" readonly>
            </div>
        </div>
        <div class="form-group row">
            <label class="label col-6 col-md-2">Tanggal</label>
            <div class="col-6 col-md-4">
                <input type="text" name="filterTanggal" id="filterTanggal" class="form-control form-control-sm">
            </div>
        </div>
        <div class="form-group row">
            <label class="label col-6 col-md-2">Keterangan</label>
            <div class="col-6 col-md-4">
                <textarea class="form-control" rows="4" placeholder="Enter ..." name="description" id="description"></textarea>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-2">
                <button type="submit" class="btn btn-success font-weight-bold btn-block"><i class="fa-solid fa-magnifying-glass"></i> Submit</button>
            </div>
        </div>
    </form>
</div>

<script>
    $( function() {
        $( "#filterTanggal" ).datepicker({
            dateFormat: 'yy-mm-dd',
            autoclose: true,
            todayHighlight: true,
        });
        $('#filterTanggal').datepicker("setDate",new Date());
    } );

    $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        $("form#formInputKoreksi").submit(function(event){
            event.preventDefault();
            let display = "listInputBarang";
            $("#cardAddDocCorrection").fadeOut("slow");
            $("#displayNotif").fadeIn("slow");
            $.ajax({
                url: "{{route('koreksiBarang')}}/submitFormKoreksi",
                type: 'POST',
                data: new FormData(this),
                async: true,
                cache: true,
                contentType: false,
                processData: false,
                success: function (data) {
                    // $("form#formInputKoreksi")[0].reset();
                    // document.getElementById("formInputKoreksi").style.display = "none";
                    $("#displayNotif").fadeOut("slow");
                    alertify.success('Success !');
                    viewTableInput(display);
                }
            });
            return false;
        });
    });
    
    function viewTableInput(display) {
        $.ajax({
            type : 'get',
            url : "{{route('koreksiBarang')}}/"+display,
            success : function(response){
                $('#displayOnDiv').html(response);
            }
        });
    }  
</script>