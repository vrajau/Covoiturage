window.addEventListener("load", initialize, false);
var placeSearch, autocomplete;
var options = {
  types: ['(cities)'],
  componentRestrictions: {country: "fr"}
 };

function initialize() {
  // Create the autocomplete object, restricting the search
  // to geographical location types.
  autocomplete1 = new google.maps.places.Autocomplete((document.getElementById('ville_depart_trajet')),options);
  autocomplete2 = new google.maps.places.Autocomplete((document.getElementById('ville_arrive_trajet')),options );

}


