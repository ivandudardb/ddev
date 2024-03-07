let mainMenuAttached = false;

Drupal.behaviors.mainMenu = {
  attach() {
    if (!mainMenuAttached) {
      mainMenuAttached = true;

      const toggleExpand = document.getElementById('toggle-expand');
      const menu = document.getElementById('main-nav');
      if (menu) {
        const expandMenu = menu.getElementsByClassName('expand-sub');

        // Mobile Menu Show/Hide.
        toggleExpand.addEventListener('click', (e) => {
          toggleExpand.classList.toggle('toggle-expand--open');
          menu.classList.toggle('main-nav--open');
          e.preventDefault();
        });

        // Expose mobile sub menu on click.
        Array.from(expandMenu).forEach((item) => {
          item.addEventListener('click', (e) => {
            const menuItem = e.currentTarget;
            const subMenu = menuItem.nextElementSibling;

            menuItem.classList.toggle('expand-sub--open');
            subMenu.classList.toggle('main-menu--sub-open');
          });
        });
      }
    }
  },
};

(function ($, Drupal, once) {
  Drupal.behaviors.backToTop = {
    attach: function (context, settings) {
      var backButton = once('backToTopButton', '.back-to-top', context)[0];
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
        $('html, body').animate({ scrollTop: 0 }, 300);
      });
    },
  };
})(jQuery, Drupal, once);
