Ext.ns("MAT.listpanel");

/**
 * @class MAT.listpanel.EmployeeList
 * @extends MAT.listpanel.ListPanelBaseCls
 * A configuration instance of {@link MAT.listpanel.ListPanelBaseCls}
 * <br />
 * @constructor
 * @param {Object} config The config object
 **/
MAT.listpanel.EmployeeList = Ext.extend(MAT.listpanel.ListPanelBaseCls, {

	initComponent : function() {

		Ext.applyIf(this, {
			tbar  : this.buildTbar(),
			bbar  : this.buildBbar()
		});


		MAT.listpanel.EmployeeList.superclass.initComponent.call(this);
	},

	buildTbar : function() {
		return [
			{
				text	: 'filter by: ',
				iconCls : 'icon-find',
				scope	: this
			},
			{
				xtype		 : 'historyclerablecombobox',
				emptyText	 : 'searchtext...',
				selectOnFocus	 : true,
				enableKeyEvents	 : true,
				hideClearTrigger : false,
				width		 : 100,
				typeAhead	 : true,
				resizable 	 : true,
				scope   	 : this,
				mode		 : 'local',
				triggerAction 	 : 'all',
				listeners     	 : {
                			scope : this,
					'keyup' : this.onFilterEmployeeListEnter,
					'click' : this.onFilterCleanEmployeeListClick
				}
			}
		];
	},

	buildBbar : function() {
		return [
			{
				xtype		: 'paging',
				store		: this.listStore,
				pageSize	: this.listSizeStore,
				displayInfo	: false
			}
		];
	},

	buildListView : function() {
		return {
			xtype         	: 'listview',
			singleSelect  	: true,
			store         	: this.listStore,
			style         	: 'background-color: #FFFFFF;',
			columns       	: [
				{
					header    : 'UserId',
					dataIndex : 'users_id'
				},
				{
					header    : 'Username',
					dataIndex : 'users_username'
				}
			]
		};
	},

	onFilterEmployeeListEnter : function(field, key) {
		if ( key.getKey() == key.ENTER )
		{
			var fieldValue = field.getValue();

			if (fieldValue) {
				this.loadStoreBySetParams('username',fieldValue);
			}
		}
	},
	
	onFilterCleanEmployeeListClick : function() {
		this.loadStoreBySetParams('username','');
	}
});

Ext.reg('employeelist', MAT.listpanel.EmployeeList);