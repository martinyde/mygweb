<?php
// $Id$

/**
 * @file
 * template.php!
 */

/**
 * Override or insert variables into the html template.
 */
function mygweb_preprocess_html(&$vars) {
  global $theme_path;

  // Add conditional CSS for IE7 and below.
  drupal_add_css($theme_path . '/css/ie.css', array('group' => CSS_THEME, 'browsers' => array('IE' => 'lte IE 7', '!IE' => FALSE), 'preprocess' => FALSE));
}

/**
 * Implements template_preprocess_page().
 */
function mygweb_preprocess_page(&$vars) {
  // Shorten the sidebar variable names.
  $sidebar_1 = $vars['page']['sidebar_first'];
  $sidebar_2 = $vars['page']['sidebar_second'];
  // Grid size for sidebars for 2-column layout.
  $width = 4;
  // Grid size for sidebars for 3-column layout.
  if (!empty($sidebar_1) && !empty($sidebar_2)) {
    $width = 4;
  }
  // Define grid classes for page.tpl.php
  $vars['content_grid_classes'] = sky_ns('grid-16', $sidebar_1, $width, $sidebar_2, $width) . ' ' . sky_ns('push-' . $width, !$sidebar_1,  $width);
  $vars['sidebar_first_grid_classes'] = 'grid-' . $width . ' ' . sky_ns('pull-' . (16 - $width), $sidebar_2, $width);
  $vars['sidebar_second_grid_classes'] = 'grid-' . $width;

  // Add text for unpublished nodes.
  if (isset($vars['node']) && $vars['node']->status == 0) {
    $vars['title'] =  drupal_get_title() . ' <span class="marker">(' . t('Unpublished') . ')</span>';
  }
}

function mygweb_menu_link(array $variables) {
  $element = $variables['element'];
  $sub_menu = '';

  if ($element['#below']) {
    $sub_menu = drupal_render($element['#below']);
  }
  $output = l($element['#title'], $element['#href'], $element['#localized_options']);
  return '<li' . drupal_attributes($element['#attributes']) . '><span></span>' . $output . $sub_menu . "</li>\n";
}


