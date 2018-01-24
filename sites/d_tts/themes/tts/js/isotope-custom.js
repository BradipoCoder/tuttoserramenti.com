/**
 * Isotope custom
 */

jQuery().ready(function(){
  // Usa il primo figlio come larghezza della griglia
  jQuery('.landing-isotope').imagesLoaded( function() {
    jQuery('.landing-isotope').isotope({
      itemSelector: '.node',
    })
  });

  jQuery('.view-id-related').imagesLoaded( function() {
    jQuery('.view-id-related').isotope({
      itemSelector: '.node',
    })
  });

  jQuery('.wrapper-taxonomy-child').imagesLoaded( function() {
    jQuery('.wrapper-taxonomy-child').isotope({
      itemSelector: '.node',
    })
  });
  
});
