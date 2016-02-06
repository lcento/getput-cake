Ext.ns("MAT.form");

/**
 * @class MAT.form.AgeUserForm
 * @extends MAT.form.FormPanelBaseCls
 *  An Ext.form.FormPanel implementation that contains a number of fields to manage ageuser data
 * <br />
 * @constructor
 * @param {Object} config The config object
 * @xtype ageuserform
 **/
MAT.form.AgeUserForm = Ext.extend(MAT.form.FormPanelBaseCls, {
	border        : true,
	autoScroll    : true,
	bodyStyle     : 'background-color: #DFE8F6; padding: 10px;',
	layout        : 'form',
	labelWidth    : 110,
	defaultType   : 'textfield',
	defaults      : {
		width      : 200,
		maxLength  : 255,
		allowBLank : false,
		labelStyle : 'font-family: Verdana, Geneva, sans-serif;font-size: 10px; font-weight:bold;',
		msgTarget  : 'side'
		/*listeners: {
            		change: function(field, newVal, oldVal) {
                		alert(field);
            		}
		}*/
	},

	//private
	//constructs the form layout elements.
	initComponent : function() {
		Ext.applyIf(this, {
			tbar  : this.buildTbar(),
			items : this.buildFormItems()
		});

		MAT.form.CollabForm.superclass.initComponent.call(this);

		this.addEvents({
			/**
			* @event newemp
			* Fired after the new employee button is pressed
			*
			*/
			newemp    : true,
			saveemp   : true,
			delemp    : true
		});

		this.on({
			scope  : this,
			render : {
				single : true,
				fn     : this.loadDefFormAfterRender
			}
		});
	},

	buildTbar : function() {
		return [
			{
				text     : 'Save',
				id	 : 'save',
				iconCls  : 'icon-disk',
				disabled : false,
				scope    : this,
				handler  : this.onSave
			},
			'-',
			{
				text    : 'Reset',
				iconCls : 'icon-arrow_undo',
				scope   : this,
				handler : this.onReset
			},
			'-',
			{
				text    : 'New User',
				iconCls : 'icon-user_add',
				scope   : this,
				handler : this.onNew
			},
			'->',
			{
				text    : 'Delete User',
				iconCls : 'icon-user_delete',
				scope   : this,
				handler : this.onDelete
			}
		];
	},

	buildFormItems : function() {
		var 	topContainer			= this.buildTopContainer(),
			nameContainer 			= this.buildNameContainer(),
			agencyGroupContainer		= this.buildAgencyGroupContainer();
	
		return [
			topContainer,

			{
				xtype      : 'numberfield',
				fieldLabel : 'Id',
				name       : 'users_id',
				readOnly   : true,
				cls	   : 'table_form_text1',
				width      : 50,
				maxLength  : 11
			},

			nameContainer,

			{
				xtype      : 'textfield',
				fieldLabel : 'Realname',
				name       : 'users_username_realname',
				cls	   : 'table_form_text1',
				width      : 200,
				maxLength  : 50
			},
			{
				xtype      : 'textfield',
				fieldLabel : 'Se_author',
				name       : 'users_se_author',
				cls	   : 'table_form_text1',
				width      : 200,
				maxLength  : 50
			},

			agencyGroupContainer
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
				width      : 345,
				labelWidth : 110,
				layout     : 'form'
			},
			items          : [
			{
				items      :  {
					xtype      : 'textfield',
					fieldLabel : 'Username',
					name       : 'users_username',
					style	   : 'margin-right: 20px;',
					anchor     : '-10',
					allowBlank : false,
					cls	   : 'table_form_text1',
					msgTarget  : 'side',
					labelStyle: 'font-family: Verdana, Geneva, sans-serif;font-size: 10px; font-weight:bold;',
					maxLength  : 50
				}
			},
			{
				width      : 310,
				labelWidth : 75,
				items      :  {
					xtype      : 'textfield',
					fieldLabel : 'Password',
					name       : 'users_password',
					style	   : 'margin-right: 20px;',
					anchor     : '-10',
					cls	   : 'table_form_text1',
					msgTarget  : 'side',
					labelStyle : 'font-family: Verdana, Geneva, sans-serif;font-size: 10px; font-weight:bold;',
					maxLength  : 50
				}
			}
			]
		};
	},

	buildAgencyGroupContainer : function() {
		return {
			xtype       : 'container',
			layout      : 'column',
			defaultType : 'container',
			style	    : 'margin-top: 10px;',
			anchor      : '-10',
			defaults    : {
				width      : 260,
				labelWidth : 110,
				layout     : 'form'
			},
			items       : [
				{
					items  : {
						xtype          : 'combo',
						fieldLabel     : 'Agency_group',
						forceSelection : true,
						name           : 'agency_group',
						labelStyle     : 'font-family: Verdana, Geneva, sans-serif;font-size: 10px; font-weight:bold;',
						displayField   : 'group_desc',
						valueField     : 'group_id',
						allowBlank     : false,
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
							]
						}
					}
				}
			]
        	};
    	},

	disableSaveButton : function() {
		Ext.getCmp('save').disable();
	},

	enableSaveButton : function() {
		Ext.getCmp('save').enable();
	},

	onNew : function() {
		this.clearForm();
		this.fireEvent('newemp', this);
	},

	onSave : function() {
		if (this.isValid()) {
			this.fireEvent('saveemp', this, this.getValues());
		}
	},

	onReset : function() {
		this.reset();
	},

	onDelete : function() {
		var vals = this.getValues();

		if ((vals.users_username.length > 0) && this.isValid()) {
			this.fireEvent('delemp', this, vals);
        	}
	},

	loadDefFormAfterRender : function() {
		this.load({
			url    : '/getput-cake/gestexternal/jsonGetDefUser',
			params       : {
				permitUrl : true
			}
        	});
    	}
});

Ext.reg('ageuserform', MAT.form.AgeUserForm);