Ext.onReady(function() {
    MODx.load({ xtype: 'moneybird-page-user-customers' });
});

MoneyBird.page.UserCustomers = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        components: [{
            xtype: 'moneybird-panel-user-customers'
        }]
        ,buttons: [{
            text: _('help_ex')
            ,handler: MODx.loadHelpPane
        }]
    });
    MoneyBird.page.UserCustomers.superclass.constructor.call(this,config);
};
Ext.extend(MoneyBird.page.UserCustomers,MODx.Component);
Ext.reg('moneybird-page-user-customers',MoneyBird.page.UserCustomers);
