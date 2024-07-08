'use strict';

function loaderFunc() {
  console.log('loader loaded');
  const spinner = $(
    '<div class="spinner-bg"><div id="loadingSpinner" class="spinner-border spinner-border-lg text-primary"></div></div>'
  ).appendTo('body');
  $('body').addClass('disable-interaction');
}
