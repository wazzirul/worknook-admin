@extends('layouts/contentNavbarLayout')

@section('title', 'Plan Management - Alacarte')

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
                <h2 class="card-title">Alacarte</h2>
            </div>
            
            <div class="card-body">
                <form method="POST" id="myForm">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-7">
                            <label for="labelPostJob" class="form-label">Post Job</label>
                            <input type="number" class="form-control" id="postJob" name="postJob"step="any">
                        </div>
                        <div class="col-5">
                            <label for="labelPostJob" class="form-label">
                                Allow Add Post Job </label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="checkPostJob" name="checkPostJob">
                                    <label class="form-check-label" for="flexSwitchCheckDefault" id="labelPostJob">on</label>
                                  </div>
                        </div>
                      </div>
                      <div class="row mb-3">
                        <div class="col-7">
                            <label for="labelPostBoost" class="form-label">Post Boost</label>
                            <input type="number" class="form-control" id="postBoost" name="postBoost" step="any">
                        </div>
                        <div class="col-5">
                            <label for="labelPostBoost" class="form-label">
                                Allow Add Post Boost </label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="checkPostBoost" name="checkPostBoost">
                                    <label class="form-check-label" for="flexSwitchCheckDefault" id="labelPostBoost">on</label>
                                  </div>
                        </div>
                      </div>
                      <div class="row mb-3">
                        <div class="col-7">
                            <label for="labelInterview" class="form-label">Interview</label>
                            <input type="number" class="form-control" id="interview" name="interview" step="any">
                        </div>
                        <div class="col-5">
                            <label for="labelInterview" class="form-label">
                                Allow Add Interview </label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="checkInterview" name="checkInterview">
                                    <label class="form-check-label" for="flexSwitchCheckDefault" id="labelInterview">on</label>
                                  </div>
                        </div>
                      </div>
                      <div class="row mb-3">
                        <div class="col-7">
                            <label for="labelTeamMember" class="form-label">Team Member</label>
                            <input type="number" class="form-control" id="teamMember" name="teamMember" step="any">
                        </div>
                        <div class="col-5">
                            <label for="labelTeamMember" class="form-label">
                                Allow Add Team Member </label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="checkTeamMember" name="checkTeamMember">
                                    <label class="form-check-label" for="flexSwitchCheckDefault" id="labelTeamMember">on</label>
                                  </div>
                        </div>
                      </div>
                      <div class="row mb-5">
                        <div class="col-7">
                            <label for="labelHire" class="form-label">Hire</label>
                            <input type="number" class="form-control" id="hire" name="hire" step="any">
                        </div>
                        <div class="col-5">
                            <label for="labelHire" class="form-label">
                                Allow Add Hire </label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="checkHire" name="checkHire">
                                    <label class="form-check-label" for="flexSwitchCheckDefault" id="labelHire">on</label>
                                  </div>
                        </div>
                      </div>
                    <button type="submit" class="btn btn-primary" id="saveButton" onclick="loaderFunc();" disabled>Save</button>
                  </form>
            </div>
           
            
        </div>
    </div>
    <div class="col-md-6">
        <div class="card mb-4">
           
            <div class="card-header">
                <h2 class="card-title">Alacarte Details</h2>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <h5 class="card-title">Pricing Details</h5>
                    </div>
                    <div class="col-6">
                        <h5 class="card-title">Approval for Use Feature</h5>
                    </div>
                </div>
                
            </div>
            <ul class="list-group list-group-flush"> 
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-2">
                            <small>POST JOB</small>
                        </div>
                        <div class="col-4">
                            <strong id="pricePJ">: $10</strong> / Post Job
                        </div>
                        <div class="col-4">
                            <small>ALLOW ADD POST JOB</small>
                        </div>
                        <div class="col-2">
                            <div id="apj">
                                {{-- content allow --}}
                            </div>
                        </div>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-2">
                            <small>POST BOOST</small> 
                        </div>
                        <div class="col-4">
                            <strong id="pricePB">: $10</strong> / Post Boost
                        </div>
                        <div class="col-4">
                            <small>ALLOW ADD POST BOOST</small>
                        </div>
                        <div class="col-2">
                            <div id="apb">
                                {{-- content allow --}}
                            </div>
                        </div>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-2">
                            <small>INTERVIEW</small>
                        </div>
                        <div class="col-4">
                            <strong id="priceIN">: $10</strong> / Interview
                        </div>
                        <div class="col-4">
                            <small>ALLOW ADD INTERVIEW</small>
                        </div>
                        <div class="col-2">
                            <div id="ait">
                                {{-- content allow --}}
                            </div>
                        </div>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-2">
                            <small>TEAM MEMBER</small>
                        </div>
                        <div class="col-4">
                            <strong id="priceTM">: $10</strong> / Team Member
                        </div>
                        <div class="col-4">
                            <small>ALLOW ADD TEAM MEMBER</small>
                        </div>
                        <div class="col-2">
                            <div id="atm">
                                {{-- content allow --}}
                            </div>
                        </div>
                    </div>
                </li>
                <li class="list-group-item mb-4">
                    <div class="row">
                        <div class="col-2">
                            <small>HIRE</small> 
                        </div>
                        <div class="col-4">
                            <strong id="priceHI">: $10</strong> / Hire
                        </div>
                        <div class="col-4">
                            <small>ALLOW ADD HIRE</small>
                        </div>
                        <div class="col-2">
                            <div id="ahi">
                                {{-- content allow --}}
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
           
           
        </div>
    </div>
