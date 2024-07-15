'use strict';

// Request User Data
(async function () {
  // let urlAPI = '/blog/show';
  // let methodAPI = 'POST';
  // let payloadAPI = {};

  let data_api = [];

  // await $.ajax({
  //   method: 'POST',
  //   url: '/query',
  //   data: {
  //     _token: $('meta[name="csrf-token"]').attr('content'),
  //     url: urlAPI,
  //     method: methodAPI,
  //     payload: payloadAPI
  //   },
  //   success: res => {
  //     data_api = res.data;
  //     // console.log(data_api);
  //     // return;
  //   },
  //   error: err => {
  //     console.log('error', err);
  //   }
  // });

  $(function () {
    var e,
      t = $('#tableJob');
    t.length &&
      ((e = t.DataTable({
        data: data_api,
        autoWidth: false,
        paging: false, // Disable pagination
        lengthChange: false, // Hide "entries per page" select input
        searching: false,
        columns: [
          {
            data: 'blog_title'
          },
          {
            data: 'short_description'
          },
          {
            data: 'admin.fullname'
          },
          {
            data: 'category.category_name'
          },
          {
            data: 'date'
          }
        ],
        columnDefs: [
          {
            targets: 0,
            class: 'blog-list',
            render: function (e, t, a, s) {
              var n = a.blog_thumbnail,
                r = a.blog_title;
              if (n) var o = '<img src="' + n + '" alt="Avatar" class="rounded-circle">';
              else {
                var d = ['success', 'danger', 'warning', 'info', 'dark', 'primary', 'secondary'][
                    Math.floor(6 * Math.random())
                  ],
                  i = (r = a.fullname).match(/\b\w/g) || [];
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
            targets: 3,
            render: function (e, t, a, s) {
              var n = a.category.category_name;
              return '<span class="badge bg-primary text-capitalize">' + n + '</span>';
            }
          }
        ],
        order: [[2, 'desc']],
        dom: '<"card-header flex-column flex-md-row"<"head-label-job text-center"><"dt-action-buttons text-end pt-3 pt-md-0"B>><"row mb-2"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
        buttons: [
          {
            className: 'btn btn-primary',
            attr: {
              role: 'button'
            },
            action: function (e, dt, node, config, cb) {
              window.location.href = '/job-list';
              this.disable(); // disable button
            },
            text: 'See more jobs'
          }
        ]
      })),
      $('div.head-label-job').html('<h1 class="card-title mb-3">Latest Job Posted</h1>'));
  });
})();
