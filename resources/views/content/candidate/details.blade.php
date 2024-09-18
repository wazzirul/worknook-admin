@extends('layouts/contentNavbarLayout')

@section('title', 'Candidate Management - Details')

@section('vendor-style')
<link href="https://cdn.datatables.net/v/bs5/dt-2.0.5/b-3.0.2/r-3.0.2/sl-2.0.1/datatables.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="{{ asset(mix('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')) }}">
<link rel="stylesheet"
  href="{{ asset(mix('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')) }}">
<link rel="stylesheet"
  href="{{ asset(mix('assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('assets/vendor/libs/datatables-rowgroup-bs5/rowgroup.bootstrap5.css')) }}">
<style>
</style>
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

<h4 class="py-3 mb-4">
  <span class="text-muted fw-light">Candidate /</span> Job Applied
</h4>
<div class="card mb-4">
  <div class="d-flex align-items-start row">
    <div class="col-sm-2 text-center text-sm-left">
      <div class="card-body p-4" id="imgApplicant">
        <img src='{{ $dataComp->data->applicant_profile->profile_photo ?? "" }}' height="140" alt="View Badge User"
          data-app-dark-img="illustrations/man-with-laptop-dark.png"
          data-app-light-img="illustrations/man-with-laptop-light.png" class="rounded-circle">
      </div>
    </div>
    <div class="col-sm-7">
      <div class="card-body">
        <h5 class="card-title text-primary" id="applicantName">{{ $dataComp->data->applicant_profile->fullname ?? $dataComp->data->fullname  }}</h5>
        <small>
          <a href="javascript:;" class="text-primary">{{ $dataComp->data->applicant_profile->website ?? ""}}</a>
        </small>
        <div class="mb-4">{!! $dataComp->data->applicant_profile->about_me ?? "none"!!}</div>

        <div class="d-flex column gap-2">
          <small class="text-muted">Company : {{ $dataComp->data->applicant_profile->company ?? "none" }}</small>
        </div>
        <div class="d-flex column gap-2">
          <small class="text-muted">Position : {{ $dataComp->data->applicant_profile->position ?? "none"}}</small>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- DataTable with Buttons -->
<div class="card">
  <div class="card-datatable table-responsive">
    <table class="datatables-basic table border-top table-hover table-striped table-striped" style="width:100%">
      <thead>
        <tr>
          <th>Company</th>
          <th>Job Title</th>
          <th>Location</th>
          <th>Salary Range</th>
          <th>Status</th>
          <th>Update At</th>
        </tr>
      </thead>
    </table>
  </div>
</div>

@endsection

@section('page-script')
<script>
  var userRole = "{{ session('role') }}";
  var data_api = @json($dataComp->data->job);

  var ft = "{{  $dataComp->data->applicant_profile->profile_photo ?? ""  }}";
  var name = document.getElementById("applicantName").innerText;

  if (ft) {
    var o = '<img src="' + ft + '" alt="Avatar" class="rounded-circle ">';
  } else {
      var d = ['success', 'danger', 'warning', 'info', 'dark', 'primary', 'secondary'][
          Math.floor(6 * Math.random())
      ];
      var i = (name).match(/\b\w/g) || [];
      o =
          '<span class="avatar-initial rounded-circle bg-label-' +
          d +
          '">' +
          ((i.shift() || '') + (i.pop() || '')).toUpperCase() +
          '</span>';
  }

  var output = '<div class="d-flex justify-content-center align-items-center">';
  output += '<div class="avatar-wrapper"><div class="avatar me-3" style="font-size:2rem;height:140px;width:140px">' + o + '</div></div>';
  output += '</div>';

document.getElementById("imgApplicant").innerHTML = output;
</script>
<script src="https://cdn.datatables.net/v/bs5/dt-2.0.5/datatables.min.js"></script>
<script src="https://cdn.datatables.net/v/bs5/dt-2.0.5/b-3.0.2/r-3.0.2/sl-2.0.1/datatables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script
  src="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.5/b-3.0.2/b-colvis-3.0.2/b-html5-3.0.2/b-print-3.0.2/r-3.0.2/sl-2.0.1/datatables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="{{asset('assets/js/candidate-details-data-tables.js')}}"></script>
@endsection