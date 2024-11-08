<div id="loadPaginate">
    @php
        $no = 1;
        $Status = array(
            0=>"Non Aktif",
            1=>"Aktif",
            2=>"Non Member",
        );
    @endphp
    <table class="table table-valign-middle table-hover">
        <thead class="text-center bg-gradient-purple">
            <tr>
                <th>Klik Pada Nama Pelanggan</th>
        </thead>
        <tbody>
            @foreach($customer as $c)
                <tr>
                    <td>
                        <a class="text-navy DETAIL-CUS" href="#" data-index="{{$c->idm_customer}}">{{$c->customer_store}}</a>
                        <a class="DEL-CUS btn  btn-outline-danger btn-sm float-right" href="#" data-id="{{$c->idm_customer}}" title="delete">
                            <i class="fa-solid fa-trash-can"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <small>{{$customer->links()}}</small>
</div>
<script>
    $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });  
        function ajaxPaging() {
            $('.pagination a').on('click', function (e) {
                e.preventDefault();
                var url = $(this).attr('href');
                $('#loadPaginate').load(url);
            });
        }
        ajaxPaging();

        $('.DEL-CUS').on('click', function () {
            let el = $(this);
            let dataID = el.attr('data-id');
            $.ajax({
                url: "{{route('Customers')}}/TableDataCustomer/DeleteTable/" + dataID,
                type: 'GET',
                success: function (data) {   
                    window.location.reload();                
                },                
            });
        });
        $('.DETAIL-CUS').on('click', function () {
            let el = $(this);
            let dataID = el.attr('data-index');
            $.ajax({
                url: "{{route('Customers')}}/TableDataCustomer/EditTable/" + dataID,
                type: 'GET',
                success: function (response) {
                    $("#displayEditCos").html(response);
                },                
            });
        });
    })
</script>