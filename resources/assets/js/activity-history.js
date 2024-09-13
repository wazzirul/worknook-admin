'use strict';

function photo_profile(photo, fullname) {
  var photo = photo ?? null;
  var o = '';
  if (photo != '') {
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

document.getElementById('typeSelect').addEventListener('change', function () {
  var type = this.value;
  localStorage.setItem('type', type);
  window.location.replace('/activity-history');
});
document.getElementById('pageSelect').addEventListener('change', function () {
  var page = this.value;
  localStorage.setItem('entries', page);
  window.location.replace('/activity-history');
});
document.getElementById('button-search').addEventListener('click', function () {
  var search = document.getElementById('search').value;
  localStorage.setItem('search', search);

  window.location.replace('/activity-history');
});
document.getElementById('search').addEventListener('keydown', function (event) {
  if (event.key === 'Enter') {
    var search = document.getElementById('search').value;
    localStorage.setItem('search', search);
    window.location.replace('/activity-history');
  }
});
document.getElementById('button-reset').addEventListener('click', function () {
  var search = '';
  localStorage.setItem('search', search);
  window.location.replace('/activity-history');
});

(async function () {
  console.log('tes');

  const url = new URL(window.location.href);
  const params = new URLSearchParams(url.search);

  var page = params.get('page');
  var type = localStorage.getItem('type', page) ?? null;
  var entries = localStorage.getItem('entries', page) ?? null;
  var search = localStorage.getItem('search', page) ?? null;
  console.log(search);

  var type_user = '';
  if (type) {
    const selectElement = document.getElementById('typeSelect');
    selectElement.value = type;
  }
  if (entries) {
    const selectElement = document.getElementById('pageSelect');
    selectElement.value = entries;
  } else {
    entries = 10;
  }
  if (search) {
    const selectElement = document.getElementById('search');
    selectElement.value = search;
  }
  switch (type) {
    case 'all':
      type_user = '';
      break;
    case 'applicant':
      type_user = 1;
      break;
    case 'company':
      type_user = 2;
      break;
    case 'team-company':
      type_user = 3;
      break;

    default:
      type_user = '';
      break;
  }
  let urlUser = '/users-history/show';
  if (page == null) {
    urlUser = '/users-history/show';
  } else {
    urlUser = '/users-history/show?page=' + page;
  }
  let methodUser = 'POST';
  let payloadUser = {
    paginate: entries,
    type_user: type_user,
    search: search
  };

  let data = [];
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
      data = res.data;
      console.log(data);
    },
    error: err => {
      console.log('error', err);
    }
  });
  var output = '';
  var i = 0;
  data.data.forEach(function (item) {
    var isoDate = item.created_at;

    // Split the string into date and time parts
    var [datePart, timePart] = isoDate.split('T');
    var [year, month, day] = datePart.split('-');
    var [hours, minutes, seconds] = timePart.split(':');

    // Format to hhmmss ddmmyy
    var formattedDate = `${hours}:${minutes}:${seconds.slice(0, 2)} ${year}-${month}-${day}`;

    i++;
    var background = i % 2 ? '' : '#E9EAEC';
    output +=
      '<div class="col-12 border-top border-bottom border-1 border-light" style="background:' +
      background +
      '"><div class="row"><div class="col-lg-3 col-md-3 col-8 p-2 ">';
    if (item.users != null) {
      if (item.users.company_profile) {
        var icon = item.users.company_profile.company_icon ? item.users.company_profile.company_icon : '';
      }
      if (item.users.applicant_profile) {
        var icon = item.users.applicant_profile.profile_photo ? item.users.applicant_profile.profile_photo : '';
      }
      output += photo_profile(icon, item.users.fullname);
    } else {
      if (item.users_team) {
        var icon = item.users_team.team_photo ? item.users_team.team_photo : '';
      } else {
        var icon = '';
      }
      output += photo_profile(icon, item.users_team.team_name);
    }
    output += '</div><div class="col-lg-5 col-md-5 col-8 p-2 align-content-center order-4 order-md-3">';
    output += item.history;
    output += '</div> <div class="col-lg-2 col-md-2 col-4 p-2 align-content-center order-md-3 order-4">';
    switch (item.type_user) {
      case 1:
        output += 'Applicant';
        break;
      case 2:
        output += 'Company';
        break;
      case 3:
        output += 'Team Company';
        break;

      default:
        break;
    }
    output += '</div><div class="col-lg-2 col-md-2 col-4 p-2 align-content-center order-2 order-md-4">';
    output += formattedDate;
    output += '</div></div></div>';
  });
  document.getElementById('name').innerHTML = output;

  var currentPage = data.current_page,
    lastPage = data.last_page,
    perPageGroup = 5,
    currentGroup = Math.ceil(currentPage / perPageGroup),
    startPage = (currentGroup - 1) * perPageGroup + 1,
    endPage = Math.min(startPage + perPageGroup - 1, lastPage);

  console.log(currentPage, lastPage, perPageGroup, currentGroup, startPage, endPage);
  var paginateOutput = '';
  if (lastPage > 1) {
    paginateOutput += ' <ul class="pagination d-inline-flex">';
    // link ke halaman sebelumnya
    if (currentPage > 1) {
      paginateOutput += '<li class="page-item">';
      paginateOutput +=
        '<a class="page-link" href=" /activity-history?page=' + (startPage - 1) + '" aria-label="Previous">';
      paginateOutput += '<span aria-hidden="true">&laquo; Previous</span>';
      paginateOutput += '</a></li>';
    }

    //link ke halaman dalam grup
    for (i = startPage; i <= endPage; i++) {
      var active = i == currentPage ? 'active' : '';
      paginateOutput += '<li class="page-item ' + active + '">';
      paginateOutput += '<a class="page-link" href="/activity-history?page=' + i + '">' + i + '</a></li>';
    }
    //link terakhir
    if (endPage < lastPage) {
      paginateOutput += '<li class="page-item"><a class="page-link">...</a></li>';
      paginateOutput +=
        '<li class="page-item"><a class="page-link" href="/activity-history?page=' +
        lastPage +
        '">' +
        lastPage +
        '</a></li>';
    }
    //link ke grup halaman berikutnya
    if (endPage < lastPage) {
      paginateOutput +=
        '<li class="page-item"><a class="page-link" href="/activity-history?page=' +
        (endPage + 1) +
        '" aria-label="Next"><span aria-hidden="true">Next &raquo;</span></a></li>';
    }
    paginateOutput += '</ul>';
  }
  console.log(paginateOutput);
  document.getElementById('paginate').innerHTML = paginateOutput;
})();
