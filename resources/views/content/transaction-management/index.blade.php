@extends('layouts/contentNavbarLayout')

@section('title', 'Transaction Management - Index')

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
  .datatables-basic thead tr th:nth-child(7),
  .datatables-basic thead tr th:nth-child(8),
  .datatables-basic thead tr th:nth-child(9),
  .datatables-basic thead tr th:nth-child(10),
  .datatables-basic thead tr th:nth-child(11),
  .datatables-basic thead tr th:nth-child(12),
  .datatables-basic thead tr th:nth-child(13),
  .datatables-basic thead tr th:nth-child(14),
  .datatables-basic thead tr th:nth-child(15),
  .datatables-basic thead tr th:nth-child(16),
  .datatables-basic thead tr th:nth-child(17),
  .datatables-basic thead tr th:nth-child(18),
  .datatables-basic tbody tr *:nth-child(7),
  .datatables-basic tbody tr *:nth-child(8),
  .datatables-basic tbody tr *:nth-child(9),
  .datatables-basic tbody tr *:nth-child(10),
  .datatables-basic tbody tr *:nth-child(11),
  .datatables-basic tbody tr *:nth-child(12),
  .datatables-basic tbody tr *:nth-child(13),
  .datatables-basic tbody tr *:nth-child(14),
  .datatables-basic tbody tr *:nth-child(15), 
 .datatables-basic tbody tr *:nth-child(16),
 .datatables-basic tbody tr *:nth-child(17),
 .datatables-basic tbody tr *:nth-child(18)
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
    <table class="datatables-basic table border-top table-hover table-striped">
      <thead>
        <tr>
          <th>Name</th>
          <th>Subscription</th>
          <th>Plan</th>
          <th>Price</th>
          <th>Status</th>
          <th>Date</th>
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

<!-- Modal Delete Confirmation -->
<div class="modal fade" id="modalConfirmation" tabindex="-1" aria-hidden="true" style="z-index: 1091">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">

      <div class="modal-header">

        <h5 class="modal-title" id="modalCenterTitle">Decline Transaction</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="myForm" method="POST">
        @csrf
      <div class="modal-body">
        <input type="hidden" class="form-control mb-2" name="status" id="status" placeholder="Enter Text">
        <input type="hidden" class="form-control mb-2" name="id" id="id" placeholder="Enter Text">
        <label for="note" class="form-label">Note</label>
        <input type="text" class="form-control mb-2" name="note" id="note" placeholder="Enter Text">
        <p id="confirmText">Are you sure to decline this transaction?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-danger delete-record" id="confirmationBtn" onclick="loaderFunc()" disabled>Decline</button>
      </div>
    </form>

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
  
<script src="{{asset('assets/js/transaction-management-data-tables.js')}}"></script>

<script>
  // Approve Decline Function
  $(document).on('click', '.item-approve,.decline-record', async function () {
    $('.modal').modal('hide');
   
    var modal = $('#modalConfirmation');
    const id = $(this).data('id');
    const status = $(this).data('status');
    console.log(status);
    $('#status').val(status);
    $('#id').val(id);
    if(status == 3){
      modal.find('.modal-title').text('Approve Transaction');
      modal.find('#confirmText').text('Are you sure to approve this transaction?');
      var btn = document.getElementById('confirmationBtn');
      btn.classList.remove('btn-danger');
      btn.classList.add('btn-primary');
      btn.innerText = "Approve";
      btn.disabled = false;
    }else{
      modal.find('.modal-title').text('Decline Transaction');
      modal.find('#confirmText').text('Are you sure to decline this transaction?');
      var btn = document.getElementById('confirmationBtn');
      btn.classList.remove('btn-primary');
      btn.classList.add('btn-danger');
      btn.innerText = "Decline";
      btn.disabled = true;
    }
    
    const url = "/transaction-management/store";
    modal.find('form').attr('action', url);
    modal.modal('show');
  });
</script>
<script>
  document.getElementById('myForm').addEventListener('input', function () {
  // Seleksi tombol Save
  var saveButton = document.getElementById('confirmationBtn');
  
  // Cek apakah ada perubahan di form
  var isChanged = false;
  var inputs = this.querySelectorAll('input');
  
  inputs.forEach(function(input) {
      if (input.defaultValue !== input.value) {
          isChanged = true;
      }
  });
  
  // Jika ada perubahan, aktifkan tombol Save
  if (isChanged) {
      saveButton.disabled = false;
  } else {
      saveButton.disabled = true;
  }
});
</script>


@endsection