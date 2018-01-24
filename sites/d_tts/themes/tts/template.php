<?php

/**
 * @file
 * template.php
 */

require('include/content.php');
require('include/content-types.php');
require('include/paragraphs.php');



function tts_html_head_alter(&$vars){
  $arg = arg();
  //in cookie and privacy page put noindex meta tag - (maybe it could be in module)
  if(in_array($arg[0], ["privacy", "cookie"]) && count($arg) == 1){
    $indexMeta = [
      '#tag' => 'meta',
      '#type' => 'html_tag',
      '#attributes' => [
        'name' => 'robots',
        'content' => 'noindex, nofollow'
      ]
    ];
    $vars["tts_meta_robots"] = $indexMeta;
  }

  // Href Lang
  // <link rel="alternate" href="http://example.com" hreflang="en-us" />
  $hreflang = array(
    '#tag' => 'link',
    '#type' => 'html_tag',
    '#attributes' => array(
      'rel' => 'alternate',
      'hreflang' => 'it',
    ),
  );
  $vars['tts_hreflang'] = $hreflang;
}

function tts_preprocess_field(&$vars){
  if(in_array($vars["element"]["#field_name"], ["field_img"])){
   //Forcing Alt content on images:
   $alt = (isset($vars["items"][0]['#item']['title'])
          && !empty($vars["items"][0]['#item']['title'])
          ? $vars["items"][0]['#item']['title'] . ' - '
          : '') . 'Serramenti Torino';
   $vars["items"][0]['#item']['alt'] = $alt;
 }
}



/**
 * Implements hook_preprocess_html()
 * Google fonts and Google Analitycs
 */
function tts_preprocess_html(&$variables) {
  $fonts = array(
    0 => 'https://fonts.googleapis.com/css?family=Lora:400i,700i|Source+Sans+Pro:400,400i,600,600i',
  );

  foreach ($fonts as $key => $css) {
    drupal_add_css($css, array('type' => 'external'));
  }

  $ga = _tts_get_ga_script();
  drupal_add_js($ga, array('type' => 'inline', 'scope' => 'header', 'weight' => 5));
}

function tts_preprocess_page(&$vars){
  $show = TRUE;
  if (isset($vars['node'])){
    $node = $vars['node'];
    if ($node->nid == 21 || $node->nid == 2 || $node->nid == 3){
      $show = FALSE;
    }
  }

  // Hide annoying pop up for administrators
  global $user;
  if ($user->uid == 1){
    $show = FALSE;
  }

  if ($show){
    $opt = array(
      'attributes' => array(
        'class' => array('btn', 'btn-primary'),
      ),
    );

    $data['btn'] = array(
      '#markup' => l('Preventivo', 'node/21', $opt),
    );
    $vars['page']['cta_over'] = array(
      '#theme' => 'tts-cta-over',
      '#content' => $data,
    );

    $js = drupal_get_path('theme', 'tts') . '/js/cta-over.js';
    drupal_add_js($js, array('scope' => 'footer', 'weight' => 5));
  }
}

// ** THEME **
// -----------

function tts_preprocess_webform_confirmation(&$vars){
  // Form Node | usefull to find
  $node = $vars['node'];

  if (isset($node->field_post_text['und'][0]['value']) && $node->field_post_text['und'][0]['value']!== ''){
    $post = field_view_field('node', $node, 'field_post_text');
    $post['#label_display'] = 'hidden';
    $vars['content']['post'] = $post;
    $vars['confirmation_message'] = false;
  }
}

function tts_preprocess_footer(&$vars){
  $vars['common_link'] = tts_get_common_link();

  if (isset($vars['menu_social'])){
    $menu = $vars['menu_social'];
    $ks = element_children($menu);
    
    $data = array(
      '#prefix' => '<div class="wrapper-fancy-social"><ul class="fancy-social">',
      '#suffix' => '</ul></div>',
    );


    foreach ($ks as $key => $mid) {
      $l = $menu[$mid];
      $opt = array(
        'html' => true,
      );

      if (isset($l['#localized_options']['icon']['icon'])){
        $icon = $l['#localized_options']['icon']['icon'];
        $icon = '<i class="fa fa-' . $icon . '"></i>';
        $data[$mid] = array(
          '#prefix' => '<li class="fancy-social-btn">',
          '#suffix' => '</li>',
          '#markup' => l($icon, $l['#href'], $opt),
        );
      }

      $vars['menu_social'] = $data;
    }
  }
}

function tts_get_common_link(){
  $site_name = variable_get('site_name');

  $common_link = '<p>&copy; Copyright ' . date('Y') . ' ' . $site_name . ' - All rights reserved | ';
  $common_link .= l('Web Design by Mekit', 'http://www.mekit.it') . ' | ';
  $common_link .= '<a href="http://www.informatica-logica.com" target="_blank">Posizionamento motori di ricerca</a> by LOGICA | ';
  $common_link .= l('Admin', 'user') . '</p>';

  return $common_link;
}

function tts_preprocess_taxonomy_child_page(&$vars){
  add_js_isotope();
  $js = drupal_get_path('theme', 'tts') . '/js/isotope-custom.js';
  drupal_add_js($js, array('scope' => 'footer', 'weight' => 5));
}

// ** ADMIN **
// -----------

/**
 * Implements hook_form_FORM_ID_alter(&$form, &$form_state, $form_id)
 * Node editing and some permission
 */
function tts_form_node_form_alter(&$form, $form_state){
  global $user;

  $form['nodehierarchy']['#title'] = 'Genitore';
  if (isset($form['nodehierarchy']['nodehierarchy_menu_links'][0]['#title'])){
    $form['nodehierarchy']['nodehierarchy_menu_links'][0]['#title'] = 'Genitore';
  }

  if ($user->uid == 1){
    // Administrator
  } else {
    // Authenticated user
    $form['options']['promote']['#access'] = false;
    $form['options']['sticky']['#access'] = false;
    $form['revision_information']['#access'] = false;
  }
}

// ** GA **
// --------

function _tts_get_ga_script(){
  $ga = "(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-98514700-1', 'auto');
  ga('send', 'pageview');";
  return $ga;
}

// ** THEME **
// -----------

/**
 * Implements hook_theme
 * @return [type] [description]
 */
function tts_theme(){
  $path = drupal_get_path('theme', 'tts') . '/templates/';
  return array(
    'tts-cta-over' => array(
      // use a template and give the template's name.
      'template' => 'tts-cta-over',
      'variables' => array(
        'content' => array(),
      ),
      'pattern' => 'tts-cta-over__',
      'path' => $path,
    ),
  );
}