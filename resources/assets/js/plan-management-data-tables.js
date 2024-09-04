'use strict';

// Request User Data
(async function () {
  let urlUser = '/subscriptions/show';
  let methodUser = 'POST';
  let payloadUser = {};

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
      console.log(data_user);
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
        columns: [
          {
            data: 'name'
          },
          {
            data: 'description'
          },
          {
            data: 'post_job'
          },
          {
            data: 'interview'
          },
          {
            data: 'team_member'
          },
          {
            data: 'hire'
          },
          {
            data: 'boost_job'
          },
          {
            data: 'price'
          },
          {
            data: ''
          },
          {
            data: ''
          },
          {
            data: ''
          },
          {
            data: ''
          },
          {
            data: ''
          },
          {
            data: ''
          },
          {
            data: ''
          }
        ],
        columnDefs: [
          {
            targets: 0,
            responsivePriority: 4,
            render: function (e, t, a, s) {
              var n = a.icon,
                r = a.name,
                mp = a.most_popular;
              if (n) var o = '<img src="' + n + '" alt="Avatar" class="" style="max-width:30px;max-height:30px;">';
              else {
                var d = ['success', 'danger', 'warning', 'info', 'dark', 'primary', 'secondary'][
                    Math.floor(6 * Math.random())
                  ],
                  i = r.match(/\b\w/g) || [];
                o =
                  '<span class="avatar-initial rounded-circle bg-label-' +
                  d +
                  '" >' +
                  (i = ((i.shift() || '') + (i.pop() || '')).toUpperCase()) +
                  '</span>';
              }

              var l = mp ? '<span class="badge bg-label-primary">Most Popular</span>' : '';

              return (
                '<div class="d-flex justify-content-start align-items-center user-name"><div class="avatar-wrapper"><div class="avatar me-2">' +
                o +
                '</div></div><div class="d-flex flex-column"><span class="emp_name text-truncate">' +
                r +
                '</span>' +
                l +
                '</div></div>'
              );
            }
          },
          {
            targets: 15,
            title: 'Action',
            orderable: !1,
            searchable: !1,
            render: function (e, t, a, s) {
              var id = a.subscription_id,
                n = a.name,
                desc = a.description,
                pj = a.post_job,
                it = a.interview,
                tm = a.team_member,
                hi = a.hire,
                bj = a.boost_job,
                pr = a.price,
                st = a.status,
                mp = a.most_popular,
                apm = a.allow_application_management,
                acp = a.allow_company_profile,
                ahp = a.allow_hiring_job_post,
                aci = a.allow_calendar_integration,
                ais = a.allow_interview_scheduling,
                acs = a.allow_account_support;

              var data = 'data-id="' + id + '" ';
              data += 'data-name="' + n + '" ';
              data += 'data-desc="' + desc + '" ';
              data += 'data-pj="' + pj + '" ';
              data += 'data-it="' + it + '" ';
              data += 'data-tm="' + tm + '" ';
              data += 'data-hire="' + hi + '" ';
              data += 'data-bj="' + bj + '" ';
              data += 'data-price="' + pr + '" ';
              data += 'data-status="' + st + '" ';
              data += 'data-mp="' + mp + '" ';
              data += 'data-apm="' + apm + '" ';
              data += 'data-acp="' + acp + '" ';
              data += 'data-ahp="' + ahp + '" ';
              data += 'data-aci="' + aci + '" ';
              data += 'data-ais="' + ais + '" ';
              data += 'data-acs="' + acs + '" ';

              return userRole === '1'
                ? '<a class="btn btn-primary item-edit" href="javascript:;" ' +
                    data +
                    '>Edit</a>' +
                    ' <a class="btn btn-danger delete-record" href="javascript:;" data-id=' +
                    id +
                    '>Delete</a>'
                : '<small>Unathorized</small>';
            }
          },
          {
            targets: 14,
            title: 'Allow Application Management',
            render: function (e, t, a, s) {
              var n = a.allow_application_management,
                r = {
                  0: {
                    title: '<i class="bx bx-x-circle text-danger me-lg-2"></i>'
                  },
                  1: {
                    title: '<i class="bx bx-check-circle text-success me-lg-2"></i>'
                  }
                };

              return void 0 === r[n] ? e : '<span class="badge">' + r[n].title + '</span>';
            }
          },

          {
            targets: 13,
            title: 'Allow Company Profile',
            render: function (e, t, a, s) {
              var n = a.allow_company_profile,
                r = {
                  0: {
                    title: '<i class="bx bx-x-circle text-danger me-lg-2"></i>'
                  },
                  1: {
                    title: '<i class="bx bx-check-circle text-success me-lg-2"></i>'
                  }
                };

              return void 0 === r[n] ? e : '<span class="badge">' + r[n].title + '</span>';
            }
          },
          {
            targets: 12,
            title: 'Allow Interview Scheduling',
            render: function (e, t, a, s) {
              var n = a.allow_interview_scheduling,
                r = {
                  0: {
                    title: '<i class="bx bx-x-circle text-danger me-lg-2"></i>'
                  },
                  1: {
                    title: '<i class="bx bx-check-circle text-success me-lg-2"></i>'
                  }
                };

              return void 0 === r[n] ? e : '<span class="badge">' + r[n].title + '</span>';
            }
          },
          {
            targets: 11,
            title: 'Allow Calendar Integration',
            render: function (e, t, a, s) {
              var n = a.allow_calendar_integration,
                r = {
                  0: {
                    title: '<i class="bx bx-x-circle text-danger me-lg-2"></i>'
                  },
                  1: {
                    title: '<i class="bx bx-check-circle text-success me-lg-2"></i>'
                  }
                };

              return void 0 === r[n] ? e : '<span class="badge">' + r[n].title + '</span>';
            }
          },
          {
            targets: 10,
            title: 'Allow Hiring Job Post',
            render: function (e, t, a, s) {
              var n = a.allow_hiring_job_post,
                r = {
                  0: {
                    title: '<i class="bx bx-x-circle text-danger me-lg-2"></i>'
                  },
                  1: {
                    title: '<i class="bx bx-check-circle text-success me-lg-2"></i>'
                  }
                };

              return void 0 === r[n] ? e : '<span class="badge">' + r[n].title + '</span>';
            }
          },
          {
            targets: 8,
            title: 'Status',
            render: function (e, t, a, s) {
              var n = a.status,
                df = a.default,
                r = {
                  1: {
                    title: 'Active',
                    class: 'bg-label-primary'
                  },
                  0: {
                    title: 'Non Active',
                    class: 'bg-label-secondary'
                  }
                };
              if (df == 1) {
                r[0].title = 'Default';
              }
              return void 0 === r[n] ? e : '<span class="badge ' + r[n].class + '">' + r[n].title + '</span>';
            }
          },
          {
            targets: 9,
            title: 'Allow Account Support',
            render: function (e, t, a, s) {
              var n = a.allow_account_support,
                r = {
                  0: {
                    title: '<i class="bx bx-x-circle text-danger me-lg-2"></i>'
                  },
                  1: {
                    title: '<i class="bx bx-check-circle text-success me-lg-2"></i>'
                  }
                };

              return void 0 === r[n] ? e : '<span class="badge">' + r[n].title + '</span>';
            }
          },
          {
            targets: 7,
            render: function (data, type, row) {
              var output = '$ ' + data;
              return output; // Adjust format as needed
            }
          }
        ],
        order: [[2, 'desc']],
        dom: '<"card-header flex-column flex-md-row"<"head-label text-center"><"dt-action-buttons text-end pt-3 pt-md-0"B>><"row mb-2"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
        displayLength: 7,
        lengthMenu: [7, 10, 25, 50, 75, 100],
        buttons: [],
        // Add the "create-new" button conditionally
        initComplete: function (settings, json) {
          // Append the button to the appropriate DOM element (adjust as needed)
          $('.dt-action-buttons').append(
            '<button type="button" class="create-new btn btn-primary"><i class="bx bx-plus me-sm-1"></i> <span class="d-none d-sm-inline-block">Add new Subscription</span></button>'
          );
        }
      })),
      $('div.head-label').html('<h1 class="card-title mb-3">Subscriptions</h1>'));
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

        // Clear any existing content in the modal data element
        modalData.empty();

        // Iterate over the td elements
        c.each(function (index) {
          if (index == 0) {
            let tdContent = $(this).children().length > 0 ? $(this).html() : $(this).text();
            $('#modalCenterTitle').html(tdContent);
          }
          if (index > 8) {
            // Check if the element inside c is an HTML element or text
            let tdContent = $(this).children().length > 0 ? $(this).html() : $(this).text();
            let dtColumnTitleText = d.eq(index).text();

            modalData.append('<tr><td>' + dtColumnTitleText + '</td><td>' + tdContent + '</td></tr>');
          }
        });

        // Show the modal
        $('#modalDetails').modal('show');
      }
    });
  });
})();

