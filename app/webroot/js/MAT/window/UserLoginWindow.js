Ext.ns("MAT.window");

/**
 * @class MAT.window.UserLoginWindow
 * @extends Ext.Window
 * A class to manage user logins
 * @constructor
 */
MAT.window.UserLoginWindow = Ext.extend(Ext.Window, {
	/**
	* @cfg scope [Object} A refrence to the handler scope
	*/
	/**
	* @cfg handler {Object} A reference to a method to be called to process the login
	*/
	/**
	* @private
	* Configures the component, enforcing defaults
	*/

	initComponent : function() {
		// Force defaults
		Ext.apply(this, {
			width     : 260,
			height    : 150,
			x	  : 600,
			y	  : 250,
			modal     : false,
			draggable : false,
			title     : 'Login',
			layout    : 'fit',
			center    : true,
			closable  : false,
			resizable : false,
			border    : false,
			items     : this.buildForm(),
			buttons   : [
				{
					text    : 'Login',
					handler : this.handler || Ext.emptyFn,
					scope   : this.scope || this
				}
			]
		});
	
		MAT.window.UserLoginWindow.superclass.initComponent.call(this);
	},
	//private builds the form.
	buildForm : function() {
	
		var formItemDefaults = {
			allowBlank : false,
			anchor     : '-5',
			listeners  : {
				scope      : this,
				specialkey : function(field, e) {
					if (e.getKey() === e.ENTER && this.handler) {
						this.handler.call(this.scope);
					}
				}
			}
		};
		
		return {
			xtype       : 'form',
			defaultType : 'textfield',
			labelWidth  : 70,
			frame       : true,
			labelAlign  : 'right',
			defaults    : formItemDefaults,
			items       : [
				{
					fieldLabel : 'User Name',
					labelStyle : 'font-family:Verdana, Geneva, sans-serif;font-weight:bold;font-size:10px;',
					name       : 'data[User][txUsername]',
					id	   : 'txUsername',
					listeners: {
						scope      : this,
						afterrender: function(field) {
							field.focus('', 500);
						}
					}
				},
				{
					inputType  : 'password',
					fieldLabel : 'Password',
					labelStyle : 'font-family:Verdana, Geneva, sans-serif;font-weight:bold;font-size:10px;',
					name       : 'data[User][txPassword]',
					id	   : 'txPassword'
				}
			]
		};
	}
});