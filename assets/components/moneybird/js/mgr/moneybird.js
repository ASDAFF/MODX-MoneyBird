var MoneyBird = function(config) {
    config = config || {};
    MoneyBird.superclass.constructor.call(this,config);
};
Ext.extend(MoneyBird,Ext.Component,{
    page:{},window:{},grid:{},tree:{},panel:{},combo:{},config: {}
});
Ext.reg('moneybird',MoneyBird);
MoneyBird = new MoneyBird();
MODx.config.help_url = 'http://rtfm.modx.com/display/ADDON/MoneyBird';