<?php

/**
 * Webform crea referenza
 */

?>
<?php
  // Print out the progress bar at the top of the page
  print drupal_render($form['progressbar']);

  // Print out the preview message if on the preview page.
  if (isset($form['preview_message'])) {
    print '<div class="alert alert-info">';
    print drupal_render($form['preview_message']);
    print '</div>';
  }
?>

<?php // Print out the main part of the form. ?>
<?php // Feel free to break this up and move the pieces within the array. ?>

<div class="row">
  <div class="col-md-6">
    <?php print drupal_render($form['submitted']['name']); ?>
    <?php print drupal_render($form['submitted']['e_mail']); ?>
    <?php print drupal_render($form['submitted']['phone']); ?>
    <?php print drupal_render($form['submitted']['address']); ?>
    <?php print drupal_render($form['submitted']['files']); ?>
  </div>
  <div class="col-md-6">
    <?php print drupal_render($form['submitted']['message']); ?>
    <?php print drupal_render($form['submitted']); ?>
  </div>
  <div class="col-xs-12">
    <?php if (isset($form['preview'])) : ?>
      <div class="form-preview">
        <?php print drupal_render($form['preview']); ?>  
      </div>
    <?php endif; ?>
    <div class="text-right">
      <?php print drupal_render_children($form); ?>
    </div>
  </div>
</div>

  

  
