@extends('layouts/contentNavbarLayout')

@section('title', 'Company Management - Index')

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
          <th>Company Name</th>
          <th>Founder</th>
          <th>Email</th>
          <!-- <th>Industry</th>
          <th>Location</th> -->
          <th>Employees</th>
          <th>Created at</th>
          <th>Status</th>
          <th>Description</th>
          <th>Action</th>
        </tr>
      </thead>
    </table>
  </div>
</div>

<!-- Modal Details -->
<div class="modal fade" id="modalDetails" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalCenterTitle">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="data-modal"></div>
      </div>
      <!-- <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div> -->
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
<script src="{{asset('assets/js/company-data-tables.js')}}"></script>
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
<!-- <script>
   $('.datatables-basic tbody').on('click', 'button', function() {
    var data = table.row($(this).parents('tr')).data(); // getting target row data
    $('.data-modal').html(
			// Adding and structuring the full data
      '<table class="table dtr-details" width="100%"><tbody><tr><td>Company Name<td><td>' + data[0] + '</td></tr><tr><td>Position<td><td>' + data[1] + '</td></tr><tr><td>Office<td><td>' + data[2] + '</td></tr><tr><td>Age<td><td>' + data[3] + '</td></tr><tr><td>Start date<td><td>' + data[4] + '</td></tr><tr><td>Salary<td><td>' + data[5] + '</td></tr></tbody></table>'
    );
    $('#modalDetails').modal('show'); // calling the bootstrap modal
  });
</script> -->
@endsection