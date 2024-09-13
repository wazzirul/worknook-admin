@extends('layouts/contentNavbarLayout')

@section('title', 'Activity History - Index')

@section('vendor-style')
<!-- Include stylesheet -->
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" />
<style>

</style>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endsection

@section('content')
<!-- Error and Success Alert -->
@if(Session::has('error'))
<div class="alert alert-danger alert-dismissible" role="alert">
  {{ Session::get('error') }}
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
  </button>
</div>
@endif @if(Session::has('success'))
<div class="alert alert-success alert-dismissible" role="alert">
  {{ Session::get('success') }}
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
  </button>
</div>
@endif


<!-- DataTable with Buttons -->
<div class="card">
  <div class="card-header">
    <h2>Activity History</h2>
  </div>
  <div class="card-body">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-2 col-5"> <select class="form-select" id="typeSelect">
          <option value="all">All</option>
          <option value="applicant">Applicant</option>
          <option value="company">Company</option>
          <option value="team-company">Team Company</option>
        </select></div>
        <div class="col-3 col-md-1"><select class="form-select" id="pageSelect">
          <option value="10">10</option>
          <option value="25">25</option>
          <option value="50">50</option>
        </select></div>
        <div class="col-4 col-md-3 align-content-center">entries per page</div>
        <div class="col-4 col-md-4 align-content-center"><input type="text" class="form-control" id="search" placeholder="Enter text"></div>
        <div class="col-4 col-md-1 align-content-center"><form><button class="btn btn-primary" type="submit" id="button-search">Search</button></form></div>
        <div class="col-4 col-md-1 align-content-center"><button class="btn btn-outline-dark" type="button" id="button-reset">Reset</button></div>
      </div>
    </div>
    <div class="container-fluid mt-3 p-2 border-bottom border-top border-1 border-light">
      <table class="text-center" style="width: 100%;font-size:0.75rem;letter-spacing: 1px">
        <colgroup>
          <col span="1" style="width: 15%;">
          <col span="1" style="width: 45%;">
          <col span="1" style="width: 20%;">
          <col span="1" style="width: 20%;">
       </colgroup>
        <thead>
          <tr>
            <th>NAME</th>
            <th>HISTORY</th>
            <th>TYPE</th>
            <th>DATE</th>
          </tr>
        </thead>
      </table>
     
    </div>
    <div class="container-fluid">
      <div class="row" id="name">
        {{-- content --}}
      </div>
    </div>
    <div class="container-fluid mt-2">
      <div class="row">
          
          <div class="col-md-12 text-center" id="paginate">
         {{-- paginate --}}
        </div>
      </div>
    </div>
   
  </div>
  
</div>
@endsection

@section('page-script')
<script>
  var userRole = "{{ session('role') }}";
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="{{asset('assets/js/activity-history.js')}}"></script>
@endsection
