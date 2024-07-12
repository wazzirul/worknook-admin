'use strict';

// Request User Data
(async function () {
  let urlAPI = '/backup/database/list';
  let methodAPI = 'GET';
  let payloadAPI = {};

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
      data_api = res.data;
      // console.log(data_api);
    },
    error: err => {
      console.log('error', err);
    }
  });

  $(function () {
    var e,
      t = $('.datatables-basic');
    t.length &&
      ((e = t.DataTable({
        data: data_api,
        columns: [
          {
            data: 'file'
          },
          // {
          //   data: 'created_at'
          // },
          {
            data: ''
          }
        ],
        columnDefs: [
        
          {
            targets: -1,
            title: 'Actions',
            orderable: !1,
            searchable: !1,
            render: function (e, t, a, s) {
              var n = a.url
               
              return userRole === '1'
                ? '<div class="d-inline-block"><a href="javascript:;" class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></a><ul class="dropdown-menu dropdown-menu-end m-0"><li><a href="'+n+'" class="dropdown-item text-secondary delete-record">Download File</a></li></ul></div>'
                : '<small>Unathorized</small>';
            }
          }
        ],
        order: [[2, 'desc']],
        dom: '<"card-header flex-column flex-md-row"<"head-label text-center">><"row mb-2"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
      
        
        // Add the "create-new" button conditionally
        initComplete: function (settings, json) {
          if (userRole === '1') {
            // Append the button to the appropriate DOM element (adjust as needed)
            
          }
        }
      })),
      $('div.head-label').html('<h1 class="card-title mb-3">List Backup</h1>'));
    setTimeout(() => {
      $('.dataTables_filter .form-control').removeClass('form-control-sm'),
        $('.dataTables_length .form-select').removeClass('form-select-sm');
    }, 300);
  });
})();
