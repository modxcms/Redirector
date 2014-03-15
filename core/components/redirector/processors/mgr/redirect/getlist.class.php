<?php

class RedirectorGetListProcessor extends modObjectGetListProcessor {
    public $classKey = 'modRedirect';
    public $languageTopics = array('redirector:default');
    public $objectType = 'redirector.redirect';
    public $defaultSortField = 'pattern ASC, target';
    public $defaultSortDirection = 'ASC';

    public function prepareQueryBeforeCount(xPDOQuery $c) {

        $query = $this->getProperty('query');
        if(!empty($query)) {
            $c->andCondition(array(
                'pattern:LIKE' => '%'.$query.'%',
                'OR:target:LIKE' => '%'.$query.'%',
            ));
        }

        $context = $this->getProperty('context');
        if(!empty($context)) {
            $c->andCondition(array(
                'context_key:LIKE' => '%'.$context.'%',
            ));
        }

        return $c;
    }

    public function prepareRow(xPDOObject $object) {
        $arr = $object->toArray();
        $arr['valid'] = true;
        $arr['resource_id'] = '';
        $arr['resource_ctx'] = '';

        // find out if pattern URI exists
        $criteria = array('uri' => $object->get('pattern'));
        if(!empty($arr['context_key'])) {
            $criteria['context_key'] = $object->get('context_key');
        }

        $resource = $this->modx->getObject('modResource', $criteria);
        if(!empty($resource) && is_object($resource)) {
            $arr['resource_id'] = $resource->get('id');
            $arr['resource_ctx'] = $resource->get('context_key');
            $arr['valid'] = false;
        }

        // OR target not exists
        if(!strpos($arr['target'], '://') && !strpos($arr['target'], '$')) {
            $criteria = array('uri' => $object->get('target'));
            if(!empty($arr['context_key'])) {
                $criteria['context_key'] = $object->get('context_key');
            }

            $resource = $this->modx->getObject('modResource', $criteria);
            if(empty($resource) || !is_object($resource)) {
                $arr['valid'] = false;
            }
        }

        return $arr;
    }
}

return 'RedirectorGetListProcessor';