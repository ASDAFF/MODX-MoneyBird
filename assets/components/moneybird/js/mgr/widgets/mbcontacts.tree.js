MoneyBird.tree.Contacts = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        title: _('moneybird.contacts')
        ,id: 'moneybird-tree-contacts'
        ,url: MoneyBird.config.connectorUrl
		,action: 'mgr/contacts/getList'
		
        ,root_id: 'n_mbc_0'
        ,root_name: _('moneybird.contacts')
        ,enableDrag: true
        ,enableDrop: false
		,enableDD: false
        ,rootVisible: true
        ,ddAppendOnly: true
        ,useDefaultToolbar: true
		,stateful: false
		,tbar: [{
			text: _('moneybird.contacts.refresh')
			,handler: this.refreshFromMoneyBird
			,scope: this
		}]
    });
    MoneyBird.tree.Contacts.superclass.constructor.call(this,config);
	this.on('load', function() {
		Ext.getCmp('moneybird-tree-localusers').refresh();
	});
};
Ext.extend(MoneyBird.tree.Contacts,MODx.tree.Tree,{	
    windows: {}
	
	,refreshFromMoneyBird: function(btn,e) {
		MODx.Ajax.request({
			url: this.config.url,
			params: { action: 'mgr/contacts/clearcache' },
			listeners: {
				'success': {
					fn: this.refresh,
					scope: this
				}
			}
		});
	}
});
Ext.reg('moneybird-tree-contacts',MoneyBird.tree.Contacts);