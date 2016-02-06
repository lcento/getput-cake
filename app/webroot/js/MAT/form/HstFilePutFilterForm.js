Ext.ns("MAT.form");

/**
 * @class MAT.form.HstFilePutFilterForm
 * @extends MAT.form.FormPanelBaseCls
 *  An Ext.form.FormPanel implementation that contains a number of fields to filter employee data
 * <br />
 * @constructor
 * @param {Object} config The config object
 * @xtype hstfileputfilterform
 **/
MAT.form.HstFilePutFilterForm = Ext.extend(MAT.form.FormPanelBaseCls, {
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

		MAT.form.HstFilePutFilterForm.superclass.initComponent.call(this);

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
				width      : 8,
				items : {
					xtype: 'spacer'
				}
			},
			{
				width      : 200,
				labelWidth : 75,
				items  : {
					xtype          : 'combo',
					fieldLabel     : 'Type_user',
					name           : 'users_type',
					forceSelection : true,
					allowBlank     : true,
					labelStyle     : 'font-family: Verdana, Geneva, sans-serif;font-size: 10px; font-weight:bold;',
					displayField   : 'type_users_desc',
					valueField     : 'type_users_num',
					tpl	       : '<tpl for="."><div class="x-combo-list-item">{type_users_desc:defaultValue("\u00a0")}</div></tpl>',
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
							url: '/getput-cake/histories/jsonGetTypeUser'
						}),
						fields   : [ 
							{ name: 'type_users_num', type: 'int'},
							{ name: 'type_users_desc', type: 'string'}
						],
						listeners: {
							load: function() {
								var r = new (this.recordType)({
									type_users_num: '100',
									type_users_desc: ''
								});

								this.insert(0, r);
							}
						}
					}
				}
			},
			{
				width      : 8,
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
							url: '/getput-cake/histories/jsonGetAgencyGroup'
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
			},
			{
				width      : 8,
				items : {
					xtype: 'spacer'
				}
			},
			{
				width      : 200,
				labelWidth : 70,
				items  : {
					xtype          : 'combo',
					fieldLabel     : 'File_dest',
					forceSelection : true,
					allowBlank     : true,
					emptyText      :'',
					labelStyle     : 'font-family: Verdana, Geneva, sans-serif;font-size: 10px; font-weight:bold;',
					displayField   : 'filedest_desc',
					valueField     : 'filedest_id',
					hiddenName     : 'filedest_id',
					tpl	       : '<tpl for="."><div class="x-combo-list-item">{filedest_desc:defaultValue("\u00a0")}</div></tpl>',
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
							url: '/getput-cake/histories/jsonGetFileDest'
						}),
						fields   : [
							{ name: 'id_num', type: 'int'},
							{ name: 'filedest_id', type: 'string'},
							{ name: 'filedest_desc', type: 'string'}
						],
						listeners: {
							load: function() {
								var r = new (this.recordType)({
									id_num: '100',
									filedest_desc: ''
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
			url    : '/getput-cake/histories/jsonGetDefFilter',
			params       : {
				permitUrl : true
			}
        	});
	}
});

Ext.reg('hstfileputfilterform', MAT.form.HstFilePutFilterForm);