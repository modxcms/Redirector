<?php

class RedirectorUpdateProcessor extends modObjectUpdateProcessor {
    public $classKey = 'modRedirect';
    public $languageTopics = array('redirector:default');
    public $objectType = 'redirector.redirect';

    public function beforeSet() {
        $context = $this->getProperty('context_key');
        if(empty($context)) {
            $this->setProperty('context_key', NULL);
        }
        $context = $this->getProperty('context_key');

        // check if pattern is an existing resource
        $criteria = array('uri' => $this->getProperty('pattern'));
        if(!empty($context)) { $criteria['context_key'] = $context; }
        $resource = $this->modx->getObject('modResource', $criteria);
        if(!empty($resource) && is_object($resource)) {
            $this->addFieldError('pattern', 'URI exists for Resource ID '.$resource->get('id').' in "'.$resource->get('context_key').'" context... Redirect will not work!');
        }

        // check if target is an NON existing resource
        $target = $this->getProperty('target');
        if(!strpos($target, '://') && !strpos($target, '$')) {

            $this->modx->getParser();
            $this->modx->parser->processElementTags('', $target, true, true);

            $criteria = array('uri' => $target);
            if(!empty($context)) { $criteria['context_key'] = $context; }
            $resource = $this->modx->getObject('modResource', $criteria);
            if(empty($resource) || !is_object($resource)) {
                $this->addFieldError('target', 'Resource doesn\'t exists! Redirect won\'t work...');
            }
        }

        return parent::beforeSet();
    }
}

return 'RedirectorUpdateProcessor';