Ext.ns("GetPut");

/**
 * @class GetPut.ClbFilePutListManager
 * @extends Ext.Panel
 * An Ext.Window implementation that contains  the {@link Ext.layout.FitLayout fit} layout to
 *  present {@link MAT.form.ClbFilePutFilterForm} implementation.
 * <br />
 * @constructor
 * @param {Object} config The config object
 **/
GetPut.ClbFilePutListManager = Ext.extend(Ext.Panel, {
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
				this.buildClbFilePutGridView(),
				this.buildClbFilePutFilterForm()
			]
		});

		GetPut.ClbFilePutListManager.superclass.initComponent.call(this);
	},

	buildClbFilePutGridView : function() {
		var gridClbFilePutStore = new Ext.data.JsonStore(
			{
				xtype       	: 'jsonstore',
				root	    	: 'records',
				totalProperty	: 'totalCount',
				autoLoad    	: true,
				baseParams	: {start:0, limit:200},
				proxy	    	: new Ext.data.HttpProxy({
					url	: '/getput-cake/gestcollabs/jsonPutListContrib',
						  }),
				fields   	: [
					{ name: 'num', type: 'int'},
					{ name: 'activity_fileput_history_filedest', type: 'string'},
					{ name: 'total_put', type: 'int'}
				],
				sortInfo 	: {
					field 		: 'num',
					direction	: 'ASC'
				}
			});

		return {
			xtype     	: 'clbfileputgridpanel',
			itemId    	: 'clbFilePutGridPanel',
			loadMask	: true,
			height     	: 450,
			border    	: false,
			gridStore	: gridClbFilePutStore,
			gridSizeStore	: 200,
			stripeRows 	: true,
			border    	: false,
			style     	: 'border-top: 1px solid #99BBE8;border-left: 1px solid #99BBE8;border-right: 1px solid #99BBE8;border-bottom: 1px solid #99BBE8',
			title     	: 'Lista'
		};
	},

	buildClbFilePutFilterForm : function() {
		return {
			xtype     : 'clbfileputfilterform',
			itemId    : 'clbFilePutFilterForm',
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

		Ext.get('listcontrput').mask(msg, 'x-mask-loading');

		Ext.Ajax.request({
			url          : '/getput-cake/gestcollabs/jsonPrintContrPutPdf',
			scope        : this,
			callback     : this.onAfterAjaxReq,
			succCallback : this.onAfterPrintEmployee,
			params       : {
				type_contr : vals.type_contr,
				dateflt	   : vals.rb_auto,
				datefrom   : vals.date_from,
				dateto	   : vals.date_to
			}
		});
	},

	onAfterAjaxReq : function(options, success, result) {
		Ext.get('listcontrput').unmask();

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

			var redirectPtrUrl = '/getput-cake/gestcollabs/viewContrPutPdf';

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
		this.getComponent('clbFilePutFilterForm').clearForm();

		var msg = String.format(
			this.msgs.fetchingData
		);

		this.getComponent('clbFilePutGridPanel').loadStoreBySetFilterParams({
					start	   : 0,
					limit	   : 200,
					type_contr : '',
					dateflt	   : '',
					datefrom   : '',
					dateto	   : ''
		});
	},

	onFilterEmployeeGrid : function(form, action) {

		if ( this.getComponent('clbFilePutFilterForm').getForm().isDirty() ) {
			var vals = form.getValues();
	
			var msg = String.format(
				this.msgs.fetchingData
			);
	
			this.getComponent('clbFilePutGridPanel').loadStoreBySetFilterParams({
					start 	   : 0,
					limit 	   : 200,
					type_contr : vals.type_contr,
					dateflt	   : vals.rb_auto,
					datefrom   : vals.date_from,
					dateto	   : vals.date_to
			});
		}
	},

	onFilterDateForm : function(form, action) {
		var dt_now = new Date();
		var dt_after = new Date().add(Date.DAY, 1);

		this.getComponent('clbFilePutFilterForm').getForm().findField("date_from").setValue(dt_now);
		this.getComponent('clbFilePutFilterForm').getForm().findField("date_to").setValue(dt_after);
	},

	clearMask : function() {
		Ext.get('listcontrput').unmask();
	}
});

Ext.reg('clbfileputlistmanager', GetPut.ClbFilePutListManager);