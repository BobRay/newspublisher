
MODx.NpFileBrowser = function(config) {
    config = config || {};
    MODx.browserOpen = true; // Hide the button for opening another browser
    this.ident = Ext.id();
    this.view = MODx.load({
        xtype: 'modx-browser-view'
        ,onSelect: {fn: this.onSelect, scope: this}
        ,source: config.source || MODx.config.default_media_source
        ,wctx: config.wctx || 'web'
        ,openTo: config.openTo || ''
        ,ident: this.ident
    });
    this.tree = MODx.load({
        xtype: 'modx-tree-directory'
        ,onUpload: function() { this.view.run(); }
        ,scope: this
        ,source: config.source || MODx.config.default_media_source
        ,openTo: config.openTo || ''
        ,ident: this.ident
        ,hideSourceCombo: true
        ,rootId: '/'
        ,rootName: _('files')
        ,rootVisible: true
        ,listeners: {
            'afterUpload': {fn:function() { this.view.run(); },scope:this}
            ,'changeSource': {fn:function(s) {
                this.config.source = s;
                this.view.config.source = s;
                this.view.baseParams.source = s;
                this.view.run();
            },scope:this}
        }
    });
    this.tree.on('click',function(node,e) {
        this.load(node.id);
    },this);
    
    Ext.applyIf(config,{
        title: _('modx_browser')+' ('+(MODx.ctx ? MODx.ctx : 'web')+')'
        ,cls: 'modx-pb-win'
        ,layout: 'border'
        ,minWidth: 500
        ,minHeight: 300
        ,width: '90%'
        ,height: 500
        ,modal: false
        ,closeAction: 'hide'
        ,border: false
        ,items: [{
            id: this.ident+'-browser-tree'
            ,cls: 'modx-pb-browser-tree'
            ,region: 'west'
            ,width: 250
            ,height: '100%'
            ,items: this.tree
            ,autoScroll: true
            ,split: true
            ,border: false
        },{
            id: this.ident+'-browser-view'
            ,cls: 'modx-pb-view-ct'
            ,region: 'center'
            ,autoScroll: true
            ,width: 450
            ,border: false
            ,items: this.view
            ,tbar: this.getToolbar()
        },{
            id: this.ident+'-img-detail-panel'
            ,cls: 'modx-pb-details-ct'
            ,region: 'east'
            ,split: true
            ,border: false
            ,width: 200
            ,minWidth: 200
            ,maxWidth: 300
        },{
            id: this.ident+'-south'
            ,cls: 'modx-pb-buttons'
            ,region: 'south'
            ,split: false
            ,border: false
            ,style: 'padding: 4px 8px'
            ,bbar: ['->',{
                id: this.ident+'-ok-btn'
                ,text: _('ok')
                ,handler: this.onSelect
                ,scope: this
                ,width: 150
            },{
                text: _('cancel')
                ,handler: this.hide
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
        ,fn: this.hide
     }]);

    MODx.NpFileBrowser.superclass.constructor.call(this,config);
    this.config = config;
    this.addEvents({
        'select': true
    });
};

Ext.extend(MODx.NpFileBrowser, Ext.Viewport, {
    returnEl: null
    
    ,filter : function(){
        var filter = Ext.getCmp(this.ident+'filter');
        this.view.store.filter('name', filter.getValue(),true);
        this.view.select(0);
    }
    
    ,setReturn: function(el) {
        this.returnEl = el;
    }
    
    ,load: function(dir) {
        dir = dir || (Ext.isEmpty(this.config.openTo) ? '' : this.config.openTo);
        this.view.run({
            dir: dir
            ,source: this.config.source
            ,wctx: this.config.wctx || 'web'
        });
    }
    
    ,sortImages : function(){
        var v = Ext.getCmp(this.ident+'sortSelect').getValue();
        this.view.store.sort(v, v == 'name' ? 'asc' : 'desc');
        this.view.select(0);
    }
    
    ,reset: function(){
        if(this.rendered){
            Ext.getCmp(this.ident+'filter').reset();
            this.view.getEl().dom.scrollTop = 0;
        }
        this.view.store.clearFilter();
        this.view.select(0);
    }
    
    ,getToolbar: function() {
        return [{
            text: _('filter')+':'
        },{
            xtype: 'textfield'
            ,id: this.ident+'filter'
            ,selectOnFocus: true
            ,width: 100
            ,listeners: {
                'render': {fn:function(){
                    Ext.getCmp(this.ident+'filter').getEl().on('keyup', function(){
                        this.filter();
                    }, this, {buffer:500});
                }, scope:this}
            }
        }, ' ', '-', {
            text: _('sort_by')+':'
        }, {
            id: this.ident+'sortSelect'
            ,xtype: 'combo'
            ,typeAhead: true
            ,triggerAction: 'all'
            ,width: 100
            ,editable: false
            ,mode: 'local'
            ,displayField: 'desc'
            ,valueField: 'name'
            ,lazyInit: false
            ,value: 'name'
            ,store: new Ext.data.SimpleStore({
                fields: ['name', 'desc'],
                data : [['name',_('name')],['size',_('file_size')],['lastmod',_('last_modified')]]
            })
            ,listeners: {
                'select': {fn:this.sortImages, scope:this}
            }
        }];
    }
    
    ,onSelect: function(data) {
        var selNode = this.view.getSelectedNodes()[0];
        var callback = this.config.onSelect || this.onSelectHandler;
        var lookup = this.view.lookup;
        var scope = this.config.scope;
        if(selNode && callback) {
            var data = lookup[selNode.id];
            Ext.callback(callback,scope || this,[data]);
            this.fireEvent('select',data);
            if (window.top.opener) {
                window.top.close();
                window.top.opener.focus();
            }
        }
    }
    
    ,onSelectHandler: function(data) {
        Ext.get(this.returnEl).dom.value = unescape(data.url);
    }
});

Ext.reg('modx-np-filebrowser', MODx.NpFileBrowser);
