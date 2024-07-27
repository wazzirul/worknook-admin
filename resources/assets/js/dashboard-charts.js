'use strict';

(async function () {
  // Function for Polar Chart / Job Types
  //   Function for fetch
  async function requestURI(urlAPI) {
    let methodAPI = 'POST';
    let payloadAPI = {
      filter: '3'
    };

    try {
      let response = await new Promise((resolve, reject) => {
        $.ajax({
          method: methodAPI,
          url: '/query',
          data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            url: urlAPI,
            method: methodAPI,
            payload: payloadAPI
          },
          success: res => {
            resolve(res.data);
          },
          error: err => {
            reject(err);
          }
        });
      });

      return response;
    } catch (err) {
      console.log('error', err);
      return null;
    }
  }

  // Put URL Here
  let [dataJobStat, dataJobType] = await Promise.all([
    requestURI('/admin-dashboard/job-statistics'),
    requestURI('/admin-dashboard/job-categories-statistics')
  ]);
  let dataJobStatistics = [];

  //ngecek object
  function isObject(value) {
    return typeof value === 'object' && value !== null && !Array.isArray(value);
  }
  //Mengubah Object jadi Array
  if (isObject(dataJobStat)) {
    dataJobStatistics.push(dataJobStat);
  } else {
    dataJobStatistics = dataJobStat;
  }
  console.log(dataJobStatistics);
  var dataList = document.getElementById('dataList');

  //dropdown ITEM
  dataJobStatistics.forEach(function (item) {
    // Membuat elemen <li> baru
    var listItem = document.createElement('li');
    var data = new Date(item.start_date).getFullYear();
    listItem.textContent = data;
    listItem.classList.add('dropdown-item');
    listItem.classList.add('dropdown-item', 'd-flex', 'align-items-center');
    listItem.setAttribute('data-year', data);
    // Menambahkan elemen <li> ke dalam <ul>
    dataList.appendChild(listItem);
  });
  // }
  var labels = [];
  var data = [];

  dataJobType.forEach(function (item) {
    //key mengambil data nama
    for (var key in item) {
      //check properti
      if (item.hasOwnProperty(key)) {
        labels.push(key);
        data.push(item[key]);
      }
    }
  });

  var MonthNow = [];
  var job_applied = [];
  var job_posted = [];
  var none = 0;
  var Month = 12;
  var dataYear = [];
  var listMonth = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

  let yearNow = new Date().getFullYear();
  var dataYear = [];

  function DataMonthNow() {
    Month = new Date().getMonth();
    MonthNow = [];
    //bulan berdasarkan tahun ini
    for (let i = 0; i <= Month; i++) {
      MonthNow.push(listMonth[i]);
    }
    return MonthNow;
  }

  //Mengambil data
  function DataYearsNow(year) {
    if (year == yearNow) {
      DataMonthNow();
    } else {
      MonthNow = listMonth;
      Month = 12;
    }
    job_applied = [];
    job_posted = [];
    var dataMonth = [];
    none = 0;
    listMonth.slice(0, Month + 1).forEach((list, i) => {
      dataMonth = FilterMonth(list, year);
      console.log(dataMonth);
      if (dataMonth) {
        job_applied.push(dataMonth[0].job_applied);
        job_posted.push(dataMonth[0].job_posted);
      } else {
        job_applied.push(none);
        job_posted.push(none);
      }
    });
  }

  DataYearsNow(yearNow);

  function filterYear(year, array) {
    var data;
    data = array.filter(p => new Date(p.start_date).getFullYear() == year);
    return data;
  }

  //filter data berdasarkan bulan
  function FilterMonth(month, year) {
    dataYear = filterYear(year, dataJobStatistics);
    var data = dataYear[0].statistics.filter(p => p.label === month);

    if (data.length === 0) {
      data = 0;
    }
    return data;
  }

  console.log(MonthNow);

  // Variable Definition
  let cardClr, headClr, textClr, bodyClr, borderClr, primaryClr, secondaryClr, isRtl;
  isRtl = false;
  borderClr = ((cardClr = config.colors.cardColor),
  (headClr = config.colors.headingColor),
  (textClr = config.colors.textColor),
  (bodyClr = config.colors.bodyColor),
  (primaryClr = config.colors.primaryColor),
  (secondaryClr = config.colors.secondaryColor),
  config.colors).borderColor;
  document.querySelectorAll('.chartjs').forEach(function (o) {
    o.height = o.dataset.height;
  });

  // Doughnut Chart Initialize
  const colors = [primaryClr, '#00C6FF', '#F6E382', '#525FB4', '#D1FAE0', '#DEB887', '#B43C2F'];
  $(function () {
    var k = $('#doughnutChart'),
      k =
        k &&
        new Chart(k, {
          type: 'doughnut',
          data: {
            labels: labels,
            label: 'sjs',
            datasets: [
              {
                data: data,
                backgroundColor: colors,
                // Todo : Enable and replace the data after fetching
                // data: data_polar,
                borderWidth: 0,
                pointStyle: 'rectRounded'
              }
            ]
          },
          options: {
            maintainAspectRatio: false,
            responsive: !0,
            animation: {
              duration: 500
            },
            cutout: '68%',
            plugins: {
              legend: {
                display: 1,
                position: 'bottom'
              },
              tooltip: {
                callbacks: {
                  label: function (o) {
                    return ' ' + (o.labels || '') + ' : ' + o.parsed;
                  }
                },
                rtl: isRtl,
                backgroundColor: cardClr,
                titleColor: headClr,
                bodyColor: textClr,
                borderWidth: 1,
                borderColor: borderClr
              }
            }
          }
        });
  });

  // Line Area Chart Initialize
  $(function () {
    var l = $('#lineAreaChart');
    let myChart = new Chart(l, {
      type: 'line',
      data: {
        labels: MonthNow,
        datasets: [
          {
            label: 'Job Applied',
            data: job_applied,
            // Todo : Enable and replace the data after fetching
            // Todo : Data must have array of per month
            // data: data_job_applied,
            tension: 0,
            fill: !0,
            backgroundColor: primaryClr,
            pointStyle: 'circle',
            borderColor: 'transparent',
            pointRadius: 0.5,
            pointHoverRadius: 5,
            pointHoverBorderWidth: 5,
            pointBorderColor: 'transparent',
            pointHoverBackgroundColor: primaryClr,
            pointHoverBorderColor: '#ababca'
          },
          {
            label: 'Job Posted',
            data: job_posted,
            // Todo : Enable and replace the data after fetching
            // Todo : Data must have array of per month
            // Todo : If 2024 now is still on July, the month appear only from 2024 Jan - July
            // data: data_job_posted,
            tension: 0,
            fill: !0,
            backgroundColor: secondaryClr,
            pointStyle: 'circle',
            borderColor: 'transparent',
            pointRadius: 0.5,
            pointHoverRadius: 5,
            pointHoverBorderWidth: 5,
            pointBorderColor: 'transparent',
            pointHoverBackgroundColor: secondaryClr,
            pointHoverBorderColor: '#ceceab'
          }
        ]
      },
      options: {
        responsive: !0,
        maintainAspectRatio: !1,
        plugins: {
          legend: {
            position: 'top',
            rtl: isRtl,
            align: 'start',
            labels: {
              usePointStyle: !0,
              padding: 35,
              boxWidth: 6,
              boxHeight: 6,
              color: textClr
            }
          },
          tooltip: {
            rtl: isRtl,
            backgroundColor: bodyClr,
            titleColor: headClr,
            bodyColor: textClr,
            borderWidth: 1,
            borderColor: borderClr
          }
        },
        scales: {
          x: {
            grid: {
              color: 'transparent',
              borderColor: borderClr
            },
            ticks: {
              color: textClr
            }
          },
          y: {
            min: 0,
            max: 100,
            grid: {
              color: 'transparent',
              borderColor: borderClr
            },
            ticks: {
              stepSize: 10,
              color: textClr
            }
          }
        }
      }
    });
    function refreshChartData(year) {
      // Data baru
      listMonth = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
      if (yearNow == year) {
        listMonth = DataMonthNow();
      }
      DataYearsNow(year);

      // Update data pada dataset
      myChart.data.labels = listMonth;
      myChart.data.datasets[0].data = job_applied;
      myChart.data.datasets[1].data = job_posted;
      // Perbarui grafik
      myChart.update();
    }

    document.querySelectorAll('.dropdown-item').forEach(function (item) {
      item.addEventListener('click', function () {
        var year = this.getAttribute('data-year');
        setTimeout(refreshChartData(year), 2000);
      });
    });
  });
})();
