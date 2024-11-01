@extends('layouts/contentNavbarLayout')

@section('title', 'Settings')

@section('vendor-style')

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



<div class="row">
    <div class="col-md-6">
        <div class="card mb-4">
           
            <div class="card-header">
                <h2 class="card-title">Reset Password</h2>
            </div>
            
            <div class="card-body">
                <form method="POST" id="myForm">
                    @csrf
                    <input type="text" name="email" value="{{Session::get('email')}}" hidden>
                    <div class="row mb-3">
                        <div class="input-group mb-3">
                            <input type="password" class="form-control" placeholder="Current Password" name="current_password" aria-describedby="basic-addon2" required>
                            <span class="input-group-text" id="basic-addon2">
                                <button type="button" class="bg-transparent border-0" onclick="togglePasswordVisibility(this)">
                                    <i class="bx bx-hide"></i>
                                </button>
                            </span>
                        </div>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control" placeholder="New Password" name="new_password" id="new_password" aria-describedby="basic-addon2" required>
                            <span class="input-group-text" id="basic-addon2">
                                <button type="button" class="bg-transparent border-0" onclick="togglePasswordVisibility(this)">
                                    <i class="bx bx-hide"></i>
                                </button>
                            </span>
                        </div>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control" placeholder="Confirm Password" name="confirm_password" id="confirm_password" aria-describedby="basic-addon2" required>
                            <span class="input-group-text" id="basic-addon2">
                                <button type="button" class="bg-transparent border-0" onclick="togglePasswordVisibility(this)">
                                    <i class="bx bx-hide"></i>
                                </button>
                            </span>
                        </div>
                        <div class="text-danger" id="error-message"></div>
                    </div>
                    <button type="submit" class="btn btn-secondary" id="saveButton" disabled>Submit</button>
                </form>
            </div>
           
            
        </div>
    </div>
   
</div>

@endsection

@section('page-script')

<script>
    function validatePasswords() {
        const newPassword = document.getElementById('new_password').value;
        const confirmPassword = document.getElementById('confirm_password').value;
        const errorMessage = document.getElementById('error-message');
        const saveButton = document.getElementById('saveButton');
        
        if (newPassword !== confirmPassword) {
            errorMessage.textContent = 'Passwords do not match';
            saveButton.disabled = true;
        } else {
            errorMessage.textContent = '';
            saveButton.disabled = false;
        }
    }
    
    // Listen for input events on both password fields
    document.getElementById('new_password').addEventListener('input', validatePasswords);
    document.getElementById('confirm_password').addEventListener('input', validatePasswords);
    
    // Toggle password visibility
    function togglePasswordVisibility(button) {
        const input = button.closest('.input-group').querySelector('input');
        const icon = button.querySelector('i');
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('bx-hide');
            icon.classList.add('bx-show');
        } else {
            input.type = 'password';
            icon.classList.remove('bx-show');
            icon.classList.add('bx-hide');
        }
    }
    </script>
<script>
    $(document).on('click', '#saveButton', function () {
        const url = '/settings/reset-password';
        $('#myForm').attr('action',url);
    })
</script>
@endsection