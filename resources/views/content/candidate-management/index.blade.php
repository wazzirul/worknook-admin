@extends('layouts/contentNavbarLayout')

@section('title', 'Job Lists - Index')

@section('vendor-style')
<link href="https://cdn.datatables.net/v/bs5/dt-2.0.5/b-3.0.2/r-3.0.2/sl-2.0.1/datatables.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset(mix('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('assets/vendor/libs/datatables-rowgroup-bs5/rowgroup.bootstrap5.css')) }}">
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
            <th>Location</th>
            <th>Salary Range</th>
            <th>Job Level</th>
            <th>Responsibilities</th>
            <th>Status</th>
            <th>Description</th>
            <th>Capacity</th>
            <th>Created At</th>
            <th>Action</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
  <!-- Modal to add new job -->
  <div class="offcanvas offcanvas-end" id="modal-offcanvas">
    <div class="offcanvas-header border-bottom">
      <h5 class="offcanvas-title" id="modalLabel"></h5>
      <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body flex-grow-1">
      <form class="add-new-record pt-0 row g-2" id="modal-form" action="#" method="POST">
        @csrf
        <input type="hidden" class="dt-id" name="id">
        <div class="col-sm-12">
          <label class="form-label" for="basicFullname">Full Name</label>
          <div class="input-group input-group-merge">
            <span id="basicFullname2" class="input-group-text"><i class="bx bx-user"></i></span>
            <input type="text" id="basicFullname" class="form-control dt-full-name" name="basicFullname" placeholder="John Doe" aria-label="John Doe" aria-describedby="basicFullname2" required />
          </div>
        </div>
        <div class="col-sm-12">
          <label class="form-label" for="profilePicture">Profile Picture</label>
          <div class="input-group input-group-merge">
            <input type="file" id="profilePicture" class="form-control dt-profile-img" name="profilePicture" aria-label="Profile Picture" aria-describedby="profilePicture2" accept="image/png" required/>
            <input type="hidden" class="dt-profile-encode" id="profileEncode" name="profileEncode" required>
          </div>
          <div class="form-text">
            Max file size is 4 MB
          </div>
        </div>
        <div class="col-sm-12">
          <label class="form-label" for="basicEmail">Email</label>
          <div class="input-group input-group-merge">
            <span class="input-group-text"><i class="bx bx-envelope"></i></span>
            <input type="email" id="basicEmail" name="basicEmail" class="form-control dt-email" placeholder="john.doe@example.com" aria-label="john.doe@example.com" required/>
          </div>
          <div class="form-text">
            You can use letters, numbers & periods
          </div>
        </div>
        <div class="col-sm-12 col-pass">
          <label class="form-label" for="password">Password</label>
          <div class="input-group input-group-merge">
            <input type="password" id="password" class="form-control" name="password"
              placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
              aria-describedby="password" />
            <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
          </div>
        </div>
        <div class="col-sm-12">
          <label class="form-label" for="role">Role</label>
          <div class="input-group input-group-merge">
            <span id="basicSalary2" class="input-group-text"><i class='bx bx-cog'></i></span>
            <select id="role" name="role" class="form-select dt-role" required>
              <option value="1">Superadmin</option>
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

  <!-- Button trigger modal -->
  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCenter">
    Delete Modal
  </button>

  <!-- Modal Delete Confirmation -->
  <div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalCenterTitle">Delete Job</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>Are you sure to delete {Job Name}?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-danger">Delete</button>
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
<script src="{{asset('assets/js/job-list-data-tables.js')}}"></script>
<script>
  // Delete Function
  $(document).on('click', '.delete-record', async function() {
    const status = $(this).data('banned');
    const userId = $(this).data('id');
    const url = "/company/store";
    const method = "POST";
    // Prepare payload data
    const payload = {
      user_id: userId,
      soft_delete: status === 1 ? 0 : 1
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
  });
</script> 
@endsection