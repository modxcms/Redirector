<?php

define('PKG_NAME', 'Redirector');
define('PKG_NAME_LOWER', strtolower(PKG_NAME));

require_once dirname(__FILE__).'/build.config.php';
include_once MODX_CORE_PATH . 'model/modx/modx.class.php';
require_once dirname(__FILE__).'/build.properties.php';

$modx = new modX();
$modx->initialize('mgr');
$modx->loadClass('transport.modPackageBuilder','',false, true);
$modx->setLogLevel(modX::LOG_LEVEL_INFO);
$modx->setLogTarget(XPDO_CLI_MODE ? 'ECHO' : 'HTML');

$dbDriver = $modx->config['dbtype'];
$root = dirname(dirname(__FILE__)).'/';
$sources = array(
    'root' => $root,
    'core' => $root.'core/components/redirector/',
    'model' => $root.'core/components/redirector/model/',
    'schema' => $root.'core/components/redirector/model/schema/',
    'schema_file' => $root.'core/components/redirector/model/schema/redirector.'.$dbDriver.'.schema.xml',
    'assets' => $root.'assets/components/redirector/',
);

$manager= $modx->getManager();
$generator= $manager->getGenerator();

if(!is_dir($sources['model'])) {
	$modx->log(modX::LOG_LEVEL_ERROR,'Model directory not found ('.$sources['model'].')!');
	die();
}

if(!file_exists($sources['schema_file'])) {
	$modx->log(modX::LOG_LEVEL_ERROR,'Schema file not found!');
	die();
}

$generator->parseSchema($sources['schema_file'], $sources['model']);

$modx->addPackage(PKG_NAME_LOWER, $sources['model']);
$manager->createObjectContainer('modRedirect');

$manager->addField('modRedirect', 'context_key', array('after' => 'target'));
$manager->addIndex('modRedirect', 'pattern_context');
$manager->removeIndex('modRedirect', 'pattern');
