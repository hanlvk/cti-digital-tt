/**
 * @file JavaScript
 */

(function ($, Drupal, once, drupalSettings) {
  Drupal.behaviors.cti_locations = {
    attach: function (context, settings) {
      const elements = once('leaflet_map', '#leaflet_map', context);

      elements.forEach(function () {
        var map = L.map('map', {
          center: [51.9194, 19.1451],
          zoom: 5
        });
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
          maxZoom: 19,
          attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        let locations = drupalSettings.cti_locations.locations;
        Object.keys(locations).forEach(key => {
          const location = locations[key];
          let marker = L.marker([location.latitude, location.longitude]).addTo(map);
          marker.bindPopup(key);
        });
      })
    }
  };
})(jQuery, Drupal, once, drupalSettings);
