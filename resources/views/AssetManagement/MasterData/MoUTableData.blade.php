@php
    $no = 1;
@endphp
<table class="table table-striped table-valign-middle table-sm">
    <thead class="bg-purple text-center">
        <tr>
            <th>No.</th>
            <th>Inisial</th>
            <th>Satuan</th>
            <th><i class="fa-solid fa-bars"></i></th>
        </tr>
    </thead>
    <tbody>
        @foreach($mouData as $mou)
            <tr>
                <td class="text-center">{{$no++}}</td>
                <td>{{$mou->unit_initial}}</td>
                <td>{{$mou->unit_note}}</td>
                <td class="text-right">
                    <div class="btn-group btn-sm">
                        <button type="button" class="btn btn-default" data-toggle="dropdown">
                            <i class="fa-solid fa-bars"></i>
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" role="menu">
                            <a class="dropdown-item BTN-OPEN-MODAL-GLOBAL-LG" href="{{route('MoU')}}/tableMoU/EditMoU/{{$mou->idm_unit}}"><i class="fa-solid fa-pencil"></i> Edit Unit</a>                                    
                            <a class="dropdown-item BTN-OPEN-MODAL-GLOBAL-LG" href="{{route('MoU')}}/tableMoU/DeleteMoU/{{$mou->idm_unit}}"><i class="fa-solid fa-trash-can"></i> Delete Permanently</a>
                        </div>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>