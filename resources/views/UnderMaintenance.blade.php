@extends('layouts.sidebarpage')

@section('content')
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Page Loading</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">404 Error Page</li>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>
<section class="content">
  <div class="error-page">
    <h2 class="headline text-warning"> 404</h2>

    <div class="error-content">
      <h3><i class="fas fa-exclamation-triangle text-warning"></i> Sorry Page Loading Uploaded.</h3>

      <p>
        Halaman sedang dalam proses upload Data. Terima kasih
      </p>

      
    </div>
    <!-- /.error-content -->
  </div>
  <!-- /.error-page -->
</section>
@endsection