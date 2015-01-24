Redi.grid.Redirects = function(config) {
    config = config || {};

    var cb = new Ext.ux.grid.CheckColumn({
        header: _('redirector.active')
        ,dataIndex: 'active'
        ,width: 40
        ,sortable: true
        ,onMouseDown: this.saveCheckbox
    });

    var exp = new Ext.grid.RowExpander({
        tpl: new Ext.Template('<p style="margin-top: 8px">{failure_msg}</p>')
        ,renderer: function(v, p, record){
            return record.get('failure_msg').length > 0 ? '<div class="x-grid3-row-expander">&#160;</div>' : '&#160;';
        }
        ,getRowClass : function(record, rowIndex, p, ds){
            p.cols = p.cols-1;
            var content = this.bodyContent[record.id];
            if(!content && !this.lazyRender){
                content = this.getBodyContent(record, rowIndex);
            }
            if(content){
                p.body = content;
            }

            var cls = this.state[record.id] ? 'x-grid3-row-expanded' : 'x-grid3-row-collapsed';
                cls += ' ' + ((!record.data.valid) ? 'grid-row-invalid' : 'grid-row-valid');
            return cls;
        }
        ,expandOnEnter: false
        ,expandOnDblClick: false
        ,enableCaching: false
    });

    Ext.applyIf(config,{
        id: 'redirector-grid-redirects'
        ,url: Redi.config.connector_url
        ,baseParams: { action: 'mgr/redirect/getList' }
        ,fields: ['id','pattern','target','context_key','triggered','triggered_first','triggered_last','valid','failure_msg','active']
        ,save_action: 'mgr/redirect/updateFromGrid'
        ,save_callback: function(r) {
            if(!r.success) {
                Ext.MessageBox.alert(_('error'), r.data[0].msg);
            }
            this.refresh();
        }
        ,autosave: true
        ,paging: true
        ,remoteSort: true

        ,viewConfig: {
            forceFit: true
            ,scrollOffset: 0
            ,autoFill: true
            ,showPreview: true
            ,emptyText: _('redirector.nothing_found')
        }

        ,anchor: '97%'
        ,autoExpandColumn: 'name'
        ,plugins: [exp, cb]
        ,columns: [exp, {
            header: _('id')
            ,dataIndex: 'id'
            ,sortable: true
            ,width: 25
            ,hidden: true
        },{
            header: _('redirector.pattern')
            ,dataIndex: 'pattern'
            ,sortable: true
            ,editor: { xtype: 'textfield' }
            ,renderer: this.renderPattern.createDelegate(this,[this],true)
        },{
            header: _('redirector.target')
            ,dataIndex: 'target'
            ,sortable: true
            ,editor: { xtype: 'textfield' }
        },{
            header: _('redirector.context')
            ,dataIndex: 'context_key'
            ,sortable: true
            ,width: 50
            ,editor: { xtype: 'redirector-combo-contextlist' }
        },{
            header: _('redirector.triggered')
            ,dataIndex: 'triggered'
            ,sortable: true
            ,width: 50
        },{
            header: _('redirector.triggered_first')
            ,dataIndex: 'triggered_first'
            ,sortable: true
            ,hidden: true
        },{
            header: _('redirector.triggered_last')
            ,dataIndex: 'triggered_last'
            ,sortable: true
        },cb]
        ,tbar: [{
            text: _('redirector.redirect_create')
            ,handler: { xtype: 'redirector-window-redirect-createupdate' ,blankValues: true ,update: false }
        },'->',{
            xtype: 'redirector-combo-contextlist'
            ,id: 'redirector-context-filter'
            ,emptyText: _('redirector.context')
            ,listeners: {
                'select': { fn: this.searchContext ,scope: this }
                ,'change': { fn: this.searchContext ,scope: this }
            }
        },'-',{
            xtype: 'textfield'
            ,id: 'redirector-search-filter'
            ,emptyText: _('redirector.search...')
            ,listeners: {
                'change': { fn: this.search ,scope: this }
                ,'render': { fn: function(cmp) {
                    new Ext.KeyMap(cmp.getEl(), {
                        key: Ext.EventObject.ENTER
                        ,fn: function() {
                            this.fireEvent('change',this.getValue());
                            this.blur();
                            return true; }
                        ,scope: cmp
                    });
                } ,scope: this }
            }
        }]
    });
    Redi.grid.Redirects.superclass.constructor.call(this,config)
};
Ext.extend(Redi.grid.Redirects,MODx.grid.Grid,{
    saveRecord: function(e) {
        e.record.data.menu = null;
        var p = this.config.saveParams || {};
        Ext.apply(e.record.data,p);
        var d = Ext.util.JSON.encode(e.record.data);
        var url = this.config.saveUrl || (this.config.url || this.config.connector);

        MODx.Ajax.request({
            url: url
            ,params: {
                action: this.config.save_action || 'updateFromGrid'
                ,data: d
            }
            ,listeners: {
                'failure': {fn:function(r) {
                    if (this.config.save_callback) {
                        Ext.callback(this.config.save_callback,this.config.scope || this,[r]);
                    }
                    this.fireEvent('afterAutoSave',r);
                    if (!this.config.preventSaveRefresh) {
                        this.refresh();
                    }
                } ,scope:this }
                ,'success': {fn:function(r) {
                    if (this.config.save_callback) {
                        Ext.callback(this.config.save_callback,this.config.scope || this,[r]);
                    }
                    e.record.commit();
                    if (!this.config.preventSaveRefresh) {
                        this.refresh();
                    }
                    this.fireEvent('afterAutoSave',r);
                },scope:this}
            }
        });
    }


    ,search: function(tf,nv,ov) {
        var s = this.getStore();
            s.baseParams.query = tf.getValue();
        this.getBottomToolbar().changePage(1);
        this.refresh();
    }
    ,searchContext: function(tf,nv,ov) {
        var s = this.getStore();
            s.baseParams.context = tf.getValue();
        this.getBottomToolbar().changePage(1);
        this.refresh();
    }
    ,getMenu: function(g,ri) {
		var m = [];
        m.push({
            text: _('redirector.redirect_update')
            ,handler: this.updateRedirect
        },'-',{
            text: _('redirector.redirect_remove')
            ,handler: this.removeRedirect
        });
        return m;
    }
    ,saveCheckbox: function(e, t){
        var rowData = false;
        /* checks/unchecks */
        if(t.className && t.className.indexOf('x-grid3-cc-'+this.id) != -1){
            e.stopEvent();
            var index = this.grid.getView().findRowIndex(t);
            var record = this.grid.store.getAt(index);
            record.set(this.dataIndex, !record.data[this.dataIndex]);
            rowData = record.data; /*save row records. will be used in the ajax request */
        }

        /*don't send the ajax request if the rowData is empty. rowData is empty if the row is clicked. */
        if (!rowData) return;

        /* send ajax request to update the data */
        MODx.Ajax.request({
            url: Redi.config.connector_url
            ,params: {
                action : 'mgr/redirect/updateFromGrid'
                ,data: Ext.util.JSON.encode(rowData)
            }
            ,method: 'POST'
            ,listeners: {
                'success': {fn: function(r) {
                    Ext.getCmp('redirector-grid-redirects').getStore().commitChanges();
                },scope: this}
            }
        });
    }
    ,updateRedirect: function(btn,e) {
        var w = MODx.load({
			xtype: 'redirector-window-redirect-createupdate'
			,record: this.menu.record
            ,update: true
			,listeners: {
				'success': { fn: this.refresh, scope: this }
				,'hide': { fn: function() { this.destroy(); }}
			}
		});
		w.setValues(this.menu.record);
		w.show(e.target, function() {
			Ext.isSafari ? w.setPosition(null,30) : w.center();
		}, this);
    }
    ,removeRedirect: function() {
        MODx.msg.confirm({
            title: _('redirector.redirect_remove')
            ,text: _('redirector.redirect_remove_confirm')
            ,url: this.config.url
            ,params: {
                action: 'mgr/redirect/remove'
                ,id: this.menu.record.id
            }
            ,listeners: {
                'success': {fn:this.refresh,scope:this}
            }
        });
    }
    /** RENDERERS **/
    ,renderPattern: function(v,md,rec,ri,ci,s,g) {
        var r = s.getAt(ri).data;
        if(!Ext.isEmpty(r.resource_id)) {
            v += ' <i>(' + _('resource') + ': ' + r.resource_id + ' - ' + r.resource_ctx + ')</i>';
        }
        return v;
    }
});
Ext.reg('redirector-grid-redirects',Redi.grid.Redirects);


