Ext.ns("GetPut");

/**
 * @class GetPut.EmployeeManager
 * @extends Ext.Panel
 * An Ext.Window implementation that contains  the {@link Ext.layout.FitLayout fit} layout to
 *  present {@link MAT.form.EmployeeForm} implementation.
 * <br />
 * @constructor
 * @param {Object} config The config object
 **/
GetPut.EmployeeManager = Ext.extend(Ext.Panel, {
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
			this.buildEmployeeListView(),
			this.buildEmployeeForm()
		];

		GetPut.EmployeeManager.superclass.initComponent.call(this);
	},

	buildEmployeeListView : function() {

		var listEmployeeStore = new Ext.data.JsonStore(
			{
				xtype       	: 'jsonstore',
				root	    	: 'records',
				totalProperty	: 'totalCount',
				autoLoad    	: true,
				baseParams	: {start:0, limit:300, username:''},
				proxy	    	: new Ext.data.HttpProxy({
					url: '/getput-cake/admins/jsonGetListUser'
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
			listStore	: listEmployeeStore,
			listSizeStore	: 300,
			style     	: 'border-top: 1px solid #99BBE8;border-left: 1px solid #99BBE8;border-right: 1px solid #99BBE8;border-bottom: 1px solid #99BBE8',
			title     	: 'Lista',
			listeners : {
				scope  : this,
				click  : this.onEmployeeListClick
			}
		};
	},

	buildEmployeeForm : function() {
		return {
			xtype     : 'employeeform',
			itemId    : 'employeeForm',
			flex      : 1,
			border    : false,
			style     : 'border-top: 1px solid #99BBE8;border-left: 1px solid #99BBE8;border-right: 1px solid #99BBE8;border-bottom: 1px solid #99BBE8',
			title     : 'Form utenti',
			listeners : {
				scope   : this,
				newemp  : this.onNewEmployee,
				delemp  : this.onDeleteEmployee,
				saveemp : this.onSaveEmployee
			}
		};

    	},

	onEmployeeListClick : function() {
		var record = this.getComponent('employeeList').getSelected();
		var msg = String.format(
			this.msgs.fetchingDataFor,
			record.get('users_username')
		);

		Ext.get('gestusers').mask(msg, 'x-mask-loading');

		//this.getComponent('employeeForm').disableSaveButton();

		this.getComponent('employeeForm').load({
			url     : '/getput-cake/admins/jsonGetUser',
			scope   : this,
			success : this.clearMask,
			failure : this.onEmployeeFormLoadFailure,
			params  : {
				id : record.get('users_id')
			}
		});
	},

	onEmployeeFormLoadFailure : function() {
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
    
	onNewEmployee : function() {
		//this.getComponent('employeeForm').enableSaveButton();

		this.getComponent('employeeList').clearSelections();
		this.prepareFormForNew();
	},

	onDeleteEmployee : function(formPanel, vals) {
		var msg = String.format(this.msgs.deleteEmpConfirm, vals.users_id, vals.users_username);

		Ext.MessageBox.confirm(
			this.msgs.immediateChanges,
			msg,
			this.onConfirmDeleteEmployee,
			this
        	);
	},

	onConfirmDeleteEmployee : function(btn) {
		if (btn === 'yes') {
			var vals = this.getComponent('employeeForm').getValues();

			var msg = String.format(
				this.msgs.deletingEmployee,
				vals.users_id,
				vals.users_username
			);

			Ext.get('gestusers').mask(msg, 'x-mask-loading');

			Ext.Ajax.request({
				url          : '/getput-cake/admins/jsonDelUser',
				scope        : this,
				callback     : this.onAfterAjaxReq,
				succCallback : this.onAfterDeleteEmployee,
				params       : {
					id : vals.users_id
				}
			});
        	}
	},

	onAfterAjaxReq : function(options, success, result) {
		//Ext.get('gestusers').unmask();

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



	onAfterDeleteEmployee : function(jsonData) {
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
			this.getComponent('employeeForm').clearForm();
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

	onSaveEmployee : function(employeeForm, vals) {
		if ( employeeForm.getForm().isDirty() ) {
			if (employeeForm.getForm().isValid()) {
				var msg = String.format(
					this.msgs.saving,
					vals.users_username
				);

				Ext.get('gestusers').mask(msg, 'x-mask-loading');
	
				employeeForm.getForm().submit({
					url     : '/getput-cake/admins/jsonSaveUserIfValid',
					scope   : this,
					success : this.onEmpFormSaveSuccess,
					failure : this.onEmpFormSaveFailure
				});
			}
			else {
				Ext.MessageBox.alert('Error', this.msgs.errorsInForm);
			}
		}
	},

	onEmpFormSaveSuccess : function(form, action) {
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
			this.getComponent('employeeForm').setValues(resultData);
		}

		Ext.MessageBox.alert('Success', msg);

		this.clearMask();
	},

	onEmpFormSaveFailure : function(form, action) {
		var result = action.result;

		this.clearMask();
		Ext.MessageBox.alert('Error', this.msgs.errorSavingData);
	},

	prepareFormForNew : function() {
		this.getComponent('employeeForm').load({
			url     : '/getput-cake/admins/jsonGetDefUser',
			scope   : this,
			params       : {
				permitUrl : true
			}
		});
	},

	clearMask : function() {
		Ext.get('gestusers').unmask();
	},

   /* cleanSlate : function () {
        this.getComponent('departmentList').refreshView();
        this.getComponent('employeeList').clearView();
        this.getComponent('employeeForm').clearForm();
    }*/
});

Ext.reg('employeemanager', GetPut.EmployeeManager);