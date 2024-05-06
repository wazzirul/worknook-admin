@extends('layouts/contentNavbarLayout')

@section('title', 'User Management - Index')

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
      <table class="datatables-basic table border-top">
        <thead>
          <tr>
            <th></th>
            <th></th>
            <th>id</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Action</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
  <!-- Modal to add new user -->
  <div class="offcanvas offcanvas-end" id="add-new-record">
    <div class="offcanvas-header border-bottom">
      <h5 class="offcanvas-title" id="exampleModalLabel">New User</h5>
      <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body flex-grow-1">
      <form class="add-new-record pt-0 row g-2" id="form-add-new-record" action="/user-management/create" method="POST">
        @csrf
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
        <div class="col-sm-12">
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
  <!--/ DataTable with Buttons -->
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
<script src="{{asset('assets/js/data-tables.js')}}"></script>
<script>
  // Open create user modal
  $(document).on('click', '.create-new', function() {
    const addNewRecordModal = $('#add-new-record');

    // Check if addNewRecordModal exists
    if (addNewRecordModal.length) {
        // Clear input fields
        addNewRecordModal.find('.dt-full-name, .dt-profile-img, .dt-profile-encode, .dt-email, .dt-password, .dt-role').val('');

        // Show the Offcanvas modal
        new bootstrap.Offcanvas(addNewRecordModal.get(0)).show();
    }
  });
</script>
<script>
  // Input Image script
  $(document).ready(function() {
    $('#profilePicture').change(function() {
        var file = this.files[0];
        var maxSize = 4 * 1024 * 1024; // Convert MB to bytes

        if (file && file.size > maxSize) {
            alert('File size exceeds 4 MB limit.');
            $(this).val(''); // Clear the file input
            return;
        }

        var reader = new FileReader();
        reader.onload = function(e) {
            $('#profileEncode').val(e.target.result);
        };
        reader.readAsDataURL(file);
    });
  });
</script>
<script>
  $(document).on('click', '.delete-record', async function() {
    const adminId = $(this).data('id');
    const url = "/admins/store";
    const method = "POST";
    // Prepare payload data
    const payload = {
        admin_id: adminId,
        soft_delete: 1
    };

    // console.log(payload);
    // return;

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
            // $('.alert-success').html(response.message).show(); // Display success message

            // Reload the page after a short delay (e.g., 1 second)
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