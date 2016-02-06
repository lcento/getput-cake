Ext.ns("GetPut");

/**
 * @class GetPut.CollabManager
 * @extends Ext.Panel
 * An Ext.Window implementation that contains  the {@link Ext.layout.FitLayout fit} layout to
 *  present {@link MAT.form.CollabForm} implementation.
 * <br />
 * @constructor
 * @param {Object} config The config object
 **/
GetPut.CollabManager = Ext.extend(Ext.Panel, {
	border : false,
	layout : {
		type  : 'hbox',
		align : 'stretch'
	},
	msgs : {
		immediateChanges : 'Warning! Changes are <span style="color: red;">immediate</span>.',
		errorsInForm     : 'There are errors in the form. Please correct and try again.',
		empSavedSuccess  : 'Saved {0} successfully.',
		fetchingDataFor  : 'Fetching data for : {0}',
		couldNotLoadData : 'Could not load data for : {0} !!!',
		saving           : 'Saving user : {0}',
		errorSavingData  : 'There was an error saving the form !!!',
		deletingEmployee : 'Deleting user {0}, {1}...',
		deleteEmpConfirm : 'Are you sure you want to delete user {0}, {1}?',
		deleteEmpSuccess : 'User {0}, {1} was deleted successfully.',
		deleteEmpFailure : 'User {0}, {1} was not deleted due to a failure.'
	},
	initComponent : function() {
		this.items = [
			this.buildCollabListView(),
			this.buildCollabForm()
		];

		GetPut.CollabManager.superclass.initComponent.call(this);
	},

	buildCollabListView : function() {

		var listCollabStore = new Ext.data.JsonStore(
			{
				xtype       	: 'jsonstore',
				root	    	: 'records',
				totalProperty	: 'totalCount',
				autoLoad    	: true,
				baseParams	: {start:0, limit:300, username:''},
				proxy	    	: new Ext.data.HttpProxy({
					url: '/getput-cake/gestcollabs/jsonGetListUser'
						  }),
				fields      	: [ 
					{ name: 'users_id', type: 'int'},
					{ name: 'users_username', type: 'string'} 
				],
				sortInfo    	:  {
					field     : 'users_username',
					direction : 'ASC'
				},
			});

		return {
			xtype     	: 'employeelist',
			itemId    	: 'employeeList',
			width     	: 235,
			border    	: false,
			listStore	: listCollabStore,
			listSizeStore	: 300,
			style     	: 'border-top: 1px solid #99BBE8;border-left: 1px solid #99BBE8;border-right: 1px solid #99BBE8;border-bottom: 1px solid #99BBE8',
			title     	: 'Lista',
			listeners : {
				scope  : this,
				click  : this.onCollabListClick
			}
		};
	},

	buildCollabForm : function() {
		return {
			xtype     : 'collabform',
			itemId    : 'collabForm',
			flex      : 1,
			border    : false,
			style     : 'border-top: 1px solid #99BBE8;border-left: 1px solid #99BBE8;border-right: 1px solid #99BBE8;border-bottom: 1px solid #99BBE8',
			title     : 'Form collaboratori',
			listeners : {
				scope   : this,
				newemp  : this.onNewCollab,
				delemp  : this.onDeleteCollab,
				saveemp : this.onSaveCollab
			}
		};

    	},

	onCollabListClick : function() {
		var record = this.getComponent('employeeList').getSelected();
		var msg = String.format(
			this.msgs.fetchingDataFor,
			record.get('users_username')
		);

		Ext.get('gestcollabs').mask(msg, 'x-mask-loading');

		this.getComponent('collabForm').load({
			url     : '/getput-cake/gestcollabs/jsonGetUser',
			scope   : this,
			success : this.clearMask,
			failure : this.onCollabFormLoadFailure,
			params  : {
				id : record.get('users_id')
			}
		});
	},

	onCollabFormLoadFailure : function() {
		var record = this.getComponent('employeeList').getSelected();
		var msg = String.format(
			this.msgs.couldNotLoadData,
			record.get('users_username')
		);

		Ext.MessageBox.show({
			title   : 'Error',
			msg     : msg,
			buttons : Ext.MessageBox.OK,
			icon    : Ext.MessageBox.WARNING
		});

		this.clearMask();
	},
    
	onNewCollab : function() {
		//this.getComponent('employeeForm').enableSaveButton();

		this.getComponent('employeeList').clearSelections();
		this.prepareFormForNew();
	},

	onDeleteCollab : function(formPanel, vals) {
		var msg = String.format(this.msgs.deleteEmpConfirm, vals.users_id, vals.users_username);

		Ext.MessageBox.confirm(
			this.msgs.immediateChanges,
			msg,
			this.onConfirmDeleteCollab,
			this
        	);
	},

	onConfirmDeleteCollab : function(btn) {
		if (btn === 'yes') {
			var vals = this.getComponent('collabForm').getValues();

			var msg = String.format(
				this.msgs.deletingEmployee,
				vals.users_id,
				vals.users_username
			);

			Ext.get('gestcollabs').mask(msg, 'x-mask-loading');

			Ext.Ajax.request({
				url          : '/getput-cake/gestcollabs/jsonDelUser',
				scope        : this,
				callback     : this.onAfterAjaxReq,
				succCallback : this.onAfterDeleteCollab,
				params       : {
					id : vals.users_id
				}
			});
        	}
	},

	onAfterAjaxReq : function(options, success, result) {
		Ext.get('gestcollabs').unmask();

		if (success === true) {
			var jsonData;
			try {
				jsonData = Ext.decode(result.responseText);
			}
			catch (e) {
				Ext.MessageBox.alert('Error!', 'Data returned is not valid!');
			}
			
			options.succCallback.call(options.scope, jsonData, options);
            	}
		else {
			Ext.MessageBox.alert('Error!', 'The web transaction failed!');
		}
	},



	onAfterDeleteCollab : function(jsonData) {
		var msg,
		selectedEmployee = this.getComponent('employeeList').getSelected();

		if (jsonData.success === true) {

			msg = String.format(
				this.msgs.deleteEmpSuccess,
				selectedEmployee.get('users_id'),
				selectedEmployee.get('users_username')
			);
	
			Ext.MessageBox.alert('success', msg);
	
			selectedEmployee.store.remove(selectedEmployee);
			this.getComponent('collabForm').clearForm();
			this.prepareFormForNew();
        	}
		else {

			msg = String.format(
				this.msgs.deleteEmpFailure,
				selectedEmployee.get('users_id'),
				selectedEmployee.get('users_username')
			);

			Ext.MessageBox.alert('Error', msg);
		}

        	this.clearMask();
	},

	onSaveCollab : function(collabForm, vals) {
		if ( collabForm.getForm().isDirty() ) {
			if (collabForm.getForm().isValid()) {
				var msg = String.format(
					this.msgs.saving,
					vals.users_username
				);

				Ext.get('gestcollabs').mask(msg, 'x-mask-loading');
	
				collabForm.getForm().submit({
					url     : '/getput-cake/gestcollabs/jsonSaveUserIfValid',
					scope   : this,
					success : this.onCollabFormSaveSuccess,
					failure : this.onCollabFormSaveFailure,
				});
			}
			else {
				Ext.MessageBox.alert('Error', this.msgs.errorsInForm);
			}
		}
	},

	onCollabFormSaveSuccess : function(form, action) {
		var record = this.getComponent('employeeList').getSelected();
		var vals = form.getValues();

		var msg = String.format(
			this.msgs.empSavedSuccess,
			vals.users_username
		);

		if (record) {
			record.set('users_id', vals.users_id);
			record.set('users_username', vals.users_username);
			record.commit();
		}
        	else {
			var resultData = action.result.data;

			this.getComponent('employeeList').createAndSelectRecord(resultData);
			this.getComponent('collabForm').setValues(resultData);
		}

		Ext.MessageBox.alert('Success', msg);

		this.clearMask();
	},

	onCollabFormSaveFailure : function(form, action) {
		var result = action.result;

		this.clearMask();
		Ext.MessageBox.alert('Error', this.msgs.errorSavingData);
	},

	prepareFormForNew : function() {
		this.getComponent('collabForm').load({
			url     : '/getput-cake/gestcollabs/jsonGetDefUser',
			scope   : this,
			params       : {
				permitUrl : true
			}
		});
	},

	clearMask : function() {
		Ext.get('gestcollabs').unmask();
	},
});

Ext.reg('collabmanager', GetPut.CollabManager);