Ext.ns("GetPut");

/**
 * @class GetPut.WorkspaceGraphItemPutManager
 * NEEDS DESCRIPTION
 * <br />
 * @constructor
 * @singleton
 **/
GetPut.WorkspaceGraphItemPutManager = function() {
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
				defaults    :  { WorkspaceGraphItemPutManager : this },
				items       :  [
					{
                        			xtype  : 'graphitemputmanager'
					},
				]
			});

		viewWindow = new Ext.Window({
			width	    : 930,
			height      : 620,
			modal       : false,
			draggable   : false,
			applyTo	    : 'graphitemput',
			title	    : "Grafico contributi inviati",
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


Ext.onReady(GetPut.WorkspaceGraphItemPutManager.init, GetPut.WorkspaceGraphItemPutManager );