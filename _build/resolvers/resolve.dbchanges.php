<?php

$modx =& $object->xpdo;

$modx->log(xPDO::LOG_LEVEL_INFO, 'Making database changes.');
switch($options[xPDOTransport::PACKAGE_ACTION]) {
	case xPDOTransport::ACTION_INSTALL:
	case xPDOTransport::ACTION_UPGRADE:
		
		$modx =& $object->xpdo;
		$modelPath = $modx->getOption('redirector.core_path', null, $modx->getOption('core_path').'components/redirector/').'model/';
		$modx->addPackage('redirector', $modelPath);
		
		$manager = $modx->getManager();
		
		$manager->addField('modRedirect', 'context_key', array('after' => 'target'));
        $manager->addIndex('modRedirect', 'pattern_context');
        $manager->removeIndex('modRedirect', 'pattern');

        // update controller location
        $modAction = $modx->getObject('modAction', array('namespace' => 'redirector', 'controller' => 'index'));
        if(!empty($modAction) && is_object($modAction)) {
            $modAction->set('controller', 'controllers/index');
            $modAction->save();
        }

	break;
}