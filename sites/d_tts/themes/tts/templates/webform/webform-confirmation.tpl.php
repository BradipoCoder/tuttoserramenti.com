<?php

/**
 * @file
 * Customize confirmation screen after successful submission.
 *
 * This file may be renamed "webform-confirmation-[nid].tpl.php" to target a
 * specific webform e-mail on your site. Or you can leave it
 * "webform-confirmation.tpl.php" to affect all webform confirmations on your
 * site.
 *
 * Available variables:
 * - $node: The node object for this webform.
 * - $confirmation_message: The confirmation message input by the webform author.
 * - $sid: The unique submission ID of this submission.
 */
?>

<?php if ($confirmation_message): ?>
  <div class="text-center text-max-width webform-confirmation margin-b-2">
    <?php print $confirmation_message ?>
  </div>

  <div class="text-max-width text-center links margin-b-4">
    <p>
      <?php $opt2['attributes']['class'] = array('btn','btn-primary'); ?>
      <?php print l('Visita il sito', '<front>', $opt2); ?>
    </p>
  </div>
<?php else: ?>
  <div class="text-max-width text-center links margin-b-4">
    <?php print render($content); ?>
    <p class="margin-t-1"><?php print l('Torna alla homepage','<front>'); ?></p>
  </div>
<?php endif; ?>
