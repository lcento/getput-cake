Ext.ns("GetPut");

/**
 * @class GetPut.AgeUserListManager
 * @extends Ext.Panel
 * An Ext.Window implementation that contains  the {@link Ext.layout.FitLayout fit} layout to
 *  present {@link MAT.form.EmployeeFilterForm} implementation.
 * <br />
 * @constructor
 * @param {Object} config The config object
 **/
GetPut.AgeUserListManager = Ext.extend(Ext.Panel, {
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
				this.buildAgeUserGridView(),
				this.buildAgeUserFilterForm()
			]
		});

		GetPut.AgeUserListManager.superclass.initComponent.call(this);
	},

	buildAgeUserGridView : function() {
		var gridAgeUserStore = new Ext.data.JsonStore(
			{
				xtype       	: 'jsonstore',
				root	    	: 'records',
				totalProperty	: 'totalCount',
				autoLoad    	: true,
				baseParams	: {start:0, limit:200},
				proxy	    	: new Ext.data.HttpProxy({
					url	: '/getput-cake/gestexternal/jsonGetListViewUser',
						  }),
				fields   	: [
					{ name: 'users_id', type: 'int'},
					{ name: 'users_username', type: 'string'},
					{ name: 'users_password', type: 'string'},
					{ name: 'users_username_realname', type: 'string'},
					{ name: 'agency_group', type: 'string'},
					{ name: 'users_se_author', type: 'string'}
				],
				sortInfo 	: {
					field 		: 'users_username',
					direction	: 'ASC'
				}
			});

		return {
			xtype     	: 'ageusergridpanel',
			itemId    	: 'ageuserGridPanel',
			loadMask	: true,
			height     	: 450,
			border    	: false,
			gridStore	: gridAgeUserStore,
			gridSizeStore	: 200,
			stripeRows 	: true,
			border    	: false,
			style     	: 'border-top: 1px solid #99BBE8;border-left: 1px solid #99BBE8;border-right: 1px solid #99BBE8;border-bottom: 1px solid #99BBE8',
			title     	: 'Lista',
		};
	},

	buildAgeUserFilterForm : function() {
		return {
			xtype     : 'ageuserfilterform',
			itemId    : 'ageuserFilterForm',
			flex      : 1,
			border    : false,
			style     : 'border-top: 1px solid #99BBE8;border-left: 1px solid #99BBE8;border-right: 1px solid #99BBE8;border-bottom: 1px solid #99BBE8',
			title     : 'Filtro',
			listeners : {
				scope      : this,
				printemp   : this.onPrintAgeUserGrid,
				resetemp   : this.onResetAgeUserGrid,
				filteremp  : this.onFilterAgeUserGrid
			}
		};
	},

	onPrintAgeUserGrid : function(form, action) {
		var vals = form.getValues();

		var msg = String.format(
			this.msgs.printingData
		);

		Ext.get('listusers').mask(msg, 'x-mask-loading');

		Ext.Ajax.request({
			url          : '/getput-cake/gestexternal/jsonPrintPdf',
			scope        : this,
			callback     : this.onAfterAjaxReq,
			succCallback : this.onAfterPrintEmployee,
			params       : {
				username : vals.users_username,
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

			var redirectPtrUrl = '/getput-cake/gestexternal/viewPdf';

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

	onResetAgeUserGrid : function() {
		this.getComponent('ageuserFilterForm').clearForm();

		var msg = String.format(
			this.msgs.fetchingData
		);

		this.getComponent('ageuserGridPanel').loadStoreBySetFilterParams({
					start 	 : 0,
					limit 	 : 200,
					username : '',
					agegroup : ''
		});
	},

	onFilterAgeUserGrid : function(form, action) {
		if ( this.getComponent('ageuserFilterForm').getForm().isDirty() ) {
			var vals = form.getValues();
	
			var msg = String.format(
				this.msgs.fetchingData
			);

			this.getComponent('ageuserGridPanel').loadStoreBySetFilterParams({
					start 	 : 0,
					limit 	 : 200,
					username : vals.users_username,
					agegroup : vals.agency_group
			});	
		}
	},

	clearMask : function() {
		Ext.get('listusers').unmask();
	}
});

Ext.reg('ageuserlistmanager', GetPut.AgeUserListManager);