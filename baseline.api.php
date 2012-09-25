<?php

/**
 * @file
 * Hooks provided by baseline module.
 */

/**
 * Implements hook_baseline_setup().
 */
function hook_baseline_baseline_setup() {
  $theme = 'mysitename';
  $admin_theme = 'rubik';
  // Enable our main theme.
  theme_enable(array($theme));
  // Set our main theme as default.
  variable_set('theme_default', $theme);
  // Enable admin theme.
  theme_enable(array($admin_theme));
  variable_set('admin_theme', $admin_theme);
}

/**
 * Implements hook_baseline_info_variables().
 */
function hook_baseline_baseline_info_variables() {
  return array(
    'user_register'             => USER_REGISTER_ADMINISTRATORS_ONLY,
    'site_name'                 => 'mysitename',
    'site_slogan'               => 'Myslogan.',
    'node_admin_theme'          => 1,
    'theme_mysitename_settings'  => array (
      'toggle_logo' => 1,
      'toggle_name' => 0,
      'toggle_slogan' => 1,
      'toggle_node_user_picture' => 1,
      'toggle_comment_user_picture' => 1,
      'toggle_favicon' => 1,
      'toggle_main_menu' => 1,
      'toggle_secondary_menu' => 1,
      'default_logo' => 0,
      'logo_path' => 'sites/all/themes/custom/mysitename/images/mysitename.png',
      'logo_upload' => '',
      'default_favicon' => 1,
      'favicon_path' => '',
      'favicon_upload' => '',
      'zen_breadcrumb' => 'yes',
      'zen_breadcrumb_separator' => ' › ',
      'zen_breadcrumb_home' => 1,
      'zen_breadcrumb_trailing' => 0,
      'zen_breadcrumb_title' => 1,
      'zen_skip_link_anchor' => 'main-menu',
      'zen_skip_link_text' => 'Jump to navigation',
      'zen_html5_respond_meta' => array (
        'respond' => 'respond',
        'html5' => 'html5',
        'meta' => 'meta',
      ),
      'zen_rebuild_registry' => 1,
      'zen_wireframes' => 0,
    )
  );
}

/**
 * Implements hook_baseline_baseline_info_menus().
 */
function hook_baseline_baseline_info_menus() {
  return array(
    array(
      'title'       => 'Service menu',
      'menu_name'   => 'menu-service',
      'description' => 'The <em>Service</em> menu contains a short list of links and is normally shown at the top of the page and in the footer.',
      'language'    => LANGUAGE_NONE,
      // Translate and localize.
      // @todo i18n module probably provides a constant for this.
      'i18n_mode'   => 5,
    ),
    array(
      'title'       => 'Main menu',
      'menu_name'   => 'main-menu',
      'description' => 'The <em>Main</em> menu is used on many sites to show the major sections of the site, often in a top navigation bar.',
      'language'    => LANGUAGE_NONE,
      // Translate and localize.
      // @todo i18n module probably provides a constant for this.
      'i18n_mode'   => 5,
    ),
  );
}

/**
 * Implements hook_baseline_info_menu_links().
 */
function hook_baseline_baseline_info_menu_links() {
   return array(
    array(
      'menu_name' => 'main-menu',
      'link_path' => 'news',
      'link_title' => 'News',
      'weight' => -50,
    ),
  );
}

/**
 * Implements hook_baseline_info_blocks().
 */
function hook_baseline_baseline_info_blocks() {
  $theme = 'mysitename';
  $admin_theme = 'rubik';

  return array(
    array(
      'module' => 'locale',
      'delta' => 'language',
      'theme' => $theme,
      'status' => 1,
      'weight' => 0,
      'region' => 'header_top',
      'title'  => '<none>',
      'pages' => '',
      'cache' => -1,
    ),
    array(
      'module' => 'menu',
      'delta' => 'menu-service',
      'theme' => $theme,
      'status' => 1,
      'weight' => 1,
      'region' => 'header_top',
      'title'  => '<none>',
      'pages' => '',
      'cache' => -1,
    ),
    array(
      'module' => 'search',
      'delta' => 'form',
      'theme' => $theme,
      'status' => 1,
      'weight' => 1,
      'region' => 'header',
      'title'  => '<none>',
      'pages' => '',
      'cache' => -1,
    ),
    array(
      'module' => 'system',
      'delta' => 'navigation',
      'theme' => $theme,
      'status' => 0,
      'weight' => 1,
      'region' => '-1',
      'title'  => '<none>',
      'pages' => '',
      'cache' => -1,
    ),
    array(
      'module' => 'system',
      'delta' => 'management',
      'theme' => $theme,
      'status' => 0,
      'weight' => 1,
      'region' => '-1',
      'title'  => '<none>',
      'pages' => '',
      'cache' => -1,
    ),
    array(
      'module' => 'system',
      'delta' => 'navigation',
      'theme' => $admin_theme,
      'status' => 0,
      'weight' => 1,
      'region' => '-1',
      'title'  => '<none>',
      'pages' => '',
      'cache' => -1,
    ),
    array(
      'module' => 'system',
      'delta' => 'management',
      'theme' => $admin_theme,
      'status' => 0,
      'weight' => 1,
      'region' => '-1',
      'title'  => '<none>',
      'pages' => '',
      'cache' => -1,
    ),
    array(
      'module' => 'on_the_web',
      'delta' => 0,
      'theme' => $theme,
      'status' => 1,
      'weight' => 10,
      'region' => 'sidebar_first',
      'title'  => 'Follow mysitename',
      'pages' => '',
      'cache' => -1,
    ),
    // Custom blocks
    array(
      'module'  => 'block',
      'delta'   => 1,
      'theme'   => $theme,
      'status'  => 1,
      'weight'  => 1,
      'region'  => 'sidebar_first',
      'title'   => 'Search our supplier index.',
      'pages'   => '',
      'cache'   => -1,
      'body'    => 'Search our supplier index. <a href="#" class="button">Search index</a>',
      'info'    => 'Search our supplier index.',
      'format'  => 'filtered_html',
      'custom'  => TRUE,
    ),
  );
}

/**
 * Implements hook_baseline_info_date_formats().
 */
function hook_baseline_baseline_info_date_formats() {
  return array(
    // Monday 29/03/1980
    array(
      'format' => 'l d/m/Y',
    ),
    // Monday 29/03/1980 20:50
    array(
      'format' => 'l d/m/Y - G:s',
    )
  );
}

/**
 * Implements hook_baseline_info_date_types().
 */
function hook_baseline_baseline_info_date_types() {
  return array(
    // Monday 29/03/1980
    array(
      'type'    => 'day',
      'title'   => 'Day',
      'locked'  => '0',
      'format' => 'l d/m/Y',
    ),
    // Monday 29/03/1980 20:50
    array(
      'type'    => 'day_hour',
      'title'   => 'Day and hour',
      'locked'  => '0',
      'format' => 'l d/m/Y - G:s',
    ),
  );
}
