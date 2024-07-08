@extends('layouts/contentNavbarLayout')

@section('title', 'Blogs - Details')

@section('vendor-style')
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" />
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
            <img src="{{$dataBlog->data->blog_thumbnail}}" class="card-img-top" alt="Blog Post Thumbnail">
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
                <h5 class="card-title">Content :</h5>
                <div class="card-text" id="blogContent">{!!$dataBlog->data->description!!}</div>
            </div>
            <div class="card-footer">
                <a href="#" class="btn btn-primary me-2 edit-blog" data-bs-toggle="modal"
                    data-bs-target="#editBlogModal">Edit</a>
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
            <form action="/blog/update" method="POST">
                <div class="modal-body">
                    @csrf
                    <div class="mb-3">
                        <input type="hidden" name="blogId" id="blogId" value="{{$dataBlog->data->blog_id}}">
                        <label for="blogThumbnailEdit" class="form-label">Thumbnail</label>
                        <small class="text-muted">Tip : Leave it empty if image will not updated.</small>
                        <input type="file" class="form-control" id="blogThumbnailEdit" accept="image/png">
                        <input type="hidden" name="thumbnailEncode" id="thumbnailEncode">
                    </div>
                    <div class="mb-3">
                        <label for="blogTitleEdit" class="form-label">Title</label>
                        <input type="text" class="form-control" id="blogTitleEdit" name="blogTitleEdit"
                            value="{{$dataBlog->data->blog_title}}" required>
                    </div>
                    <div class="mb-3">
                        <label for="blogCategoryEdit" class="form-label">Category</label>
                        <select class="form-select" id="blogCategoryEdit" name="blogCategoryEdit" required>

                            @foreach ($data->data as $category)
                            <option class="text-capitalize" value="{{ $category->blog_category_id }}" <?php
                                if($category->blog_category_id == $dataBlog->data->category->blog_category_id)echo
                                "Selected"?>>{{ $category->category_name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="blogFeaturedEdit" class="form-label">Featured</label>
                        <select class="form-select" id="blogFeaturedEdit" name="blogFeaturedEdit" required>
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
                        <label for="blogShortContent" class="form-label">Short Content</label>
                        <input type="text" class="form-control" name="blogShortContent" id="blogShortContent"
                            value="{{$dataBlog->data->short_description}}" required>
                    </div>
                    <div class="mb-3">
                        <label for="blogContentEdit" class="form-label">Content</label>
                        <input type="hidden" name="blogContent" id="blogContentEditHidden" required>
                        <div id="blogContentEdit">
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
                <button type="button" class="btn btn-danger delete-record" id="confirmationBtn"
                    data-id="{{$dataBlog->data->blog_id}}">Delete</button>
            </div>

        </div>
    </div>
</div>
</div>
@endsection

@section('page-script')
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>

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
    // Input Image script
    $(document).ready(function () {
        $('#blogThumbnailEdit').change(function () {
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
<script>
    $(document).ready(function () {
        var quill = new Quill('#blogContentEdit', {
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

        let blogContent = $(document).find('#blogContent').html();

        $('#blogContentEditHidden').val(blogContent);

        // quill.setContents([{ insert: blogContent }]);
        quill.clipboard.dangerouslyPasteHTML(blogContent)

        $(document).on('click', '.edit-blog', function () {
            quill.on('text-change', function () {
                var content = quill.root.innerHTML;

                $('#blogContentEditHidden').val(content);
            });
        })
    })
</script>
@endsection