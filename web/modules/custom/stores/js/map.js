(function (Drupal, once) {
  "use strict";

  Drupal.behaviors.myLeafletMap = {
    attach: function (context, settings) {
      if (typeof L !== 'undefined') {
        const test = drupalSettings;
        console.log(test);

        // Ініціалізація карти Leaflet
        const map = L.map('map').setView([51.505, -0.09], 13);
        // Додавання підкладки
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
          attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Додавання маркера
        L.marker([51.5, -0.09]).addTo(map)
          .bindPopup('A pretty CSS3 popup.<br> Easily customizable.')
          .openPopup();
      }
      else {
        console.error('Leaflet library is not loaded.');
      }
    }
  };

})(Drupal, once);
