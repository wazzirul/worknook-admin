'use strict';

// Request User Data
(async function () {
  let urlAPI = '/jobs/show-all';
  let methodAPI = 'GET';
  // let payloadAPI = {};

  let data_api = [];

  await $.ajax({
    method: 'POST',
    url: '/query',
    data: {
      _token: $('meta[name="csrf-token"]').attr('content'),
      url: urlAPI,
      method: methodAPI
      // payload: payloadAPI
    },
    success: res => {
      data_api = res.data;
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
        responsive: true,
        autoWidth: false,
        columns: [
          {
            data: 'job_title'
          },
          {
            data: 'job_level.level_name'
          },
          {
            data: 'job_type_employment[0].type_name'
          },
          {
            data: 'job_category'
          },
          {
            data: 'job_description'
          },
          {
            data: 'location'
          },
          {
            data: 'salary'
          },
          {
            data: 'responsibilities'
          },
          {
            data: 'skills'
          },
          {
            data: 'current_applicant'
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
            class: 'job-name',
            render: function (e, t, a, s) {
              var j = a.job_title;
              var l = a.company.company_profile.company_name;
              return j + ' at ' + l + ' Company';
            }
          },
          {
            targets: '_all',
            responsivePriority: 0
          },
          {
            targets: 2,
            render: function (e, t, a, s) {
              var d = a.job_type_employment.map(type => type.type_name).join(', ');
              return d;
            }
          },
          {
            targets: 3,
            render: function (e, t, a, s) {
              var c = a.job_category.map(category => category.category_name).join(', ');
              return c;
            }
          },
          // {
          //   targets: [1, 3, 6, 7, 8, -1],
          //   visible: !1
          //   // responsivePriority: 5
          // },
          {
            targets: 6,
            render: function (e, t, a, s) {
              var g = a.start_salary;
              var j = a.top_salary;
              return g + ' - ' + j;
            }
          },
          {
            targets: 8,
            render: function (e, t, a, s) {
              var b = a.job_required_skill.map(skill => skill.skill_name).join(', ');
              return b;
            }
          },
          {
            targets: 9,
            render: function (e, t, a, s) {
              var v = a.applied;
              var w = a.capacity;
              return v + ' people of ' + w + ' slots available';
            }
          },
          {
            targets: 10,
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
              var l = a.job_id;
              var r = 'Delete Job';

              return userRole === '1'
                ? '<a class="btn btn-danger delete-record" href="javascript:;" data-id=' + l + '>' + r + '</a>'
                : '<small>No action available</small>';
            }
          }
        ],
        order: [[2, 'desc']],
        dom: '<"card-header flex-column flex-md-row"<"head-label text-center"><"dt-action-buttons text-end pt-3 pt-md-0"B>><"row mb-2"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
        displayLength: 7,
        lengthMenu: [7, 10, 25, 50, 75, 100],
        buttons: [
          {
            extend: 'collection',
            className: 'btn btn-label-primary dropdown-toggle me-2',
            text: '<i class="bx bx-export me-sm-1"></i> <span class="d-none d-sm-inline-block">Export</span>',
            buttons: [
              {
                extend: 'print',
                text: '<i class="bx bx-printer me-1" ></i>Print',
                className: 'dropdown-item',
                exportOptions: {
                  columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
                  format: {
                    body: function (e, t, a) {
                      if (e.length <= 0) return e;
                      var s = $.parseHTML(e),
                        n = '';
                      return (
                        $.each(s, function (e, t) {
                          void 0 !== t.classList && t.classList.contains('job-name')
                            ? (n += t.lastChild.firstChild.textContent)
                            : void 0 === t.innerText
                            ? (n += t.textContent)
                            : (n += t.innerText);
                        }),
                        n
                      );
                    }
                  }
                },
                customize: function (e) {
                  $(e.document.body)
                    .css('color', config.colors.headingColor)
                    .css('border-color', config.colors.borderColor)
                    .css('background-color', config.colors.bodyBg),
                    $(e.document.body)
                      .find('table')
                      .addClass('compact')
                      .css('color', 'inherit')
                      .css('border-color', 'inherit')
                      .css('background-color', 'inherit');
                }
              },
              {
                extend: 'csv',
                text: '<i class="bx bx-file me-1" ></i>Csv',
                className: 'dropdown-item',
                exportOptions: {
                  columns: [0, 1, 2, 3, 4, 5, 6, 7, 8],
                  format: {
                    body: function (e, t, a) {
                      if (e.length <= 0) return e;
                      var s = $.parseHTML(e),
                        n = '';
                      return (
                        $.each(s, function (e, t) {
                          void 0 !== t.classList && t.classList.contains('job-name')
                            ? (n += t.lastChild.firstChild.textContent)
                            : void 0 === t.innerText
                            ? (n += t.textContent)
                            : (n += t.innerText);
                        }),
                        n
                      );
                    }
                  }
                }
              },
              {
                extend: 'excel',
                text: '<i class="bx bxs-file-export me-1"></i>Excel',
                className: 'dropdown-item',
                exportOptions: {
                  columns: [0, 1, 2, 3, 4, 5, 6, 7, 8],
                  format: {
                    body: function (e, t, a) {
                      if (e.length <= 0) return e;
                      var s = $.parseHTML(e),
                        n = '';
                      return (
                        $.each(s, function (e, t) {
                          void 0 !== t.classList && t.classList.contains('job-name')
                            ? (n += t.lastChild.firstChild.textContent)
                            : void 0 === t.innerText
                            ? (n += t.textContent)
                            : (n += t.innerText);
                        }),
                        n
                      );
                    }
                  }
                }
              },
              {
                extend: 'pdf',
                text: '<i class="bx bxs-file-pdf me-1"></i>Pdf',
                className: 'dropdown-item',
                exportOptions: {
                  columns: [0, 1, 2, 3, 4, 5, 6, 7, 8],
                  format: {
                    body: function (e, t, a) {
                      if (e.length <= 0) return e;
                      var s = $.parseHTML(e),
                        n = '';
                      return (
                        $.each(s, function (e, t) {
                          void 0 !== t.classList && t.classList.contains('job-name')
                            ? (n += t.lastChild.firstChild.textContent)
                            : void 0 === t.innerText
                            ? (n += t.textContent)
                            : (n += t.innerText);
                        }),
                        n
                      );
                    }
                  }
                }
              },
              {
                extend: 'copy',
                text: '<i class="bx bx-copy me-1" ></i>Copy',
                className: 'dropdown-item',
                exportOptions: {
                  columns: [0, 1, 2, 3, 4, 5, 6, 7, 8],
                  format: {
                    body: function (e, t, a) {
                      if (e.length <= 0) return e;
                      var s = $.parseHTML(e),
                        n = '';
                      return (
                        $.each(s, function (e, t) {
                          void 0 !== t.classList && t.classList.contains('job-name')
                            ? (n += t.lastChild.firstChild.textContent)
                            : void 0 === t.innerText
                            ? (n += t.textContent)
                            : (n += t.innerText);
                        }),
                        n
                      );
                    }
                  }
                }
              }
            ]
          }
        ],
        responsive: {
          details: {
            display: DataTable.Responsive.display.modal({
              header: function (e) {
                return 'Details of ' + e.data().job_title;
              }
            }),
            type: 'column',
            target: 'td',
            renderer: function (e, t, a) {
              var s = $.map(a, function (e, t) {
                return '' !== e.title
                  ? '<tr data-dt-row="' +
                      e.rowIndex +
                      '" data-dt-column="' +
                      e.columnIndex +
                      '"><td>' +
                      e.title +
                      ':</td> <td>' +
                      e.data +
                      '</td></tr>'
                  : '';
              }).join('');
              return !!s && $('<table class="table"/><tbody />').append(s);
            }
          }
        }
      })),
      $('div.head-label').html('<h1 class="card-title mb-3">Jobs List of Company</h1>'));
    setTimeout(() => {
      $('.dataTables_filter .form-control').removeClass('form-control-sm'),
        $('.dataTables_length .form-select').removeClass('form-select-sm');
    }, 300);
  });
})();
