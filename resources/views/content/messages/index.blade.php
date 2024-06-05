@extends('layouts/contentNavbarLayout')

@section('title', 'Messages - Index')

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
  /* .datatables-basic thead tr th:nth-child(2), 
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
  } */
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
            <th>Sender</th>
            <th>Email</th>
            <th>Phone Number</th>
            <th>Messages</th>
            <th>Posted Date</th>
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
        <form action="/">
          <div id="replyForm"></div>
        </form>
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
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<!-- Include the Quill library -->
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
<!-- <script src="{{asset('assets/js/job-list-data-tables.js')}}"></script> -->
<script>
  const quill = new Quill('#replyForm', {
    modules: {
    toolbar: [
      [{ header: [1, 2, false] }],
      ['bold', 'italic', 'underline'],
      ['image', 'code-block'],
    ],
  },
  placeholder: 'Reply message',
  theme: 'snow',
  })
</script>
@endsection