$(document).on('click', '.create-new, .item-edit', function () {
  const modal = $('#addPlanModal');
  const url = '/plan-subscriptions/store';
  //Validasi Input Required
  document.getElementById('myForm').addEventListener('submit', function (event) {
    if (!this.checkValidity()) {
      event.preventDefault();
    } else {
      loaderFunc();
    }
  });

  if (modal.length) {
    if ($(this).hasClass('create-new')) {
      modal.find('#subscriptionId').val('');
      modal.find('#planName').val('');
      modal.find('#postJob').val('');
      modal.find('#interview').val('');
      modal.find('#teamMember').val('');
      modal.find('#Hire').val('');
      modal.find('#boostJob').val('');
      modal.find('#price').val('');
      modal.find('#descPlan').val('');

      modal.find('#checkStatus').prop('checked', false);
      modal.find('#checkMostPopular').prop('checked', false);
      modal.find('#checkApplicationManagement').prop('checked', false);
      modal.find('#checkCompanyProfile').prop('checked', false);
      modal.find('#checkInterviewScheduling').prop('checked', false);
      modal.find('#checkCalendarIntegration').prop('checked', false);
      modal.find('#checkHiringJobPost').prop('checked', false);
      modal.find('#checkAccountSupport').prop('checked', false);
      modal.find('#addPlanModalLabel').text('Add new Subscription');
      modal.find('#buttonModal').text('Add Subscription');
    } else {
      const data = $(this).data();
      const id = decodeURIComponent(data.id);
      const status = data.status ? true : false;
      const most_popular = data.mp ? true : false;
      const apm = data.apm ? true : false;
      const acp = data.acp ? true : false;
      const ahp = data.ahp ? true : false;
      const aci = data.aci ? true : false;
      const ais = data.ais ? true : false;
      const acs = data.acs ? true : false;

      modal.find('#subscriptionId').val(id);
      modal.find('#planName').val(data.name);
      modal.find('#postJob').val(data.pj);
      modal.find('#interview').val(data.it);
      modal.find('#teamMember').val(data.tm);
      modal.find('#Hire').val(data.hire);
      modal.find('#boostJob').val(data.bj);
      modal.find('#price').val(data.price);
      modal.find('#descPlan').val(data.desc);

      modal.find('#checkStatus').prop('checked', status);
      modal.find('#checkMostPopular').prop('checked', most_popular);
      modal.find('#checkApplicationManagement').prop('checked', apm);
      modal.find('#checkCompanyProfile').prop('checked', acp);
      modal.find('#checkInterviewScheduling').prop('checked', ais);
      modal.find('#checkCalendarIntegration').prop('checked', aci);
      modal.find('#checkHiringJobPost').prop('checked', ahp);
      modal.find('#checkAccountSupport').prop('checked', acs);

      modal.find('#addPlanModalLabel').text('Edit Plan');
      modal.find('#buttonModal').text('Edit Plan');
    }

    modal.find('form').attr('action', url);
    modal.modal('show');
  }
});
