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
            <img src="https://images.pexels.com/photos/25312271/pexels-photo-25312271/free-photo-of-a-woman-sitting-on-a-cube-with-a-camera.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2"
                class="card-img-top" alt="Blog Post Thumbnail">
            <div class="card-header">
                <h4 class="card-title">Blog Post Details</h4>
            </div>
            <div class="card-body">
                <h5 class="card-title">Title of the Blog Post</h5>
                <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce rutrum in massa eu
                    maximus. Sed viverra lobortis mi, nec feugiat tellus scelerisque a.</p>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <strong>Author:</strong> John Doe
                </li>
                <li class="list-group-item">
                    <strong>Published:</strong> June 19, 2024
                </li>
                <li class="list-group-item">
                    <strong>Category:</strong>
                    <div class="badge bg-primary">Technology</div>
                </li>
            </ul>
            <div class="card-body">
                <h5 class="card-title">Content</h5>
                <p class="card-text">More detailed content of the blog post...</p>
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
                <p class="card-text">Author bio and other details...</p>
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
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label for="blogThumbnail" class="form-label">Thumbnail</label>
                        <input type="file" class="form-control" id="blogThumbnail">
                    </div>
                    <div class="mb-3">
                        <label for="blogTitle" class="form-label">Title</label>
                        <input type="text" class="form-control" id="blogTitle" value="Title of the Blog Post">
                    </div>
                    <div class="mb-3">
                        <label for="blogCategory" class="form-label">Category</label>
                        <select class="form-select" id="blogCategory">
                            <option value="technology">Technology</option>
                            <option value="lifestyle">Lifestyle</option>
                            <option value="business">Business</option>
                            <!-- Add more categories as needed -->
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="blogContent" class="form-label">Content</label>
                        <div id="blogContent">
                            <!-- Content editor or textarea can be added here -->
                            <textarea class="form-control"
                                rows="10">More detailed content of the blog post...</textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
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
                <p>Are you sure to delete this blog post?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmationBtn">Delete</button>
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
    async function deleteJob (jobId) {
        $('.modal').modal('hide');
        await $('#modalConfirmation').modal('show');
        $(document).on('click', '#confirmationBtn', async function () {
            const url = "/jobs/store";
            const method = "POST";
            // Prepare payload data
            const payload = {
                job_id: jobId,
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
                        location.reload();
                    }, 500); // Adjust delay as needed
                },
                error: function (xhr, status, error) {
                    $('.alert-danger').html(xhr.responseText).show(); // Display error message
                }
            });
        })
    };

    $(document).on('click', '.delete-record', async function () {
        const jobId = $(this).data('id');

        deleteJob(jobId);
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