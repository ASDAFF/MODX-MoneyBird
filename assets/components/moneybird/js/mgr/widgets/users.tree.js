MoneyBird.tree.LocalUsers = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        title: _('moneybird.local_users')
        ,id: 'moneybird-tree-local-users'
        ,url: MoneyBird.config.connectorUrl
		,action: 'mgr/users/getList'
		
        ,root_id: 'n_lu_0'
        ,root_name: _('moneybird.local_users')
        ,enableDrag: true
        ,enableDrop: true
        ,rootVisible: true
        ,ddAppendOnly: true
        ,useDefaultToolbar: true
		,sortAction: false
    });
    MoneyBird.tree.LocalUsers.superclass.constructor.call(this,config);
};
Ext.extend(MoneyBird.tree.LocalUsers,MODx.tree.Tree,{	
    windows: {}
	
	,getMenu: function() {
		var n = this.cm.activeNode;
        var m = [];
        if (n.attributes.type == 'MoneyBirdContact') {
			m.push({
				text: _('moneybird.local_users.remove')
				,handler: this.removeContactFromUser
			});
		}
		return m;
	}
	
	,removeContactFromUser: function(btn,e) {
		var n = this.cm.activeNode;
        var userid = n.id.split('_')[2]; // n_lumbc_[uid]_[cid]
        var customerid = n.id.split('_')[3]; // n_lumbc_[uid]_[cid]

        MODx.msg.confirm({
            text: _('moneybird.local_users.remove_confirm', { name: n.text })
            ,url: this.config.url
            ,params: {
                action: 'mgr/users/removecontact'
                ,user: userid
                ,customer: customerid
            }
            ,listeners: {
                'success': {
					fn: function() { 
						this.refresh();
						Ext.getCmp('moneybird-tree-mbcontacts').refresh();
					}, scope:this
				}
            }
        });
	}
	
	,_handleDrag: function(dropEvent) {
		Ext.Msg.show({
            title: _('please_wait')
            ,msg: _('saving')
            ,width: 240
            ,progress:true
            ,closable:false
        });
		
        MODx.util.Progress.reset();
        for(var i = 1; i < 20; i++) {
            setTimeout('MODx.util.Progress.time('+i+','+MODx.util.Progress.id+')',i*1000);
        }
		
        MODx.Ajax.request({
            url: this.config.url
            ,scope: this
            ,params: {
                contact: dropEvent.dropNode.attributes.id
                ,contactname: dropEvent.dropNode.attributes.text
                ,user: dropEvent.target.attributes.id
                ,action: 'mgr/users/bindContact'
            }
            ,listeners: {
                'success': { fn: function(r,o) {
                    MODx.util.Progress.reset();
                    Ext.Msg.hide();
                    if (!r.success) {
						return false;
                    }
                    //this.refresh();
                    return true;
                },scope:this }
                ,'failure': { fn: function(r,o) {
					MODx.util.Progress.reset();
                    Ext.Msg.hide();
					Ext.Msg.alert(_('error'),r.message);
                    this.refresh();
                    return false;
                },scope:this }
            }
        });
	}
});
Ext.reg('moneybird-tree-local-users',MoneyBird.tree.LocalUsers);