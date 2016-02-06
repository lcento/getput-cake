Ext.ns("MAT.form");

/**
 * @class MAT.form.CollabForm
 * @extends MAT.form.FormPanelBaseCls
 *  An Ext.form.FormPanel implementation that contains a number of fields to manage collab data
 * <br />
 * @constructor
 * @param {Object} config The config object
 * @xtype collabform
 **/
MAT.form.CollabForm = Ext.extend(MAT.form.FormPanelBaseCls, {
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
			userLevelContainer  		= this.buildUserLevelContainer(),
			userTypeContainer		= this.buildUserTypeContainer(),
			userAccessContainer		= this.buildUserAccessContainer(),
			userAccessRealnameConatiner	= this.buildUserAccessRealnameContainer(),
			agencyGroupContainer		= this.buildAgencyGroupContainer(),
			permitUserContainer		= this.buildUserPermitContainer();
	
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

			userLevelContainer,
			userTypeContainer,
			userAccessContainer,
			userAccessRealnameConatiner,
			agencyGroupContainer,

			{
				xtype      : 'textfield',
				fieldLabel : 'Dir_get',
				name       : 'dirname_get',
				allowBlank : false,
				cls	   : 'table_form_text1',
				width      : 400,
				maxLength  : 255
			},
			{
				xtype      : 'textfield',
				fieldLabel : 'Dir_put_art',
				name       : 'dirname_put_art',
				allowBlank : false,
				cls	   : 'table_form_text1',
				width      : 400,
				maxLength  : 255
			},
			{
				xtype      : 'textfield',
				fieldLabel : 'Dir_put_pho',
				name       : 'dirname_put_pho',
				allowBlank : false,
				cls	   : 'table_form_text1',
				width      : 400,
				maxLength  : 255
			},
			{
				xtype      : 'textfield',
				fieldLabel : 'Dir_put_all',
				name       : 'dirname_put_all',
				cls	   : 'table_form_text1',
				width      : 400,
				maxLength  : 255
			},

			permitUserContainer
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

	buildUserLevelContainer : function() {
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
						fieldLabel     : 'Level',
						forceSelection : true ,
						name           : 'users_level',
						labelStyle     : 'font-family: Verdana, Geneva, sans-serif;font-size: 10px; font-weight:bold;',
						displayField   : 'level_users_desc',
						valueField     : 'level_users_num',
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
								url: '/getput-cake/gestcollabs/jsonGetLevelUser'
							}),
							fields   : [ 
								{ name: 'level_users_num', type: 'int'},
								{ name: 'level_users_desc', type: 'string'}
							]
						}
					}
				}
			]
        	};
    	},

	buildUserTypeContainer : function() {
		return {
			xtype       : 'container',
			layout      : 'column',
			defaultType : 'container',
			anchor      : '-10',
			defaults    : {
				width      : 220,
				labelWidth : 110,
				layout     : 'form'
			},
			items       : [
				{
					items  : {
						xtype          : 'combo',
						fieldLabel     : 'Type_user',
						forceSelection : true,
						name           : 'users_type',
						labelStyle     : 'font-family: Verdana, Geneva, sans-serif;font-size: 10px; font-weight:bold;',
						displayField   : 'type_users_desc',
						valueField     : 'type_users_num',
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
								url: '/getput-cake/gestcollabs/jsonGetTypeUser'
							}),
							fields   : [ 
								{ name: 'type_users_num', type: 'int'},
								{ name: 'type_users_desc', type: 'string'}
							]
						}
					}
				}
			]
        	};
    	},

	buildUserAccessContainer : function() {
		return {
			xtype       : 'container',
			layout      : 'column',
			defaultType : 'container',
			anchor      : '-10',
			defaults    : {
				width      : 220,
				labelWidth : 110,
				layout     : 'form'
			},
			items       : [
				{
					items  : {
						xtype          : 'combo',
						fieldLabel     : 'Access_user',
						forceSelection : true,
						name           : 'users_access',
						labelStyle     : 'font-family: Verdana, Geneva, sans-serif;font-size: 10px; font-weight:bold;',
						displayField   : 'type_access_desc',
						valueField     : 'type_access_num',
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
								url: '/getput-cake/gestcollabs/jsonGetAccessUser'
							}),
							fields   : [ 
								{ name: 'type_access_num', type: 'int'},
								{ name: 'type_access_desc', type: 'string'}
							]
						}
					}
				}
			]
        	};
    	},

	buildUserAccessRealnameContainer : function() {
		return {
			xtype       : 'container',
			layout      : 'column',
			defaultType : 'container',
			anchor      : '-10',
			defaults    : {
				width      : 220,
				labelWidth : 110,
				layout     : 'form'
			},
			items       : [
				{
					items  : {
						xtype          : 'combo',
						fieldLabel     : 'Access_realname',
						forceSelection : true,
						name           : 'users_access_realname',
						labelStyle     : 'font-family: Verdana, Geneva, sans-serif;font-size: 10px; font-weight:bold;',
						displayField   : 'type_access_realname_desc',
						valueField     : 'type_access_realname_num',
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
								url: '/getput-cake/gestcollabs/jsonGetAccessRealnameUser'
							}),
							fields   : [ 
								{ name: 'type_access_realname_num', type: 'int'},
								{ name: 'type_access_realname_desc', type: 'string'}
							]
						}
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
			style	    : 'margin-bottom: 10px;',
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
								url: '/getput-cake/gestcollabs/jsonGetAgencyGroup'
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

	buildUserPermitContainer : function() {
		return {
			xtype          : 'container',
			layout         : 'hbox',
			anchor         : '-10',
			defaultType    : 'container',
			style	       : 'margin-top: 20px;',
			defaults       : {
				width      : 170,
				labelWidth : 110,
				layout     : 'form'
			},
			items          : [
			{
				items      :  {
					xtype      : 'checkbox',
					fieldLabel : 'Put_art_permit',
					boxLabel   : '',
					checked	   : true,
					name       : 'put_art',
					anchor     : '-10',
					cls	   : 'table_form_text1',
					labelStyle: 'font-family: Verdana, Geneva, sans-serif;font-size: 10px; font-weight:bold;'
				}
			},
			{
				items      :  {
					xtype          : 'checkbox',
					fieldLabel     : 'Put_pho_permit',
					boxLabel       : '',
					checked	       : true,
					name           : 'put_pho',
					anchor         : '-10',
					cls	       : 'table_form_text1',
					labelStyle     : 'font-family: Verdana, Geneva, sans-serif;font-size: 10px; font-weight:bold;'
				}
			},
			{
				items      :  {
					xtype          : 'checkbox',
					fieldLabel     : 'Put_all_permit',
					boxLabel       : '',
					checked	       : true,
					name           : 'put_all',
					anchor         : '-10',
					cls	       : 'table_form_text1',
					labelStyle     : 'font-family: Verdana, Geneva, sans-serif;font-size: 10px; font-weight:bold;'
				}
			},
			{
				items      :  {
					xtype          : 'checkbox',
					fieldLabel     : 'Sendcms_permit',
					boxLabel       : '',
					name           : 'sndcms_mnu',
					anchor         : '-10',
					cls	       : 'table_form_text1',
					labelStyle     : 'font-family: Verdana, Geneva, sans-serif;font-size: 10px; font-weight:bold;'
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
			url    : '/getput-cake/gestcollabs/jsonGetDefUser',
			params       : {
				permitUrl : true
			}
        	});
    	}
});

Ext.reg('collabform', MAT.form.CollabForm);