<?php

class ContextsGetListProcessor extends modObjectGetListProcessor {
	public $classKey = 'modContext';
	public $languageTopics = array('redirector:default');
	public $defaultSortField = 'key';
	public $defaultSortDirection = 'ASC';
	public $objectType = 'modcontext';

    public function prepareQueryBeforeCount(xPDOQuery $c) {
		$c->where(array('key:!=' => 'mgr'));
		
		$query = $this->getProperty('query');
		if(!empty($query)) {
			$c->andCondition(array(
				'key:LIKE' => '%'.$query.'%'
			));
		}
		return $c;
    }
}
return 'ContextsGetListProcessor';