'use strict';

// Request User Data
(async function () {
  let urlUser = '/company/show';
  let methodUser = 'POST';
  let payloadUser = {
    status: '2'
  };

  let data_user = [];

  await $.ajax({
    method: 'POST',
    url: '/query',
    data: {
      _token: $('meta[name="csrf-token"]').attr('content'),
      url: urlUser,
      method: methodUser,
      payload: payloadUser
    },
    success: res => {
      data_user = res.data;
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
        data: data_user,
        // responsive: true,
        autoWidth: false,
        columns: [
          {
            data: 'company_profile.company_name'
          },
          {
            data: 'founder'
          },
          {
            data: 'company_profile.email'
          },
          // {
          //   data: 'industry'
          // },
          // {
          //   data: 'location'
          // },
          {
            data: 'company_profile.employees'
          },
          {
            data: 'created_at'
          },
          {
            data: 'status'
          },
          {
            data: 'description'
          },
          {
            data: ''
          }
        ],
        columnDefs: [
          {
            targets: 0,
            responsivePriority: 0,
            render: function (e, t, a, s) {
              var n = a.company_profile.company_icon,
                r = a.company_profile.company_name,
                l = a.company_profile.website;

              if (n) {
                var o = '<img src="' + n + '" alt="Avatar" class="rounded-circle">';
              } else {
                var d = ['success', 'danger', 'warning', 'info', 'dark', 'primary', 'secondary'][
                  Math.floor(6 * Math.random())
                ];
                var i = (r = a.fullname).match(/\b\w/g) || [];
                o =
                  '<span class="avatar-initial rounded-circle bg-label-' +
                  d +
                  '">' +
                  ((i.shift() || '') + (i.pop() || '')).toUpperCase() +
                  '</span>';
              }

              var output = '<div class="d-flex justify-content-start align-items-center company-name">';
              output += '<div class="avatar-wrapper"><div class="avatar me-2">' + o + '</div></div>';
              output += '<div class="d-flex flex-column"><span class="emp_name text-truncate">' + r + '</span>';

              // Conditionally add website link if `l` is not null
              if (l !== null && l !== undefined) {
                output +=
                  '<a target="_blank" href="http://' +
                  l +
                  '"><small class="emp_post text-truncate text-muted">' +
                  l +
                  '</small></a>';
              }

              output += '</div></div>';

              return output;
            }
          },
          // {
          //   targets: 3,
          //   visible: !1
          // },
          // {
          //   targets: 6,
          //   visible: !1
          // },
          // {
          //   targets: 7,
          //   visible: !1
          // },
          {
            responsivePriority: 0,
            targets: 4,
            render: function (data, type, row) {
              return moment(data).format('YYYY-MM-DD'); // Adjust format as needed
            }
          },
          {
            responsivePriority: 0,
            targets: 1,
            render: function (e, t, a, s) {
              var p = a.fullname;
              return p;
            }
          },
          {
            targets: 5,
            responsivePriority: 0,
            render: function (e, t, a, s) {
              var n = a.soft_delete,
                r = {
                  0: {
                    title: 'Permitted',
                    class: 'bg-label-primary'
                  },
                  1: {
                    title: 'Banned',
                    class: ' bg-label-danger'
                  }
                };
              return void 0 === r[n] ? e : '<span class="badge ' + r[n].class + '">' + r[n].title + '</span>';
            }
          },
          {
            targets: 6,
            render: function (e, t, a, s) {
              var g = a.company_profile.description;
              return g;
            }
          },
          {
            targets: -2,
            render: function (e, t, a, s) {}
          },
          {
            targets: -1,
            title: 'Actions',
            orderable: !1,
            searchable: !1,
            render: function (e, t, a, s) {
              var l = a.user_id;
              var s = a.soft_delete;
              var x = s === 1 ? 'Remove Ban' : 'Ban Company';
              return userRole === '1'
                ? '<div class="d-flex gap-1"><a class="btn btn-outline-primary" href="company-details/' +
                    l +
                    '">See Jobs</a><a class="btn btn-danger delete-record" href="javascript:;" data-id=' +
                    l +
                    ' data-banned=' +
                    s +
                    '>' +
                    x +
                    '</a></div>'
                : '<small>Unathorized</small>';
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
                  columns: [0, 1, 2, 3, 4, 5, 6],
                  format: {
                    body: function (e, t, a) {
                      if (e.length <= 0) return e;
                      var s = $.parseHTML(e),
                        n = '';
                      return (
                        $.each(s, function (e, t) {
                          void 0 !== t.classList && t.classList.contains('company-name')
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
                  columns: [0, 1, 2, 3, 4, 5, 6],
                  format: {
                    body: function (e, t, a) {
                      if (e.length <= 0) return e;
                      var s = $.parseHTML(e),
                        n = '';
                      return (
                        $.each(s, function (e, t) {
                          void 0 !== t.classList && t.classList.contains('company-name')
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
                  columns: [0, 1, 2, 3, 4, 5, 6],
                  format: {
                    body: function (e, t, a) {
                      if (e.length <= 0) return e;
                      var s = $.parseHTML(e),
                        n = '';
                      return (
                        $.each(s, function (e, t) {
                          void 0 !== t.classList && t.classList.contains('company-name')
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
                  columns: [0, 1, 2, 3, 4, 5, 6],
                  format: {
                    body: function (e, t, a) {
                      if (e.length <= 0) return e;
                      var s = $.parseHTML(e),
                        n = '';
                      return (
                        $.each(s, function (e, t) {
                          void 0 !== t.classList && t.classList.contains('company-name')
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
                  columns: [0, 1, 2, 3, 4, 5, 6],
                  format: {
                    body: function (e, t, a) {
                      if (e.length <= 0) return e;
                      var s = $.parseHTML(e),
                        n = '';
                      return (
                        $.each(s, function (e, t) {
                          void 0 !== t.classList && t.classList.contains('company-name')
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
                return 'Details of ' + e.data().company_profile.company_name;
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
      $('div.head-label').html('<h1 class="card-title mb-3">Company Management</h1>'));
    setTimeout(() => {
      $('.dataTables_filter .form-control').removeClass('form-control-sm'),
        $('.dataTables_length .form-select').removeClass('form-select-sm');
    }, 300);
  });
})();
