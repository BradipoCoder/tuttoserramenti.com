<?php
/**
 * Taxonomy Child Page
 */

  hide($content['pager']);
?>

<?php print render($content['term_heading']); ?>
<div class="taxonomy-page taxonomy-child-page">
  <div class="wrapper-taxonomy-child row margin-b-2">
    <?php print render($content); ?>
  </div>
  <?php print render($content['pager']); ?>
</div>