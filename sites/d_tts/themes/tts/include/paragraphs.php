<?php

/**
 * @file
 * paragraphs.php
 */

// ** PARAGRAPH **
// ---------------

function tts_preprocess_entity(&$vars){
  if($vars['entity_type'] == 'paragraphs_item'){
    $vars['classes_array'][] = 'entity-paragraphs-item-' . $vars['id'];
    switch ($vars['paragraphs_item']->bundle) {
      case 'imgs':
        _tts_preprocess_p_imgs($vars);
        break;

      case 'img_big':
        _tts_preprocess_p_img_big($vars);
        break;

      case 'text_icon':
        _tts_preprocess_p_text_icon($vars);
        break;

      case 'text_img':
        _tts_preprocess_p_text_img($vars);
        break;

      case 'text_parallax':
        _tts_preprocess_p_text_parallax($vars);
        break;

      case 'text_isotope':
        _tts_preprocess_p_text_isotope($vars);
        break;

      case 'copy':
        _tts_preprocess_p_copy($vars);
        break;

        # code...
        break;
    }
  }
}

function _tts_preprocess_p_imgs(&$vars){
  $p = $vars['paragraphs_item'];

  // Options
  $style = 'square';
  if (isset($p->field_vertical['und'][0]['value']) && $p->field_vertical['und'][0]['value']){
    $style = 'vertical';
  }

  $vars['content']['#prefix'] = '<div class="row row-imgs">';
  $vars['content']['#suffix'] = '</div>';

  if ($vars['view_mode'] == 'full'){
    hide($vars['content']['field_img_2']);

    $elements = element_children($p->field_img_2['und']);
    foreach ($elements as $key => $n) {
      //$img = $vars['content']['field_img_2']['#items'][$n];
    
        //Forcing Alt content on images:
        $alt = (isset($vars['content']['field_img_2'][$n]['#item']['title'])
            && !empty($vars['content']['field_img_2'][$n]['#item']['title'])
                ? $vars['content']['field_img_2'][$n]['#item']['title'] . ' - '
                : '') . 'Serramenti Torino';
        $vars['content']['field_img_2'][$n]['#item']['alt'] = $alt;
        
        
      $vars['content'][$n] = array(
        '#prefix' => '<div class="col-sm-6"><div class="margin-b-1">',
        '#suffix' => '</div></div>',
        'img' => array(
          'data' => $vars['content']['field_img_2'][$n],
        ),
        '#weight' => $n,
      );
      $vars['content'][$n]['img']['data']['#display_settings']['colorbox_node_style'] = $style;

      if (isset($vars['content']['field_img_2'][$n]['#item']['title']) && $vars['content']['field_img_2'][$n]['#item']['title'] !== ''){
        $title = $vars['content']['field_img_2'][$n]['#item']['title'];
        $vars['content'][$n]['desc'] = array(
          '#prefix' => '<div class="margin-t-05 margin-sm-h-2"><p class="small">',
          '#suffix' => '</p></div>',
          '#markup' => $title,
          '#weight' => 2,
        );
      }
    }
  }

  if ($vars['view_mode'] == 'paragraphs_editor_preview'){
    $vars['content']['#prefix'] = '<div class="wrapper-p-imgs">';
    $vars['content']['#suffix'] = '</div>';
  }
}

function _tts_preprocess_p_img_big(&$vars){
    
    //Forcing Alt content on images:
    $alt = (isset($vars['content']['field_img'][0]['#item']['title'])
        && !empty($vars['content']['field_img'][0]['#item']['title'])
        ? $vars['content']['field_img'][0]['#item']['title'] . ' - '
        : '') . 'Serramenti Torino';
    $vars['content']['field_img'][0]['#item']['alt'] = $alt;
    
    
  if ($vars['view_mode'] == 'full'){
    $vars['content']['field_img'] = array(
      '#prefix' => '<div class="wrapper-p-img margin-b-1">',
      '#suffix' => '</div>',
      'data' => $vars['content']['field_img'][0],
    );

    //_tts_add_fancy_svg($vars);

    if (isset($vars['content']['field_img']['data']['#item']['title']) && $vars['content']['field_img']['data']['#item']['title']!== ''){
      $title = $vars['content']['field_img']['data']['#item']['title'];
      $vars['content']['field_img']['desc'] = array(
        '#prefix' => '<div class="margin-t-05 margin-sm-h-2"><p class="small">',
        '#suffix' => '</p></div>',
        '#markup' => $title,
        '#weight' => 2,
      );
    }
  }
}

function _tts_add_fancy_svg(&$vars){
  $mask = drupal_get_path('theme', 'tts') . '/svg/mask.svg';
  $mask2 = drupal_get_path('theme', 'tts') . '/svg/mask-2.svg';
  $vars['content']['field_img']['mask']['#markup'] = file_get_contents($mask);
  $vars['content']['field_img']['mask2']['#markup'] = file_get_contents($mask2);
  $vars['content']['field_img']['#prefix'] = '<div class="wrapper-p-img wrapper-mask-img margin-b-1">';

  drupal_add_js(drupal_get_path('theme', 'tts') . '/js/mask.js');
}

