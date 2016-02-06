Ext.ns("GetPut");

/**
 * @class GetPut.EmployeeListManager
 * @extends Ext.Panel
 * An Ext.Window implementation that contains  the {@link Ext.layout.FitLayout fit} layout to
 *  present {@link MAT.form.EmployeeFilterForm} implementation.
 * <br />
 * @constructor
 * @param {Object} config The config object
 **/
GetPut.EmployeeListManager = Ext.extend(Ext.Panel, {
	border : false,
	layout : {
		type  : 'vbox',
		align : 'stretch'
	},
	msgs : {
		fetchingDataFor   : 'Fetching data for : {0}',
		fetchingData	  : 'Fetching data',
		printingData	  : 'Printing data',
		couldNotPrintData : 'Could not print data !!!',
		couldNotLoadData  : 'Could not load data !!!'
	},
	initComponent : function() {
		Ext.apply(this, {
			items   : [
				this.buildEmployeeGridView(),
				this.buildEmployeeFilterForm()
			]
		});

		GetPut.EmployeeListManager.superclass.initComponent.call(this);
	},

	buildEmployeeGridView : function() {
		var gridEmployeeStore = new Ext.data.JsonStore(
			{
				xtype       	: 'jsonstore',
				root	    	: 'records',
				totalProperty	: 'totalCount',
				autoLoad    	: true,
				baseParams	: {start:0, limit:200},
				proxy	    	: new Ext.data.HttpProxy({
					url	: '/getput-cake/admins/jsonGetListViewUser',
						  }),
				fields   	: [
					{ name: 'users_id', type: 'int'},
					{ name: 'users_username', type: 'string'},
					{ name: 'users_password', type: 'string'},
					{ name: 'users_username_realname', type: 'string'},
					{ name: 'users_level', type: 'string'},
					{ name: 'users_type', type: 'string'},
					{ name: 'agency_group', type: 'string'},
					{ name: 'users_se_author', type: 'string'}
				],
				sortInfo 	: {
					field 		: 'users_username',
					direction	: 'ASC'
				}
			});

		return {
			xtype     	: 'employeegridpanel',
			itemId    	: 'employeeGridPanel',
			loadMask	: true,
			height     	: 450,
			border    	: false,
			gridStore	: gridEmployeeStore,
			gridSizeStore	: 200,
			stripeRows 	: true,
			border    	: false,
			style     	: 'border-top: 1px solid #99BBE8;border-left: 1px solid #99BBE8;border-right: 1px solid #99BBE8;border-bottom: 1px solid #99BBE8',
			title     	: 'Lista',
		};
	},

	buildEmployeeFilterForm : function() {
		return {
			xtype     : 'employeefilterform',
			itemId    : 'employeeFilterForm',
			flex      : 1,
			border    : false,
			style     : 'border-top: 1px solid #99BBE8;border-left: 1px solid #99BBE8;border-right: 1px solid #99BBE8;border-bottom: 1px solid #99BBE8',
			title     : 'Filtro',
			listeners : {
				scope      : this,
				printemp   : this.onPrintEmployeeGrid,
				resetemp   : this.onResetEmployeeGrid,
				filteremp  : this.onFilterEmployeeGrid
			}
		};
	},

	onPrintEmployeeGrid : function(form, action) {
		var vals = form.getValues();

		var msg = String.format(
			this.msgs.printingData
		);

		Ext.get('listusers').mask(msg, 'x-mask-loading');

		Ext.Ajax.request({
			url          : '/getput-cake/admins/jsonPrintPdf',
			scope        : this,
			callback     : this.onAfterAjaxReq,
			succCallback : this.onAfterPrintEmployee,
			params       : {
				username : vals.users_username,
				usertype : vals.users_type,
				agegroup : vals.agency_group
			}
		});
	},

	onAfterAjaxReq : function(options, success, result) {
		Ext.get('listusers').unmask();

		if ( success === true ) {
			var jsonData;
			try {
				jsonData = Ext.decode(result.responseText);
			}
			catch (e) {
				Ext.MessageBox.alert('Error!', 'Data returned is not valid!');
			}

			options.succCallback.call(options.scope, jsonData, options);
		}
		else {
			Ext.MessageBox.alert('Error!', 'The web transaction failed!');
		}
	},

	onAfterPrintEmployee : function(jsonData) {
		if ( jsonData.success === true ) {

			var redirectPtrUrl = '/getput-cake/admins/viewPdf';

			window.location.href = redirectPtrUrl;
        	}
		else {

			msg = String.format(
				this.msgs.couldNotPrintData
			);

			Ext.MessageBox.alert('Error', msg);
		}

		this.clearMask();
	},

	onResetEmployeeGrid : function() {
		this.getComponent('employeeFilterForm').clearForm();

		var msg = String.format(
			this.msgs.fetchingData
		);

		this.getComponent('employeeGridPanel').loadStoreBySetFilterParams({
					start 	 : 0,
					limit 	 : 200,
					username : '',
					usertype : '',
					agegroup : ''
		});
	},

	onFilterEmployeeGrid : function(form, action) {
		if ( this.getComponent('employeeFilterForm').getForm().isDirty() ) {
			var vals = form.getValues();
	
			var msg = String.format(
				this.msgs.fetchingData
			);

			this.getComponent('employeeGridPanel').loadStoreBySetFilterParams({
					start 	 : 0,
					limit 	 : 200,
					username : vals.users_username,
					usertype : vals.users_type,
					agegroup : vals.agency_group
			});	
		}
	},

	clearMask : function() {
		Ext.get('listusers').unmask();
	}
});

Ext.reg('employeelistmanager', GetPut.EmployeeListManager);