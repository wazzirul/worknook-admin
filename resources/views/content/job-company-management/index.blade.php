@extends('layouts/contentNavbarLayout')

@section('title', 'Company Management - Index')

@section('vendor-style')
<link href="https://cdn.datatables.net/v/bs5/dt-2.0.5/b-3.0.2/r-3.0.2/sl-2.0.1/datatables.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset(mix('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')) }}">
<link rel="stylesheet"
  href="{{ asset(mix('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')) }}">
<link rel="stylesheet"
  href="{{ asset(mix('assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('assets/vendor/libs/datatables-rowgroup-bs5/rowgroup.bootstrap5.css')) }}">
<style>
  /* Hide selected columns on initial */
  .datatables-basic thead tr th:nth-child(2),
  .datatables-basic thead tr th:nth-child(4),
  .datatables-basic thead tr th:nth-child(7),
  .datatables-basic thead tr th:nth-child(8),
  .datatables-basic thead tr th:nth-child(9),
  .datatables-basic thead tr th:nth-child(12),
  .datatables-basic tbody tr *:nth-child(2),
  .datatables-basic tbody tr *:nth-child(4),
  .datatables-basic tbody tr *:nth-child(7),
  .datatables-basic tbody tr *:nth-child(8),
  .datatables-basic tbody tr *:nth-child(9),
  .datatables-basic tbody tr *:nth-child(12) {
    display: none;
  }
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
  <span class="text-muted fw-light">Company /</span> Job List
</h4>
<div class="card mb-4">
  <div class="d-flex align-items-start row">
    <div class="col-sm-2 text-center text-sm-left">
      <div class="card-body p-4">
        <img src='{{ $dataComp->data->company_profile->company_icon }}' height="140" alt="View Badge User"
          data-app-dark-img="illustrations/man-with-laptop-dark.png"
          data-app-light-img="illustrations/man-with-laptop-light.png">
      </div>
    </div>
    <div class="col-sm-7">
      <div class="card-body">
        <h5 class="card-title text-primary">{{ $dataComp->data->company_profile->company_name }}</h5>
        <small>
          <a href="javascript:;" class="text-primary">{{ $dataComp->data->company_profile->website }}</a>
        </small>
        <div class="mb-4">{!! $dataComp->data->company_profile->description !!}</div>

        <div class="d-flex column gap-2">
          <small class="text-muted">Founded by : {{ $dataComp->data->fullname }}</small>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- DataTable with Buttons -->
<div class="card">
  <div class="card-datatable table-responsive">
    <table class="datatables-basic table border-top table-hover table-striped" style="width:100%">
      <thead>
        <tr>
          <th>Job Title</th>
          <th>Job Level</th>
          <th>Job Type</th>
          <th>Description</th>
          <th>Location</th>
          <th>Salary Range</th>
          <th>Responsibilities</th>
          <th>Requirements</th>
          <th>Current Applicant</th>
          <th>Status</th>
          <th>Posted Date</th>
          <th>Action</th>
        </tr>
      </thead>
    </table>
  </div>
</div>

<!-- Modal Details -->
<div class="modal fade dtr-bs-modal" id="modalDetails" role="dialog" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalCenterTitle">Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input type="text" id="id_company" value="{{$dataComp->data->company_profile->user_id}}" hidden>
        <table class="table">
          <tbody class="data-modal">
          </tbody>
        </table>
      </div>
      <!-- <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div> -->
    </div>
  </div>
</div>
<!-- Modal Delete Confirmation -->
<div class="modal fade" id="deleteJobModal" tabindex="-1" aria-hidden="true" style="z-index: 1091">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">

      <div class="modal-header">

        <h5 class="modal-title" id="modalCenterTitle">Close Job</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" class="dt-blog-id" name="blogID">
        <p>Are you sure to close this Job Company?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-danger delete-record" id="confirmationBtn">Delete</button>
      </div>

    </div>
  </div>
</div>
@endsection

@section('page-script')
<script>
  var userRole = "{{ session('role') }}";
  var uuid;

  (function () {
    var match = window.location.href.match(/\/company-details\/([0-9a-fA-F-]{36})/);
    if (match && match[1])
    {
      uuid = match[1];
      console.log('Extracted Company ID:', uuid);
    } else
    {
      alert('Company ID not found in the URL');
    }
  })();
</script>
<script src="https://cdn.datatables.net/v/bs5/dt-2.0.5/datatables.min.js"></script>
<script src="https://cdn.datatables.net/v/bs5/dt-2.0.5/b-3.0.2/r-3.0.2/sl-2.0.1/datatables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script
  src="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.5/b-3.0.2/b-colvis-3.0.2/b-html5-3.0.2/b-print-3.0.2/r-3.0.2/sl-2.0.1/datatables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js"></script>
<script src="{{asset('assets/js/job-company-data-tables.js')}}"></script>
<script>
  // Delete Function
  $(document).on('click', '.delete-record', async function () {
    const status = $(this).data('banned');
    const dataId = $(this).data('id');

    $('.modal').modal('hide');
    $('#deleteJobModal').modal('show');

    $(document).on('click', '#confirmationBtn', async function () {
    const url = "/jobs/store";
    const method = "POST";
    const elementData = $('#id_company').val();
    const url_delete = "/company-details/delete/" + elementData;
    console.log(url_delete);
    // Prepare payload data
    const payload = {
      job_id: dataId,
      soft_delete: status === 1 ? 0 : 1
    };
  // TODO : Close Job with Status not softdelete

    // await $.ajax({
    //   method: 'POST',
    //   url: '/query',
    //   data: {
    //     _token: $('meta[name="csrf-token"]').attr('content'),
    //     url: url,
    //     method: method,
    //     payload: payload
    //   },
    //   success: function (response) {
    //     setTimeout(function () {
          
    //      location.replace(url_delete);
          
    //     }, 500); // Adjust delay as needed
        
    //   },
    //   error: function (xhr, status, error) {
    //     $('.alert-danger').html(xhr.responseText).show(); // Display error message
    //   }
    // });
  })
  });

</script>
@endsection