@extends('layouts/contentNavbarLayout')

@section('title', 'Categories - Index')

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
          <th>Category Name</th>
          <th>Date</th>
          <th>Action</th>
        </tr>
      </thead>
    </table>
  </div>
</div>
<!-- Add and Edit Blog Category Modal -->
<div class="modal fade" id="blogModalCategory" tabindex="-1" aria-labelledby="BlogModalCategoryLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="blogModalLabel">Add New Blog Category</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="/blog-categories/add" method="POST">
        <div class="modal-body">
          @csrf
          <div class="mb-3">
            <input type="text" class="form-control" id="categoryId" name="categoryId" value="Name of the Category"
              hidden>
            <label for="categoryName" class="form-label">Name</label>
            <input type="text" class="form-control" id="categoryName" name="categoryName" value="Name of the Category"
              required>
          </div>
          <div class="mb-3">
            
            <label for="categoryName" class="form-label">Icon</label>
            <input type="file" class="form-control" id="iconCategory" name="iconCategory" required>
            <input type="text" class="form-control" id="iconThumbnail" name="iconThumbnail" value="Name of the Category"
              hidden>
          </div>
          <div class="mb-3" style="display: flex">
              <img src="" alt="" id="valueImage" style="max-width:65px;aspect-ratio:1/1">
          </div>
         
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" id="buttonModal" onclick="">Add Blog
            Category</button>
          </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Delete Confirmation -->
<div class="modal fade" id="deleteBlogModal" tabindex="-1" aria-hidden="true" style="z-index: 1091">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">

      <div class="modal-header">

        <h5 class="modal-title" id="modalCenterTitle">Delete category</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" class="dt-blog-id" name="blogID">
        <p>Are you sure to delete this category?</p>
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
<script src="{{asset('assets/js/master/categories-data-tables.js')}}"></script>

<script>
  function requiredInput(){
    document.getElementById('iconCategory').required = false;
  }
  // Add and Edit Modal
  $(document).on('click', '.create-new, .item-edit', function () {
    
    $(document).on('click', '#buttonModal', function () {
      if($('#categoryName').val()!="" && $('#iconCategory').val()!="" || $('#iconThumbnail').val()!=""){
      loaderFunc();
    }
    })
    const modal = $('#blogModalCategory');
    const url = '/master-categories/store';

    if (modal.length)
    {
      if ($(this).hasClass('create-new'))
      {
        setImgSrc("");
        modal.find('#categoryId').val('');
        modal.find('#categoryName').val('');
        modal.find('#iconCategory').val('');
        modal.find('#iconThumbnail').val('');
        modal.find('#blogModalLabel').text('Add new category');
        modal.find('#buttonModal').text('Add category');
      } else
      {
        const data = $(this).data();
        const name = decodeURIComponent(data.name);
        const icon = decodeURIComponent(data.icon);
        modal.find('#categoryId').val(data.id || '');
        modal.find('#categoryName').val(name || '');
        modal.find('#iconCategory').val('');
        modal.find('#iconThumbnail').val(icon || '');
        setImgSrc(icon);
        modal.find('#blogModalLabel').text('Edit category');
        modal.find('#buttonModal').text('Edit category');
      }

      modal.find('form').attr('action', url);
      modal.modal('show');
    }
  });
  function setImgSrc(url) {
    var imgElement = document.getElementById('valueImage');
    imgElement.src = url;
  }
</script>

<script>
  // Delete Function
  $(document).on('click', '.delete-record', async function () {
    $('.modal').modal('hide');
    $('#deleteBlogModal').modal('show');
    const categoryId = $(this).data('id');
    
    $(document).on('click', '#confirmationBtn', async function () {
      loaderFunc();
   
    const url = "/categories/store";
    const method = "POST";
    // Prepare payload data
    const payload = {
      category_id: categoryId,
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
          location.replace('master-categories/delete');
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
   $(document).ready(function () {
    $('#iconCategory').change(function () {
      var file = this.files[0];
      
      var reader = new FileReader();
      
        reader.onload = function (e) {
          var result =  e.target.result;
          var img = document.getElementById('valueImage');

          //cek file svg
          if (file.type === 'image/svg+xml') {
            
                // Parse the SVG string and change color to black
            var parser = new DOMParser();
            var svgDoc = parser.parseFromString(result, 'image/svg+xml');
            var svgElement = svgDoc.documentElement;

            // Change fill and stroke attributes to black
            changeSvgColorToBlack(svgElement);

            // Serialize the modified SVG back to string
            var serializer = new XMLSerializer();
            var newResult = serializer.serializeToString(svgElement);

            // svg.innerHTML = newResult;
            var newResult = 'data:image/svg+xml;base64,' + btoa(newResult);
            img.src = newResult;
            result = newResult;
          }else{
            img.src = result;
          }
          $('#iconThumbnail').val(result);
      };
     
      if(file.type === 'image/svg+xml'){
        reader.readAsText(file);
      }else{
        reader.readAsDataURL(file);
      }
      
    
    });
  });

  function changeSvgColorToBlack(svgElement) {
    // Change fill and stroke attributes to black
    var elements = svgElement.querySelectorAll('*');
    elements.forEach(function(element) {
        if (element.hasAttribute('width')) {
            element.setAttribute('width', '100%');
        }
        if (element.hasAttribute('height')) {
            element.setAttribute('height', '100%');
        }
        if (element.hasAttribute('stroke')) {
            element.setAttribute('stroke', 'currentColor');
        }
        if (element.hasAttribute('fill')) {
            element.setAttribute('fill', 'currentColor');
        }

    });
}

</script>
@endsection


