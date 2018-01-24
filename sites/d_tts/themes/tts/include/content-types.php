<?php

/**
 * @file
 * content-types.php
 */

// ** PREPROCESS NODE **
// ---------------------

/**
 * Implements hook_preprocess_node()
 */
function tts_preprocess_node(&$vars){
  $node = $vars['node'];
  switch ($node->type) {
    case 'news':
      _tts_preprocess_node_news($vars);
      break;

    case 'page':
      _tts_preprocess_node_page($vars);
      break;

    case 'landing':
      _tts_preprocess_node_landing($vars);
      break;

    case 'expert':
      _tts_preprocess_node_expert($vars);
      break;

    default:
      # code...
      break;
  }

  // Pagina contatti / l'esperto risponde
  if ($node->nid == 2){
    $context = menu_get_object();
    if ($context && $context->type == 'news'){
      // Do nothing
    } else {
       $vars['content']['#prefix'] = '<div class="row"><div class="container"><div class="row"><div class="col-md-8 col-md-offset-2">';
       $vars['content']['#suffix'] = '</div></div></div></div>';
    }
    _tts_insert_contact_form($vars);
  }

  if ($node->nid == 21 && $vars['view_mode'] == 'full'){
    _tts_insert_contact_form($vars);
    $vars['content']['#prefix'] = '<div class="row"><div class="container"><div class="row"><div class="col-md-8 col-md-offset-2">';
    $vars['content']['#suffix'] = '</div></div></div></div>';
  }


  if ($node->nid == 3){
    _tts_insert_contact_form($vars);


    $markup = '<h2 class="text-center">Contatta i nostri esperti';
    $markup .= '<br />';
    //$url_to_turin = url("node/15");
    //$markup .= '<a href="'.$url_to_turin.'" class="h2-sub">per serramenti e infissi sul territorio di Torino</a>';
    $markup .= '<span class="h2-sub">per serramenti e infissi sul territorio di Torino</span>';
    $markup .= '</h2>';

    $vars['content']['webform'] = array(
      '#prefix' => '<div class="row"><div class="container"><div class="row"><div class="col-md-8 col-md-offset-2">',
      '#suffix' => '</div></div></div></div>',
      'title' => array(
        '#markup' => $markup,
      ),
      'form' => $vars['content']['webform'],
      '#weight' => $vars['content']['webform']['#weight'],
    );
  }
}

function _tts_preprocess_node_page(&$vars){
  $node = $vars['node'];
  if (isset($node->field_title_emo['und'][0]['value']) && $node->field_title_emo['und'][0]['value'] !== ''){
    hide($vars['content']['title_field']);
  }

  if ($node->nid == 1){
    // Cambio spazi nel titolo
    $value = $node->field_title_emo['und'][0]['value'];
    $vars['content']['field_title_emo'][0]['#prefix'] = '<h1 class="text-center margin-b-1 margin-t-0">';
    $vars['content']['field_title_emo'][0]['#suffix'] = '</h1>';
    $vars['content']['field_title_emo'][0]['#markup'] = l($value, 'node/' . $node->nid);

    if ($vars['view_mode'] == 'teaser'){
      $opt = array(
        'attributes' => array(
          'class' => array(
            'btn', 'btn-primary',
          ),
        ),
      );
      $vars['content']['more'] = array(
        '#prefix' => '<div class="row"><div class="wrapper-more wrapper-more-node-1 text-center">',
        '#suffix' => '</div></div>',
        '#markup' => l('Leggi altri articoli', 'node/1', $opt),
        '#weight' => 20,
      );
    }

  }

}

function _tts_preprocess_node_expert(&$vars){
  if ($vars['view_mode'] == 'child'){
    $vars['classes_array'][] = 'col-sm-6';
    $vars['classes_array'][] = 'col-md-2';

    if ($vars['nid'] == 7){
      $vars['classes_array'][] = 'col-md-offset-1';
    }
  }
}

function _tts_preprocess_node_landing(&$vars){
  $vars['content']['title_field']['#prefix'] = '<a name="first" class="anchor"></a>';
  add_js_isotope();
  $js = drupal_get_path('theme', 'tts') . '/js/isotope-custom.js';
  drupal_add_js($js, array('scope' => 'footer', 'weight' => 5));
}

function _tts_preprocess_node_news(&$vars){
  _add_custom_btn_social($vars);

  if ($vars['view_mode'] == 'child'){
    $vars['classes_array'][] = 'col-sm-6';
    $vars['classes_array'][] = 'col-md-4';
    $vars['classes_array'][] = 'col-lg-3';
    $vars['classes_array'][] = 'margin-b-1';

    _tts_news_date_category($vars);
    _tts_news_footer($vars);
  }

  if ($vars['view_mode'] == 'full'){
    _tts_news_add_anchor_to_parent($vars);
    _tts_news_date_category($vars);
    _tts_news_share($vars);
    _tts_news_add_expert($vars);
    _tts_news_related($vars);
    _alter_pagination($vars);

    $vars['content']['hr'] = array(
      '#markup' => '<hr class="margin-t-0">',
      '#weight' => $vars['content']['title_field']['#weight'] + 1,
    );

    $vars['content']['field_content']['#weight'] = $vars['content']['title_field']['#weight'] + 2;

    $vars['content']['hr2'] = array(
      '#markup' => '<hr class="margin-t-0">',
      '#weight' => 8,
    );
  }
}