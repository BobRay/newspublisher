
MODx.NpBrowser = function(config) {
    config = config || {};

    this.ident = config.ident || Ext.id();

    this.onSelect = function() {
        var selnode = this.browser.view.getSelectedNodes()[0];
        this.fireEvent('select', this.browser.view.lookup[selnode.id]);
    }

    this.hide = function() {
        this.fireEvent('hide');
    }

    this.browser = MODx.load({
        xtype: 'modx-media-view'
        ,onSelect: {fn: this.onSelect, scope: this}
    });

    Ext.applyIf(config, {
        cls: 'np-browser'
        ,layout: 'border'
        ,items: [{
            region: 'center'
            ,layout: 'fit'
            ,items: this.browser
            ,id: this.ident+'-browser-view'
            ,cls: 'modx-browser-view-ct'
        },{
            id: this.ident+'-south'
            ,cls: 'modx-pb-buttons'
            ,region: 'south'
            ,split: false
            ,border: false
            ,tbar: ['->',{
                id: this.ident+'-ok-btn'
                ,text: _('ok')
                ,style: 'color: white; background-color: green;'
                ,handler: this.onSelect
                ,scope: this
                ,width: 200
            },{
                text: _('cancel')
                ,handler: this.hide
                ,scope: this
                ,width: 200
            }]
        }]
    });

    var map = new Ext.KeyMap(Ext.getBody(), [{
        key: Ext.EventObject.ESC
        ,scope: this
        ,fn: this.hide
     }]);    
    
    MODx.NpBrowser.superclass.constructor.call(this, config);
    this.config = config;
}


Ext.extend(MODx.NpBrowser, Ext.Viewport);

Ext.reg('modx-browser-np', MODx.NpBrowser);
