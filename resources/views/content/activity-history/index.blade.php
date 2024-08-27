@extends('layouts/contentNavbarLayout')

@section('title', 'Activity History - Index')

@section('vendor-style')
<!-- Include stylesheet -->
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" />
<style>

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
  <div class="card-header">
    <h2>Job Details</h2>
  </div>
  <div class="card-body">
    
    @foreach ($data->data->data as $d)
    <div class="col-md-12 bg-white p-3 ">
      {{ $d->history }}
    </div>
    @endforeach
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12 text-center">
          @php
          $currentPage = $data->data->current_page;
          $lastPage = $data->data->last_page;
          $perPageGroup = 5; // Jumlah halaman per grup
          $currentGroup = ceil($currentPage / $perPageGroup);
          $startPage = ($currentGroup - 1) * $perPageGroup + 1;
          $endPage = min($startPage + $perPageGroup - 1, $lastPage);
      @endphp
      
      @if ($lastPage > 1)
          <ul class="pagination">
              {{-- Link ke halaman sebelumnya --}}
              @if ($currentPage > 1)
                  <li class="page-item">
                      <a class="page-link" href="{{ $data->data->prev_page_url }}" aria-label="Previous">
                          <span aria-hidden="true">&laquo; Previous</span>
                      </a>
                  </li>
              @endif
      
              {{-- Link ke halaman dalam grup --}}
              @for ($page = $startPage; $page <= $endPage; $page++)
                  <li class="page-item {{ $page == $currentPage ? 'active' : '' }}">
                      <a class="page-link" href="/activity-history?page={{ $page }}">{{ $page }}</a>
                  </li>
              @endfor
      
              {{-- Link ke grup halaman berikutnya --}}
              @if ($endPage < $lastPage)
                  <li class="page-item">
                      <a class="page-link" href="/activity-history?page={{ $endPage + 1 }}" aria-label="Next">
                          <span aria-hidden="true">Next &raquo;</span>
                      </a>
                  </li>
              @endif
          </ul>
      @endif
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script
  src="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.5/b-3.0.2/b-colvis-3.0.2/b-html5-3.0.2/b-print-3.0.2/r-3.0.2/sl-2.0.1/datatables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>


@endsection