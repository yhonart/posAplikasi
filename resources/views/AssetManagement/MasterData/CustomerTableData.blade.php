<div id="loadPaginate">
    @php
        $no = 1;
        $Status = array(
            0=>"Non Aktif",
            1=>"Aktif",
            2=>"Non Member",
        );
    @endphp
    <table class="table table-valign-middle table-hover table-sm">        
        <tbody>
            @foreach($customer as $c)
                <tr>
                    <td class="p-0">
                        <a class="btn btn-default btn-block rounded-0 border-0 elevation-0 btn-sm text-primary font-weight-bold text-left DETAIL-CUS" href="#" data-index="{{$c->idm_customer}}">
                            {{$c->customer_store}}
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