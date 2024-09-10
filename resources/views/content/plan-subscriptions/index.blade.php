@extends('layouts/contentNavbarLayout')

@section('title', 'Plan Management - Index')

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
  .datatables-basic thead tr th:nth-child(10),
  .datatables-basic thead tr th:nth-child(11),
  .datatables-basic thead tr th:nth-child(12),
  .datatables-basic thead tr th:nth-child(13),
  .datatables-basic thead tr th:nth-child(14),
  .datatables-basic thead tr th:nth-child(15),
  .datatables-basic thead tr th:nth-child(16),
  .datatables-basic tbody tr *:nth-child(10),
  .datatables-basic tbody tr *:nth-child(11),
  .datatables-basic tbody tr *:nth-child(12),
  .datatables-basic tbody tr *:nth-child(13),
  .datatables-basic tbody tr *:nth-child(14),
  .datatables-basic tbody tr *:nth-child(15),
  .datatables-basic tbody tr *:nth-child(16){
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
    <table class="datatables-basic table border-top table-hover table-striped">
      <thead>
        <tr>
          <th>Name</th>
          <th>Description</th>
          <th>Post Job</th>
          <th>Interview</th>
          <th>Team Member</th>
          <th>Hire</th>
          <th>Boost Job</th>
          <th>Price</th>
          <th>Status</th>
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
        <h5 class="modal-title" id="modalCenterTitle">Featured</h5>
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
<!-- Add Edit Plan Modal -->
<div class="modal fade" id="addPlanModal" tabindex="-1" aria-labelledby="addPlanModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addPlanModalLabel">Add New Blog Post</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
    <form method="POST" id="myForm"> 
        <div class="modal-body">
          @csrf
          <div class="mb-3">
            <input type="text" class="form-control" id="subscriptionId" name="subscriptionId" hidden>
            <label for="blogThumbnailAdd" class="form-label">Icon</label>
            <small class="text-muted">Tip : Leave it empty if image will not updated.</small>
            <input type="file" class="form-control" id="iconPlanAdd">
            <input type="hidden" name="iconEncode" id="iconEncode">
          </div>
          <div class="mb-3">
            <label for="planName" class="form-label">Name</label>
            <input type="text" class="form-control" id="planName" name="planName" required>
          </div>
          <div class="mb-3">
            <label for="descPlan" class="form-label">Description</label>
            <input type="text" class="form-control" id="descPlan" name="descPlan" required>
          </div>
         
          <div class="row g-3 mb-3">
            <div class="col-md-4">
              <label for="postJob" class="form-label">Post Job</label>
              <input type="number" class="form-control" id="postJob" name="postJob" required>
            </div>
            <div class="col-md-4">
              <label for="interview" class="form-label">Interview</label>
              <input type="number" class="form-control" id="interview" name="interview" required>
            </div>
            <div class="col-md-4">
              <label for="teamMember" class="form-label">Team Member</label>
              <input type="number" class="form-control" id="teamMember" name="teamMember" required>
            </div>
          </div>
          <div class="row g-3 mb-4">
            <div class="col-md-4">
              <label for="Hire" class="form-label">Hire</label>
              <input type="number" class="form-control" id="Hire" name="Hire" required>
            </div>
            <div class="col-md-4">
              <label for="boostJob" class="form-label">Boost Job</label>
              <input type="number" class="form-control" id="boostJob" name="boostJob" required>
            </div>
            <div class="col-md-4">
              <label for="price" class="form-label">Price</label>
              <input type="text" class="form-control" id="price" name="price" required>
            </div>
          </div>
          <div class="row g-3 mb-3">
            <div class="col-md-4">
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="checkStatus" name="checkStatus">
                <label class="form-check-label" for="checkStatus">Status</label>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="checkMostPopular" name="checkMostPopular">
                <label class="form-check-label" for="checkMostPopular">Most Popular</label>
              </div>
            </div>
          </div>
          <div class="row g-3 mb-3">
            <div class="col-md-4">
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="checkAccountSupport" name="checkAccountSupport">
                <label class="form-check-label" for="checkAccountSupport">Allow Account Support</label>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="checkHiringJobPost" name="checkHiringJobPost">
                <label class="form-check-label" for="checkHiringJobPost">Allow Hiring Job Post</label>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="checkCalendarIntegration" name="checkCalendarIntegration">
                <label class="form-check-label" for="checkCalendarIntegration">Allow Calendar Integration</label>
              </div>
            </div>
          </div>
          <div class="row g-3">
            <div class="col-md-4">
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="checkCompanyProfile" name="checkCompanyProfile">
                <label class="form-check-label" for="checkCompanyProfile">Allow Company Profile</label>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="checkApplicationManagement" name="checkApplicationManagement">
                <label class="form-check-label" for="checkApplicationManagement">Allow Application Management</label>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="checkInterviewScheduling" name="checkInterviewScheduling">
                <label class="form-check-label" for="checkInterviewScheduling">Allow Interview Scheduling</label>
              </div>
            </div>
          </div>

        </div>
      
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" id="buttonModal" onclick="" >Add Blog Post</button>
        </div>
      </form>
    </div>
  </div>
</div>
</div>
<!-- Modal Delete Confirmation -->
<div class="modal fade" id="modalConfirmation" tabindex="-1" aria-hidden="true" style="z-index: 1091">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">

      <div class="modal-header">

        <h5 class="modal-title" id="modalCenterTitle">Delete Subscription</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" class="dt-blog-id" name="blogID">
        <p>Are you sure to delete this subscription?</p>
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
</script>
<script src="https://cdn.datatables.net/v/bs5/dt-2.0.5/datatables.min.js"></script>
<script src="https://cdn.datatables.net/v/bs5/dt-2.0.5/b-3.0.2/r-3.0.2/sl-2.0.1/datatables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script
  src="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.5/b-3.0.2/b-colvis-3.0.2/b-html5-3.0.2/b-print-3.0.2/r-3.0.2/sl-2.0.1/datatables.min.js"></script>
  
<script src="{{asset('assets/js/plan-management-data-tables.js')}}"></script>

<script>
  // Input Image script
  $(document).ready(function () {
    $('#iconPlanAdd').change(function () {
      var file = this.files[0];
      var maxSize = 4 * 1024 * 1024; // Convert MB to bytes

      if (file && file.size > maxSize)
      {
        alert('File size exceeds 4 MB limit.');
        $(this).val(''); // Clear the file input
        return;
      }

      var reader = new FileReader();
      reader.onload = function (e) {
        $('#iconEncode').val(e.target.result);
      };
      reader.readAsDataURL(file);
    });
  });
</script>
<script>
  // Delete Function
  $(document).on('click', '.delete-record', async function () {
    $('.modal').modal('hide');
    await $('#modalConfirmation').modal('show');
    const id = $(this).data('id');
    const url = "/subscriptions/store";
    $(document).on('click', '#confirmationBtn', async function () {
      loaderFunc();
      const method = "POST";
      // Prepare payload data
      const payload = {
        subscription_id: id,
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
            location.replace("/plan-subscriptions/delete");
          }, 500); // Adjust delay as needed
        },
        error: function (xhr, status, error) {
          $('.alert-danger').html(xhr.responseText).show(); // Display error message
        }
      });
    })
  });
</script>
<script>
  $(document).ready(function() {
    $('#price').on('input', function() {
        var inputVal = $(this).val();

        // Hapus simbol $ jika sudah ada sebelumnya
        inputVal = inputVal.replace(/^\$/, '');

        // Tambahkan simbol $ di depan nilai
        $(this).val('$' + inputVal);
    });
});
</script>

@endsection