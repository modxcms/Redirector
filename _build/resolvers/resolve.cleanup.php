<?php
/**
 * Resolve cleanup
 *
 * @package backupmodx
 * @subpackage build
 *
 * @var array $options
 * @var xPDOObject $object
 */

$success = false;

if ($object->xpdo) {
    /** @var xPDO $modx */
    $modx =& $object->xpdo;

    switch ($options[xPDOTransport::PACKAGE_ACTION]) {
        case xPDOTransport::ACTION_INSTALL:
        case xPDOTransport::ACTION_UPGRADE:
            $c = $modx->newQuery('transport.modTransportPackage');
            $c->where(
                array(
                    'workspace' => 1,
                    "(SELECT
            `signature`
            FROM {$modx->getTableName('modTransportPackage')} AS `latestPackage`
            WHERE `latestPackage`.`package_name` = `modTransportPackage`.`package_name`
            ORDER BY
                `latestPackage`.`version_major` DESC,
                `latestPackage`.`version_minor` DESC,
                `latestPackage`.`version_patch` DESC,
                IF(`release` = '' OR `release` = 'ga' OR `release` = 'pl','z',`release`) DESC,
                `latestPackage`.`release_index` DESC
                LIMIT 1,1) = `modTransportPackage`.`signature`",
                )
            );
            $c->where(
                array(
                    'modTransportPackage.signature:LIKE' => $options['namespace'] . '-%',
                    'modTransportPackage.installed:IS NOT' => null
                )
            );
            $c->limit(1);

            /** @var modTransportPackage $oldPackage */
            $oldPackage = $modx->getObject('transport.modTransportPackage', $c);

            $oldVersion = '';
            if ($oldPackage) {
                $oldVersion = $oldPackage->get('version_major') .
                    '.' . $oldPackage->get('version_minor') .
                    '.' . $oldPackage->get('version_patch') .
                    '-' . $oldPackage->get('release');
            }

            if ($oldPackage && $oldPackage->compareVersion('2.0.5', '>')) {
                // add database fields
                $modelPath = $modx->getOption('redirector.core_path', null, $modx->getOption('core_path').'components/redirector/').'model/';
                $modx->addPackage('redirector', $modelPath);

                /** @var xPDOManager $manager */
                $manager = $modx->getManager();

                $manager->addField('modRedirect', 'context_key', array('after' => 'target'));

                $manager->addIndex('modRedirect', 'pattern');
                $manager->addIndex('modRedirect', 'context_key');
                $manager->removeIndex('modRedirect', 'pattern_context');

                $manager->addField('modRedirect', 'triggered', array('after' => 'context_key'));
                $manager->addField('modRedirect', 'triggered_first', array('after' => 'triggered'));
                $manager->addField('modRedirect', 'triggered_last', array('after' => 'triggered_first'));

                // update controller location
                $modAction = $modx->getObject('modAction', array('namespace' => 'redirector', 'controller' => 'index'));
                if(!empty($modAction) && is_object($modAction)) {
                    $modAction->set('controller', 'controllers/index');
                    $modAction->save();
                    $modx->log(xPDO::LOG_LEVEL_INFO, 'Updated controller location.');
                }

                // remove old system setting
                $setting = $modx->getObject('modSystemSetting', array('key' => 'redirector.track_alias_updates'));
                if(!empty($setting) && is_object($setting)) {
                    $setting->remove();
                    $modx->log(xPDO::LOG_LEVEL_INFO, 'Removed redirector.track_alias_updates legacy system settings.');
                }
            }

            $success = true;
            break;
        case xPDOTransport::ACTION_UNINSTALL:
            $success = true;
            break;
    }
}
return $success;
