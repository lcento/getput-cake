Ext.ns('GetPut');

/**
 * @class GetPut.GraphItemPutManager
 * @extends Ext.Container
 * An Ext.Container implementation that contains at least two implementations of {@link MAT.chartpanel.ChartPanelBaseCls}.  <br />
 * The first (left) chart is a 
 * It uses the {@link MAT.layout.VboxLayout vbox} layout to organize the {@link MAT.chartpanel.ChartPanelBaseCls} implementations.
 * <br />
 * @constructor
 * @param {Object} config The config object
 * @xtype itemput_snapshot_panel
 **/
GetPut.GraphItemPutManager = Ext.extend(Ext.Container, {
	border  : false,
	/**
	* @cfg {Object} layout  The layout that you desire to use.
	* defaults to { type : 'hbox', align : 'stretch' }
	*/
	layout  : {
		type  : 'hbox',
		align : 'stretch'
	},
	//private
	defaults : {
		style : 'background-color: #DFE8F6; padding: 10px',
		flex  : 1
	},
	/**
	* @cfg {Object} msgs an object containing messages. <br />
	* defaults to { putCurChartMsg : 'File Inviati per Anno: {0}' }
	*/
	msgs : {
		putCurChartMsg : 'File Inviati per Anno: {0}'
	},
	//private
	// Instantiates the instance of the ItemPutOldSnapshot and ItemPutCurSnapshot and configures accordingly.
	initComponent : function() {
		this.items =  [
		{
			xtype     : 'itemputoldsnapshot',
			itemId    : 'itemputoldsnapshot',
			title     : 'Files Inviati Storico',
			listeners : {
				scope     : this,
				itemclick : this.ItemPutOldSnapshot
			}
		},
		{
			xtype  : 'itemputcursnapshot',
			itemId : 'itemputcursnapshot',
			title  : 'File Inviati per Anno'
		}
		];
		
		GetPut.GraphItemPutManager.superclass.initComponent.call(this);
	},
	//private
	// The listener for the relayed item click
	ItemPutOldSnapshot : function(evtObj){
		var record = evtObj.component.store.getAt(evtObj.index);
		var itemPutCurChart = this.getComponent('itemputcursnapshot');
		itemPutCurChart.loadStoreByParams({
			year : record.get('year')
		});

		var msg = String.format(this.msgs.putCurChartMsg, record.get('year'));

		itemPutCurChart.setTitle(msg);
	}
});

Ext.reg('graphitemputmanager', GetPut.GraphItemPutManager);