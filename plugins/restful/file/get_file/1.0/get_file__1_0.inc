<?php

$plugin = array(
  'label' => t('Get a file'),
  'name' => 'get_file__1_0',
  'resource' => 'get_file',
  'entity_type' => 'file',
  'description' => t('Get a file.'),
  'class' => 'RestfulGetFile',
  'authentication_types' => TRUE,
  'formatter' => 'file',
  // We will implement hook_menu() with custom settings.
  'menu_item' => variable_get('restful_hook_menu_base_path', 'api') . '/get-file',
);
