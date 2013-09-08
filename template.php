<?php
/**
 * @file
 * Theme functions
 */

require_once dirname(__FILE__) . '/includes/structure.inc';
require_once dirname(__FILE__) . '/includes/form.inc';
require_once dirname(__FILE__) . '/includes/menu.inc';
require_once dirname(__FILE__) . '/includes/comment.inc';
require_once dirname(__FILE__) . '/includes/node.inc';

/**
 * Implements hook_css_alter().
 */
function admiral_css_alter(&$css) {
  $radix_path = drupal_get_path('theme', 'radix');

  // Radix now includes compiled stylesheets for demo purposes.
  // We remove these from our subtheme since they are already included 
  // in compass_radix.
  unset($css[$radix_path . '/assets/stylesheets/radix-style.css']);
  unset($css[$radix_path . '/assets/stylesheets/radix-print.css']);
}

/**
 * Implements template_preprocess_page().
 */
function admiral_preprocess_page(&$variables) {
  // Add copyright to theme.
  if ($copyright = theme_get_setting('copyright')) {
    $variables['copyright'] = check_markup($copyright['value'], $copyright['format']);
  }

  // Format and add main menu to theme.
  $menu_name = theme_get_setting('admiral_admin_menu');
  $main_menu_tree = menu_tree_all_data($menu_name);
  $menu_output =  menu_tree_output($main_menu_tree);
  
  // Management has its first level link as Admin
  // All other menu items are below it
  if($menu_name == 'management') {
     $variables['main_menu'] = $menu_output[1]['#below'];
  }
  else {
    $variables['main_menu'] = $menu_output;
  }
  $variables['main_menu']['#theme_wrappers'] = array('menu_tree__primary');
}
