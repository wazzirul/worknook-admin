@extends('layouts/contentNavbarLayout')

@section('title', 'Blogs - Index')

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
  .datatables-basic thead tr th:nth-child(6),
  .datatables-basic tbody tr *:nth-child(6) {
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
          <th>Title</th>
          <th>Description</th>
          <th>Author</th>
          <th>Category</th>
          <th>Date</th>
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
        <h5 class="modal-title" id="filterModalLabel">Filter Blogs</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <h6>By Category</h6>
        <!-- <select class="form-select status-dropdown text-capitalize">
          <option value="">All</option>
          @foreach ($data->data as $category)
          <option class="text-capitalize" value="{{ $category->category_name }}">{{ $category->category_name }}</option>
          @endforeach
        </select> -->
        <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
          <input type="radio" class="btn-check" name="filterCat" id="statusAll" checked>
          <label class="btn btn-outline-primary text-capitalize" for="statusAll">All</label>

          @foreach ($data->data as $category)
          <input type="radio" class="btn-check" name="filterCat" id="category{{ $category->category_name }}">
          <label class="btn btn-outline-primary text-capitalize" for="category{{ $category->category_name }}">
            {{ $category->category_name }}
          </label>
          @endforeach
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

<!-- Add Blog Modal -->
<div class="modal fade" id="addBlogModal" tabindex="-1" aria-labelledby="addBlogModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addBlogModalLabel">Add New Blog Post</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="blogs/add" method="POST">
          @csrf
          <div class="mb-3">
            <label for="blogThumbnailAdd" class="form-label">Thumbnail</label>
            <input type="file" class="form-control" id="blogThumbnailAdd">
            <input type="hidden" name="thumbnailEncode" id="thumbnailEncode">
          </div>
          <div class="mb-3">
            <label for="blogTitleAdd" class="form-label">Title</label>
            <input type="text" class="form-control" id="blogTitleAdd">
          </div>
          <div class="mb-3">
            <label for="blogCategoryAdd" class="form-label">Category</label>
            <select class="form-select" id="blogCategoryAdd">
              @foreach ($data->data as $category)
              <option class="text-capitalize" value="{{ $category->category_name }}">{{ $category->category_name }}
              </option>
              @endforeach
            </select>
          </div>
          <div class="mb-3">
            <label for="blogContentAdd" class="form-label">Content</label>
            <input type="hidden" name="blogContent" id="blogContent">
            <div id="blogContentAdd">
              <!-- Content editor or textarea can be added here -->
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Add Blog Post</button>
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
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
<script src="{{asset('assets/js/blogs-data-tables.js')}}"></script>
<script>
  $(document).ready(function () {
    var quill = new Quill('#blogContentAdd', {
      modules: {
        toolbar: [
          [{ header: [1, 2, false] }],
          ['bold', 'italic', 'underline'],
          ['image', 'code-block'],
        ],
      },
      placeholder: 'Blog content here',
      theme: 'snow',
    });

    quill.on('text-change', function () {
      var content = quill.root.innerHTML;
      $('#blogContent').val(content);
    });
  });
</script>
<script>
  // Input Image script
  $(document).ready(function () {
    $('#blogThumbnailAdd').change(function () {
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
        $('#thumbnailEncode').val(e.target.result);
      };
      reader.readAsDataURL(file);
    });
  });
</script>
@endsection