@extends('layouts/contentNavbarLayout')

@section('title', 'Dashboard - Analytics')

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
<!-- Dashboard Line 1 -->
<div class="row">
  <div class="col-sm-4 col-sm-4 mb-4">
    <div class="card card-border-shadow-primary h-100">
      <div class="card-body">
        <div class="d-flex align-items-center mb-2 pb-1">
          <div class="avatar me-2">
            <span class="avatar-initial rounded bg-label-primary"><i class="bx bxs-user"></i></span>
          </div>
          <h4 class="ms-1 mb-0">220</h4>
        </div>
        <p class="mb-1">Total Jobs Posted</p>
      </div>
    </div>
  </div>
  <div class="col-sm-4 col-sm-4 mb-4">
    <div class="card card-border-shadow-warning h-100">
      <div class="card-body">
        <div class="d-flex align-items-center mb-2 pb-1">
          <div class="avatar me-2">
            <span class="avatar-initial rounded bg-label-info"><i class="bx bx-user-plus"></i></span>
          </div>
          <h4 class="ms-1 mb-0">705</h4>
        </div>
        <p class="mb-1">Total Applicants</p>
      </div>
    </div>
  </div>
  <div class="col-sm-4 col-sm-4 mb-4">
    <div class="card card-border-shadow-danger h-100">
      <div class="card-body">
        <div class="d-flex align-items-center mb-2 pb-1">
          <div class="avatar me-2">
            <span class="avatar-initial rounded bg-label-success"><i class="bx bx-user-check"></i></span>
          </div>
          <h4 class="ms-1 mb-0">115</h4>
        </div>
        <p class="mb-1">Total Company Registered</p>
      </div>
    </div>
  </div>
</div>
<!-- Dashboard Line 1 -->
<!-- Dashboard Line 2 -->
<div class="row">
  <!-- Line 2 Col 1 -->
  <div class="col-12 col-md-8 mb-4">
    <div class="card">
      <div class="card-header header-elements">
        <h5 class="card-title mb-0">Job Statistics</h5>
        <div class="card-header-elements py-0 ms-auto">
          <div class="dropdown">
            <button type="button" class="btn dropdown-toggle p-0" data-bs-toggle="dropdown" aria-expanded="false"><i
                class="bx bx-calendar"></i></button>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">2024</a></li>
              <li><a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">2023</a></li>
            </ul>
          </div>
        </div>
      </div>
      <div class="card-body pt-2">
        <canvas id="lineAreaChart" class="chartjs" data-height="450"></canvas>
      </div>
    </div>
  </div>
  <!-- Line 2 Col 1 -->
  <!-- Line 2 Col 2 -->
  <div class="col-12 col-md-4 mb-4">
    <div class="card">
      <div class="card-header header-elements">
        <h5 class="card-title mb-0">Job Types</h5>
      </div>
      <div class="card-body">
        <canvas id="polarChart" class="chartjs" data-height="200"></canvas>
      </div>
    </div>
    <!-- Line 2 Col 2 -->
  </div>
  <!-- Dashboard Line 2 -->
  <!-- Dashboard Line 3 -->
  <div class="row">
    <div class="col-12 mb-4">
      <!-- Datatables New Jobs Here -->
      <!-- Heading : Latest Jobs Posted -->
      <!-- Button See More Jobs -->
      <div class="card">
        <div class="card-datatable table-responsive">
          <table class="datatables-basic table border-top table-hover" style="width:100%">
            <thead>
              <tr>
                <th>Job Title</th>
                <th>Job Type</th>
                <th>Job Level</th>
                <th>Job Location</th>
                <th>Registered Date</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
  <!-- Dashboard Line 3 -->
  <!-- Dashboard Line 4 -->
  <div class="row">
    <div class="col-12 mb-4">
      <!-- Datatables New Registered User Here -->
      <!-- Heading : New Users -->
      <!-- Button See More Candidates / User -->
      <div class="card">
        <div class="card-datatable table-responsive">
          <table class="datatables-basic table border-top table-hover" style="width:100%">
            <thead>
              <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Status</th>
                <th>Registered Date</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
  <!-- Dashboard Line 4 -->
  @endsection
  @section('page-script')
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
  <script src="{{asset('assets/js/dashboard-charts.js')}}"></script>
  @endsection