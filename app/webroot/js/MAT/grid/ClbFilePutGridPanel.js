Ext.ns('MAT.grid');

MAT.grid.ClbFilePutGridPanel = Ext.extend(Ext.grid.GridPanel, {

	viewConfig    : { forceFit : true },

	columns       : [
		{
			header    : 'num',
			dataIndex : 'num',
			width	  : 40,
			locked	  : true
		},
		{
			header    : 'redazione',
			dataIndex : 'activity_fileput_history_filedest',
			sortable  : true
		},
		{
			header    : 'totale',
			dataIndex : 'total_put',
			sortable  : true
		}
	],

	initComponent : function() {
		Ext.applyIf(this, {
			bbar  : this.buildBbar(),
			store : this.gridStore
		});

		MAT.grid.ClbFilePutGridPanel.superclass.initComponent.call(this);
	},
 
	buildBbar : function() {
		return [
			{
				xtype		: 'paging',
				store		: this.gridStore,
				pageSize	: this.gridSizeStore,
				displayInfo	: true
			}
		];
	},

	loadStoreBySetFilterParams : function(filters) {

		for ( key in filters )
		{
			this.store.setBaseParam(key, filters[key]);
		}

		this.store.load();
	},

	loadStoreBySetParams : function(params, val) {

		this.store.setBaseParam(params,val);

		this.store.load();
	},

	load : function(o) {
		return this.store.load(o);
	}
});

Ext.reg('clbfileputgridpanel', MAT.grid.ClbFilePutGridPanel);