</div>

@endsection

@section('page-script')
<script>

(async function () {
  let url = '/subscriptions/alacarte/show';
  let method = 'GET';

  let data = [];

  await $.ajax({
    method: 'POST',
    url: '/query',
    data: {
      _token: $('meta[name="csrf-token"]').attr('content'),
      url: url,
      method: method,
    },
    success: res => {
      data = res.data;
      console.log(data);
    },
    error: err => {
      console.log('error', err);
    }
  })
  if(data){
    // singkatan
    var pj = ": $" + data.price_per_post_job,
    pb = ": $" + data.price_per_post_boost,
    it = ": $" + data.price_per_interview,
    tm = ": $" + data.price_per_team_member,
    hi = ": $" + data.price_per_hire;
    $('#pricePJ').text(pj);
    $('#pricePB').text(pb);
    $('#priceIN').text(it);
    $('#priceTM').text(tm);
    $('#priceHI').text(hi);

    $('#postJob').val(data.price_per_post_job);
    $('#postBoost').val(data.price_per_post_boost);
    $('#interview').val(data.price_per_interview);
    $('#teamMember').val(data.price_per_team_member);
    $('#hire').val(data.price_per_hire);

    // a = allow 
    var iconFalse = '<i class="bx bx-x-circle text-danger me-lg-2"></i>';
    var iconTrue = '<i class="bx bx-check-circle text-success me-lg-2"></i>';
    var apj = data.allow_add_post_job ? iconTrue : iconFalse,
    apb = data.allow_add_post_boost ?iconTrue : iconFalse ,
    ait = data.allow_add_interview ?iconTrue : iconFalse ,
    atm = data.allow_add_team_member ?iconTrue : iconFalse ,
    ahi = data.allow_add_hire ? iconTrue : iconFalse ;
    $('#apj').html(apj);
    $('#apb').html(apb);
    $('#ait').html(ait);
    $('#atm').html(atm);
    $('#ahi').html(ahi);

    $('#checkPostJob').prop('checked', data.allow_add_post_job);
    $('#checkPostBoost').prop('checked', data.allow_add_post_boost);
    $('#checkInterview').prop('checked', data.allow_add_interview);
    $('#checkTeamMember').prop('checked', data.allow_add_team_member);
    $('#checkHire').prop('checked', data.allow_add_hire);

  }
  var smallElements = document.querySelectorAll('small');
  smallElements.forEach(function(element) {
        element.style.fontWeight = '600';
    });
  })();
</script>
<script>
    document.getElementById('myForm').addEventListener('input', function () {
    // Seleksi tombol Save
    var saveButton = document.getElementById('saveButton');
    
    // Cek apakah ada perubahan di form
    var isChanged = false;
    var inputs = this.querySelectorAll('input');
    
    inputs.forEach(function(input) {
        if (input.defaultValue !== input.value) {
            isChanged = true;
        }
    });
    
    // Jika ada perubahan, aktifkan tombol Save
    if (isChanged) {
        saveButton.disabled = false;
    } else {
        saveButton.disabled = true;
    }
});
</script>
<script>
    $(document).on('click', '#saveButton', function () {
        const url = '/plan-alacarte/store';
        $('#myForm').attr('action',url);
    })
</script>
@endsection