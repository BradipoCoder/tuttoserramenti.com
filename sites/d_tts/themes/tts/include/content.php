<?php

/**
 * @file
 * content.php
 */

/**
 * Display date and category on the same line
 */
function _tts_news_date_category(&$vars){
  $date = false;
  if (isset($vars['content']['field_date'][0]['#markup'])){
    $date = $vars['content']['field_date'][0]['#markup'];
  }

  $cat = false;
  if (isset($vars['content']['field_ref_cat_news'][0]['#markup'])){
    $cat = $vars['content']['field_ref_cat_news'][0]['#markup'];
  }

  if ($date && $cat){
    $vars['content']['head'] = array(
      '#prefix' => '<div class="wrapper-head-news row">',
      '#suffix' => '</div>',
      '0' => array(
        '#prefix' => '<div class="col-xs-12 date-cat margin-b-05">',
        '#suffix' => '</div>',
        'date_cat' => array(
          '#prefix' => '<p class="text-serif">',
          '#suffix' => '</p>',
          '#markup' => $date . ' / ' . $cat,
        ),
      ),
      //'1' => array(
      //  '#prefix' => '<div class="col-xs-6">',
      //  '#suffix' => '</div>',
      //  'date_cat' => array(
      //    '#prefix' => '<p class="text-caps text-right text-share">',
      //    '#suffix' => '</p>',
      //    'share' => _tts_share($vars),
      //  ),
      //),
    );
    hide($vars['content']['field_date']);
    hide($vars['content']['field_ref_cat_news']);
  }
}

/**
 * Display the footer of the news
 */
function _tts_news_footer(&$vars){
  $node = $vars['node'];

  $vars['content']['footer'] = array(
    '#prefix' => '<hr><div class="row">',
    '#suffix' => '</div>',
    '1' => array(
      '#prefix' => '<div class="col-xs-6"><p class="text-caps">',
      '#suffix' => '</p></div>',
      '#markup' => l('Leggi', 'node/' . $node->nid),
    ),
    '2' => array(
      '#prefix' => '<div class="col-xs-6"><p class="text-caps text-right text-share">',
      '#suffix' => '</p></div>',
      'share' => _tts_share($vars),
    ),
    '#weight' => 8,
  );
  $vars['content']['social']['#printed'] = true;
}

function _tts_news_share(&$vars){
  $node = $vars['node'];

  $vars['content']['share'] = array(
    '#prefix' => '<div class="wrapper-share text-right">',
    '#suffix' => '</div>',
    'link' => array(
      '#prefix' => '<p class="text-caps text-share">',
      '#suffix' => '</p>',
      'share' => _tts_share($vars),
    ),
    '#weight' => 9,
  );
  $vars['content']['social']['#printed'] = true;
}

function _tts_share($vars){
  $opt = array(
    'html' => true,
    'fragment' => ' ',
    'absolute' => true,
    'attributes' => array(
      'class' => array(
        'a-share',
      ),
    ),
  );
  $i = '<i class="fa fa-share-alt fa-fw"></i>';
  $share = array(
    '#prefix' => '<span class="wrapper-social-toggle">',
    '#suffix' => '</span>',
    'link' => array(
      '#markup' => l($i . ' Condividi', '', $opt),
    ),
    'social' => $vars['content']['social'],
  );
  return $share;
}

function _tts_insert_contact_form(&$vars){
  $node_contact = node_load(6);
  $node_view = node_view($node_contact);
  $vars['content']['webform']['node'] = $node_view;
  $vars['content']['webform']['#prefix'] = '<div class="wrapper-webform margin-v-2">';
  $vars['content']['webform']['#suffix'] = '</div>';
  $vars['content']['webform']['#weight'] = 14;
}

function _tts_news_add_expert(&$vars){
  $node_expert = node_load(2);
  $node_view = node_view($node_expert, "teaser");
  $vars['content']['expert'] = $node_view;
  $vars['content']['expert']['#weight'] = 10;
}

function _tts_news_related(&$vars){
  $vars['content']['related'] = array(
    '#markup' => views_embed_view('related', 'default'),
    '#weight' => 40,
  );

  add_js_isotope();
  $js = drupal_get_path('theme', 'tts') . '/js/isotope-custom.js';
  drupal_add_js($js, array('scope' => 'footer', 'weight' => 5));
}

function _tts_news_add_anchor_to_parent(&$vars){
  $node = $vars['node'];

  if (isset($vars['content']['title_field'])){
    $title = $node->title;

    $seo = ' <span class="label-seo">Serramenti Torino</span>';

    $opt = array(
      'fragment' => 'first',
      'html' => TRUE,
    );

    $vars['content']['title_field'][0] = array(
      '#prefix' => '<h1 class="margin-t-0 margin-b-1">',
      '#suffix' => '</h1>',
      '#markup' => l($title . $seo, 'node/15', $opt),
    );
  }
}

function _alter_pagination(&$vars, $title = TRUE){
  if (isset($vars['pagination']['prev'])){
    $vars['content']['pager']['#prefix'] = '<hr>' . $vars['content']['pager']['#prefix'];
    $prev = node_load($vars['pagination']['prev']);
    $next = node_load($vars['pagination']['next']);
    if ($title){
      $t_prev = '<i class="fa fa-angle-left fa-fw"></i> <span>' . $prev->title . '</span>';
      $t_next = '<span>' . $next->title . '</span> <i class="fa fa-angle-right fa-fw"></i>';
    } else {
      $t_prev = '<i class="fa fa-angle-left fa-fw"></i> <span>Precedente</span>';
      $t_next = '<span>Successivo</span> <i class="fa fa-angle-right fa-fw"></i>';
    }
    
    $vars['content']['pager']['#prefix'] = '<div class="nhc-pager row margin-b-1">';

    $vars['content']['pager']['prev']['#text'] = '<span class="small">' . $t_prev . '</span>';
    $vars['content']['pager']['next']['#text'] = '<span class="small">' . $t_next . '</span>';
  }
}