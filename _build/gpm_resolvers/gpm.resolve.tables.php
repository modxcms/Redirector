<?php
/**
 * Resolve creating db tables
 *
 * THIS RESOLVER IS AUTOMATICALLY GENERATED, NO CHANGES WILL APPLY
 *
 * @package redirector
 * @subpackage build
 *
 * @var mixed $object
 * @var modX $modx
 * @var array $options
 */

if ($object->xpdo) {
    $modx =& $object->xpdo;
    switch ($options[xPDOTransport::PACKAGE_ACTION]) {
        case xPDOTransport::ACTION_INSTALL:
        case xPDOTransport::ACTION_UPGRADE:
            $modelPath = $modx->getOption('redirector.core_path', null, $modx->getOption('core_path') . 'components/redirector/') . 'model/';
            
            $modx->addPackage('redirector', $modelPath, null);


            $manager = $modx->getManager();

            $manager->createObjectContainer('modRedirect');

            break;
    }
}

return true;