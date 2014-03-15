<?php

class RedirectorHomeManagerController extends RedirectorManagerController {
    public function process(array $scriptProperties = array()) {

    }

    public function getPageTitle() { return $this->modx->lexicon('redirector'); }

    public function loadCustomCssJs() {
        $this->addJavascript($this->redirector->config['jsUrl'].'mgr/utils/fileuploadfield.xtype.js');

        $this->addJavascript($this->redirector->config['jsUrl'].'mgr/widgets/redirects.grid.js');
        $this->addJavascript($this->redirector->config['jsUrl'].'mgr/widgets/home.panel.js');
        $this->addLastJavascript($this->redirector->config['jsUrl'].'mgr/sections/index.js');
    }

    public function getTemplateFile() { return $this->redirector->config['templatesPath'].'home.tpl'; }
}