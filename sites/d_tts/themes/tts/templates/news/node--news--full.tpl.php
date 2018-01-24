<?php
/**
 * Node News Full
 */
?>

<?php
  hide($content['links']);
  hide($content['related']);
  hide($content['pager']);
?>

<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?>"<?php print $attributes; ?>>

  <?php print render($title_prefix); ?>
  <?php print render($title_suffix); ?>

  <div class="node-content"<?php print $content_attributes; ?>>

    <div class="row">
      <div class="container">
        <div class="row">
          <div class="col-md-8 col-md-offset-2">
            <?php print render($content); ?>   
          </div>
        </div>
      </div>
    </div>

    <?php print render($content['pager']); ?>
    <?php print render($content['related']); ?>
     
  </div>
</div>