(function ($, Drupal, once) {
  Drupal.behaviors.backToTop = {
    attach: function (context, settings) {
      var backButton = once('backToTopButton', '.font-container', context)[0];
      $(backButton).hide();
      $(window, context).on('scroll', function() {
        var scrollPosition = $(window).scrollTop();

        if (scrollPosition > 100) {
          $(backButton).fadeIn();
        } else {
          $(backButton).fadeOut();
        }
      });

      $(backButton).on('click', function (event) {
        event.preventDefault();
        $('html, body').animate({ scrollTop: 0 }, 1000);
      });
    },
  };
})(jQuery, Drupal, once);
