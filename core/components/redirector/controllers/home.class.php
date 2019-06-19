<?php

class RedirectorHomeManagerController extends modExtraManagerController {
    /**
     * @var Redirector $redirector
     */
    public $redirector;

    public function initialize() {
        $path = $this->modx->getOption('redirector.core_path', null, MODX_CORE_PATH . 'components/redirector/');
        $this->redirector = $this->modx->getService('redirector', 'model.redirector.Redirector', $path);

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

    public function getPageTitle() {
        return $this->modx->lexicon('redirector');
    }

    public function loadCustomCssJs() {
        $this->addJavascript($this->redirector->config['jsUrl'].'mgr/utils/fileuploadfield.xtype.js');

        $this->addJavascript($this->redirector->config['jsUrl'].'mgr/widgets/redirects.grid.js');
        $this->addJavascript($this->redirector->config['jsUrl'].'mgr/widgets/home.panel.js');
        $this->addJavascript($this->redirector->config['jsUrl'].'mgr/sections/index.js');
        $this->addHtml('<script type="text/javascript">
        Ext.onReady(function() {
            MODx.load({ xtype: "redirector-page-home"});
        });
        </script>');
    }

    public function getTemplateFile() {
        return $this->redirector->config['templatesPath'].'home.tpl';
    }
}
