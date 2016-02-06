Ext.ns('MAT.listpanel');

/**
 * @class MAT.listpanel.ListPanelBaseCls
 * @extends Ext.Panel
 * A base class that contains the reusable bits of configuration for ListViews in a Panel.
 * It uses the {@link Ext.layout.FitLayout fit} layout to stretch the {@link Ext.chart.Chart} instance.
 * <br />
 * @constructor
 * @param {Object} config The config object
 **/

MAT.listpanel.ListPanelBaseCls = Ext.extend(Ext.Panel, {
	layout  : 'fit',
	initComponent : function() {
		this.items = this.buildListView();

		MAT.listpanel.ListPanelBaseCls.superclass.initComponent.call(this);

		this.relayEvents(this.getView(), ['click']);
		this.relayEvents(this.getStore(), ['load']);
	},

	buildBbar : function() {
		return {};
	},

	buildBbar : function() {
		return {};
	},

	buildListView : function() {
        	return {};
	},

	buildStore : function() {
		return { xtype : 'jsonstore' };
	},

	/*clearView : function() {
        	this.getStore().removeAll();
	},*/

	createAndSelectRecord : function(obj) {
		var view = this.getView();
		var record = new view.store.recordType(obj);

		view.store.addSorted(record);

		var index = view.store.indexOf(record);
		view.select(index);

		return record;
	},

	clearSelections : function() {
		return this.getView().clearSelections();
	},

	getView : function() {
        	return this.items.items[0];
	},

	getStore : function() {
		return this.getView().store;
	},

	getSelectedRecords : function() {
        	return this.getView().getSelectedRecords();
	},

	getSelected : function() {
		return this.getSelectedRecords()[0];
	},

	refreshView : function() {
		this.getView().store.reload();
	},

	/*selectById : function(id) {
		var view = this.getView();
		id = id || false;
		if (id) {
			var ind = view.store.find('id', id);
			view.select(ind);
        	}
	},*/

	loadStoreBySetParams : function(params, val) {

		this.getStore().setBaseParam(params,val);

		this.getStore().load();
	},

	loadStoreByParams : function(params) {
		params = params || {};

		this.getStore().load({params:params});
	},

	loadStoreByFilters : function(filters) {
		if (filters) {
			this.getStore().filter(filters);
		}
	},

	clearStoreFilters : function(supEvent) {
		supEvent = supEvent || false;

		this.getStore().clearFilter(true);
	}
});