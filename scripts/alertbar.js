(function (Drupal, $) {
  'use strict';
  Drupal.behaviors.alertbar = {
    attach: function (context, settings) {
      const $alertbar = $('.js-alert-bar', context);
      // On click close alert bar
      $('.js-alert-bar-close', context).click(function(e) {
        e.preventDefault();
        // Set local storage as last saved timestamp on alert bar
        window.localStorage.setItem('alertbar', $('.js-alert-bar', context).data('timestamp'));
        $alertbar.addClass('alert-bar--closed');
        $alertbar.removeClass('alert-bar--show');
      });
      
      // If last saved and localstorage are not the same, show alert bar
      if (window.localStorage.getItem('alertbar') != $('.js-alert-bar').data('timestamp').toString()) {
        $alertbar.addClass('alert-bar--show');
      }
    }
  };
})(window.Drupal, window.jQuery);
