/**
 * Cta over
 */

jQuery().ready(function(){
  set_up_cta();
  arm_cta_close();
  arm_cta_open();
});

function set_up_cta(){
  setTimeout(function(){
    jQuery('.wrapper-cta-over').removeClass('to-show');
  }, 3000);
}

function arm_cta_close(){
  jQuery('.cta-close').click(function(){
    jQuery('.wrapper-cta-over').addClass('closed'); 
  });
}

function arm_cta_open(){
  jQuery('.cta-open').click(function(){
    jQuery('.wrapper-cta-over').removeClass('closed'); 
  });
}
