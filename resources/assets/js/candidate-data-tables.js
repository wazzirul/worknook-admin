'use strict';

// Request User Data
(async function () {
  let urlAPI = '/admin-user/data';
  let methodAPI = 'POST';
  let payloadAPI = {
    paginate: 100
  };

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
      data_api = res.data.data;
      console.log(data_api);
      // return;
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
        autoWidth: false,
        columns: [
          {
            data: 'fullname'
          },
          {
            data: 'email'
          },
          {
            data: 'status'
          },
          {
            data: 'applicant_profile.current_working'
          },
          {
            data: 'applicant_profile.position'
          },
          {
            data: 'applicant_profile.company'
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
            render: function (e, t, a, s) {
              var n = a.applicant_profile?.profile_photo,
                r = a.fullname;
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
            targets: 2,
            render: function (e, t, a, s) {
              var n = a.status,
                r = {
                  1: {
                    title: 'Active',
                    class: 'bg-label-primary'
                  },
                  0: {
                    title: 'Inactive',
                    class: ' bg-label-danger'
                  }
                };
              return void 0 === r[n] ? e : '<span class="badge ' + r[n].class + '">' + r[n].title + '</span>';
            }
          },
          {
            targets: 3,
            render: function (e, t, a, s) {
              var n = a.applicant_profile?.current_working,
                r = {
                  1: {
                    title: 'Yes',
                    class: 'bg-label-primary'
                  },
                  0: {
                    title: 'No',
                    class: 'bg-label-danger'
                  },
                  undefined: {
                    title: 'No Data',
                    class: 'bg-label-secondary'
                  }
                };
              return void 0 === r[n] ? e : '<span class="badge ' + r[n].class + '">' + r[n].title + '</span>';
            }
          },
          {
            targets: '_all',
            responsivePriority: 0
          },
          {
            targets: 6,
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
              var l = a.user_id;
              var j = a.status;
              var k = j === 1 ? 'Deactivate' : 'Activate';
              var r = 'Delete';

              return userRole === '1'
                ? '<div class="d-flex gap-1 flex-wrap"><a class="btn btn-outline-primary" href="candidate-details/' +
                    l +
                    '">See Details</a><a class="btn btn-warning ban-user" href="javascript:;" data-id=' +
                    l +
                    ' data-banned=' +
                    j +
                    '>' +
                    k +
                    '</a><a class="btn btn-danger delete-record" href="javascript:;" data-id=' +
                    l +
                    '>' +
                    r +
                    '</a></div>'
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
          },
          {
            className: 'btn btn-primary',
            attr: {
              'data-bs-toggle': 'modal',
              'data-bs-target': '#filterModal',
              id: 'btnFilter',
              role: 'button'
            },
            text: '<i class="tf-icons bx bx-filter"></i>'
          }
        ]
      })),
      $('div.head-label').html('<h1 class="card-title mb-3">Candidates</h1>'));
    setTimeout(() => {
      $('.dataTables_filter .form-control').removeClass('form-control-sm'),
        $('.dataTables_length .form-select').removeClass('form-select-sm');
    }, 300);
    // Code for modal
    $('.datatables-basic tbody').on('click', 'tr', function () {
      let c = $(this).find('td');
      const d = $('.dt-column-title');
      // Select the modal data element where you want to display the values
      let modalData = $('.data-modal'); // Change this selector to your actual modal data element's ID or class

      // Clear any existing content in the modal data element
      modalData.empty();

      // Iterate over the td elements
      c.each(function (index) {
        // Check if the element inside c is an HTML element or text
        let tdContent;
        if ($(this).children().length > 0) {
          tdContent = $(this).html();
        } else {
          tdContent = $(this).text();
        }

        let dtColumnTitleText = d.eq(index).text();

        modalData.append('<tr><td>' + dtColumnTitleText + '</td><td>' + tdContent + '<td/></tr>');
      });
      $('#modalDetails').modal('show');
    });
  });
})();
