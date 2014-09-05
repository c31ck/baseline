<?php

/**
 * @file
 * Baseline build functions.
 */

/**
 * Creates aliases
 *
 * @param array $alias_info
 *  Array containing alias info.
 */
function baseline_build_aliases($alias_info) {
  foreach ($alias_info as $source => $alias_language_info) {
    foreach ($alias_language_info as $langcode => $alias) {
      baseline_api_create_path_alias($source, $alias, $langcode);
    }
  }
}

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
 * Creates nodes.
 *
 * @param array $nodes
 *   Nodes info.
 */
function baseline_build_nodes($nodes) {
  foreach ($nodes as $node) {
    baseline_api_create_node($node);
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
                ->fields($menu_info)
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

/**
 * Creates user roles.
 *
 * This will create a variable 'baseline_user_role_ids' containing an array
 * mapping the keys of the roles passed to this funtion to the generated role
 * ids.
 *
 * @param array $roles
 *   An array of user roles to create.
 *
 * @see hook_baseline_info_user_roles().
 */
function baseline_build_user_roles($roles) {
  $existing_roles = user_roles(TRUE);
  // Save the role ids so we can save them to a variable.
  $role_id_mapping = array();
  foreach ($roles as $role_name => $role) {
    $role = (object) $role;
    // If the role exists we update the role.
    $rid = array_search($role_name, $existing_roles);
    if ($rid) {
      $role->rid = $rid;
    }
    // Save the role to the database.
    user_role_save($role);
    $role_id_mapping[$role_name] = $role->rid;
  }
  // Set the variable for being able to access the role ids generated for the
  // roles later in the build process.
  variable_set('baseline_user_role_ids', $role_id_mapping);
}

/**
 * Assigns user permissions to roles.
 *
 * @param array $roles
 *   For each role an array of permissions to assign to that role. The array
 *   is keyed by role id or machine name.
 *
 * @see hook_baseline_info_user_permissions()
 */
function baseline_build_user_permissions($roles) {
  // Fetch the role ids set up by hook_baseline_info_user_permissions().
  $role_ids = variable_get('baseline_user_role_ids', array());
  // Get a list of existing permissions.
  $existing_permissions = array_keys(user_permission_get_modules());

  foreach ($roles as $rid => $permissions) {
    // Find out the role id if a machine name was used.
    if (!is_numeric($rid) && isset($role_ids[$rid])) {
      $rid = $role_ids[$rid];
    }
    // Replace machine names by their ID within the current environment
    $permissions = baseline_replace_permission_ids($permissions);
    // Filter permissions that don't exists.
    $permissions = array_intersect($permissions, $existing_permissions);
    // Save the permissions for this role.
    user_role_grant_permissions($rid, $permissions);
  }
}

/**
 * Replaces machine names by IDs in permissions.
 *
 * @param array $permissions
 *   An array of permission names.
 *
 * @return array
 *   An array of permissions with the machine names replaced.
 */
function baseline_replace_permission_ids($permissions) {
  // An array of replacement pattern for each entity type. The key is pattern
  // and the value the ID type (nid, vid, rid, ...).
  $replacements = array(
    'delete terms in ' => 'vid',
    'edit terms in '=> 'vid',
  );

  foreach ($permissions as $i => $permission) {
    foreach ($replacements as $pattern => $key_type) {
      if (strpos($permission, $pattern) === 0) {
        $machine_name = drupal_substr($permission, drupal_strlen($pattern));
        $key = $machine_name;
        // Look for a vocabulary ID.
        if ($key_type == 'vid') {
          $vocabulary = taxonomy_vocabulary_machine_name_load($machine_name);
          if ($vocabulary) {
            $key = $vocabulary->vid;
          }
        }
        // Rebuild the permission.
        $permissions[$i] = $pattern . $key;
      }
    }
  }
  return $permissions;
}

/**
 * Create nodequeues.
 *
 * @param array $nodeqeueus
 *   An array of nodeqeues, keyed by machine name.
 */
function baseline_build_nodequeues($nodequeues) {
  foreach ($nodequeues as $nodequeue) {
    $nodequeue = (object) $nodequeue;
    // Fetch the nodequeue if it already exists so it can be updated instead of
    // saved.
    $existing_nodequeue = nodequeue_load_queue_by_name($nodequeue->name);
    if (isset($existing_nodequeue->qid)) {
      $nodequeue->qid = $existing_nodequeue->qid;
      // Make sure the subqueues aren't added indefinitely.
      if (isset($nodequeue->add_subqueue)) {
        unset($nodequeue->add_subqueue);
      }
    }
    // Save the new or updated nodequeue.
    nodequeue_save($nodequeue);
  }
}


/**
 * Creates or updates taxonomy vocabularies.
 *
 * @param array $vocabularies
 *   An array of vocabularies. See the return value of
 *   hook_baseline_info_taxonomy_vocabularies().
 */
function baseline_build_taxonomy_vocabularies($vocabularies) {
  $existing = taxonomy_vocabulary_get_names();
  foreach ($vocabularies as $machine_name => $vocabulary) {
    $vocabulary = (object) $vocabulary;
    $vocabulary->machine_name = $machine_name;
    // Check if the vocabulary doesn't already exist so we can update it.
    if (isset($existing[$machine_name])) {
      $vocabulary->vid = $existing[$machine_name]->vid;
    }
    taxonomy_vocabulary_save($vocabulary);
  }
}

/**
 * Creates or updates taxonomy terms.
 *
 * @param array $terms
 *   An array of terms. See the return value of
 *   hook_baseline_info_taxonomy_terms().
 */
function baseline_build_taxonomy_terms($terms) {
  $vocabularies = taxonomy_vocabulary_get_names();
  foreach ($terms as $term) {
    $term = (object) $term;
    // Only save the term if it has an existing vocabulary.
    if (isset($term->vocabulary) && isset($vocabularies[$term->vocabulary])) {
      $term->vid = $vocabularies[$term->vocabulary]->vid;
      // Check if a term with the same name in the vocabulary already exists.
      $existing = taxonomy_get_term_by_name($term->name, $term->vocabulary);
      if (!empty($existing)) {
        $first = array_shift($existing);
        $term->tid = $first->tid;
      }
      // Remove the vocabulary property because it's not saved to the db.
      unset($term->vocabulary);
      taxonomy_term_save($term);
    }
  }
}
