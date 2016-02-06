Ext.ns("GetPut");

/**
 * @class GetPut.WorkspaceAgeUserManager
 * NEEDS DESCRIPTION
 * <br />
 * @constructor
 * @singleton
 **/
GetPut.WorkspaceAgeUserManager = function() {
    var viewWindow, viewPanel;

	return {
		init : function() {
			this.buildView();
		},

		buildView : function() {
			viewPanel = new Ext.Panel({
				layout      : 'fit',
				activeItem  : 0,
				border      : false,
				defaults    :  { WorkspaceAgeUserManager : this },
				items       :  [
					{
                        			xtype  : 'ageusermanager'
					},
				]
			});

		viewWindow = new Ext.Window({
			width	    : 930,
			height      : 620,
			modal       : false,
			draggable   : false,
			applyTo	    : 'gestusers',
			title	    : "Gestione utenti agenzie",
			layout 	    : 'fit',
			center	    : true,
			closable    : false,
			resizable   : false,
			border      : false,
			items       : viewPanel
		}).show();

		Ext.getBody().unmask();
        },

	destroy : function() {
		viewWindow.destroy();
		viewWindow = null;
		viewPanel = null;
	
		this.init();
        }
    };
}();


Ext.onReady(GetPut.WorkspaceAgeUserManager.init, GetPut.WorkspaceAgeUserManager );