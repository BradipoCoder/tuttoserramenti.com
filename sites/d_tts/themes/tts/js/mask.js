/**
 * Mask
 */

jQuery().ready(function(){
  //animate();

  animate_on_scroll();
});

function animate(){
  jQuery('.wrapper-mask-img').toggleClass('animate');
  setTimeout(function(){
    animate(); 
  }, 10000);
}

function animate_on_scroll(){

  var position = jQuery('.wrapper-mask-img').position();
  var top = position.top;
  var min = top;

  jQuery(window).scroll(function() {
    if (jQuery(this).scrollTop() >= min){
      jQuery('.wrapper-mask-img').addClass('animate');
    }

    if (jQuery(this).scrollTop() < min){
      jQuery('.wrapper-mask-img').removeClass('animate');
    }
  });

  //jQuery(window).scroll(function() {
  //  console.debug(jQuery(this).scrollTop(), top);
  //});
}