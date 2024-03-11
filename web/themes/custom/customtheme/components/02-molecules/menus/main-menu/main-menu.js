(function (Drupal, once) {
  Drupal.behaviors.mainMenu = {
    attach(context) {
      const mobileContainers = once('mobileContainer', '.mobile_container', context);
      if (!mobileContainers.length) {
        return;
      }

      mobileContainers.forEach(container => {
        const toggleExpands = container.querySelectorAll('.toggle-expand');
        const menus = container.querySelectorAll('.main-nav');

        if (!toggleExpands.length || !menus.length || toggleExpands.length !== menus.length) {
          return;
        }

        toggleExpands.forEach((toggleExpand, index) => {
          toggleExpand.addEventListener('click', (e) => {
            e.preventDefault();
            toggleExpand.classList.toggle('toggle-expand--open');
            menus[index].classList.toggle('main-nav--open');
          });
        });
      });
    }
  };
})(Drupal, once);
