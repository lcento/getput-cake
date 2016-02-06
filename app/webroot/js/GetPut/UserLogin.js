Ext.ns("GetPut");

/**
 * @class GetPut.UserLogin
 * NEEDS DESCRIPTION
 * <br />
 * @constructor
 * @singleton
 **/
GetPut.UserLogin = function() {
	var loginWindow,
	    //baseUrl = "/getput-cake/"
	    baseUrl = "/"
	    loginUrl = "/getput-cake/users/login";

	return {
		init : function() {
			if (!loginWindow) {
				loginWindow = this.buildLoginWindow();
			}

			loginWindow.show();
		},
	
		buildLoginWindow : function() {
			return new MAT.window.UserLoginWindow({
				title   : ' Portale ILMATTINO',
				scope   : this,
				handler : this.onLogin
			});
		},

		onLogin :  function() {
			var form = loginWindow.get(0);
	
			if (form.getForm().isValid()) {
				loginWindow.el.mask('Please wait...', 'x-mask-loading');
		
				form.getForm().submit({
					url	: loginUrl,
					success : this.onLoginSuccess,
					failure : function(form, action) { 
						this.onLoginFailure(form, action);
					},
					scope   : this
				});
			}
		},

		onLoginSuccess : function() {
			loginWindow.el.unmask();

			window.location.href = baseUrl;
			//window.location = baseUrl;
	
			loginWindow.destroy();
			loginWindow = null;
			baseUrl = null;
		},

		onLoginFailure : function(form, action) {
			loginWindow.el.unmask();
	
			var xPos = loginWindow.el.getX();
			var yPos = loginWindow.el.getY();
	
			var jsonData;
			jsonData = Ext.decode(action.response.responseText);
	
			var msgWithStyle = '<div style="font-family:Verdana, Geneva, sans-serif; font-weight:normal; font-size:11px;">' + jsonData.message + '</div>';
			var msgGenericWithStyle = '<div style="font-family:Verdana, Geneva, sans-serif; font-weight:normal; font-size:11px;"> Connessione - Server non raggiungibile !!!</div>';
	
			if (action.failureType == 'server') { 
				var dialMsg = Ext.Msg.show({
					title		  : 'Errore',
					msg 		  : msgWithStyle,
					maxWidth	  : 350,
					buttons 	  : Ext.MessageBox.OK,
					fn 		  : this.doResetForm(form),
					icon 	  	  : 'icon-error-24'}, this);
			}
			else {
				var dialMsg = Ext.Msg.show({
					title		  : 'Errore',
					msg 		  : msgGenericWithStyle,
					maxWidth	  : 350,
					buttons 	  : Ext.MessageBox.OK,
					fn 		  : this.doResetForm(form),
					icon 	  	  : 'icon-error-24'}, this);
			}

			dialMsg.getDialog().setPosition(xPos - 45, yPos + 20);
		},

		doResetForm : function(form) {
			form.reset();
		}
	};
}();


Ext.onReady(GetPut.UserLogin.init, GetPut.UserLogin);
