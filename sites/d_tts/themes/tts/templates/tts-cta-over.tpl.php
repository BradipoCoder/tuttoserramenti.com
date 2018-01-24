<?php
/**
 * TTS CTA OVER
 * Call to action sempre visibile nella pagina
 */
?>

<div class="wrapper-cta-over to-show">
  <div class="cta-over-header negative clearfix hidden-xs">
    <h4 class="margin-v-05 text-center">Richiedi il tuo preventivo</h4>
  </div>
  <div class="cta-over-content text-center">
    <p>Chiama il <span class="hidden-xs">numero</span> <a href="tel://011 994 56 98"><i class="fa fa-phone"></i> 011 994 56 98</a></p>
    <div class="btn-group btn-group-justified">
      <?php print render($content['btn']); ?>
    </div>
  </div>
  <span class="cta-close">&times;</span>
  <span class="cta-open"><i class="fa fa-angle-up"></i></span>
</div>