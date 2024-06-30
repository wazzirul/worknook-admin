@extends('layouts/contentNavbarLayout')

@section('title', 'Messages - Index')

@section('vendor-style')
<link href="https://cdn.datatables.net/v/bs5/dt-2.0.5/b-3.0.2/r-3.0.2/sl-2.0.1/datatables.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset(mix('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')) }}">
<link rel="stylesheet"
  href="{{ asset(mix('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')) }}">
<link rel="stylesheet"
  href="{{ asset(mix('assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('assets/vendor/libs/datatables-rowgroup-bs5/rowgroup.bootstrap5.css')) }}">
<!-- Include stylesheet -->
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" />
<style>
  /* Hide selected columns on initial */
  .datatables-basic thead tr th:nth-child(4),
  .datatables-basic tbody tr *:nth-child(4) {
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
<div class="modal fade" id="modalDetails" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <table class="table">
          <tbody class="data-modal">
            <!-- Details will be inserted here dynamically -->
          </tbody>
        </table>
        <div class="d-flex gap-2 justify-content-end p-3 border-bottom">
          <button type="button" class="btn btn-secondary" id="replyBtn">
            <span>Reply</span>
            <span style="display: none;">Hide Form</span>
          </button>
          <button type="button" class="btn btn-outline-secondary" id="showRepBtn">
            <span>Show Reply</span>
            <span style="display: none;">Hide Reply</span>
          </button>
        </div>
        <div class="reply-block" id="replyBlock" style="display: none;">
          <!-- Reply content will be inserted here dynamically -->
        </div>
        <form action="/message/reply" method="POST" id="formWrap" style="display: none;">
          @csrf
          <div class="d-flex gap-2 p-3 flex-column">
            <div class="col-sm-12">
              <label class="form-label" for="subject">Subject</label>
              <div class="input-group input-group-merge">
                <input type="text" id="subject" class="form-control dt-full-name" name="subject"
                  placeholder="How to register" required />
              </div>
            </div>
            <input type="hidden" name="idMail" id="idMail">
            <input type="hidden" name="content" id="content">
            <div class="col-sm-12">
              <label class="form-label" for="replyForm">Message</label>
              <div id="replyForm" name="replyForm"></div>
            </div>
            <button type="submit" class="btn btn-primary data-submit">Submit</button>
          </div>
        </form>
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
<!-- Include the Quill library -->
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
<script src="{{asset('assets/js/message-data-tables.js')}}"></script>
<script>
  $(document).ready(function () {
    var quill = new Quill('#replyForm', {
      modules: {
        toolbar: [
          [{ header: [1, 2, false] }],
          ['bold', 'italic', 'underline'],
          ['image', 'code-block'],
        ],
      },
      placeholder: 'Reply message',
      theme: 'snow',
    });

    quill.on('text-change', function () {
      var content = quill.root.innerHTML;
      $('#content').val(content);
    });

    $('#replyBtn').click(function () {
      $(this).find('span').toggle();
      $("#formWrap").toggle();
    });

    $('#showRepBtn').click(function () {
      $(this).find('span').toggle();
      $("#replyBlock").toggle();
    });

    $('#modalDetails').on('hidden.bs.modal', function () {
      $('#replyBlock').empty();
    });

    $('#showRepBtn').click(async function () {
      if ($(this).find('span:contains("Hide Reply")').is(':visible'))
      {
        $('#replyBlock').html('<p class="text-center mt-2">Loading...</p>');

        let idMail = $('#idMail').val();
        let urlAPI = '/contact/show-reply';
        let methodAPI = 'POST';
        let payloadAPI = {
          contact_email_id: idMail
        };
        await $.ajax({
          url: '/query',
          method: 'POST',
          data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            url: urlAPI,
            method: methodAPI,
            payload: payloadAPI
          },
          success: function (response) {
            if (response.data)
            {
              var formattedDate = new Date(response.data.created_at).toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
              });
              var replyBlock = `
                <div class="d-flex flex-column gap-4 p-3 m-3 position-relative">
                  <div class="position-absolute top-0 bottom-0 start-0 end-0 bg-primary" style="opacity: .3;"></div>
                  <div class="d-flex flex-column gap-1">
                    <h4 class="m-0">${response.data.subject}</h4>
                    <small class="mb-1 text-muted">${formattedDate}</small>
                    <div>${response.data.email_body}</div>
                  </div>
                  <strong class="text-muted">Admin Staff</strong>
                </div>`;
              $('#replyBlock').empty();
              $('#replyBlock').html(replyBlock);
            } else
            {
              $('#replyBlock').html('<p class="text-center mt-2">No replies</p>');
            }
          }
        });
      }
    });
  });
</script>
@endsection