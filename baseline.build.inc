<?php

/**
 * @file
 * Baseline build functions.
 */

/**
 * Creates blocks.
 *
 * @param array $blocks_info
 *   Blocks info.
 */
function baseline_build_blocks($blocks_info) {
  foreach ($blocks_info as $block_info) {
    $is_custom_block = (isset($block_info['custom']) && $block_info['custom'] === TRUE) ? TRUE : FALSE;
    if ($is_custom_block) {
      baseline_api_create_custom_block($block_info);
    }
    else {
      baseline_api_create_block($block_info);
    }
  }
}

/**
 * Creates menus.
 *
 * @param array
 *   Menus info.
 */
function baseline_build_menus($menus) {
  foreach ($menus as $menu_info) {
    $query = db_merge('menu_custom')
                ->key(array('menu_name' => $menu_info['menu_name']))
                ->fields(array(
                    'menu_name'   => $menu_info['menu_name'],
                    'title'       => $menu_info['title'],
                    'description' => $menu_info['description'],
                    'language'    => $menu_info['language'],
                    'i18n_mode'   => $menu_info['i18n_mode'],
                 ))
                ->execute();
  }
}

/**
 * Builds date formats.
 *
 * @param array $formats
 *   List of date formats.
 */
function baseline_build_date_formats($formats) {
  foreach ((array) $formats as $format) {
    baseline_api_create_date_format($format);
  }
}

/**
 * Builds date types.
 *
 * @param array $types
 *   List of date types.
 */
function baseline_build_date_types($types) {
  foreach ((array) $types as $type) {
    baseline_api_create_date_type($type);
  }
}

/**
 * Builds menu links.
 *
 * @param array $menu_links_info
 *   Menu links info.
 */
function baseline_build_menu_links($menu_links_info) {
  foreach ($menu_links_info as $menu_link_info) {
    baseline_api_create_menu_link($menu_link_info);
  }
}

/**
 * Builds general config.
 *
 * @param array $variables
 *   Variables. info.
 */
function baseline_build_variables($variables) {
  foreach ((array) $variables as $name => $value) {
    variable_set($name, $value);
  }
}
