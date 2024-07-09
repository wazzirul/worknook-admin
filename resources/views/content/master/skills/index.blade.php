@extends('layouts/contentNavbarLayout')

@section('title', 'Skills - Index')

@section('vendor-style')
<link href="https://cdn.datatables.net/v/bs5/dt-2.0.5/b-3.0.2/r-3.0.2/sl-2.0.1/datatables.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset(mix('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')) }}">
<link rel="stylesheet"
  href="{{ asset(mix('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')) }}">
<link rel="stylesheet"
  href="{{ asset(mix('assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css')) }}">
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
    <table class="datatables-basic table border-top table-hover table-striped">
      <thead>
        <tr>
          <th>Skill Name</th>
          <th>Date</th>
          <th>Action</th>
        </tr>
      </thead>
    </table>
  </div>
</div>
<!-- Add and Edit Blog Category Modal -->
<div class="modal fade" id="blogModalSkill" tabindex="-1" aria-labelledby="BlogModalCategoryLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="blogModalLabel">Add Skill Level</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="/blog-categories/add" method="POST">
        <div class="modal-body">
          @csrf
          <div class="mb-3">
            <input type="text" class="form-control" id="skillId" name="skillId" value="Name of the Level"
              hidden>
            <label for="categoryName" class="form-label">Title</label>
            <input type="text" class="form-control" id="skillName" name="skillName" value="Name of the Level"
              required>
          </div>

         
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" id="buttonModal" onclick="loaderFunc();">Add Level</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Delete Confirmation -->
<div class="modal fade" id="deleteSkills" tabindex="-1" aria-hidden="true" style="z-index: 1091">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">

      <div class="modal-header">

        <h5 class="modal-title" id="modalCenterTitle">Delete Skill</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" class="dt-blog-id" name="blogID">
        <p>Are you sure to delete this skill?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-danger delete-record" id="confirmationBtn">Delete</button>
      </div>

    </div>
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
<script
  src="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.5/b-3.0.2/b-colvis-3.0.2/b-html5-3.0.2/b-print-3.0.2/r-3.0.2/sl-2.0.1/datatables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js"></script>
<script src="{{asset('assets/js/master/skills-data-tables.js')}}"></script>

<script>
  // Add and Edit Modal
  $(document).on('click', '.create-new, .item-edit', function () {
    const modal = $('#blogModalSkill');
    const url = '/master-skills/store';

    if (modal.length)
    {
      if ($(this).hasClass('create-new'))
      {
        modal.find('#skillId').val('');
        modal.find('#skillName').val('');
        modal.find('#blogModalLabel').text('Add new Skill');
        modal.find('#buttonModal').text('Add Skill');
      } else
      {
        const data = $(this).data();
        const name = decodeURIComponent(data.name);
        const desc = decodeURIComponent(data.desc);
        modal.find('#skillId').val(data.id || '');
        modal.find('#skillName').val(name || '');
        modal.find('#blogModalLabel').text('Edit Skill');
        modal.find('#buttonModal').text('Edit Skill');
      }

      modal.find('form').attr('action', url);
      modal.modal('show');
    }
  });
</script>

<script>
  // Delete Function
  $(document).on('click', '.delete-record', async function () {
    $('.modal').modal('hide');
    $('#deleteSkills').modal('show');
    const skill_id = $(this).data('id');
    
    $(document).on('click', '#confirmationBtn', async function () {
      loaderFunc();
   
    const url = "/skills/store";
    const method = "POST";
    // Prepare payload data
    const payload = {
      skill_id: skill_id,
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
          location.replace('/master-skills/delete');
        }, 500); // Adjust delay as needed
      },
      error: function (xhr, status, error) {
        $('.alert-danger').html(xhr.responseText).show(); // Display error message
      }
    });
    })
  });
</script>
@endsection