function _tts_preprocess_p_text_icon(&$vars){
  $icon = $vars['content']['field_icon'][0]['#icon'];

  $vars['content']['data'] = array(
    '#prefix' => '<div class="wrapper-p-text-icon margin-md-r-4">',
    '#suffix' => '</div>',
    'icon' => array(
      '#markup' => '<i class="fa fa-2x fa-' . $icon . ' fa-fw text-primary"></i>',
    ),
    'text' => array(
      '#prefix' => '<div class="p-text-icon-content">',
      '#suffix' => '</div>',
      'data' => $vars['content']['field_desc'],
    ),
  );
  $vars['content']['field_icon']['#printed'] = TRUE;
  $vars['content']['field_desc']['#printed'] = TRUE;
}

function _tts_preprocess_p_text_img(&$vars){
  $p = $vars['paragraphs_item'];

  $vars['content'] = array(
    'row' => array(
      '#prefix' => '<div class="row row-text-img margin-b-2">',
      '#suffix' => '</div>',
      'left' => array(
        '#prefix' => '<div class="col-md-5">',
        '#suffix' => '</div>',
        'data' => $vars['content']['field_img'],
      ),
      'right' => array(
        '#prefix' => '<div class="col-md-7">',
        '#suffix' => '</div>',
        'data' => array(
          '#prefix' => '<div class="margin-md-l-2">',
          '#suffix' => '</div>',
          'data' => $vars['content']['field_desc'],
        ),
      ),
    ),
  );

  if ($p->field_option['und'][0]['value'] == 'right'){
    $vars['content']['row']['left']['#prefix'] = '<div class="col-md-5 col-md-push-7">';
    $vars['content']['row']['right']['#prefix'] = '<div class="col-md-7 col-md-pull-5">';
    $vars['content']['row']['right']['data']['#prefix'] = '<div class="margin-md-r-2">';
  }

  // In specific field
  if ($vars['elements']['#entity']->field_name == 'field_content_down'){
    $vars['content']['#prefix'] = '<div class="container">';
    $vars['content']['#suffix'] = '</div>';
    if ($p->item_id !== '10'){
      $vars['content']['#suffix'] .= '<hr class="margin-b-2 hidden-xs">';
    }
  }
}

function _tts_preprocess_p_text_isotope(&$vars){
  $p = $vars['paragraphs_item'];

  $vars['content'] = array(
    'row' => array(
      '#prefix' => '<div class="row row-text-img margin-b-2">',
      '#suffix' => '</div>',
      'left' => array(
        '#prefix' => '<div class="col-md-7">',
        '#suffix' => '</div>',
        'data' => array(
          'data' => $vars['content']['field_imgs'],
        ),
      ),
      'right' => array(
        '#prefix' => '<div class="col-md-5">',
        '#suffix' => '</div>',
        'data' => array(
          '#prefix' => '<div class="margin-md-l-1">',
          '#suffix' => '</div>',
          'data' => $vars['content']['field_desc'],
        ),
      ),
    ),
  );

  if ($p->field_option['und'][0]['value'] == 'right'){
    $vars['content']['row']['left']['#prefix'] = '<div class="col-md-7 col-md-push-5">';
    $vars['content']['row']['right']['#prefix'] = '<div class="col-md-5 col-md-pull-7">';
    $vars['content']['row']['right']['data']['#prefix'] = '<div class="margin-md-r-2">';
  }

  // In specific field
  if ($vars['elements']['#entity']->field_name == 'field_content_down'){
    $vars['content']['#prefix'] = '<div class="container">';
    $vars['content']['#suffix'] = '</div>';
  }
}

function _tts_preprocess_p_text_parallax(&$vars){
  $p = $vars['paragraphs_item'];
  if (isset($p->field_img['und'][0]['uri'])){
    $uri = $p->field_img['und'][0]['uri'];
    $url_img = image_style_url('free_crop_lg', $uri);

    $prefix = '<div class="parallax-w" data-bleed="1" data-parallax="scroll" data-image-src="' . $url_img . '">';
    $parallax = array(
      '#prefix' => $prefix,
      '#suffix' => '</div>',
    );

    $parallax['content'] = array(
        '#prefix' => '<div class="wrapper-over-parallax"><div class="over-parallax">',
        '#suffix' => '</div></div>',
      );

    $parallax['content']['over'] = array(
      '#prefix' => '<div class="parallax-content"><div class="container"><div class="row">',
      '#suffix' => '</div></div></div>',
      'desc' => array(
        '#prefix' => '<div class="col-md-5 col-md-offset-6">',
        '#suffix' => '</div>',
        'data' => $vars['content']['field_desc'],
      ),
    );

    $vars['content']['parallax'] = $parallax;

    $js_parallax = libraries_get_path('jquery.parallax') . '/jquery.parallax.min.js';
    drupal_add_js( $js_parallax , array('group' => JS_LIBRARY, 'weight' => 1));

    $vars['content']['field_img']['#printed'] = TRUE;
    $vars['content']['field_desc']['#printed'] = TRUE;
  }
}

function _tts_preprocess_p_copy(&$vars){
  if ($vars['view_mode'] == 'default'){
    $vars['content']['#prefix'] = '<div class="margin-sm-h-2 margin-v-15">';
    $vars['content']['#suffix'] = '</div>';
  }
}