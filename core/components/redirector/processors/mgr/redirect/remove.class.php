<?php

class RedirectorRemoveProcessor extends modObjectRemoveProcessor {
    public $classKey = 'modRedirect';
    public $languageTopics = array('redirector:default');
    public $objectType = 'redirector.redirect';
}

return 'RedirectorRemoveProcessor';