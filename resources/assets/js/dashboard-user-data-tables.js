'use strict';

// Request User Data
(async function () {
  let urlAPI = '/admin-dashboard/new-user-registered';
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
      // return;
    },
    error: err => {
      console.log('error', err);
    }
  });

  $(function () {
    var e,
      t = $('#tableUser');
    t.length &&
      ((e = t.DataTable({
        data: data_api,
        autoWidth: false,
        paging: false, // Disable pagination
        lengthChange: false, // Hide "entries per page" select input
        searching: false,
        columns: [
          {
            data: 'fullname'
          },
          {
            data: 'email'
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
            targets: 3,
            render: function (data, type, row) {
              return moment(data).format('YYYY-MM-DD'); // Adjust format as needed
            }
          },
          {
            targets: -2,
            render: function (e, t, a, s) {
              var n = a.status,
                r = {
                  1: {
                    title: 'User',
                    class: 'bg-label-primary'
                  },
                  2: {
                    title: 'Company',
                    class: ' bg-label-success'
                  }
                };
              return void 0 === r[n] ? e : '<span class="badge ' + r[n].class + '">' + r[n].title + '</span>';
            }
          }
        ],
        order: [[2, 'desc']],
        dom: '<"card-header flex-column flex-md-row"<"head-label-user text-center"><"dt-action-buttons text-end pt-3 pt-md-0"B>><"row mb-2"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
        buttons: [
          {
            className: 'btn btn-primary',
            attr: {
              role: 'button'
            },
            action: function (e, dt, node, config, cb) {
              window.location.href = '/candidate';
              this.disable(); // disable button
            },
            text: 'See more candidates'
          }
        ]
      })),
      $('div.head-label-user').html('<h1 class="card-title mb-3">New Registered Candidates</h1>'));
  });
})();
