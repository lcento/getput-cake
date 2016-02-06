Ext.ns("GetPut");

/**
 * @class GetPut.WorkspaceHstFileGetListManager
 * NEEDS DESCRIPTION
 * <br />
 * @constructor
 * @singleton
 **/
GetPut.WorkspaceHstFileGetListManager = function() {
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
				defaults    :  { WorkspaceHstFileGetListManager : this },
				items       :  [
					{
                        			xtype  : 'hstfilegetlistmanager'
					},
				]
			});

		viewWindow = new Ext.Window({
			width	    : 930,
			height      : 620,
			modal       : false,
			draggable   : false,
			applyTo	    : 'listfileget',
			title	    : "Files prelevati",
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


Ext.onReady(GetPut.WorkspaceHstFileGetListManager.init, GetPut.WorkspaceHstFileGetListManager );