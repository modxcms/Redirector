<?php

require_once dirname(dirname(__FILE__)) . '/model/redirector/redirector.class.php';

abstract class RedirectorManagerController extends modExtraManagerController {

    /** @var Redirector $redirector */
    public $redirector;

    public function initialize() {
        $this->redirector = new Redirector($this->modx);
        
        $this->addCss($this->redirector->config['cssUrl'].'mgr.css');
        $this->addJavascript($this->redirector->config['jsUrl'].'mgr/redirector.js');
        $this->addJavascript($this->redirector->config['jsUrl'].'mgr/combos.js');
        $this->addHtml('<script type="text/javascript">
        Ext.onReady(function() {
            Redi.config = '.$this->modx->toJSON($this->redirector->config).';
            Redi.config.connector_url = "'.$this->redirector->config['connectorUrl'].'";
            Redi.request = '.$this->modx->toJSON($_GET).';
        });
        </script>');
        return parent::initialize();
    }

    public function getLanguageTopics() {
        return array('redirector:default');
    }

    public function checkPermissions() { return true;}
}

class ControllersIndexManagerController extends RedirectorManagerController {
    public static function getDefaultController() { return 'home'; }
}