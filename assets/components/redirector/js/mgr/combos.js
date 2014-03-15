Redi.combo.ResourceList = function(config) {
    config = config || {};
    Ext.applyIf(config, {
        name: 'resource',
		hiddenName: 'resource',
		displayField: 'pagetitle',
		valueField: 'id',
		fields: ['id','pagetitle'],
		forceSelection: true,
		typeAhead: true,
		editable: true,
		allowBlank: true,
		autocomplete: true,
		url: Redi.config.connector_url,
		baseParams: {
            action: 'mgr/resources/getList',
			combo: true
        }
    });
	
    Redi.combo.ResourceList.superclass.constructor.call(this, config);
};

Ext.extend(Redi.combo.ResourceList, MODx.combo.ComboBox);
Ext.reg('redirector-combo-resourcelist', Redi.combo.ResourceList);

Redi.combo.ContextList = function(config) {
    config = config || {};
    Ext.applyIf(config, {
        name: 'context_key',
		hiddenName: 'context_key',
		displayField: 'key',
		valueField: 'key',
		fields: ['key'],
		forceSelection: true,
		typeAhead: true,
		editable: true,
		allowBlank: true,
		autocomplete: true,
		url: Redi.config.connector_url,
		baseParams: {
            action: 'mgr/contexts/getList',
			combo: true
        }
    });

    Redi.combo.ContextList.superclass.constructor.call(this, config);
};

Ext.extend(Redi.combo.ContextList, MODx.combo.ComboBox);
Ext.reg('redirector-combo-contextlist', Redi.combo.ContextList);