Redi.window.CreateUpdateRedirect = function(config) {
    config = config || {};
    this.ident = config.ident || Ext.id();

    Ext.applyIf(config,{
        title: _('redirector.redirect_create')
        ,url: Redi.config.connector_url
        ,baseParams: { action: ((config.update) ? 'mgr/redirect/update' : 'mgr/redirect/create') }
        ,modal: true
        ,width: 750
        ,fields: [{
            xtype: 'hidden'
            ,name: 'id'
        },{
            layout: 'column'
            ,border: false
            ,defaults: { msgTarget: 'under' ,border: false }
            ,items: [{
                layout: 'form'
                ,columnWidth: .5
                ,defaults: { msgTarget: 'under' ,border: false }
                ,items: [{
                    xtype: 'textfield'
                    ,fieldLabel: _('redirector.pattern')
                    ,name: 'pattern'
                    ,anchor: '100%'
                    ,allowBlank: false
                },{
                    xtype: 'redirector-combo-contextlist'
                    ,fieldLabel: _('redirector.context')
                    ,name: 'context_key'
                    ,anchor: '100%'
                },{
                    layout: 'column'
                    ,border: false
                    ,defaults: { msgTarget: 'under' ,border: false }
                    ,items: [{
                        layout: 'form'
                        ,columnWidth: .6
                        ,defaults: { msgTarget: 'under' ,border: false }
                        ,items: [{
                            xtype: 'textfield'
                            ,id: 'redirector-createupdate-window-target-'+this.ident
                            ,fieldLabel: _('redirector.target')
                            ,name: 'target'
                            ,anchor: '100%'
                            ,allowBlank: false
                        }]
                    },{
                        layout: 'form'
                        ,columnWidth: .4
                        ,defaults: { msgTarget: 'under' ,border: false }
                        ,style: 'margin: 0;'
                        ,items: [{
                            xtype: 'redirector-combo-resourcelist'
                            ,fieldLabel: _('resource')
                            ,valueField: 'uri'
                            ,fields: ['uri', 'pagetitle', 'url', 'context_key']
                            ,anchor: '100%'
                            ,listeners: {
                                select: {
                                    fn: function(cb, e) {
                                        var ctx = this.fp.find('name', 'context_key')[0].getValue()
                                            ,value = cb.getValue()
                                            ,record = cb.findRecord('uri', value);
                                        // Handle target in a different context
                                        if (ctx && ctx != record.get('context_key')) {
                                            value = record.get('url');
                                        }
                                        var targetField = Ext.getCmp('redirector-createupdate-window-target-'+this.ident);
                                            targetField.setValue(value);
                                    } ,scope: this
                                }
                            }
                        }]
                    }]
                },{
                    xtype: 'xcheckbox'
                    ,hideLabel: true
                    ,boxLabel: _('redirector.active')
                    ,name: 'active'
                    ,inputValue: 1
                    ,checked: true
                }]
            },{
                columnWidth: .5
                ,defaults: { msgTarget: 'under' ,border: false }
                ,items: [{
                    html: Ext.util.Format.nl2br(_('redirector.regex_explain'))
                    ,border: false
                    ,bodyStyle: 'font-size: 0.9em; line-height: 15px;'
                }]
            }]
        }]
    });
    Redi.window.CreateUpdateRedirect.superclass.constructor.call(this,config);
};
Ext.extend(Redi.window.CreateUpdateRedirect,MODx.Window);
Ext.reg('redirector-window-redirect-createupdate',Redi.window.CreateUpdateRedirect);
