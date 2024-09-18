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
  var output = '<div class="d-flex justify-content-start align-items-center company-name">';
  output += '<div class="avatar-wrapper"><div class="avatar me-2">' + o + '</div></div>';
  output += '<div class="d-flex flex-column"><span class="emp_name text-truncate">' + fullname + '</span>';
  output += '</div></div>';

  return output;
}
// Request User Data
(async function () {
  console.log(data_api);
  $(function () {
    var e,
      t = $('.datatables-basic');
    t.length &&
      ((e = t.DataTable({
        data: data_api,
        autoWidth: false,
        columns: [
          {
            data: 'company_profile.company_name'
          },
          {
            data: 'jobs.job_title'
          },
          {
            data: 'jobs.location'
          },
          {
            data: 'jobs.top_salary'
          },

          {
            data: 'status'
          },
          {
            data: 'updated_at'
          }
        ],
        columnDefs: [
          {
            targets: 0,
            class: 'job-name'
          },
          {
            targets: 0,
            render: function (e, t, a, s) {
              var g = a.company_profile.company_name ?? null;
              var icon = a.company_profile.company_icon ?? null;
              return photo_profile(icon, g);
            }
          },
          {
            targets: 3,
            render: function (e, t, a, s) {
              var g = a.jobs.start_salary;
              var j = a.jobs.top_salary;
              return g + ' - ' + j;
            }
          },
          {
            targets: 4,
            render: function (e, t, a, s) {
              var n = a.status,
                r = {
                  1: {
                    title: 'In-Review',
                    class: 'bg-label-secondary'
                  },
                  2: {
                    title: 'Shortlisted',
                    class: 'bg-label-secondary'
                  },
                  3: {
                    title: 'Interview',
                    class: 'bg-label-primary'
                  },
                  4: {
                    title: 'Hired',
                    class: 'bg-label-primary'
                  },
                  5: {
                    title: 'Declined',
                    class: 'bg-label-danger'
                  }
                };
              return void 0 === r[n] ? e : '<span class="badge ' + r[n].class + '">' + r[n].title + '</span>';
            }
          },

          {
            targets: 5,
            render: function (data, type, row) {
              return moment(data).format('YYYY-MM-DD HH:mm:ss'); // Adjust format as needed
            }
          }
        ],
        order: [[2, 'desc']],
        dom: '<"card-header flex-column flex-md-row"<"head-label text-center"><"dt-action-buttons text-end pt-3 pt-md-0">><"row mb-2"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
        displayLength: 7,
        lengthMenu: [7, 10, 25, 50, 75, 100]
      })),
      $('div.head-label').html('<h1 class="card-title mb-3">Jobs Applied of Candidate</h1>'));
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
