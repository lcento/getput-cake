Ext.ns("GetPut");

/**
 * @class GetPut.HstFileGetListManager
 * @extends Ext.Panel
 * An Ext.Window implementation that contains  the {@link Ext.layout.FitLayout fit} layout to
 *  present {@link MAT.form.HstFileGetFilterForm} implementation.
 * <br />
 * @constructor
 * @param {Object} config The config object
 **/
GetPut.HstFileGetListManager = Ext.extend(Ext.Panel, {
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
				this.buildHstFileGetGridView(),
				this.buildHstFileGetFilterForm()
			]
		});

		GetPut.HstFileGetListManager.superclass.initComponent.call(this);
	},

	buildHstFileGetGridView : function() {
		var gridHstFileGetStore = new Ext.data.JsonStore(
			{
				xtype       	: 'jsonstore',
				root	    	: 'records',
				totalProperty	: 'totalCount',
				autoLoad    	: true,
				baseParams	: {start:0, limit:200},
				proxy	    	: new Ext.data.HttpProxy({
					url	: '/getput-cake/histories/jsonGetListViewUser',
						  }),
				fields   	: [
					{ name: 'users_id', type: 'int'},
					{ name: 'users_username', type: 'string'},
					{ name: 'users_username_realname', type: 'string'},
					{ name: 'users_type', type: 'string'},
					{ name: 'agency_group', type: 'string'},
					{ name: 'activity_fileget_history_absfilename', type: 'string'},
					{ name: 'activity_fileget_history_date', type: 'date', dateFormat: 'timestamp'}
				],
				sortInfo 	: {
					field 		: 'activity_fileget_history_date',
					direction	: 'DESC'
				}
			});

		return {
			xtype     	: 'hstfilegetgridpanel',
			itemId    	: 'hstFileGetGridPanel',
			loadMask	: true,
			height     	: 450,
			border    	: false,
			gridStore	: gridHstFileGetStore,
			gridSizeStore	: 200,
			stripeRows 	: true,
			border    	: false,
			style     	: 'border-top: 1px solid #99BBE8;border-left: 1px solid #99BBE8;border-right: 1px solid #99BBE8;border-bottom: 1px solid #99BBE8',
			title     	: 'Lista',
		};
	},

	buildHstFileGetFilterForm : function() {
		return {
			xtype     : 'hstfilegetfilterform',
			itemId    : 'hstFileGetFilterForm',
			flex      : 1,
			border    : false,
			style     : 'border-top: 1px solid #99BBE8;border-left: 1px solid #99BBE8;border-right: 1px solid #99BBE8;border-bottom: 1px solid #99BBE8',
			title     : 'Filtro',
			listeners : {
				scope      : this,
				printemp   : this.onPrintEmployeeGrid,
				resetemp   : this.onResetEmployeeGrid,
				filteremp  : this.onFilterEmployeeGrid,
				filtdate   : this.onFilterDateForm
			}
		};
	},

	onPrintEmployeeGrid : function(form, action) {
		var vals = form.getValues();

		var msg = String.format(
			this.msgs.printingData
		);

		Ext.get('listfileget').mask(msg, 'x-mask-loading');

		Ext.Ajax.request({
			url          : '/getput-cake/histories/jsonPrintGetPdf',
			scope        : this,
			callback     : this.onAfterAjaxReq,
			succCallback : this.onAfterPrintEmployee,
			params       : {
				username : vals.users_username,
				usertype : vals.users_type,
				agegroup : vals.agency_group,
				dateflt	 : vals.rb_auto,
				datefrom : vals.date_from,
				dateto	 : vals.date_to
			}
		});
	},

	onAfterAjaxReq : function(options, success, result) {
		Ext.get('listfileget').unmask();

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

			var redirectPtrUrl = '/getput-cake/histories/viewGetPdf';

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
		this.getComponent('hstFileGetFilterForm').clearForm();

		var msg = String.format(
			this.msgs.fetchingData
		);

		this.getComponent('hstFileGetGridPanel').loadStoreBySetFilterParams({
					start 	 : 0,
					limit 	 : 200,
					username : '',
					usertype : '',
					agegroup : '',
					dateflt	 : '',
					datefrom : '',
					dateto	 : ''
		});
	},

	onFilterEmployeeGrid : function(form, action) {

		if ( this.getComponent('hstFileGetFilterForm').getForm().isDirty() ) {
			var vals = form.getValues();
	
			var msg = String.format(
				this.msgs.fetchingData
			);

			this.getComponent('hstFileGetGridPanel').loadStoreBySetFilterParams({
					start 	 : 0,
					limit 	 : 200,
					username : vals.users_username,
					usertype : vals.users_type,
					agegroup : vals.agency_group,
					dateflt	 : vals.rb_auto,
					datefrom : vals.date_from,
					dateto	 : vals.date_to
			});	
		}
	},

	onFilterDateForm : function(form, action) {
		var dt_now = new Date();
		var dt_after = new Date().add(Date.DAY, 1);

		this.getComponent('hstFileGetFilterForm').getForm().findField("date_from").setValue(dt_now);
		this.getComponent('hstFileGetFilterForm').getForm().findField("date_to").setValue(dt_after);
	},

	clearMask : function() {
		Ext.get('listfileget').unmask();
	}
});

Ext.reg('hstfilegetlistmanager', GetPut.HstFileGetListManager);