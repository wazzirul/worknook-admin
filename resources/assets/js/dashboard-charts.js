'use strict';

(async function () {
  // Function for Polar Chart / Job Types
  //   Function for fetch
  //   async function requestURI(urlAPI) {
  //     let methodAPI = 'POST';
  //     let payloadAPI = {};

  //     try {
  //       let response = await new Promise((resolve, reject) => {
  //         $.ajax({
  //           method: methodAPI,
  //           url: '/query',
  //           data: {
  //             _token: $('meta[name="csrf-token"]').attr('content'),
  //             url: urlAPI,
  //             method: methodAPI,
  //             payload: payloadAPI
  //           },
  //           success: res => {
  //             resolve(res.data);
  //           },
  //           error: err => {
  //             reject(err);
  //           }
  //         });
  //       });

  //       return response;
  //     } catch (err) {
  //       console.log('error', err);
  //       return null;
  //     }
  //   }

  //   Put URL Here
  //   const [dataLevels, dataSkills, dataCategories, dataTypes] = await Promise.all([
  //     requestURI('/job-levels/show'),
  //     requestURI('/skills/show'),
  //     requestURI('/categories/show'),
  //     requestURI('/type-employments/show')
  //   ]);

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

  // Polar Chart Initialize
  $(function () {
    var k = $('#polarChart'),
      k =
        k &&
        new Chart(k, {
          type: 'polarArea',
          data: {
            labels: ['Full Time', 'Part Time', 'Remote', 'Contract'],
            datasets: [
              {
                label: 'Total',
                backgroundColor: [primaryClr, '#00C6FF', '#F6E382', '#525FB4'],
                // Todo : Enable and replace the data after fetching
                // data: data_polar,
                data: [19, 17, 15, 13],
                borderWidth: 0
              }
            ]
          },
          options: {
            responsive: !0,
            maintainAspectRatio: !1,
            animation: {
              duration: 500
            },
            scales: {
              r: {
                ticks: {
                  display: !1,
                  color: textClr
                },
                grid: {
                  display: !1
                }
              }
            },
            plugins: {
              tooltip: {
                rtl: isRtl,
                backgroundColor: cardClr,
                titleColor: headClr,
                bodyColor: textClr,
                borderWidth: 1,
                borderColor: borderClr
              },
              legend: {
                rtl: isRtl,
                position: 'right',
                labels: {
                  usePointStyle: !0,
                  padding: 25,
                  boxWidth: 8,
                  boxHeight: 8,
                  color: textClr
                }
              }
            }
          }
        });
  });

  // Line Area Chart Initialize
  $(function () {
    var l = $('#lineAreaChart'),
      l =
        l &&
        new Chart(l, {
          type: 'line',
          data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [
              {
                label: 'Job Applied',
                data: [40, 55, 45, 75, 65, 55, 70, 60, 100, 98, 90, 120],
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
                data: [70, 85, 75, 150, 100, 140, 110, 105, 160, 150, 125, 190],
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
                max: 400,
                grid: {
                  color: 'transparent',
                  borderColor: borderClr
                },
                ticks: {
                  stepSize: 100,
                  color: textClr
                }
              }
            }
          }
        });
  });
})();
