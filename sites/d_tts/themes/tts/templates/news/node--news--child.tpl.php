<?php
/**
 * Node News Child
 *
 */
?>

<?php
  hide($content['links']);
?>

<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?>"<?php print $attributes; ?>>

  <?php print render($title_prefix); ?>
  <?php print render($title_suffix); ?>

  <?php print render($content['field_img']); ?>

  <div class="node-content">
    <?php print render($content); ?>
  </div>

</div>