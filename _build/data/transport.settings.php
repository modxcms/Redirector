<?php

$s = array(
    'Manager' => array(
        'track_alias_updates' => false,
    ),
);

$settings = array();
foreach ($s as $area => $sets) {
    foreach ($sets as $key => $value) {

        $xtype = 'textfield';
        if(is_bool($value)) { $xtype = 'combo-boolean'; }

        $settings['redirector.'.$key] = $modx->newObject('modSystemSetting');
        $settings['redirector.'.$key]->set('key', 'redirector.'.$key);
        $settings['redirector.'.$key]->fromArray(array(
            'value' => $value,
            'xtype' => $xtype,
            'namespace' => 'redirector',
            'area' => $area
        ));
    }
}

return $settings;