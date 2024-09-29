@if(!empty($storeName))
<span class="brand-text font-weight-bold"><i class="fa-solid fa-store"></i> {{$storeName->company_name}}</span>
@else
<span class="brand-text font-weight-bold"><i class="fa-solid fa-store"></i> TOKO ID</span>
@endif