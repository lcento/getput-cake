Ext.ns('MAT.chartpanel');

/**
 * @class MAT.chartpanel.ItemPutCurSnapshot
 * @extends MAT.chartpanel.ChartPanelBaseCls
 * An canned implementation extension to {@link MAT.chartpanel.ChartPanelBaseCls}, which provides a means to display
 * the number of items put, within a given month. <br />
 * <br />
 * @constructor
 * @xtype total_itemputcur_chart
 **/
MAT.chartpanel.ItemPutCurSnapshot = Ext.extend(MAT.chartpanel.ChartPanelBaseCls, {
	//private
	//An implementation of the {@link MAT.chartpanel.ChartPanelBaseCls#buildChart MAT.chartpanel.ChartPanelBaseCls.buildChart} method.
	buildChart : function() {
		return {
		xtype      : 'stackedbarchart',
		store      : this.buildStore(),
		yField     : 'month',
		series     : this.buildSeries(),
		extraStyle : this.chartExtraStyles,
		xAxis      : new Ext.chart.NumericAxis({
			title		: 'Number of items',
			stackingEnabled : true
		}),
		yAxis      :  new Ext.chart.CategoryAxis({
			title  : 'Month'
		})
		};
	},
	// private
	// An implementation of the {@link MAT.chartpanel.ChartPanelBaseCls#buildStore MAT.chartpanel.ChartPanelBaseCls.buildStore} method.
	buildStore : function() {
		return {
			xtype    : 'jsonstore',
			root     : 'records',
			autoLoad : true,
			baseParams : {
				permitUrl : true
			},
			proxy    : new Ext.data.HttpProxy({
				url: '/getput-cake/gestcollabs/jsonGetItemPutCur'
			}),
			fields   : [
				{ name: 'month', type: 'string'},
				{ name: 'photo', type: 'number'},
				{ name: 'text',  type: 'number'},
				{ name: 'total', type: 'number'}
			]
		};
	},
	//private
	// An implementation of the {@link MAT.chartpanel.ChartPanelBaseCls#buildSeries MAT.chartpanel.ChartPanelBaseCls.buildSeries} method.
	buildSeries : function() {
		var seriesStyles = this.seriesStyles;
	
		return [
		{
			xField      : 'photo',
			displayName : 'Photo',
			style       : seriesStyles.red
		},
		{
			xField      : 'text',
			displayName : 'Text',
			style       : seriesStyles.green
		},
		{
			type        : 'line',
			xField      : 'total',
			displayName : 'Total',
			style       : seriesStyles.blue
		}
		];
	}
});

Ext.reg('itemputcursnapshot', MAT.chartpanel.ItemPutCurSnapshot);