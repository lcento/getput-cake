Ext.ns('MAT.grid');

MAT.grid.EmployeeGridPanel = Ext.extend(Ext.grid.GridPanel, {

	viewConfig    : { forceFit : true },

	columns       : [
		{
			header    : 'id',
			dataIndex : 'users_id',
			width	  : 40,
			locked	  : true
		},
		{
			header    : 'username',
			dataIndex : 'users_username',
			sortable  : true
		},
		{
			header    : 'password',
			dataIndex : 'users_password'
		},
		{
			header    : 'realname',
			dataIndex : 'users_username_realname'
		},
		{
			header    : 'level',
			dataIndex : 'users_level',
			sortable  : true
		},
		{
			header    : 'type',
			dataIndex : 'users_type',
			sortable  : true
		},
		{
			header    : 'group',
			dataIndex : 'agency_group',
			sortable  : true
		},
		{
			header    : 'seauthor',
			dataIndex : 'users_se_author',
			sortable  : true
		}
	],

	initComponent : function() {
		Ext.applyIf(this, {
			bbar  : this.buildBbar(),
			store : this.gridStore
		});

		MAT.grid.EmployeeGridPanel.superclass.initComponent.call(this);
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

Ext.reg('employeegridpanel', MAT.grid.EmployeeGridPanel);