Ext.ns("MAT.form");

/**
 * @class MAT.form.ClbFilePutFilterForm
 * @extends MAT.form.FormPanelBaseCls
 *  An Ext.form.FormPanel implementation that contains a number of fields to filter employee data
 * <br />
 * @constructor
 * @param {Object} config The config object
 * @xtype clbfileputfilterform
 **/
MAT.form.ClbFilePutFilterForm = Ext.extend(MAT.form.FormPanelBaseCls, {
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

		MAT.form.ClbFilePutFilterForm.superclass.initComponent.call(this);

		this.addEvents({
			/**
			* @event filteremp
			* Fired after the filter employee button is pressed
			*
			*/
			printemp  : true,
			resetemp  : true,
			filteremp : true,
			filtdate  : true
		});

		this.on({
			scope  : this,
			render : {
				single : true,
				fn     : this.loadDefFormAfterRender
			}
		});
	},

	buildFormItems : function() {
		var topContainer 	= this.buildTopContainer(),
		    nameContainer	= this.buildNameContainer(),
		    dateContainer	= this.buildDateContainer();
	
		return [
			//topContainer,
			nameContainer,
			dateContainer
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
			style	       : 'margin-top: 5px;',
			defaults       : {
				layout     : 'form'
			},
			items          : [
			{
				width      : 200,
				labelWidth : 75,
				items  : {
					xtype          : 'combo',
					fieldLabel     : 'Type',
					hiddenName     : 'type_contr',
					forceSelection : true,
					allowBlank     : true,
					labelStyle     : 'font-family: Verdana, Geneva, sans-serif;font-size: 10px; font-weight:bold;',
					displayField   : 'type_contr_desc',
					valueField     : 'type_contr_val',
					tpl	       : '<tpl for="."><div class="x-combo-list-item">{type_contr_desc:defaultValue("\u00a0")}</div></tpl>',
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
							url: '/getput-cake/gestcollabs/jsonGetTypeContrib'
						}),
						fields   : [ 
							{ name: 'type_contr_val', type: 'string'},
							{ name: 'type_contr_desc', type: 'string'}
						],
						listeners: {
							load: function() {
								var r = new (this.recordType)({
									type_contr_val: '100',
									type_contr_desc: ''
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

	buildDateContainer : function() {
		return {
			xtype          : 'container',
			layout         : 'hbox',
			anchor         : '-10',
			defaultType    : 'container',
			style	       : 'margin-top: 8px;',
			autoHeight : true,
			defaults       : {
				width      : 330,
				labelWidth : 70,
				layout     : 'form',
				trackResetOnLoad : true
			},
			items          : [
			{
				items      :  {
					xtype          : 'radiogroup',
					fieldLabel     : 'Date',
					anchor         : '-10',
					cls	       : 'table_form_text1',
					labelStyle     : 'font-family: Verdana, Geneva, sans-serif;font-size: 10px; font-weight:bold;',
					items : [
						{
							boxLabel   : 'Tutte',
							name	   : 'rb_auto',
							checked	   : true,
							inputValue : 'T',
							itemCls    : 'table_form_radiobox2'
						},
						{
							boxLabel   : 'Oggi',
							name	   : 'rb_auto',
							inputValue : 'O',
							itemCls    : 'table_form_radiobox2'
						},
						{
							boxLabel   : 'Intervallo',
							name	   : 'rb_auto',
							inputValue : 'I',
							itemCls    : 'table_form_radiobox2',
							scope      : this,
							handler    : this.onDatef
						}
					]
				}
			},
			{
				width      : 140,
				labelWidth : 30,
				items      :  {
					xtype          : 'datefield',
					fieldLabel     : 'Da',
					name           : 'date_from',
					anchor         : '-10',
					format	       : 'd/m/Y',
					itemCls        : 'table_form_radiobox3'
				}
			},
			{
				width      : 130,
				labelWidth : 20,
				items      :  {
					xtype          : 'datefield',
					fieldLabel     : 'A',
					name           : 'date_to',
					anchor         : '-10',
					format	       : 'd/m/Y',
					itemCls        : 'table_form_radiobox3'
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

		this.loadDefFormAfterRender();
	},

	onSearch : function() {
		this.fireEvent('filteremp', this);
	},

	onDatef : function() {
		this.fireEvent('filtdate', this);
	},

	loadDefFormAfterRender : function() {
		this.load({
			url    : '/getput-cake/gestcollabs/jsonGetDefFilter',
			params       : {
				permitUrl : true
			}
        	});
	}
});

Ext.reg('clbfileputfilterform', MAT.form.ClbFilePutFilterForm);

