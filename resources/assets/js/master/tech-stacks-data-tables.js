'use strict';

// Request User Data
(async function () {
  let urlAPI = '/tech-stacks/show';
  let methodAPI = 'POST';
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
            data: 'stack_name'
          },

          {
            data: 'created_at'
          },
          {
            data: ''
          }
        ],
        columnDefs: [
          {
            targets: 0,
            class: 'blog-list',
            render: function (e, t, a, s) {
              var n = a.stack_icon,
                r = a.stack_name;
              if (n) var o = '<img src="' + n + '" alt="Avatar" class="rounded-circle">';
              else {
                var d = ['success', 'danger', 'warning', 'info', 'dark', 'primary', 'secondary'][
                    Math.floor(6 * Math.random())
                  ],
                  i = (r = a.stack_name).match(/\b\w/g) || [];
                o =
                  '<span class="avatar-initial rounded-circle bg-label-' +
                  d +
                  '">' +
                  (i = ((i.shift() || '') + (i.pop() || '')).toUpperCase()) +
                  '</span>';
              }
              return (
                '<div class="d-flex justify-content-start align-items-center user-name"><div class="avatar-wrapper"><div class="avatar me-2">' +
                o +
                '</div></div><div class="d-flex flex-column"><span class="emp_name text-truncate">' +
                r +
                '</span></div></div>'
              );
            }
          },
          {
            targets: 1,
            render: function (data, type, row) {
              return moment(data).format('YYYY-MM-DD'); // Adjust format as needed
            }
          },
          {
            targets: -1,
            title: 'Actions',
            orderable: !1,
            searchable: !1,
            render: function (e, t, a, s) {
              var n = a.tech_stack_id,
                r = a.stack_name;

              var encodedName = encodeURIComponent(r);

              return true
                ? '<div class="d-inline-block"><a href="javascript:;" class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></a><ul class="dropdown-menu dropdown-menu-end m-0"><li><a href="javascript:;" class="dropdown-item text-danger delete-record" data-id=' +
                    n +
                    '>Delete</a></li></ul></div><a href="javascript:;" class="btn btn-sm btn-icon item-edit" data-name=' +
                    encodedName +
                    ' data-id=' +
                    n +
                    '><i class="bx bxs-edit"></i></a>'
                : '<small>Unathorized</small>';
            }
          }
        ],
        order: [[2, 'desc']],
        dom: '<"card-header flex-column flex-md-row"<"head-label text-center"><"dt-action-buttons text-end pt-3 pt-md-0">><"row mb-2"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
        displayLength: 7,
        lengthMenu: [7, 10, 25, 50, 75, 100],

        // Add the "create-new" button conditionally
        initComplete: function (settings, json) {
          if (true) {
            // Append the button to the appropriate DOM element (adjust as needed)
            $('.dt-action-buttons').append(
              '<button type="button" class="create-new btn btn-primary"><i class="bx bx-plus me-sm-1"></i> <span class="d-none d-sm-inline-block">Add New Tech Stack</span></button>'
            );
          }
        }
      })),
      $('div.head-label').html('<h1 class="card-title mb-3">Master Data Tech Stacks</h1>'));
    setTimeout(() => {
      $('.dataTables_filter .form-control').removeClass('form-control-sm'),
        $('.dataTables_length .form-select').removeClass('form-select-sm');
    }, 300);
  });
})();
