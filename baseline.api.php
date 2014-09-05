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
 * Finish site setup.
 *
 * Use this hook for things that need to be done after everything else.
 */
function hook_baseline_finish() {
  $user_roles = array_flip(user_roles());
  $rid = $user_roles['administrator'];
  variable_set('user_admin_role', $rid);
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
    'theme_mysitename_settings' => array(
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
      'zen_html5_respond_meta' => array(
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
 * Creates simple nodes during installation.
 *
 * @return array
 *  An array of nodes to initialize the site with. Each node array can contain
 *  the following keys:
 *  - nid: incrementing value along the array. The nid is used for updates
 *    and can be used in menu links.
 *  - title: A string to user for the node title.
 *  - type: the node type.
 *  - language: A string defining the node's language.
 */
function hook_baseline_info_nodes() {
  return array(
    array(
      'nid' => '1',
      'title' => 'About us',
      'type' => 'page',
      'language' => 'en',
    ),
    array(
      'nid' => '2',
      'title' => 'Title of the seconde node',
      'type' => 'page',
      'language' => 'nl',
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
      'i18n_mode'   => 5,
    ),
    array(
      'title'       => 'Main menu',
      'menu_name'   => 'main-menu',
      'description' => 'The <em>Main</em> menu is used on many sites to show the major sections of the site, often in a top navigation bar.',
      'language'    => LANGUAGE_NONE,
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
 *   - options: (optional) An array of options, see l() for more.
 *   - router_path: (optional) The path of the relevant router item (new link)
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
 *   - types: (optional) An array of content types for block visbility.
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
      'title' => '<none>',
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
      'title' => '<none>',
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
      'title' => '<none>',
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
      'title' => '<none>',
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
      'title' => '<none>',
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
      'title' => '<none>',
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
      'title' => '<none>',
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
      'title' => 'Follow mysitename',
      'pages' => '',
      'cache' => -1,
      'types' => array('page', 'article'),
    ),
    // Custom blocks
    array(
      'module' => 'block',
      'delta' => 1,
      'theme' => $theme,
      'status' => 1,
      'weight' => 1,
      'region' => 'sidebar_first',
      'title' => 'Search our supplier index.',
      'pages' => '',
      'cache' => -1,
      'body' => 'Search our supplier index. <a href="#" class="button">Search index</a>',
      'info' => 'Search our supplier index.',
      'format' => 'filtered_html',
      'custom' => TRUE,
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
      'format' => 'l d/m/Y - G:i',
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
      'format'  => 'l d/m/Y',
    ),
    // Monday 29/03/1980 20:50
    array(
      'type'    => 'day_hour',
      'title'   => 'Day and hour',
      'locked'  => '0',
      'format'  => 'l d/m/Y - G:i',
    ),
  );
}

/**
 * Define allowed permissions for roles.
 *
 * This hook runs after hook_info_user_roles(), enabling you to assign
 * permissions to roles defined in that hook.
 *
 * IMPORTANT:
 *
 * Some permissions use IDs instead of machine names. When defining them in the
 * hook replace the ID by the machine name. On baseline build baseline will
 * replace the machine name by the ID so permissions can be easily deployed
 * on other environments.
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
    'edit terms in tags',
  );
  // Add permissions for the anonymous user role.
  $permissions[DRUPAL_ANONYMOUS_RID] = array(
    'access content',
  );
  // Add the same permissions for the authenticated user role.
  $permissions[DRUPAL_AUTHENTICATED_RID] = $permissions[DRUPAL_ANONYMOUS_RID];

  return $permissions;
}

/**
 * Define user roles.
 *
 * @return array
 *   An array of user roles, keyed by machine name. Each user role is an array
 *   with the following keys:
 *   - name: The unique name of the role.
 *   - weight: An integer for the weight of the role.
 */
function hook_baseline_info_user_roles() {
  return array(
    'administrator' => array(
      'name' => 'administrator',
      'weight' => 2,
    ),
    'webmaster' => array(
      'name' => 'webmaster',
      'weight' => 5,
    ),
  );
}

/**
 * Define nodequeues.
 *
 * @return array
 *   An array of nodequeues, keyed by machine name.
 */
function hook_baseline_info_nodequeues() {
  $t = get_t();
  $nodequeues = array(
    'residential_teaser' => array(
      'title' => $t('residential_teaser'),
      'name' => 'residential_teaser',
      'subqueue_title' => $t('residential_teaser'),
      'size' => 0,
      'reverse' => 0,
      'link' => '',
      'link_remove' => '',
      'roles' => array(),
      'types' => array(0 => 'banner'),
      'i18n' => 0,
      'owner' => 'nodequeue',
      'show_in_links' => FALSE,
      'show_in_tab' => TRUE,
      'show_in_ui' => TRUE,
      'add_subqueue' => array(0 => $t('residential_teaser')),
    ),
    'residential_full' => array(
      'title' => $t('residential_full'),
      'name' => 'residential_full',
      'subqueue_title' => $t('residential_full'),
      'size' => 0,
      'reverse' => 0,
      'link' => '',
      'link_remove' => '',
      'roles' => array(),
      'types' => array(0 => 'banner'),
      'i18n' => 0,
      'owner' => 'nodequeue',
      'show_in_links' => FALSE,
      'show_in_tab' => TRUE,
      'show_in_ui' => TRUE,
      'add_subqueue' => array(0 => $t('residential_full')),
    ),
  );

  return $nodequeues;
}

/**
 * Define taxonomy vocabularies.
 *
 * @return array
 *   An array of taxonomy vocabulary arrays, keyed by machine name witht the
 *   following keys:
 *   - name: The human readable name of the vocabulary.
 *   - description: The description of the vocabulary (optional).
 *   - module: The module that created the vocabulary (optional, defaults to
 *     taxonomy).
 *   - weight: The position where the vocabulary is displayed in forms (optional,
 *     defaults to 0).
 */
function hook_baseline_info_taxonomy_vocabularies() {
  return array(
    'section' => array(
      'name' => 'Section',
      'description' => 'The section where the content should be aggregated.',
    ),
    'search_group' => array(
      'name' => 'Search Group',
      'description' => 'The taxonomy to group search results by.',
    ),
  );
}

/**
 * Define taxonomy terms.
 *
 * Note that this will update terms if a term with the exact same name exists
 * in the vocabulary.
 *
 * @return array
 *   An array of taxonomy term arrays, each having the following keys:
 *   - name: The human readable name of the term.
 *   - vocabulary: The machine name of the vocabulary the term belongs to.
 *   - description: The description of the term (optional).
 *   - format: The format of the description (optional).
 *   - weight: The order in which the term appears (optional, defaults to 0).
 *   - parent: The term name of the parent (optional).
 *
 * @todo Add support for updating term names (e.g. an extra key with the current
 *   term name).
 * @todo Add support for hierarchy.
 */
function hook_baseline_info_taxonomy_terms() {
  return array(
    array(
      'name' => 'News',
      'vocabulary' => 'section',
    ),
    array(
      'name' => 'Resources',
      'vocabulary' => 'section',
    ),
    array(
      'name' => 'Articles',
      'vocabulary' => 'search_group',
    ),
    array(
      'name' => 'Resources',
      'vocabulary' => 'search_group',
    ),
    array(
      'name' => 'Videos',
      'vocabulary' => 'search_group',
    ),
    array(
      'name' => 'Galleries',
      'vocabulary' => 'search_group',
    ),
  );
}
