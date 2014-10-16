
MODx.NpBrowser = function(config) {
    config = config || {};

    this.ident = config.ident || Ext.id();

    this.onSelect = function() {
        var selnode = this.browser.view.getSelectedNodes()[0];
        this.fireEvent('select', this.browser.view.lookup[selnode.id]);
    }

    this.onCancel = function() {
        this.fireEvent('cancel');
    }

    this.browser = MODx.load({
        xtype: 'modx-media-view'
        ,hideSourceCombo: true
        ,wctx: config.wctx || 'web'
        ,source: config.source || MODx.config.default_media_source
        ,openTo: config.openTo || ''
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
            ,style: 'padding: 1px 10px'
            ,border: false
            ,tbar: ['->', {
                text: _('cancel')
                ,handler: this.onCancel
                ,scope: this
                ,width: 150
            }, {
                text: _('ok')
                ,cls: 'primary-button'
                ,handler: this.onSelect
                ,scope: this
                ,width: 150
            }]
        }]
    });

    var map = new Ext.KeyMap(Ext.getBody(), [{
        key: Ext.EventObject.ENTER
        ,scope: this
        ,fn: this.onSelect
     }, {
        key: Ext.EventObject.ESC
        ,scope: this
        ,fn: this.onCancel
     }]);
    
    MODx.NpBrowser.superclass.constructor.call(this, config);
    this.config = config;
}


Ext.extend(MODx.NpBrowser, Ext.Viewport);

Ext.reg('modx-browser-np', MODx.NpBrowser);
