@extends('layouts/blankLayout')

@section('title', 'Set New Password - Pages')

@section('page-style')
<!-- Page -->
<link rel="stylesheet" href="{{asset('assets/vendor/css/pages/page-auth.css')}}">
@endsection

@section('content')
<div class="container-xxl">
  <div class="authentication-wrapper authentication-basic container-p-y">
    <div class="authentication-inner">
      <!-- Register -->
      <div class="card">
        <div class="card-body">
          <!-- Logo -->
          <div class="app-brand justify-content-center">
            <a href="{{url('/')}}" class="app-brand-link gap-2">
              <span class="app-brand-logo demo">@include('_partials.macros')</span>
            </a>
          </div>
          <!-- /Logo -->
          <h4 class="mb-4">Set new password</h4>

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
  
          <form id="formAuthentication" class="mb-3" action="{{url('/')}}" method="GET">
            <div class="mb-3">
              <label for="otc" class="form-label">Reset Code</label>
              <input type="text" class="form-control" id="otc" name="one-time-code" placeholder="Enter one time code you received" autofocus required>
            </div>
            <div class="mb-3 form-password-toggle">
              <div class="d-flex justify-content-between">
                <label class="form-label" for="new-password">New Password</label>
              </div>
              <div class="input-group input-group-merge">
                <input type="password" id="new-password" class="form-control" name="new-password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" minlength="8" required/>
                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
              </div>
            </div>
            <div class="mb-3 form-password-toggle">
              <div class="d-flex justify-content-between">
                <label class="form-label" for="confirm-new-password">Confirm New Password</label>
              </div>
              <div class="input-group input-group-merge">
                <input type="password" id="confirm-new-password" class="form-control" name="confirm-new-password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" minlength="8" required/>
                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
              </div>
            </div>
            <div class="mb-3">
              <button class="btn btn-primary d-grid w-100" type="submit" disabled>Submit new password</button>
            </div>
            <div class="text-center">
              <a href="{{url('auth/login')}}" class="d-flex align-items-center justify-content-center">
                <i class="bx bx-chevron-left scaleX-n1-rtl bx-sm"></i>
                Back to login
              </a>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- /Register -->
  </div>
</div>
</div>
@endsection

@section('page-script')
<!-- Page -->
<script>
  $(document).ready(function () {
    $('#otc').keypress(function(e) {
      if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        return false;
      }
    });

    $('#new-password, #confirm-new-password').on('input', function() {
      $('button[type="submit"]').prop('disabled', $('#new-password').val() !== $('#confirm-new-password').val());
    });
  });
</script>
@endsection