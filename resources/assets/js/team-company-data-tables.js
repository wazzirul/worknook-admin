'use strict';

function photo_profile(photo, fullname) {
  var photo = photo ?? null;
  if (photo != null) {
    var o = '<img src="' + photo + '" alt="Avatar" class="rounded-circle">';
  } else {
    var d = ['success', 'danger', 'warning', 'info', 'dark', 'primary', 'secondary'][Math.floor(6 * Math.random())];
    var i = fullname.match(/\b\w/g) || [];
    o =
      '<span class="avatar-initial rounded-circle bg-label-' +
      d +
      '">' +
      ((i.shift() || '') + (i.pop() || '')).toUpperCase() +
      '</span>';
  }
  var output = '<div class="d-flex justify-content-start align-items-center team-name">';
  output += '<div class="avatar-wrapper"><div class="avatar me-2">' + o + '</div></div>';
  output += '<div class="d-flex flex-column"><span class="emp_name text-truncate">' + fullname + '</span>';
  output += '</div></div>';

  return output;
}
// Request User Data
(async function () {
  let urlAPI = '/company-team/show';
  let methodAPI = 'POST';
  let payloadAPI = {
    user_id: uuid
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
      data_api = res.data;
      console.log(data_api);
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
            data: 'team_name'
          },
          {
            data: 'team_position'
          },
          {
            data: 'email'
          },
          {
            data: 'instagram'
          },
          {
            data: 'linkedin'
          },
          // {
          //   data: 'status'
          // },
          {
            data: ''
          }
        ],
        columnDefs: [
          {
            targets: 0,
            responsivePriority: 0,
            render: function (e, t, a, s) {
              var n = a.team_photo,
                r = a.team_name;

              return photo_profile(n, r);
            }
          },

          {
            targets: -1,
            title: 'Activity History',
            orderable: !1,
            searchable: !1,
            render: function (e, t, a, s) {
              var l = a.id;
              var fn = a.team_name;
              var ph = a.team_photo;
              var p = a.status;
              console.log(l);

              return true
                ? '<a class="btn btn-info item-show" href="javascript:;" data-id=' +
                    l +
                    ' data-name="' +
                    fn +
                    '" data-photo="' +
                    ph +
                    '">Show</a>'
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
                  columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
                  format: {
                    body: function (e, t, a) {
                      if (e.length <= 0) return e;
                      var s = $.parseHTML(e),
                        n = '';
                      return (
                        $.each(s, function (e, t) {
                          void 0 !== t.classList && t.classList.contains('team-name')
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
                          void 0 !== t.classList && t.classList.contains('team-name')
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
                          void 0 !== t.classList && t.classList.contains('team-name')
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
                          void 0 !== t.classList && t.classList.contains('team-name')
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
                          void 0 !== t.classList && t.classList.contains('team-name')
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
        ]
      })),
      $('div.head-label').html('<h1 class="card-title mb-3">Team List of Company</h1>'));
    setTimeout(() => {
      $('.dataTables_filter .form-control').removeClass('form-control-sm'),
        $('.dataTables_length .form-select').removeClass('form-select-sm');
    }, 300);
    // Code for modal
    $('.datatables-basic tbody').on('click', 'tr', function () {
      // Check if the tbody contains any td elements with the .dt-empty class
      if ($('.datatables-basic tbody td.dt-empty').length === 0) {
        let c = $(this).find('td');
        const d = $('.dt-column-title');
        // Select the modal data element where you want to display the values
        let modalData = $('.data-modal'); // Change this selector to your actual modal data element's ID or class

        // Clear any existing content in the modal data element
        modalData.empty();

        // Iterate over the td elements
        c.each(function (index) {
          // Check if the element inside c is an HTML element or text
          let tdContent = $(this).children().length > 0 ? $(this).html() : $(this).text();

          let dtColumnTitleText = d.eq(index).text();

          modalData.append('<tr><td>' + dtColumnTitleText + '</td><td>' + tdContent + '</td></tr>');
        });

        // Show the modal
        $('#modalDetails').modal('show');
      }
    });
  });
})();
$(document).on('click', '.item-show', function () {
  if ($.fn.DataTable.isDataTable('.datatables-history')) {
    // Jika sudah, destroy DataTable tersebut
    $('.datatables-history').DataTable().destroy();

    $('.datatables-history').DataTable({
      data: [], // Data kosong
      columns: [
        { title: 'Activity History', data: 'history' },
        { title: 'Time', data: '' },
        { title: 'Date', data: '' }
      ]
    });
  }
  $('.datatables-history').DataTable().destroy();
  $('.modal').modal('hide');
  $('#showHistory').modal('show');
  const dataId = $(this).data('id');
  const fullname = $(this).data('name');
  const photo = $(this).data('photo');
  (async function () {
    let urlAPI = '/users-history/show';
    let methodAPI = 'POST';
    let payloadAPI = {
      user_id: dataId
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
        console.log(data_api.data);
      },
      error: err => {
        console.log('error', err);
      }
    });

    $(function () {
      var s,
        h = $('.datatables-history');
      h.length &&
        ((s = h.DataTable({
          data: data_api,
          autoWidth: false,

          columns: [
            {
              data: 'history'
            },
            {
              data: 'created_at'
            },
            {
              data: 'created_at'
            }
          ],
          columnDefs: [
            {
              responsivePriority: 0,
              targets: 1,
              render: function (data, type, row) {
                return moment(data).format('HH:mm:ss'); // Adjust format as needed
              }
            },
            {
              responsivePriority: 0,
              targets: 2,
              render: function (data, type, row) {
                return moment(data).format('YYYY-MM-DD'); // Adjust format as needed
              }
            }
          ],
          dom: '<"row"<"col-sm-12 col-md-12 head-labels"><"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>'
        })),
        $('div.head-labels').html('<label class="mt-3">' + photo_profile(photo, fullname) + '</label>'));
      setTimeout(() => {
        $('.dataTables_filter .form-control').removeClass('form-control-sm'),
          $('.dataTables_length .form-select').removeClass('form-select-sm');
      }, 300);
    });
  })();
});
