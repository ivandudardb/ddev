(function (Drupal, once) {
  Drupal.behaviors.backToTop = {
    attach: function (context) {
      let backButtonElements = once('backToTopButton', '.footer .button-back-to-top', context);
        backButtonElements.forEach(function(backButton) {
          backButton.addEventListener('click', function (event) {
            event.preventDefault();
            window.scrollTo({ top: 0, behavior: 'smooth' });
          });
        });

      window.addEventListener('scroll', function() {
        let scrollPosition = window.pageYOffset || document.documentElement.scrollTop;
        if (scrollPosition > 100) {
          backButtonElements.forEach(function(backButton) {
            backButton.style.display = 'block';
          });
        } else {
          backButtonElements.forEach(function(backButton) {
            backButton.style.display = 'none';
          });
        }
      });
    },
  };
})(Drupal, once);
