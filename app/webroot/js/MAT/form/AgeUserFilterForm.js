Ext.ns("MAT.form");

/**
 * @class MAT.form.AgeUserFilterForm
 * @extends MAT.form.FormPanelBaseCls
 *  An Ext.form.FormPanel implementation that contains a number of fields to filter employee data
 * <br />
 * @constructor
 * @param {Object} config The config object
 * @xtype ageuserfilterform
 **/
MAT.form.AgeUserFilterForm = Ext.extend(MAT.form.FormPanelBaseCls, {
	border        : true,
	autoScroll    : true,
	bodyStyle     : 'background-color: #DFE8F6; padding: 10px;',
	layout        : 'form',
	labelWidth    : 110,
	defaultType   : 'textfield',
	defaults      : {
		maxLength  : 255,
		labelStyle : 'font-family: Verdana, Geneva, sans-serif;font-size: 10px; font-weight:bold;'
	},

	//private
	//constructs the form layout elements.
	initComponent : function() {
		Ext.applyIf(this, {
			bbar    : this.buildBbar(),
			items   : this.buildFormItems()
		});

		MAT.form.AgeUserFilterForm.superclass.initComponent.call(this);

		this.addEvents({
			/**
			* @event filteremp
			* Fired after the filter employee button is pressed
			*
			*/
			printemp  : true,
			resetemp  : true,
			filteremp : true
		});
	},

	buildFormItems : function() {
		var topContainer 	= this.buildTopContainer(),
		    nameContainer	= this.buildNameContainer();
	
		return [
			//topContainer,
			nameContainer
		];
	},

	buildBbar : function() {
		return [
			{
				text    : 'Reset',
				iconCls : 'icon-arrow_undo',
				scope   : this,
				handler : this.onReset
			},
			'-',
			{
				text    : 'Search Now',
				iconCls : 'icon-find',
				scope   : this,
				handler : this.onSearch
			},
			'->',
			{
				text    : 'Print',
				iconCls : 'icon-printer',
				scope   : this,
				handler : this.onPrint
			}
		];
	},

	buildTopContainer : function() {
		return {
			xtype          : 'container',
			layout         : 'hbox',
			height	       : '20',
			defaultType    : 'container'
		};
	},

	buildNameContainer : function() {
		return {
			xtype          : 'container',
			layout         : 'hbox',
			anchor         : '-10',
			defaultType    : 'container',
			style	       : 'margin-top: 20px;',
			defaults       : {
				layout     : 'form'
			},
			items          : [
			{
				width      : 240,
				labelWidth : 75,
				items      :  {
					xtype      : 'textfield',
					fieldLabel : 'Username',
					name       : 'users_username',
					anchor     : '-10',
					allowBlank : true,
					cls	   : 'table_form_text1',
					labelStyle: 'font-family: Verdana, Geneva, sans-serif;font-size: 10px; font-weight:bold;',
					maxLength  : 50
				}
			},
			{
				width      : 20,
				items : {
					xtype: 'spacer'
				}
			},
			{
				width      : 230,
				labelWidth : 100,
				items  : {
					xtype          : 'combo',
					fieldLabel     : 'Agency_group',
					name           : 'agency_group',
					forceSelection : true,
					allowBlank     : true,
					emptyText      :'',
					labelStyle     : 'font-family: Verdana, Geneva, sans-serif;font-size: 10px; font-weight:bold;',
					displayField   : 'group_desc',
					valueField     : 'group_id',
					tpl	       : '<tpl for="."><div class="x-combo-list-item">{group_desc:defaultValue("\u00a0")}</div></tpl>',
					editable       : false,
					triggerAction  : 'all',
					mode	       : 'local',
					anchor         : '-10',
					cls	       : 'table_form_text1',
					store          : {
						xtype    : 'jsonstore',
						root     : 'records',
						autoLoad : true,
						baseParams       : {
							permitUrl : true
						},
						proxy    : new Ext.data.HttpProxy({
							url: '/getput-cake/gestexternal/jsonGetAgencyGroup'
						}),
						fields   : [ 
							{ name: 'group_id', type: 'int'},
							{ name: 'group_desc', type: 'string'}
						],
						listeners: {
							load: function() {
								var r = new (this.recordType)({
									group_id: '100',
									group_desc: ''
								});

								this.insert(0, r);
							}
						}
					}
				}
			}
			]
		};
	},

	onPrint : function() {
		this.fireEvent('printemp', this);
	},

	onReset : function() {
		this.fireEvent('resetemp', this);
		this.reset();
	},

	onSearch : function() {
		this.fireEvent('filteremp', this);
	}
});

Ext.reg('ageuserfilterform', MAT.form.AgeUserFilterForm);