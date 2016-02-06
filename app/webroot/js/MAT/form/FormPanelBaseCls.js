Ext.ns('MAT.form');

/**
 * @class MAT.form.FormPanelBaseCls
 * @extends Ext.form.FormPanel
 *  An Ext.form.FormPanel implementation that contains a number of fields to manage employee data
 * <br />
 * @constructor
 * @param {Object} config The config object
 **/
MAT.form.FormPanelBaseCls = Ext.extend(Ext.form.FormPanel, {

	constructor : function(config) {
			config = config || {};
			Ext.applyIf(config, {
			trackResetOnLoad : true
		});

		MAT.form.FormPanelBaseCls.superclass.constructor.call(this, config);
	},

	getValues : function() {
		return this.getForm().getValues();
	},

	isValid : function() {
		return this.getForm().isValid();
	},

	clearForm : function() {
		var vals    = this.getForm().getValues();
		var clrVals = {};
	
		for (var vName in vals)  {
			clrVals[vName] = null;
		}
	
		this.getForm().setValues(clrVals);
		this.data = null;

		this.getForm().clearInvalid();
	},

	reset : function() {
		this.getForm().reset();
	},
	
	loadData : function(data) {
		if (data) {
			this.data = data;
			this.getForm().setValues(data);
		}
		else {
			this.clearForm();
		}
	},

	setValues : function(o) {
		return this.getForm().setValues(o || {});
	}
});