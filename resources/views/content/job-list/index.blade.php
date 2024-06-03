@extends('layouts/contentNavbarLayout')

@section('title', 'Job Lists - Index')

@section('vendor-style')
<link href="https://cdn.datatables.net/v/bs5/dt-2.0.5/b-3.0.2/r-3.0.2/sl-2.0.1/datatables.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="{{ asset(mix('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('assets/vendor/libs/datatables-rowgroup-bs5/rowgroup.bootstrap5.css')) }}">
<style>
  /* Hide selected columns on initial */
  .datatables-basic thead tr th:nth-child(2), 
  .datatables-basic thead tr th:nth-child(5),
  .datatables-basic thead tr th:nth-child(7),
  .datatables-basic thead tr th:nth-child(8),
  .datatables-basic thead tr th:nth-child(9),
  .datatables-basic thead tr th:nth-child(10),
  .datatables-basic thead tr th:nth-child(12),
  .datatables-basic tbody tr *:nth-child(2),
  .datatables-basic tbody tr *:nth-child(5),
  .datatables-basic tbody tr *:nth-child(7),
  .datatables-basic tbody tr *:nth-child(8),
  .datatables-basic tbody tr *:nth-child(9),
  .datatables-basic tbody tr *:nth-child(10),
  .datatables-basic tbody tr *:nth-child(12)
   {
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
<!-- DataTable with Buttons -->
  <div class="card">
    <div class="card-datatable table-responsive">
      <table class="datatables-basic table border-top table-hover" style="width:100%">
        <thead>
          <tr>
            <th>Job Title</th>
            <th>Job Level</th>
            <th>Job Type</th>
            <th>Job Category</th>
            <th>Description</th>
            <th>Location</th>
            <th>Salary Range</th>
            <th>Responsibilities</th>
            <th>Skill Requirements</th>
            <th>Current Applicant</th>
            <th>Created At</th>
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

  <!-- Modal to edit job -->
  <div class="offcanvas offcanvas-end" id="modal-offcanvas">
    <div class="offcanvas-header border-bottom">
      <h5 class="offcanvas-title" id="modalLabel">Edit Job</h5>
      <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body flex-grow-1">
      <form class="add-new-record pt-0 row g-2" id="modal-form" action="#" method="POST">
        @csrf
        <!-- Job ID -->
        <input type="hidden" class="dt-job-id" name="jobID">
        <!-- Job Title -->
        <div class="col-sm-12">
          <label class="form-label" for="jobTitle">Job Title</label>
          <div class="input-group input-group-merge">
            <input type="text" id="jobTitle" class="form-control dt-job-title" name="jobTitle" placeholder="Job Title Here" aria-label="Job Title Here" required />
          </div>
        </div>
        <!-- Job Level -->
        <div class="col-sm-12">
          <label class="form-label" for="jobLevel">Job Level</label>
          <div class="input-group input-group-merge">
            <select id="jobLevel" name="jobLevel" class="form-select dt-job-level" required>
              <option value="1">Entry Level</option>
              <option value="2">Admin Staff</option>
            </select>
          </div>
        </div>
        <!-- Job Type (Select 2.js)-->
        <div class="col-sm-12">
          <label class="form-label" for="jobType">Job Type</label>
          <div class="input-group input-group-merge">
            <select id="jobType" name="jobType" class="form-select dt-job-level" multiple="multiple" required>
              <option value="1">Full Time</option>
              <option value="2">Admin Staff</option>
            </select>
          </div>
        </div>
        <!-- Job Category (Select 2.js)-->
        <div class="col-sm-12">
          <label class="form-label" for="jobCategory">Job Category</label>
          <div class="input-group input-group-merge">
            <select id="jobCategory" name="jobCategory" class="form-select dt-job-category" required>
              <option value="1">Sales</option>
              <option value="2">Admin Staff</option>
            </select>
          </div>
        </div>
        <!-- Description -->
        <div class="col-sm-12">
          <label class="form-label" for="description">Description</label>
          <div class="input-group input-group-merge">
            <input type="text" id="description" class="form-control dt-description" name="description" placeholder="Job Description" aria-label="Job Description" required />
          </div>
        </div>
        <!-- Location -->
        <div class="col-sm-12">
          <label class="form-label" for="location">Location</label>
          <div class="input-group input-group-merge">
            <input type="text" id="location" class="form-control dt-location" name="location" placeholder="Job Location" aria-label="Job Location" required />
          </div>
        </div>
        <!-- Salary Range -->
        <div class="col-sm-12">
          <label class="form-label" for="Salary">Salary Range</label>
          <div class="input-group">
            <input type="text dt-start-salary" name="startSalary" id="startSalary" placeholder="Start Salary" class="form-control">
            <input type="text dt-top-salary" name="topSalary" id="topSalary" placeholder="Top Salary" class="form-control">
          </div>
        </div>
        <!-- Responsibilities -->
        <div class="col-sm-12">
          <label class="form-label" for="responsibilities">Responsibilities</label>
          <div class="input-group input-group-merge">
            <input type="text" id="responsibilities" class="form-control dt-responsibilities" name="responsibilities" placeholder="Job Responsibilities" aria-label="Job Responsibilities" required />
          </div>
        </div>
        <!-- Skill (Select 2.js)-->
        <div class="col-sm-12">
          <label class="form-label" for="jobSkill">Skill Requirements</label>
          <div class="input-group input-group-merge">
            <select id="jobSkill" name="jobSkill" class="form-select dt-job-skill" required>
              <option value="1">Sales</option>
              <option value="2">Admin Staff</option>
            </select>
          </div>
        </div>
        <div class="col-sm-12">
          <button type="submit" class="btn btn-primary data-submit me-sm-3 me-1">Submit</button>
          <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">Cancel</button>
        </div>
      </form>
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
<script src="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.5/b-3.0.2/b-colvis-3.0.2/b-html5-3.0.2/b-print-3.0.2/r-3.0.2/sl-2.0.1/datatables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="{{asset('assets/js/job-list-data-tables.js')}}"></script>
<script>
  // Delete Function
  async function deleteJob(jobId) {
    $('.modal').modal('hide');
    await $('#modalConfirmation').modal('show');
    $(document).on('click', '#confirmationBtn', async function() {
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
          success: function(response) {
              setTimeout(function() {
                  location.reload();
              }, 500); // Adjust delay as needed
          },
          error: function(xhr, status, error) {
              $('.alert-danger').html(xhr.responseText).show(); // Display error message
          }
      });
    })
  };

  $(document).on('click', '.delete-record', async function() {
    const jobId = $(this).data('id');

    deleteJob(jobId);
  });
</script> 
<!-- <script>
  $(document).ready(function() {
  }); -->
<!-- </script> -->
<script>
  // Open edit user modal
  $(document).on('click', '.edit-record', function() {
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