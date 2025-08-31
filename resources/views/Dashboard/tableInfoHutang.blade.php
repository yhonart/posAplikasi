<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Hutang Pembelian</h3>
            </div>
            <div class="card-table">
                <table class="table table-sm table-valign-middle">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Supplier</th>
                            <th>Nominal Hutang</th>
                            <th>Do Date</th>
                            <th>Dibayar</th>
                            <th>Belum Dibayar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tableHutang as $th)
                            <tr>
                                <td>{{$th->number_dok}}</td>
                                <td>{{$th->store_name}}</td>
                                <td>{{$th->kredit}}</td>
                                <td></td>
                                <td class=" text-right text-blue font-weight-bolder">{{number_format($th->payed,'0',',','.')}}</td>
                                <td class=" text-right text-blue font-weight-bolder">{{number_format($th->selisih,'0',',','.')}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>