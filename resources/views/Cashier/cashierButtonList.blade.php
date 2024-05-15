@if($countActiveDisplay >= '1')
    @include('Cashier.cashierButtonListNotEmpty')
@else
    @include('Cashier.cashierButtonListEmpty')
@endif