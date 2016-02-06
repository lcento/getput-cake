Ext.ns("GetPut");

/**
 * @class GetPut.DwnFileListManager
 * @extends Ext.Panel
 * An Ext.Window implementation that contains  the {@link Ext.layout.FitLayout fit} layout to
 *  present {@link MAT.form.DwnFileListManager} implementation.
 * <br />
 * @constructor
 * @param {Object} config The config object
 **/
GetPut.DwnFileListManager = Ext.extend(Ext.Panel, {
	border : false,
	layout : 'fit',
	msgs : {
		fetchingDataFor   : 'Fetching data for : {0}',
		fetchingData	  : 'Fetching data',
		printingData	  : 'Printing data',
		couldNotPrintData : 'Could not print data !!!',
		couldNotLoadData  : 'Could not load data !!!'
	},
	redirs : {
		dwnFile : '/getput-cake/downloads/download/{0}/{1}'
	},
	refreshTask : '',
	refreshSecs : 60,
	autoRefresh : false,

	initComponent : function() {
		Ext.apply(this, {
			items   : [
				this.buildDwnFileGridView()
			]
		});

		GetPut.DwnFileListManager.superclass.initComponent.call(this);
	},

	buildDwnFileGridView : function() {
		var gridDwnFileStore = new Ext.data.JsonStore(
			{
				xtype       	: 'jsonstore',
				root	    	: 'records',
				totalProperty	: 'totalCount',
				autoLoad    	: true,
				baseParams	: {start:0, limit:200},
				proxy	    	: new Ext.data.HttpProxy({
					url	: '/getput-cake/downloads/jsonGetListFileView'
						  }),
				fields   	: [
					{ name: 'fileinfo_filename', type: 'string'},
					{ name: 'filestatus_status', type: 'string'},
					{ name: 'users_username_realname', type: 'string'},
					{ name: 'fileinfo_size', type: 'number'},
					{ name: 'fileinfo_filedate', type: 'date', dateFormat: 'timestamp'},
					{ name: 'filestatus_id', type: 'number'}
				],
				sortInfo 	: {
					field 		: 'fileinfo_filedate',
					direction	: 'DESC'
				}
			});

		return {
			xtype     	: 'dwnfilegridpanel',
			itemId    	: 'dwnFileGrid',
			loadMask	: true,
			selModel 	: new Ext.grid.RowSelectionModel({
				singleSelect : true
			}),
			stripeRows	: true,
			height     	: 450,
			border    	: false,
			gridStore	: gridDwnFileStore,
			gridSizeStore	: 200,
			stripeRows 	: true,
			border    	: false,
			style     	: 'border-top: 1px solid #99BBE8;border-left: 1px solid #99BBE8;border-right: 1px solid #99BBE8;border-bottom: 1px solid #99BBE8',
			title     	: 'Lista',
			listeners 	: {
				scope         : this,
				cellclick     : this.doCellClick,
				afterrender   : this.initTask,
				checkautorf   : this.checkRefresh
                        }
		};
	},

	doStartDownload : function(grid, record) {
		var record = grid.selModel.getSelected();
		var fileName = record.get('fileinfo_filename');
		var fileStatusId = record.get('filestatus_id');

		redirectPtrUrl= String.format(this.redirs.dwnFile, fileStatusId, fileName);

		window.location.href = redirectPtrUrl;
	},

	initTask : function () {
		this.refreshTask = {
			run      : function() {
					this.getComponent('dwnFileGrid').refreshGrid();
			},
			scope    : this,
			interval : (this.refreshSecs*1000)
		};
	},

	checkRefresh : function () {

		if ( Ext.getCmp('chkid').checked )
			this.autoRefresh = true;
		else
			this.autoRefresh = false;

        	if ( this.autoRefresh == true )
			Ext.TaskMgr.start(this.refreshTask);
		else
			Ext.TaskMgr.stop(this.refreshTask);
	},

	doCellClick : function(grid, rowIndex, colIndex, e) {
		if ( colIndex == 0 )
			this.doStartDownload(grid);
	},

	doRowDblClick : function(grid, rowIndex) {
		this.doStartDownload(grid);
	},

	clearMask : function() {
		Ext.get('listfileget').unmask();
	}
});

Ext.reg('dwnfilelistmanager', GetPut.DwnFileListManager);