Ext.ns('MAT.chartpanel');
/**
 * @class MAT.chartpanel.ItemPutOldSnapshot
 * @extends MAT.chartpanel.ChartPanelBaseCls
 * An canned implementation extension to {@link MAT.chartpanel.ChartPanelBaseCls}, which provides a means to display
 * the number of items put, retained since the portal's creation. <br />
 * <br />
 * <!--
 * {@link MAT.chartpanel.ChartPanelBaseCls#methodOne this is method one} <br/>
 * {@link MAT.chartpanel.ChartPanelBaseCls#methodOne} <br/>
 * {@link #methodOne another link} <br/>
 * {@link #methodOne} <br/>
 * {@link MAT.chartpanel.ChartPanelBaseCls} <br/>
 * {@link MAT.chartpanel.ChartPanelBaseCls sample class} <br/>
 *  -->
 * @constructor
 * @xtype total_itemputold_chart
 **/
MAT.chartpanel.ItemPutOldSnapshot = Ext.extend(MAT.chartpanel.ChartPanelBaseCls, {
	//private
	//An implementation of the {@link MAT.chartpanel.ChartPanelBaseCls#buildChart MAT.chartpanel.ChartPanelBaseCls.buildChart} method.
	buildChart : function() {
		return {
			xtype       : 'stackedcolumnchart',
			store       : this.buildStore(),
			xField      : 'year',
			tipRenderer : this.tipRenderer,
			series      : this.buildSeries(),
			extraStyle  : this.chartExtraStyles,
			xAxis       : new Ext.chart.CategoryAxis({
				title : 'Year'
			}),
			yAxis : new Ext.chart.NumericAxis({
				stackingEnabled : true,
				title           : 'Number of items'
			})
		};
	},
	// private
	// An implementation of the {@link MAT.chartpanel.ChartPanelBaseCls#buildStore MAT.chartpanel.ChartPanelBaseCls.buildStore} method.
	buildStore : function() {
		return  {
			xtype      : 'jsonstore',
			root       : 'records',
			autoLoad   : true,
			baseParams : {
				permitUrl : true
			},
			proxy    : new Ext.data.HttpProxy({
				url: '/getput-cake/gestcollabs/jsonGetItemPutOld'
			}),
			fields   : [
				{ name: 'year',  type: 'number'},
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
			yField      : 'photo',
			displayName : 'Photo',
			style       : seriesStyles.red
		},
		{
			yField      : 'text',
			displayName : 'Text',
			style       : seriesStyles.green
		},
		{
			type        : 'line',
			yField      : 'total',
			displayName : 'Total',
			style       : seriesStyles.blue
		}
		];
	}
});

Ext.reg('itemputoldsnapshot', MAT.chartpanel.ItemPutOldSnapshot);
