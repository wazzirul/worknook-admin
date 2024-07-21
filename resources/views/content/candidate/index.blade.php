@extends('layouts/contentNavbarLayout')

@section('title', 'Candidate Management - Index')

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
  /* Hide selected columns on initial */
  .datatables-basic thead tr th:nth-child(4),
  .datatables-basic thead tr th:nth-child(5),
  .datatables-basic thead tr th:nth-child(6),
  .datatables-basic thead tr th:nth-child(8),
  .datatables-basic tbody tr *:nth-child(4),
  .datatables-basic tbody tr *:nth-child(5),
  .datatables-basic tbody tr *:nth-child(6),
  .datatables-basic tbody tr *:nth-child(8) {
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
<div class="row">
  <div class="col-sm-6 col-lg-3 mb-4">
    <div class="card card-border-shadow-primary h-100">
      <div class="card-body">
        <div class="d-flex align-items-center mb-2 pb-1">
          <div class="avatar me-2">
            <span class="avatar-initial rounded bg-label-primary"><i class="bx bxs-user"></i></span>
          </div>
          <h4 class="ms-1 mb-0">{{$summary->total_candidate}}</h4>
        </div>
        <p class="mb-1">Total Candidate</p>
        <!-- <p class="mb-0">
          <span class="fw-medium me-1">+18.2%</span>
          <small class="text-muted">than last week</small>
        </p> -->
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-lg-3 mb-4">
    <div class="card card-border-shadow-warning h-100">
      <div class="card-body">
        <div class="d-flex align-items-center mb-2 pb-1">
          <div class="avatar me-2">
            <span class="avatar-initial rounded bg-label-info"><i class="bx bx-user-plus"></i></span>
          </div>
          <h4 class="ms-1 mb-0">{{$summary->total_new_candidate}}</h4>
        </div>
        <p class="mb-1">Total New Candidate</p>
        <!-- <p class="mb-0">
          <span class="fw-medium me-1">-8.7%</span>
          <small class="text-muted">than last week</small>
        </p> -->
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-lg-3 mb-4">
    <div class="card card-border-shadow-danger h-100">
      <div class="card-body">
        <div class="d-flex align-items-center mb-2 pb-1">
          <div class="avatar me-2">
            <span class="avatar-initial rounded bg-label-success"><i class="bx bx-user-check"></i></span>
          </div>
          <h4 class="ms-1 mb-0">{{$summary->total_active_candidate}}</h4>
        </div>
        <p class="mb-1">Total Active Candidate</p>
        <!-- <p class="mb-0">
          <span class="fw-medium me-1">+4.3%</span>
          <small class="text-muted">than last week</small>
        </p> -->
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-lg-3 mb-4">
    <div class="card card-border-shadow-info h-100">
      <div class="card-body">
        <div class="d-flex align-items-center mb-2 pb-1">
          <div class="avatar me-2">
            <span class="avatar-initial rounded bg-label-danger"><i class="bx bx-user-x"></i></span>
          </div>
          <h4 class="ms-1 mb-0">{{$summary->total_nonactive_candidate}}</h4>
        </div>
        <p class="mb-1">Total Inactive Candidate</p>
        <!-- <p class="mb-0">
          <span class="fw-medium me-1">-2.5%</span>
          <small class="text-muted">than last week</small>
        </p> -->
      </div>
    </div>
  </div>
</div>
<!-- DataTable with Buttons -->
<div class="card">
  <div class="card-datatable table-responsive">
    <table class="datatables-basic table border-top table-hover" style="width:100%">
      <thead>
        <tr>
          <th>Name</th>
          <th>Email</th>
          <th>Status</th>
          <th>Currently Working</th>
          <th>Position</th>
          <th>Company</th>
          <th>Registered Date</th>
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

<!-- Modal Filter -->
<div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="filterModalLabel">Filter Candidate</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <h6>By Status</h6>
        <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
          <input type="radio" class="btn-check" name="btnradio" id="statusAll" checked>
          <label class="btn btn-outline-primary" for="statusAll">All</label>
          <input type="radio" class="btn-check" name="btnradio" id="statusActive">
          <label class="btn btn-outline-primary" for="statusActive">Active</label>
          <input type="radio" class="btn-check" name="btnradio" id="statusInactive">
          <label class="btn btn-outline-primary" for="statusInactive">Deactive</label>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Delete Confirmation -->
<div class="modal fade" id="modalConfirmation" tabindex="-1" aria-hidden="true" style="z-index: 1091">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalCenterTitle">Delete Job</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Are you sure to delete job?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-danger" id="confirmationBtn">Delete</button>
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
<script src="https://cdn.datatables.net/v/bs5/dt-2.0.5/datatables.min.js"></script>
<script src="https://cdn.datatables.net/v/bs5/dt-2.0.5/b-3.0.2/r-3.0.2/sl-2.0.1/datatables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script
  src="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.5/b-3.0.2/b-colvis-3.0.2/b-html5-3.0.2/b-print-3.0.2/r-3.0.2/sl-2.0.1/datatables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="{{asset('assets/js/candidate-data-tables.js')}}"></script>
<script>
  // Delete Function
  async function deleteJob (jobId) {
    $('.modal').modal('hide');
    await $('#modalConfirmation').modal('show');
    $(document).on('click', '#confirmationBtn', async function () {
      const url = "/jobs/store";
      const method = "POST";
      // Prepare payload data
      const payload = {
        job_id: jobId,
        soft_delete: 1
      };

      await $.ajax({
        method: 'POST',
        url: '/query',
        data: {
          _token: $('meta[name="csrf-token"]').attr('content'),
          url: url,
          method: method,
          payload: payload
        },
        success: function (response) {
          setTimeout(function () {
            location.reload();
          }, 500); // Adjust delay as needed
        },
        error: function (xhr, status, error) {
          $('.alert-danger').html(xhr.responseText).show(); // Display error message
        }
      });
    })
  };

  $(document).on('click', '.delete-record', async function () {
    const jobId = $(this).data('id');

    deleteJob(jobId);
  });
</script>
<script>
  // Open edit user modal
  $(document).on('click', '.edit-record', function () {
    const modal = $('#modal-offcanvas');
    $('#jobType').select2({
      tags: true,
      tokenSeparators: true
    });
    // Show the Offcanvas modal
    new bootstrap.Offcanvas(modal.get(0)).show();
  });
</script>
@endsection