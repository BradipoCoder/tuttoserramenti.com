<?php
/**
 * Node Landing Full
 */
?>

<?php
  hide($content['links']);
  hide($content['field_ref_node']);
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

    <div class="row landing-footer">
      <div class="landing-isotope">
        <?php print render($content['field_ref_node']); ?>
      </div>
    </div>
    
  </div>
</div>