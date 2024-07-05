@extends('layouts/contentNavbarLayout')

@section('title', 'Blogs - Index')

@section('vendor-style')
<link href="https://cdn.datatables.net/v/bs5/dt-2.0.5/b-3.0.2/r-3.0.2/sl-2.0.1/datatables.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="{{ asset(mix('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')) }}">
<link rel="stylesheet"
    href="{{ asset(mix('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')) }}">
<link rel="stylesheet"
    href="{{ asset(mix('assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('assets/vendor/libs/datatables-rowgroup-bs5/rowgroup.bootstrap5.css')) }}">
<script src="https://cdnjs.cloudflare.com/ajax/libs/slim-select/2.8.2/slimselect.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/slim-select/2.8.2/slimselect.css" rel="stylesheet">
</link>
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


<!-- Blog Details -->
<h4 class="py-3 mb-4">
    <span class="text-muted fw-light">Blog Details /</span> Title Here
</h4>
<div class="row">
    <div class="col-lg-8">
        <div class="card mb-4">
            <img src="{{$dataBlog->data->blog_thumbnail}}"
                class="card-img-top" alt="Blog Post Thumbnail">
            <div class="card-header">
                <h4 class="card-title">Blog Post Details</h4>
            </div>
            <div class="card-body">
                <h5 class="card-title">Title of the Blog Post</h5>
                <p class="card-text">{{$dataBlog->data->blog_title}}</p>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <strong>Author:</strong> {{$dataBlog->data->admin->fullname}}
                </li>
                <li class="list-group-item">
                    <strong>Published:</strong> {{$dataBlog->data->date}} 
                </li>
                <li class="list-group-item">
                    <strong>Category:</strong>
                    <div class="badge bg-primary">{{$dataBlog->data->category->category_name}}</div>
                </li>
            </ul>
            <div class="card-body">
                <h5 class="card-title">Content</h5>
                <p class="card-text">{!!$dataBlog->data->short_description!!}</p>
            </div>
            <div class="card-footer">
                <a href="#" class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#editBlogModal">Edit</a>
                <a href="#" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteBlogModal">Delete</a>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card mb-4">
            <div class="card-header">
                <h4 class="card-title">Author Information</h4>
            </div>
            <div class="card-body">
                <p class="card-text">Written by {{$dataBlog->data->admin->fullname}}</p>
            </div>
        </div>
    </div>
</div>

<!-- Edit Blog Modal -->
<div class="modal fade" id="editBlogModal" tabindex="-1" aria-labelledby="editBlogModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editBlogModalLabel">Edit Blog Post</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/blogs/add" method="POST">
                <div class="modal-body">
                
                    @csrf
                    <div class="mb-3">
                      <label for="blogThumbnailAdd" class="form-label">Thumbnail</label>
                      <input type="file" class="form-control" id="blogThumbnailAdd" >
                      <input type="hidden" name="thumbnailEncode" id="thumbnailEncode" >
                    </div>
                    <div class="mb-3">
                      <label for="blogTitleAdd" class="form-label">Title</label>
                      <input type="text" class="form-control" id="blogTitleAdd" name="blogTitleAdd" value="{{$dataBlog->data->blog_title}}">
                    </div>
                    <div class="mb-3">
                      <label for="blogCategoryAdd" class="form-label">Category</label>
                      <select class="form-select" id="blogCategoryAdd" name="blogCategoryAdd">
                        
                        @foreach ($data->data as $category)
                        <option class="text-capitalize" value="{{ $category->blog_category_id }}" <?php if($category->blog_category_id == $dataBlog->data->category->blog_category_id)echo "Selected"?>>{{ $category->category_name }}
                        </option>
                        @endforeach
                      </select>
                    </div>
                    <div class="mb-3">
                      <label for="blogCategoryAdd" class="form-label">Featured</label>
                      <select class="form-select" id="blogFeaturedAdd" name="blogFeaturedAdd">
                        <?php $active = "";
                        if($dataBlog->data->featured==1){
                          $active = "Selected"; 
                        } 
                       ?>
                        <option class="text-capitalize" value="0">Non-Active
                        </option>
                        <option class="text-capitalize" value="1" {{$active}}>Active
                        </option>
                       
                      </select>
                    </div>
                    <div class="mb-3">
                      <label for="blogContentAdd" class="form-label">Short Content</label>
                      <input type="hidden" name="blogShortContent" id="blogShortContent">
                      <div id="blogShortContentAdd">
                        <!-- Content editor or textarea can be added here -->
                      </div>
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
                  <button type="submit" class="btn btn-primary">Edit Blog Post</button>
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
              
                <h5 class="modal-title" id="modalCenterTitle">Delete blog</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" class="dt-blog-id" name="blogID">
                <p>Are you sure to delete this blog post?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger delete-record" id="confirmationBtn" data-id="{{$dataBlog->data->blog_id}}">Delete</button>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js"></script>
<!-- <script src="{{asset('assets/js/job-list-data-tables.js')}}"></script> -->
<script>
    // Delete Function
    async function deleteBlog (blogId) {
        $('.modal').modal('hide');
        await $('#modalConfirmation').modal('show');
        //2x Click
        // $(document).on('click', '#confirmationBtn', async function () {
            const url = "/blog/store";
            const method = "POST";
            // Prepare payload data
            const payload = {
                blog_id: blogId,
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
                        location.replace('/blogs/delete');
                    }, 500); // Adjust delay as needed
                },
                error: function (xhr, status, error) {
                    $('.alert-danger').html(xhr.responseText).show(); // Display error message
                }
            });
        // })
    };

    $(document).on('click', '.delete-record', async function () {
        
        const blogId = $(this).data('id');
        deleteBlog(blogId);
    });
</script>
<script>
    // Open edit user modal
    $(document).on('click', '.edit-record', function () {
        $('#modalDetails').modal('hide');

        $('#modal-offcanvas').modal('show');
    });
</script>
<script>
    (async function () {
        let urlAPI = '/admin-user/data';
        let methodAPI = 'POST';
        let payloadAPI = {
            paginate: 100
        };

        let data_api = [];

        await $.ajax({
            method: 'POST',
            url: '/query',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                url: urlAPI,
                method: methodAPI,
                payload: payloadAPI
            },
            success: res => {
                data_api = res.data.data;
                console.log(data_api);
                // return;
            },
            error: err => {
                console.log('error', err);
            }
        });
    })

    new SlimSelect({
        select: '#jobLevel',
        // Array of Option objects
        data: [{ text: 'Value 1', value: 'value1' }],
        events: {
            error: function (err) {
                console.error(err)
            },
            addable: function (value) {
                return value
            }
        },
        settings: {
            searchHighlight: true
        }
    })
</script>

@endsection