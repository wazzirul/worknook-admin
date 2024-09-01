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
<!-- Page Hero Content -->
<div class="card">
  <div class="card-header">Privacy Header</div>
  <div class="card-body">
    <h5 class="mb-1">{{ $data->title}}</h5>
    <p class="mb-0">{!! $data->description !!}</p>
  </div>
</div>

<!-- Page Content -->
<div class="card mt-3">
  <div class="card-header">Privacy Content Points</div>
  <div class="card-body">
    <div class="row">
      @foreach($data->poins as $poins)
      <div class="col-lg-4 card shadow-none border border-primary">
        <div class="card-body">
          <img src="{{ $poins->icon }}" alt="{{ $poins->title }}" class="mb-3">
          <h5 class="mb-1">{{ $poins->title }}</h5>
          <p class="mb-0">{{ $poins->description }}</p>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</div>

<!-- Page Main Content -->
@foreach($data->items as $item)
<div class="card mt-3">
  <div class="card-header">Privacy Item {{ $loop->index+1 }}</div>
  <div class="card-body">
    <h5 class="mb-1">{{ $item->title}}</h5>
    <p class="mb-0">{!! $item->description !!}</p>
  </div>
</div>
@endforeach



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

<!-- Add Blog Modal -->
<div class="modal fade" id="addBlogModal" tabindex="-1" aria-labelledby="addBlogModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addBlogModalLabel">Add New Blog Post</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="/blogs/add" method="POST">
        <div class="modal-body">

          @csrf
          <div class="mb-3">
            <label for="blogThumbnailAdd" class="form-label">Thumbnail</label>
            <input type="file" class="form-control" id="blogThumbnailAdd">
            <input type="hidden" name="thumbnailEncode" id="thumbnailEncode">
          </div>
          <div class="mb-3">
            <label for="blogTitleAdd" class="form-label">Title</label>
            <input type="text" class="form-control" id="blogTitleAdd" name="blogTitleAdd">
          </div>
          
          <div class="mb-3">
            <label for="blogCategoryAdd" class="form-label">Featured</label>
            <select class="form-select" id="blogFeaturedAdd" name="blogFeaturedAdd">

              <option class="text-capitalize" value="0">Non-Active
              </option>
              <option class="text-capitalize" value="1">Active
              </option>

            </select>
          </div>
          <div class="mb-3">
            <label for="blogShortContentAdd" class="form-label">Short Description</label>
            <input type="text" class="form-control" id="blogShortContent" name="blogShortContent">
          </div>
          <div class="mb-3">
            <label for="blogContentAdd" class="form-label">Content</label>
            <input type="hidden" name="blogContent" id="blogContent">
            <div id="blogContentAdd">
              <!-- Content editor or textarea can be added here -->
            </div>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" onclick="loaderFunc();">Add Blog Post</button>
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
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
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
@endsection