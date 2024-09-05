'use strict';

// Request User Data
(async function () {
  let urlAPI = '/blog/show';
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
      t = $('.datatables-basic');
    t.length &&
      ((e = t.DataTable({
        data: data_api,
        autoWidth: false,
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
          },
          {
            data: ''
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
          },
          {
            targets: -1,
            title: 'Actions',
            orderable: !1,
            searchable: !1,
            render: function (e, t, a, s) {
              var l = a.blog_id;
              return userRole === '1'
                ? '<div class="d-flex gap-1 flex-wrap"><a class="btn btn-outline-primary" href="blog-details/' +
                    l +
                    '">Blog Details</a></div>'
                : '<small>Unathorized</small>';
            }
          }
        ],
        order: [[2, 'desc']],
        dom: '<"card-header flex-column flex-md-row"<"head-label text-center"><"dt-action-buttons text-end pt-3 pt-md-0">><"row mb-2"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
        displayLength: 7,
        lengthMenu: [7, 10, 25, 50, 75, 100],

        // Add the "create-new" button conditionally
        initComplete: function (settings, json) {
          if (userRole === '1') {
            // Append the button to the appropriate DOM element (adjust as needed)
            $('.dt-buttons').append(
              '<button type="button" class="create-new btn btn-primary ms-2" data-bs-toggle="modal" data-bs-target="#addBlogModal"><i class="bx bx-plus me-sm-1"></i></button>'
            );
          }
        }
      })),
      $('div.head-label').html('<h1 class="card-title mb-3">Blog List</h1>'));
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
    // Filter Function
    // Function to handle radio button changes
    $('input[name="filterCat"]').on('change', function (e) {
      var category = $(this).next('label').text().trim();
      var searchValue = category === 'All' ? '' : category; // Set search value for 'All' to empty string

      $('.datatables-basic').DataTable().column(3).search(searchValue).draw();
    });

    // $('.status-dropdown').on('change', function (e) {
    //   var category = $(this).val();
    //   $('.status-dropdown').val(category);
    //   $('.datatables-basic').DataTable().column(3).search(category).draw();
    // });
  });
})();
