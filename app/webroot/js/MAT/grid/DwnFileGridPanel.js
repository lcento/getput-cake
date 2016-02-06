Ext.ns('MAT.grid');

MAT.grid.DwnFileGridPanel = Ext.extend(Ext.grid.GridPanel, {

	viewConfig    : { forceFit : true },

	columns       : [
		{
			header    : 'filename',
			dataIndex : 'fileinfo_filename',
			width	  : 220,
			locked	  : true,
			sortable  : true,
			renderer  : function(value, meta, record) {
				meta.css = 'text_table1';
				
				return value;
			}

		},
		{
			header    : 'status',
			dataIndex : 'filestatus_status',
			sortable  : true,
			renderer  : function(value, meta, record) {
    				if (value == "unselected") { meta.css = 'small_green_text'; }
				if (value == "selected") { meta.css = 'small_blue_text'; }
    				if (value == "updated") { meta.css = 'small_red_text'; }

    				return value;
			}
		},
		{
			header    : 'size KB',
			dataIndex : 'fileinfo_size',
			sortable  : true
		},
		{
			header    : 'modified',
			dataIndex : 'fileinfo_filedate',
			renderer  : Ext.util.Format.dateRenderer('d-m-Y H:i'),
			sortable  : true
		}
	],

	initComponent : function() {
		Ext.applyIf(this, {
			bbar  : this.buildBbar(),
			store : this.gridStore
		});

		MAT.grid.DwnFileGridPanel.superclass.initComponent.call(this);

		this.addEvents({
			/**
			* @event checkautorf
			* Fired after the filter checkautorf button is checked
			*
			*/
			checkautorf  : true
		});
	},
 
	buildBbar : function() {
		return [
			{
				xtype		: 'paging',
				store		: this.gridStore,
				pageSize	: this.gridSizeStore,
				displayInfo	: true
			},
			'->',
			{
				xtype 		: 'checkbox',
				id		: 'chkid',
				name		: 'rf-auto',
				boxLabel	: 'Auto Refresh',
				checked		: false,
				inputValue	: 'autorefresh',
				scope   	: this,
				handler 	: this.onCheck
			}
		];
	},

	onCheck : function() {
		this.fireEvent('checkautorf', this);
	},

	refreshGrid : function() {

		this.store.reload();
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

Ext.reg('dwnfilegridpanel', MAT.grid.DwnFileGridPanel);