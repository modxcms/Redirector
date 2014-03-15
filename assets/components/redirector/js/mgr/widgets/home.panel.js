Redi.panel.Home = function(config) {
    config = config || {};
    Ext.apply(config,{
        border: false
        ,id: 'redirector-import-formpanel'

        ,url: Redi.config.connectorUrl
        ,baseParams: {
            action: 'mgr/import/import'
        }
        ,fileUpload: true

        ,baseCls: 'modx-formpanel'
        ,cls: 'container'
        ,items: [{
            html: '<h2>'+_('redirector.management')+'</h2>'
            ,border: false
            ,cls: 'modx-page-header'
        },{
            xtype: 'modx-tabs'
            ,defaults: { border: false ,autoHeight: true }
            ,border: true
            ,stateful: true
            ,stateId: 'redirector-home-tabpanel'
            ,stateEvents: ['tabchange']
            ,getState:function() {
                return {activeTab:this.items.indexOf(this.getActiveTab())};
            }
            ,items: [{
                title: _('redirector.redirects')
                ,defaults: { border: false ,autoHeight: true }
                ,items: [{
                    html: '<p>'+_('redirector.desc')+'</p>'
                    ,bodyCssClass: 'panel-desc'
                },{
                    xtype: 'redirector-grid-redirects'
                    ,cls: 'main-wrapper'
                    ,preventRender: true
                }]
            },{
                title: _('redirector.import')
                ,defaults: { border: false ,autoHeight: true }
                ,items: this.getImportPanelItems(config)
            }]
        }]
    });
    Redi.panel.Home.superclass.constructor.call(this,config);
};
Ext.extend(Redi.panel.Home, MODx.FormPanel, {
    getImportPanelItems: function(config) {
        var it = [];
        it.push({
            html: '<p>'+_('redirector.import_desc')+'<br><b>'+_('redirector.import.csv_desc', MODx.config)+'</b></p>'
            ,bodyCssClass: 'panel-desc'
        });

        it.push({
            layout: 'form'
            ,bodyCssClass: 'tab-panel-wrapper main-wrapper'
            ,cls: 'modx-resource-tab'

            ,anchor: '80%'
            ,labelAlign: 'top'
            ,labelSeparator: ''
            ,defaults: { msgTarget: 'under', anchor: '100%' }
            ,items: [{
                xtype: 'fileuploadfield'
                ,id: 'redirector-import-fileupload'
                ,fieldLabel: _('redirector.import.csv_file')
                ,name: 'csv_data_file'
                ,listeners: {
                    'fileselected': {
                        fn: function(fld, e) {
                            var btn = Ext.getCmp('redirector-import-do-button');
                            if(!Ext.isEmpty(fld.getValue())) {
                                btn.setDisabled(false);
                            } else {
                                btn.setDisabled(true);
                            }
                        }
                        ,scope: this
                    }
                }
            },{
                html: '<br />'
                ,border: false
            },{
                xtype: 'textarea'
                ,id: 'redirector-import-rawcsv'
                ,fieldLabel: _('redirector.import.raw_csv')
                ,name: 'csv_data_raw'
                ,height: 250
                ,enableKeyEvents: true
                ,listeners: {
                    'keyup': {
                        fn: function(fld, e) {
                            var btn = Ext.getCmp('redirector-import-do-button');
                            if(!Ext.isEmpty(fld.getValue())) {
                                btn.setDisabled(false);
                            } else {
                                btn.setDisabled(true);
                            }
                        }
                        ,scope: this
                    }
                }
            },{
                 xtype: 'button'
                ,id: 'redirector-import-do-button'
                ,text: _('redirector.import.do')
                ,anchor: 'auto'
                ,disabled: true
                ,handler: function() {
                    var formObj = Ext.getCmp('redirector-import-formpanel');
                    if(formObj.isValid()) {
                        formObj.getForm().submit({
                            waitMsg: config.saveMsg || _('redirector.import.doing')
                            ,scope: this
                            ,failure: function(form, response) {
                                Ext.MessageBox.alert(_('redirector.import'), response.result.message);
                            }
                            ,success: function(form, response) {
                                Ext.MessageBox.alert(_('redirector.import'), response.result.message);
                            }
                        });
                    }
                }
            }]
        });

        return it;
    }
});
Ext.reg('redirector-panel-home', Redi.panel.Home);