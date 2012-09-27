<?php

/**
 * @file
 * Hooks provided by baseline module.
 */

/**
 * Do basic site setup.
 *
 * This hook is called at the very beginning of the baseline build process. Use
 * it to set up general configuration.
 */
function hook_baseline_setup() {
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
 * Setup variables during installation.
 *
 * @return array
 *   An associative array, each key being a variable name and the value being
 *   the value to initialize the variable with.
 */
function hook_baseline_info_variables() {
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
 * Setup menus during installation.
 *
 * @return array
 *   An array of menus to initialize the site with. Each menu array can contain
 *   the following keys:
 *   - title: A string to use for the menu title.
 *   - menu_name: A string for the menu's machine name.
 *   - description: (optional) A string describing the menu.
 *   - language: (optional) A string defining the menu's language.
 *   - i18n_mode: (optional) Integer for the mode this menu is localised in.
 */
function hook_baseline_info_menus() {
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
 * Setup menu links during installation.
 *
 * @return array
 *   An array containing associative arrays for each menu item. The menu item
 *   arrays have the following structure:
 *   - menu_name: The machine name of the menu the link belongs to.
 *   - link_path: A string for the path of the menu item.
 *   - link_title: The menu item title.
 *   - weight: An integer for the weight of the menu item inside the menu.
 *   - parent: (optional) Info about the parent. Contains:
 *     - menu_name: Name of the parent menu.
 *     - path: Path of the parent.
 */
function hook_baseline_info_menu_links() {
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
 * Assign blocks to regions and create custom blocks during installation.
 *
 * @return array
 *   An array of block arrays. Each block array can have the following keys:
 *   - module: A string describing the module that defines the block.
 *   - delta: The block delta.
 *   - theme: The theme name of the theme this block is being configured for.
 *   - status: A boolean integer for setting the block status.
 *   - weight: An integer definign the order of the block in the region.
 *   - region: (optional) The region to assign the block to.
 *   - title: A string for the block title. Use <none> for no title.
 *   - visibility: A constant for the visibility mode of the block. Can be one
 *     of BLOCK_VISIBILITY_LISTED, BLOCK_VISIBILITY_NOTLISTED,
 *     BLOCK_VISIBILITY_PHP
 *   - pages: A String defining the visibiluty rules of the block.
 *   - cache: The cache configuration of the block. Can be one of the following
 *     constants: DRUPAL_CACHE_PER_ROLE, DRUPAL_CACHE_PER_USER,
 *     DRUPAL_CACHE_PER_PAGE, DRUPAL_CACHE_GLOBAL, DRUPAL_NO_CACHE.
 *   - body: (optional) A string containing the block body for custom blocks.
 *   - info: (optional) A string used for the human readable name of the block,
 *     used in the administrative interface.
 *   - format: (optional) A string used for the machine name of the format the
 *     block body is using.
 *   - custom: (optional) Set to TRUE for a custom block.
 *
 * @see hook_block_info().
 */
function hook_baseline_info_blocks() {
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
 * Define date formats during installation.
 *
 * @return array
 *   An array of date format arrays. Each date format can have the following
 *   keys:
 *   - format: A string with the date format. See the php date() function.
 */
function hook_baseline_info_date_formats() {
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
 * Define date types.
 *
 * @return array
 *   An array containing date type arrays. Each date type has the following
 *   structure:
 *   - type: The machine name of the date type.
 *   - title: The human readable name of the date type.
 *   - locked: A string that can be 0 to keep the date type editable or 1 to
 *     lock it.
 *   - format: The date type's format as used in the PHP date() function.
 */
function hook_baseline_info_date_types() {
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

/**
 * Define allowed permissions for roles.
 *
 * This hook runs after hook_info_user_roles(), enabling you to assign
 * permissions to roles defined in that hook.
 *
 * @return array
 *   An array for each role you want to assign permissions to. The key for each
 *   role can be one of the following:
 *   - A string for the machine name as defined in hook_info_user_roles().
 *   - An integer for the role ID.
 *   - A constant for drupal's predefined roles:
 *     - DRUPAL_ANONYMOUS_RID: The anonymous role.
 *     - DRUPAL_AUTHENTICATED_RID: The authenticated user role.
 *
 * @see baseline_build_user_permissions().
 */
function hook_baseline_info_user_permissions() {
  $permissions = array();
  // Add permissions for the administrator role.
  $permissions['administrator'] = array(
    'access configuration and structure pages',
    'access publishing options for content',
    'access content overview',
    'access content',
    'bypass node access',
    'view own unpublished content',
    'view revisions',
  );
  // Add permissions for the anonymous user role.
  $permissions[DRUPAL_ANONYMOUS_RID] = array(
    'access content',
  );
  // Add the same permissions for the authenticated user role.
  $permissions[DRUPAL_AUTHENTICATED_RID] = $permissions[DRUPAL_ANONYMOUS_RID];

  return $permissions;
}
