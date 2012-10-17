MoneyBird.panel.UserCustomers = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        id: 'moneybird-panel-user-customers'
		,cls: 'container'
        ,defaults: { collapsible: false ,autoHeight: true }
        ,items: [{ 
             html: '<h2>'+_('moneybird.manage')+'</h2>'
            ,border: false
            ,cls: 'modx-page-header'
            ,id: 'modx-resource-groups-header'
        },{
            layout: 'form'
            ,defaults: { border: false ,autoHeight: true }
            ,items: [{
                html: '<p>'+_('moneybird.manage.desc')+'</p>'
				,bodyCssClass: 'panel-desc'
            },{
                layout: 'column'
				,cls:'main-wrapper'
                ,defaults: { border: false }
                ,items: [{
                    columnWidth: .5
                    ,items: [{
                        xtype: 'moneybird-tree-local-users'
                        ,id: 'moneybird-tree-localusers'
                        ,ddGroup: 'mb2lu'
                        ,height: 400
                    }]
                },{
                    columnWidth: .5					
                    ,defaults: { autoHeight: true }
                    ,items: [{
                        xtype: 'moneybird-tree-contacts'
                        ,id: 'moneybird-tree-mbcontacts'
                        ,ddGroup: 'mb2lu'
                        ,height: 400
                    }]
                }]
            }]
        }]
    });
    MoneyBird.panel.UserCustomers.superclass.constructor.call(this,config);
};
Ext.extend(MoneyBird.panel.UserCustomers,MODx.FormPanel);
Ext.reg('moneybird-panel-user-customers',MoneyBird.panel.UserCustomers);