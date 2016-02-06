Ext.ns("GetPut");

/**
 * @class GetPut.WorkspaceEmployeeManager
 * NEEDS DESCRIPTION
 * <br />
 * @constructor
 * @singleton
 **/
GetPut.WorkspaceCollabManager = function() {
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
				defaults    :  { WorkspaceCollabManager : this },
				items       :  [
					{
                        			xtype  : 'collabmanager'
					},
				]
			});

		viewWindow = new Ext.Window({
			width	    : 930,
			height      : 620,
			modal       : false,
			draggable   : false,
			applyTo	    : 'gestcollabs',
			title	    : "Gestione collaboratori",
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


Ext.onReady(GetPut.WorkspaceCollabManager.init, GetPut.WorkspaceCollabManager );