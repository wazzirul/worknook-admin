'use strict';

function photo_profile(photo, name) {
  var r = name;
  var n = photo;
  if (n) var o = '<img src="' + n + '" alt="Avatar" class="p-1" >';
  else {
    var d = ['success', 'danger', 'warning', 'info', 'dark', 'primary', 'secondary'][Math.floor(6 * Math.random())],
      i = r.match(/\b\w/g) || [];
    o =
      '<span class="avatar-initial rounded-circle bg-label-' +
      d +
      '" >' +
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
// Request User Data
(async function () {
  let urlUser = '/subscriptions/transaction/show';
  let methodUser = 'POST';
  let payloadUser = {};

  let data_user = [];

  let dataIn = [];

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
      console.log(data_user);
    },
    error: err => {
      console.log('error', err);
    }
  });

  const dataPayment = data_user.filter(item => {
    return item.status == 2;
  });

  dataIn = dataPayment;

  $(function () {
    var e,
      t = $('.datatables-basic');
    t.length &&
      ((e = t.DataTable({
        data: dataIn,
        columns: [
          {
            data: 'users.fullname'
          },
          {
            data: 'subscriptions.name'
          },
          {
            data: 'subscriptions.name'
          },
          {
            data: 'price'
          },

          {
            data: 'status'
          },
          {
            data: 'created_at'
          }
        ],
        columnDefs: [
          {
            targets: 0,
            responsivePriority: 4,
            render: function (e, t, a, s) {
              var n = '',
                r = a.users.fullname;
              return photo_profile(n, r);
            }
          },
          {
            targets: 1,
            render: function (e, t, a, s) {
              var su = a.subscriptions;
              if (su) {
                var n = a.subscriptions.icon,
                  r = a.subscriptions.name;
                return photo_profile(n, r);
              } else {
                return '-';
              }
            }
          },
          {
            targets: 2,
            render: function (data, type, row) {
              return data ? 'Subscription' : 'Alacarte'; // Adjust format as needed
            }
          },
          {
            targets: 3,
            render: function (data, type, row) {
              return '$' + data; // Adjust format as needed
            }
          },
          {
            targets: 4,
            render: function (data, type, row) {
              var n = data,
                r = {
                  1: {
                    title: 'Waiting Payment',
                    class: 'bg-label-warning'
                  },
                  2: {
                    title: 'Payment Completed',
                    class: ' bg-label-primary'
                  },
                  3: {
                    title: 'Approved',
                    class: ' bg-label-primary'
                  },
                  4: {
                    title: 'Declined',
                    class: ' bg-label-secondary'
                  },
                  5: {
                    title: 'Cancelled',
                    class: ' bg-label-danger'
                  }
                };
              return void 0 === r[n] ? e : '<span class="badge ' + r[n].class + '">' + r[n].title + '</span>';
            }
          },
          {
            targets: 5,
            render: function (data, type, row) {
              return moment(data).format('HH:mm:ss YYYY-MM-DD'); // Adjust format as needed
            }
          },

          // {
          //   targets: 14,
          //   title: 'Allow Application Management',
          //   render: function (e, t, a, s) {
          //     var n = a.allow_application_management,
          //       r = {
          //         0: {
          //           title: '<i class="bx bx-x-circle text-danger me-lg-2"></i>'
          //         },
          //         1: {
          //           title: '<i class="bx bx-check-circle text-success me-lg-2"></i>'
          //         }
          //       };

          //     return void 0 === r[n] ? e : '<span class="badge">' + r[n].title + '</span>';
          //   }
          // },

          // {
          //   targets: 13,
          //   title: 'Allow Company Profile',
          //   render: function (e, t, a, s) {
          //     var n = a.allow_company_profile,
          //       r = {
          //         0: {
          //           title: '<i class="bx bx-x-circle text-danger me-lg-2"></i>'
          //         },
          //         1: {
          //           title: '<i class="bx bx-check-circle text-success me-lg-2"></i>'
          //         }
          //       };

          //     return void 0 === r[n] ? e : '<span class="badge">' + r[n].title + '</span>';
          //   }
          // },
          // {
          //   targets: 12,
          //   title: 'Allow Interview Scheduling',
          //   render: function (e, t, a, s) {
          //     var n = a.allow_interview_scheduling,
          //       r = {
          //         0: {
          //           title: '<i class="bx bx-x-circle text-danger me-lg-2"></i>'
          //         },
          //         1: {
          //           title: '<i class="bx bx-check-circle text-success me-lg-2"></i>'
          //         }
          //       };

          //     return void 0 === r[n] ? e : '<span class="badge">' + r[n].title + '</span>';
          //   }
          // },
          // {
          //   targets: 11,
          //   title: 'Allow Calendar Integration',
          //   render: function (e, t, a, s) {
          //     var n = a.allow_calendar_integration,
          //       r = {
          //         0: {
          //           title: '<i class="bx bx-x-circle text-danger me-lg-2"></i>'
          //         },
          //         1: {
          //           title: '<i class="bx bx-check-circle text-success me-lg-2"></i>'
          //         }
          //       };

          //     return void 0 === r[n] ? e : '<span class="badge">' + r[n].title + '</span>';
          //   }
          // },
          // {
          //   targets: 10,
          //   title: 'Allow Hiring Job Post',
          //   render: function (e, t, a, s) {
          //     var n = a.allow_hiring_job_post,
          //       r = {
          //         0: {
          //           title: '<i class="bx bx-x-circle text-danger me-lg-2"></i>'
          //         },
          //         1: {
          //           title: '<i class="bx bx-check-circle text-success me-lg-2"></i>'
          //         }
          //       };

          //     return void 0 === r[n] ? e : '<span class="badge">' + r[n].title + '</span>';
          //   }
          // },
          // {
          //   targets: 8,
          //   title: 'Status',
          //   render: function (e, t, a, s) {
          //     var n = a.status,
          //       df = a.default,
          //       r = {
          //         1: {
          //           title: 'Active',
          //           class: 'bg-label-primary'
          //         },
          //         0: {
          //           title: 'Non Active',
          //           class: 'bg-label-secondary'
          //         }
          //       };
          //     if (df == 1) {
          //       r[0].title = 'Default';
          //     }
          //     return void 0 === r[n] ? e : '<span class="badge ' + r[n].class + '">' + r[n].title + '</span>';
          //   }
          // },
          {
            targets: 6,
            title: 'Alacarte Post Job',
            render: function (e, t, a, s) {
              var n = a.subscriptions;

              return n ? '-' : a.alacarte_post_job ? a.alacarte_post_job + ' / month' : '-';
            }
          },
          {
            targets: 7,
            title: 'Alacarte Post Boost',
            render: function (e, t, a, s) {
              var n = a.subscriptions;

              return n ? '-' : a.alacarte_boost_job ? a.alacarte_boost_job + ' / month' : '-';
            }
          },
          {
            targets: 8,
            title: 'Alacarte Team Member',
            render: function (e, t, a, s) {
              var n = a.subscriptions;

              return n ? '-' : a.alacarte_team_member ? a.alacarte_team_member + ' / month' : '-';
            }
          },
          {
            targets: 9,
            title: 'Alacarte Interview',
            render: function (e, t, a, s) {
              var n = a.subscriptions;
              return n ? '-' : a.alacarte_interview ? a.alacarte_interview + ' / month' : '-';
            }
          },
          {
            targets: 10,
            title: 'Alacarte Hire',
            render: function (e, t, a, s) {
              var n = a.subscriptions;

              return n ? '-' : a.alacarte_hire ? a.alacarte_hire + ' / month' : '-';
            }
          },
          {
            targets: 11,
            title: 'Note',
            render: function (e, t, a, s) {
              var n = a.note;

              return n;
            }
          },
          {
            targets: 12,
            title: 'Action',
            orderable: !1,
            searchable: !1,
            render: function (e, t, a, s) {
              var id = a.user_transaction_id;

              return true
                ? '<a class="btn btn-primary item-approve" href="javascript:;" data-id="' +
                    id +
                    '" data-status="3">Approve</a>' +
                    ' <a class="btn btn-danger decline-record" href="javascript:;" data-id=' +
                    id +
                    ' data-status="4">Decline</a>'
                : '<small>Unathorized</small>';
            }
          },
          {
            targets: 2,
            render: function (data, type, row) {
              var output = '$ ' + data;
              return output; // Adjust format as needed
            }
          }
        ],
        order: [[2, 'asc']],
        dom: '<"card-header flex-column flex-md-row"<"head-label text-center"><" text-end pt-3 pt-md-0">><"row mb-2"<"dt-action-buttons col-sm-12 col-md-8"l><"col-sm-12 col-md-4 d-flex justify-content-center justify-content-md-end"f>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',

        displayLength: 7,
        lengthMenu: [7, 10, 25, 50, 75, 100],
        // Add the "create-new" button conditionally
        initComplete: function (settings, json) {
          // Append the button to the appropriate DOM element (adjust as needed)
          $('.dt-action-buttons').append(
            '<ul class="nav " id="myTab" role="tablist">' +
              '<li class="nav-item" role="presentation">' +
              '<button class="nav-link btn-item" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true" data-status="1">Waiting Payment</button>' +
              '</li>' +
              '<li class="nav-item" role="presentation">' +
              '<button class="nav-link btn-item active" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false"data-status="2">Need Approval<span class="badge rounded-circle bg-danger text-white ms-1">' +
              dataPayment.length +
              '</span></button>' +
              '</li>' +
              '<li class="nav-item" role="presentation">' +
              '<button class="nav-link btn-item" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false"data-status="3">Approve</button>' +
              '</li>' +
              '<li class="nav-item" role="presentation">' +
              '<button class="nav-link btn-item" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false"data-status="4">Decline</button>' +
              '</li>' +
              '<li class="nav-item" role="presentation">' +
              '<button class="nav-link btn-item" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false"data-status="5">Cancelled</button>' +
              '</li>' +
              '</ul>'
          );
        }
      })),
      $('div.head-label').html('<h1 class="card-title mb-3">Transaction</h1>'));
    setTimeout(() => {
      $('.dataTables_filter .form-control').removeClass('form-control-sm'),
        $('.dataTables_length .form-select').removeClass('form-select-sm');
    }, 300);
    $('.datatables-basic tbody').on('click', 'tr', function () {
      // Check if the tbody contains any td elements with the .dt-empty class
      if ($('.datatables-basic tbody td.dt-empty').length === 0) {
        let c = $(this).find('td');
        const d = $('.dt-column-title');
        // Select the modal data element where you want to display the values
        let modalData = $('.data-modal'); // Change this selector to your actual modal data element's ID or class
        let plan = '';
        let subs = '';
        let status = '';
        // Clear any existing content in the modal data element
        modalData.empty();

        // Iterate over the td elements
        c.each(function (index) {
          let tdContent = $(this).children().length > 0 ? $(this).html() : $(this).text();
          let dtColumnTitleText = d.eq(index).text();
          function contents(column, content) {
            return '<tr><td>' + column + '</td><td>' + content + '</td></tr>';
          }
          let content = contents(dtColumnTitleText, tdContent);
          // tmp subscription name
          if (index == 1) {
            subs = $(this).text();
          }
          // tmp status
          if (index == 4) {
            status = $(this).text();
          }
          //show name of company
          if (index == 0) {
            $('#modalCenterTitle').html(tdContent);
          }
          // show data plan
          if (index == 2) {
            plan = tdContent;
            subs = plan == 'Subscription' ? ' / ' + subs : '';
            modalData.append(contents(dtColumnTitleText, tdContent + subs));
          }
          // show data price and show action approve or decline
          if (index == 3 || (index == 12 && status == 'Payment Completed')) {
            modalData.append(content);
          }
          // show description subscription or alacarte
          if (plan == 'Subscription') {
            if (index > 10 && index < 12) {
              modalData.append(content);
            }
          } else {
            if (index > 5 && index < 12) {
              modalData.append(content);
            }
          }
        });

        // Show the modal
        $('#modalDetails').modal('show');
      }
    });

    $(document).on('click', '.btn-item', function () {
      var status = $(this).data('status');
      const data = data_user.filter(item => {
        return item.status == status;
      });
      e.clear(); // Menghapus semua data di tabel
      e.rows.add(data); // Menambahkan data baru ke tabel
      e.draw();
    });
  });
})();
