<?php
/**
 * Structured Data Template
 *
 * LANDING: TORINO - SOTTOPAGINE
 *
 */
?>
<script type="application/ld+json">
{
  "@context" : "http://schema.org",
  "@type" : "Product",
  "name" : "<?php print $node_data["node_meta_title"]; ?>",
  "image" : "<?php print $node_data["image_url"]; ?>",
  "description" : "<?php print $node_data["node_meta_description"]; ?>",
  "url" : "<?php print $node_data["node_url"]; ?>",
  "brand" : {
    "@type" : "Brand",
    "name" : "TuttoSerramenti",
    "logo" : "https://www.tuttoserramenti.com/sites/d_tts/files/logo-tts-header.png"
  }
}

</script>
