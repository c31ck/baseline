<?php

/**
 * @file
 * baseline commands for Drush
 */

/**
 * Implements hook_drush_command().
 */
function baseline_drush_command() {
  $items = array();
  $items['baseline'] = array(
    'description' => "Invokes hooks that get all the baseline info and then builds a baseline based on that info. to another.",
    'examples' => array(
      'drush baseline' => 'build baseline',
    ),
    'aliases' => array('bbs'),
    'bootstrap' => DRUSH_BOOTSTRAP_DRUSH,
  );
  return $items;
}

/**
 * Implementation of hook_drush_help().
 */
function baseline_drush_help($section) {
  switch ($section) {
    case 'drush:baseline':
      return dt("Build the baseline.");
  }
}

/**
 * Actual function run by the baseline command.
 */
function drush_baseline() {
  if (drush_confirm(dt('Do you want to build the baseline'))) {
    module_load_include('module', 'baseline');
    baseline_build();
    drush_print(dt('Success.'));
  }
}
