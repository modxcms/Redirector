<?php
$xpdo_meta_map['modRedirect']= array (
  'package' => 'redirector',
  'version' => NULL,
  'table' => 'redirects',
  'extends' => 'xPDOSimpleObject',
  'fields' => 
  array (
    'pattern' => '',
    'target' => '',
    'context_key' => NULL,
    'active' => 1,
  ),
  'fieldMeta' => 
  array (
    'pattern' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '255',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
      'index' => 'index',
      'indexgrp' => 'pattern_context',
    ),
    'target' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '255',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
      'index' => 'index',
    ),
    'context_key' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '255',
      'phptype' => 'string',
      'null' => true,
      'default' => NULL,
      'index' => 'index',
      'indexgrp' => 'pattern_context',
    ),
    'active' => 
    array (
      'dbtype' => 'tinyint',
      'precision' => '1',
      'attributes' => 'unsigned',
      'phptype' => 'boolean',
      'null' => false,
      'default' => 1,
      'index' => 'index',
    ),
  ),
  'indexes' => 
  array (
    'pattern_context' => 
    array (
      'alias' => 'pattern_context',
      'primary' => false,
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
  'aggregates' => 
  array (
    'PatternResource' => 
    array (
      'class' => 'modResource',
      'local' => 'pattern',
      'foreign' => 'uri',
      'cardinality' => 'one',
      'owner' => 'foreign',
    ),
    'TargetResource' => 
    array (
      'class' => 'modResource',
      'local' => 'target',
      'foreign' => 'uri',
      'cardinality' => 'one',
      'owner' => 'foreign',
    ),
    'Context' => 
    array (
      'class' => 'modContext',
      'local' => 'context_key',
      'foreign' => 'key',
      'cardinality' => 'one',
      'owner' => 'foreign',
    ),
  ),
);
