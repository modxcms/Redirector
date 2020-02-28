<?php
/**
 * Redirector connector
 *
 * @package redirector
 * @subpackage connector
 *
 * @var modX $modx
 */

require_once dirname(dirname(dirname(dirname(__FILE__)))) . '/config.core.php';
require_once MODX_CORE_PATH . 'config/' . MODX_CONFIG_KEY . '.inc.php';
require_once MODX_CONNECTORS_PATH . 'index.php';

$corePath = $modx->getOption('redirector.core_path', null, $modx->getOption('core_path') . 'components/redirector/');
/** @var Redirector $redirector */
$redirector = $modx->getService('redirector', 'Redirector', $corePath . 'model/redirector/', array(
    'core_path' => $corePath
));

/* handle request */
$path = $modx->getOption('processorsPath', $modx->redirector->config, $corePath . 'processors/');
$modx->request->handleRequest(array(
    'processors_path' => $path,
    'location' => '',
));