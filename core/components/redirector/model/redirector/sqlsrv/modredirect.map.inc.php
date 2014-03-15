<?php
/**
 * @package redirector
 */
$xpdo_meta_map['modRedirect']= array (
  'package' => 'redirector',
  'table' => 'redirects',
  'fields' => 
  array (
    'pattern' => '',
    'target' => '',
    'context_key' => '',
    'active' => 1,
  ),
  'fieldMeta' => 
  array (
    'pattern' => 
    array (
      'dbtype' => 'nvarchar',
      'precision' => '255',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
      'index' => 'unique',
    ),
    'target' => 
    array (
      'dbtype' => 'nvarchar',
      'precision' => '255',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
      'index' => 'index',
    ),
    'context_key' =>
    array (
      'dbtype' => 'nvarchar',
      'precision' => '255',
      'phptype' => 'string',
      'null' => true,
      'default' => null,
      'index' => 'index',
    ),
    'active' => 
    array (
      'dbtype' => 'bit',
      'phptype' => 'boolean',
      'null' => false,
      'default' => 1,
      'index' => 'index',
    ),
  ),
  'indexes' =>
  array(
    'pattern_context' =>
    array (
      'alias' => 'pattern_context',
      'primary' => true,
      'unique' => true,
      'type' => 'BTREE',
      'columns' =>
      array (
        'pattern' =>
        array (
          'length' => '100',
          'collation' => 'A',
          'null' => false,
        ),
        'context_key' =>
        array (
          'length' => '100',
          'collation' => 'A',
          'null' => false,
        ),
      ),
    ),
  ),
);
