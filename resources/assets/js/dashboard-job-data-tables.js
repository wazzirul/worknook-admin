'use strict';

// Request Data
(async function () {
  let urlAPI = '/admin-dashboard/new-job-posted';
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
      console.log(data_api);
      // return;
    },
    error: err => {
      console.log('error', err);
    }
  });

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
            data: 'job_title'
          },
          {
            data: 'job_type_employment[0].type_name'
          },
          {
            data: 'job_level.level_name'
          },
          {
            data: 'location'
          },
          {
            data: 'created_at'
          }
        ],
        columnDefs: [
          {
            targets: 1,
            render: function (e, t, a, s) {
              var d = a.job_type_employment.map(type => type.type_name).join(', ');
              return d;
            }
          },
          {
            targets: 4,
            render: function (data, type, row) {
              return moment(data).format('YYYY-MM-DD'); // Adjust format as needed
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
