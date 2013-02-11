
		<div id="mainBody"></div>
		<script type="text/javascript">
		 Ext.namespace("exam");
		 exam.app = function()
		 {
		 	return{
	 		init: function()
	 		{
	 			ExtCommon.util.init();
	 			ExtCommon.util.quickTips();
	 			this.getGrid();
	 		},
	 		getGrid: function()
	 		{
	 			ExtCommon.util.renderSearchField('searchby');
	
	 			var Objstore = new Ext.data.Store({
	 						proxy: new Ext.data.HttpProxy({
	 							url: "<?php echo site_url('exam/getexam') ?>",
	 							method: "POST"
	 							}),
	 						reader: new Ext.data.JsonReader({
	 								root: "data",
	 								id: "id",
	 								totalProperty: "totalCount",
	 								fields: [
		{ name: 'id'},{ name: 'name'},{ name: 'description'},{ name: 'timePerQuestion'},{ name: 'dcreated'},{ name: 'dmodified'},{ name: 'createdby'},{ name: 'modifiedby'},{ name: 'is_delete'}
		]
 						}),
 						remoteSort: true,
 						baseParams: {start: 0, limit: 25}
 					});
		
		var colModel = new Ext.grid.ColumnModel([
		{header: "id", width: 100, sortable: true, dataIndex: 'id'},{header: "name", width: 100, sortable: true, dataIndex: 'name'},{header: "description", width: 100, sortable: true, dataIndex: 'description'},{header: "timePerQuestion", width: 100, sortable: true, dataIndex: 'timePerQuestion'},{header: "dcreated", width: 100, sortable: true, dataIndex: 'dcreated'},{header: "dmodified", width: 100, sortable: true, dataIndex: 'dmodified'},{header: "createdby", width: 100, sortable: true, dataIndex: 'createdby'},{header: "modifiedby", width: 100, sortable: true, dataIndex: 'modifiedby'},{header: "is_delete", width: 100, sortable: true, dataIndex: 'is_delete'}
		]);

 			var grid = new Ext.grid.GridPanel({
 				id: 'examgrid',
 				height: 300,
 				width: '100%',
 				border: true,
 				ds: Objstore,
 				cm:  colModel,
 				sm: new Ext.grid.RowSelectionModel({singleSelect:true}),
 	        	loadMask: true,
 	        	bbar:
 	        		new Ext.PagingToolbar({
 		        		autoShow: true,
 				        pageSize: 25,
 				        store: Objstore,
 				        displayInfo: true,
 				        displayMsg: 'Displaying Results {0} - {1} of {2}',
 				        emptyMsg: "No Data Found."
 				    }),
 				tbar: [new Ext.form.ComboBox({
                    fieldLabel: 'Search',
                    hiddenName:'searchby-form',
                    id: 'searchby',
                    typeAhead: true,
                    triggerAction: 'all',
                    emptyText:'Search By...',
                    selectOnFocus:true,
                    store: new Ext.data.SimpleStore({
				         id:0
				        ,fields:
				            [
				             'myId',   //numeric value is the key
				             'myText' //the text value is the value

				            ]


				         , data: [['id', 'ID'], ['sd', 'Short Description'], ['ld', 'Long Description']]

			        }),
				    valueField:'myId',
				    displayField:'myText',
				    mode:'local',
                    width:100,
                    hidden: true

                }), {
					xtype:'tbtext',
					text:'Search:'
				},'   ', new Ext.app.SearchField({ store: Objstore, width:250}),
 					    {
 					     	xtype: 'tbfill'
 					 	},{
 					     	xtype: 'tbbutton',
 					     	text: 'ADD',
							icon: '/images/icons/application_add.png',
 							cls:'x-btn-text-icon',

 					     	handler: exam.app.Add

 					 	},'-',{
 					     	xtype: 'tbbutton',
 					     	text: 'EDIT',
							icon: '/images/icons/application_edit.png',
 							cls:'x-btn-text-icon',

 					     	handler: exam.app.Edit

 					 	},'-',{
 					     	xtype: 'tbbutton',
 					     	text: 'DELETE',
							icon: '/images/icons/application_delete.png',
 							cls:'x-btn-text-icon',

 					     	handler: exam.app.Delete

 					 	}
 	    			 ]
 	    	});

 			exam.app.Grid = grid;
 			exam.app.Grid.getStore().load({params:{start: 0, limit: 25}});

 			var _window = new Ext.Panel({
 		        title: 'Exams',
 		        width: '100%',
 		        height:'auto',
 		        renderTo: 'mainBody',
 		        draggable: false,
 		        layout: 'fit',
 		        items: [exam.app.Grid],
 		        resizable: false
 	        });

 	        _window.render();


 		},
		
		setForm: function(){

 		    var form = new Ext.form.FormPanel({
 		        labelWidth: 150,
 		        url: "<?php echo site_url('exam/addexam') ?>",
 		        method: 'POST',
 		        defaultType: 'textfield',
 		        frame: true,
 		        items: [ {
 					xtype:'fieldset',
 					title:'Fields w/ Asterisks are required.',
 					width:'auto',
 					height:'auto',
 					items:[
				{
                    xtype:'textfield',
 		            fieldLabel: 'id*',
 		            name: 'id',
 		            allowBlank:false,
 		            anchor:'95%',  // anchor width by percentage
 		            id: 'id'
 		        },
				{
                    xtype:'textfield',
 		            fieldLabel: 'name*',
 		            name: 'name',
 		            allowBlank:false,
 		            anchor:'95%',  // anchor width by percentage
 		            id: 'name'
 		        },
				{
                    xtype:'textfield',
 		            fieldLabel: 'description*',
 		            name: 'description',
 		            allowBlank:false,
 		            anchor:'95%',  // anchor width by percentage
 		            id: 'description'
 		        },
				{
                    xtype:'textfield',
 		            fieldLabel: 'timePerQuestion*',
 		            name: 'timePerQuestion',
 		            allowBlank:false,
 		            anchor:'95%',  // anchor width by percentage
 		            id: 'timePerQuestion'
 		        },
				{
                    xtype:'textfield',
 		            fieldLabel: 'dcreated*',
 		            name: 'dcreated',
 		            allowBlank:false,
 		            anchor:'95%',  // anchor width by percentage
 		            id: 'dcreated'
 		        },
				{
                    xtype:'textfield',
 		            fieldLabel: 'dmodified*',
 		            name: 'dmodified',
 		            allowBlank:false,
 		            anchor:'95%',  // anchor width by percentage
 		            id: 'dmodified'
 		        },
				{
                    xtype:'textfield',
 		            fieldLabel: 'createdby*',
 		            name: 'createdby',
 		            allowBlank:false,
 		            anchor:'95%',  // anchor width by percentage
 		            id: 'createdby'
 		        },
				{
                    xtype:'textfield',
 		            fieldLabel: 'modifiedby*',
 		            name: 'modifiedby',
 		            allowBlank:false,
 		            anchor:'95%',  // anchor width by percentage
 		            id: 'modifiedby'
 		        },
				{
                    xtype:'textfield',
 		            fieldLabel: 'is_delete*',
 		            name: 'is_delete',
 		            allowBlank:false,
 		            anchor:'95%',  // anchor width by percentage
 		            id: 'is_delete'
 		        }    
 		        

 		        		]
 					}
 					]
 		    });

 		    exam.app.Form = form;
 		},
		
 		Add: function(){

 			exam.app.setForm();

 		  	var _window;

 		    _window = new Ext.Window({
 		        title: 'New exam',
 		        width: 510,
 		        height: 365,
 		        layout: 'fit',
 		        plain:true,
 		        modal: true,
 		        bodyStyle:'padding:5px;',
 		        buttonAlign:'center',
 		        items: exam.app.Form,
 		        buttons: [{
 		         	text: 'Save',
                    icon: '/images/icons/disk.png',  
                    cls:'x-btn-text-icon',
 	                handler: function () {
 			            if(ExtCommon.util.validateFormFields(exam.app.Form)){//check if all forms are filled up
 		                exam.app.Form.getForm().submit({
 			                success: function(f,action){
                 		    	Ext.MessageBox.alert('Status', action.result.data);
                  		    	 Ext.Msg.show({
  								     title: 'Status',
 								     msg: action.result.data,
  								     buttons: Ext.Msg.OK,
  								     icon: 'icon'
  								 });
 				                ExtCommon.util.refreshGrid(exam.app.Grid.getId());
 				                _window.destroy();
 			                },
 			                failure: function(f,a){
 								Ext.Msg.show({
 									title: 'Error Alert',
 									msg: a.result.data,
 									icon: Ext.Msg.ERROR,
 									buttons: Ext.Msg.OK
 								});
 			                },
 			                waitMsg: 'Saving Data...'
 		                });
 	                }else return;
 	                }
 	            },{
 		            text: 'Cancel',
                    icon: '/images/icons/cancel.png', 
                    cls:'x-btn-text-icon',
 		            handler: function(){
 			            _window.destroy();
 		            }
 		        }]
 		    });
 		  	_window.show();
 		},
		
		Edit: function(){
 			if(ExtCommon.util.validateSelectionGrid(exam.app.Grid.getId())){//check if user has selected an item in the grid
 			var sm = exam.app.Grid.getSelectionModel();
 			var id = sm.getSelected().data.id;

 			exam.app.setForm();
 		    _window = new Ext.Window({
 		        title: 'Update Classification',
 		        width: 510,
 		        height:365,
 		        layout: 'fit',
 		        plain:true,
 		        modal: true,
 		        bodyStyle:'padding:5px;',
 		        buttonAlign:'center',
 		        items: exam.app.Form,
 		        buttons: [{
 		         	text: 'Save',
                    icon: '/images/icons/disk.png',  
                    cls:'x-btn-text-icon',
 		            handler: function () {
 			            if(ExtCommon.util.validateFormFields(exam.app.Form)){//check if all forms are filled up
 		                exam.app.Form.getForm().submit({
 			                url: "<?php echo site_url('exam/updateexam') ?>",
 			                params: {id: id},
 			                method: 'POST',
 			                success: function(f,action){
                 		    	Ext.MessageBox.alert('Status', action.result.data);
 				                ExtCommon.util.refreshGrid(exam.app.Grid.getId());
 				                _window.destroy();
 			                },
 			                failure: function(f,a){
 								Ext.Msg.show({
 									title: 'Error Alert',
 									msg: a.result.data,
 									icon: Ext.Msg.ERROR,
 									buttons: Ext.Msg.OK
 								});
 			                },
 			                waitMsg: 'Updating Data...'
 		                });
 	                }else return;
 		            }
 		        },{
 		            text: 'Cancel',
                            icon: '/images/icons/cancel.png', cls:'x-btn-text-icon',

 		            handler: function(){
 			            _window.destroy();
 		            }
 		        }]
 		    });

 		  	exam.app.Form.getForm().load({
 				url: "<?php echo site_url('exam/loadexam') ?>",
 				method: 'POST',
 				params: {id: id},
 				timeout: 300000,
 				waitMsg:'Loading...',
 				success: function(form, action){
                                    _window.show();
 				},
 				failure: function(form, action) {
         					Ext.Msg.show({
 									title: 'Error Alert',
 									msg: "A connection to the server could not be established",
 									icon: Ext.Msg.ERROR,
 									buttons: Ext.Msg.OK,
 									fn: function(){ _window.destroy(); }
 								});
     			}
 			});
 			}else return;
 		},
		
		Delete: function(){


			if(ExtCommon.util.validateSelectionGrid(exam.app.Grid.getId())){//check if user has selected an item in the grid
			var sm = exam.app.Grid.getSelectionModel();
			var id = sm.getSelected().data.id;
			Ext.Msg.show({
   			title:'Delete Selected',
  			msg: 'Are you sure you want to delete this record?',
   			buttons: Ext.Msg.OKCANCEL,
   			fn: function(btn, text){
   			if (btn == 'ok'){
   			Ext.Ajax.request({
                            url: "<?php echo site_url('exam/deleteexam') ?>",
							params:{ id: id},
							method: "POST",
							timeout:300000000,
			                success: function(responseObj){
                		    	var response = Ext.decode(responseObj.responseText);
						if(response.success == true)
						{
							exam.app.Grid.getStore().load({params:{start:0, limit: 25}});
							return;

						}
						else if(response.success == false)
						{
							Ext.Msg.show({
								title: 'Error!',
								msg: "There was an error encountered in deleting the record. Please try again",
								icon: Ext.Msg.ERROR,
								buttons: Ext.Msg.OK
							});

							return;
						}
							},
			                failure: function(f,a){
								Ext.Msg.show({
									title: 'Error Alert',
									msg: "There was an error encountered in deleting the record. Please try again",
									icon: Ext.Msg.ERROR,
									buttons: Ext.Msg.OK
								});
			                },
			                waitMsg: 'Deleting Data...'
						});
   			}
   			},

   			icon: Ext.MessageBox.QUESTION
			});

	                }else return;


		}
		
		}
		}();

	 Ext.onReady(exam.app.init, exam.app);
	
	</script>
		