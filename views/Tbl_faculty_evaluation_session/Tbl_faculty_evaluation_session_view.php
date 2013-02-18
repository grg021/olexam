
		<div id="mainBody"></div>
		<script type="text/javascript">
		 Ext.namespace("Tbl_faculty_evaluation_session");
		 Tbl_faculty_evaluation_session.app = function()
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
	 							url: "<?php echo site_url('Tbl_faculty_evaluation_session/getTbl_faculty_evaluation_session') ?>",
	 							method: "POST"
	 							}),
	 						reader: new Ext.data.JsonReader({
	 								root: "data",
	 								id: "id",
	 								totalProperty: "totalCount",
	 								fields: [
		{ name: 'id'},{ name: 'question_set_id'},{ name: 'title'},{ name: 'description'},{ name: 'start_date'},{ name: 'end_date'},{ name: 'section_id'},{ name: 'faculty_id'},{ name: 'dcreated'},{ name: 'dmodified'},{ name: 'created_by'},{ name: 'modified_by'}
		]
 						}),
 						remoteSort: true,
 						baseParams: {start: 0, limit: 25}
 					});
		
		var colModel = new Ext.grid.ColumnModel([
		{header: "id", width: 100, sortable: true, dataIndex: 'id'},{header: "question_set_id", width: 100, sortable: true, dataIndex: 'question_set_id'},{header: "title", width: 100, sortable: true, dataIndex: 'title'},{header: "description", width: 100, sortable: true, dataIndex: 'description'},{header: "start_date", width: 100, sortable: true, dataIndex: 'start_date'},{header: "end_date", width: 100, sortable: true, dataIndex: 'end_date'},{header: "section_id", width: 100, sortable: true, dataIndex: 'section_id'},{header: "faculty_id", width: 100, sortable: true, dataIndex: 'faculty_id'},{header: "dcreated", width: 100, sortable: true, dataIndex: 'dcreated'},{header: "dmodified", width: 100, sortable: true, dataIndex: 'dmodified'},{header: "created_by", width: 100, sortable: true, dataIndex: 'created_by'},{header: "modified_by", width: 100, sortable: true, dataIndex: 'modified_by'}
		]);

 			var grid = new Ext.grid.GridPanel({
 				id: 'Tbl_faculty_evaluation_sessiongrid',
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

 					     	handler: Tbl_faculty_evaluation_session.app.Add

 					 	},'-',{
 					     	xtype: 'tbbutton',
 					     	text: 'EDIT',
							icon: '/images/icons/application_edit.png',
 							cls:'x-btn-text-icon',

 					     	handler: Tbl_faculty_evaluation_session.app.Edit

 					 	},'-',{
 					     	xtype: 'tbbutton',
 					     	text: 'DELETE',
							icon: '/images/icons/application_delete.png',
 							cls:'x-btn-text-icon',

 					     	handler: Tbl_faculty_evaluation_session.app.Delete

 					 	}
 	    			 ]
 	    	});

 			Tbl_faculty_evaluation_session.app.Grid = grid;
 			Tbl_faculty_evaluation_session.app.Grid.getStore().load({params:{start: 0, limit: 25}});

 			var _window = new Ext.Panel({
 		        title: 'Tbl_faculty_evaluation_session',
 		        width: '100%',
 		        height:'auto',
 		        renderTo: 'mainBody',
 		        draggable: false,
 		        layout: 'fit',
 		        items: [Tbl_faculty_evaluation_session.app.Grid],
 		        resizable: false
 	        });

 	        _window.render();


 		},
		
		setForm: function(){

 		    var form = new Ext.form.FormPanel({
 		        labelWidth: 150,
 		        url: "<?php echo site_url('Tbl_faculty_evaluation_session/addTbl_faculty_evaluation_session') ?>",
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
 		            fieldLabel: 'question_set_id*',
 		            name: 'question_set_id',
 		            allowBlank:false,
 		            anchor:'95%',  // anchor width by percentage
 		            id: 'question_set_id'
 		        },
				{
                    xtype:'textfield',
 		            fieldLabel: 'title*',
 		            name: 'title',
 		            allowBlank:false,
 		            anchor:'95%',  // anchor width by percentage
 		            id: 'title'
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
 		            fieldLabel: 'start_date*',
 		            name: 'start_date',
 		            allowBlank:false,
 		            anchor:'95%',  // anchor width by percentage
 		            id: 'start_date'
 		        },
				{
                    xtype:'textfield',
 		            fieldLabel: 'end_date*',
 		            name: 'end_date',
 		            allowBlank:false,
 		            anchor:'95%',  // anchor width by percentage
 		            id: 'end_date'
 		        },
				{
                    xtype:'textfield',
 		            fieldLabel: 'section_id*',
 		            name: 'section_id',
 		            allowBlank:false,
 		            anchor:'95%',  // anchor width by percentage
 		            id: 'section_id'
 		        },
				{
                    xtype:'textfield',
 		            fieldLabel: 'faculty_id*',
 		            name: 'faculty_id',
 		            allowBlank:false,
 		            anchor:'95%',  // anchor width by percentage
 		            id: 'faculty_id'
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
 		            fieldLabel: 'created_by*',
 		            name: 'created_by',
 		            allowBlank:false,
 		            anchor:'95%',  // anchor width by percentage
 		            id: 'created_by'
 		        },
				{
                    xtype:'textfield',
 		            fieldLabel: 'modified_by*',
 		            name: 'modified_by',
 		            allowBlank:false,
 		            anchor:'95%',  // anchor width by percentage
 		            id: 'modified_by'
 		        }    
 		        

 		        		]
 					}
 					]
 		    });

 		    Tbl_faculty_evaluation_session.app.Form = form;
 		},
		
 		Add: function(){

 			Tbl_faculty_evaluation_session.app.setForm();

 		  	var _window;

 		    _window = new Ext.Window({
 		        title: 'New Tbl_faculty_evaluation_session',
 		        width: 510,
 		        height: 440,
 		        layout: 'fit',
 		        plain:true,
 		        modal: true,
 		        bodyStyle:'padding:5px;',
 		        buttonAlign:'center',
 		        items: Tbl_faculty_evaluation_session.app.Form,
 		        buttons: [{
 		         	text: 'Save',
                    icon: '/images/icons/disk.png',  
                    cls:'x-btn-text-icon',
 	                handler: function () {
 			            if(ExtCommon.util.validateFormFields(Tbl_faculty_evaluation_session.app.Form)){//check if all forms are filled up
 		                Tbl_faculty_evaluation_session.app.Form.getForm().submit({
 			                success: function(f,action){
                 		    	Ext.MessageBox.alert('Status', action.result.data);
                  		    	 Ext.Msg.show({
  								     title: 'Status',
 								     msg: action.result.data,
  								     buttons: Ext.Msg.OK,
  								     icon: 'icon'
  								 });
 				                ExtCommon.util.refreshGrid(Tbl_faculty_evaluation_session.app.Grid.getId());
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
 			if(ExtCommon.util.validateSelectionGrid(Tbl_faculty_evaluation_session.app.Grid.getId())){//check if user has selected an item in the grid
 			var sm = Tbl_faculty_evaluation_session.app.Grid.getSelectionModel();
 			var id = sm.getSelected().data.id;

 			Tbl_faculty_evaluation_session.app.setForm();
 		    _window = new Ext.Window({
 		        title: 'Update Classification',
 		        width: 510,
 		        height:440,
 		        layout: 'fit',
 		        plain:true,
 		        modal: true,
 		        bodyStyle:'padding:5px;',
 		        buttonAlign:'center',
 		        items: Tbl_faculty_evaluation_session.app.Form,
 		        buttons: [{
 		         	text: 'Save',
                    icon: '/images/icons/disk.png',  
                    cls:'x-btn-text-icon',
 		            handler: function () {
 			            if(ExtCommon.util.validateFormFields(Tbl_faculty_evaluation_session.app.Form)){//check if all forms are filled up
 		                Tbl_faculty_evaluation_session.app.Form.getForm().submit({
 			                url: "<?php echo site_url('Tbl_faculty_evaluation_session/updateTbl_faculty_evaluation_session') ?>",
 			                params: {id: id},
 			                method: 'POST',
 			                success: function(f,action){
                 		    	Ext.MessageBox.alert('Status', action.result.data);
 				                ExtCommon.util.refreshGrid(Tbl_faculty_evaluation_session.app.Grid.getId());
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

 		  	Tbl_faculty_evaluation_session.app.Form.getForm().load({
 				url: "<?php echo site_url('Tbl_faculty_evaluation_session/loadTbl_faculty_evaluation_session') ?>",
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


			if(ExtCommon.util.validateSelectionGrid(Tbl_faculty_evaluation_session.app.Grid.getId())){//check if user has selected an item in the grid
			var sm = Tbl_faculty_evaluation_session.app.Grid.getSelectionModel();
			var id = sm.getSelected().data.id;
			Ext.Msg.show({
   			title:'Delete Selected',
  			msg: 'Are you sure you want to delete this record?',
   			buttons: Ext.Msg.OKCANCEL,
   			fn: function(btn, text){
   			if (btn == 'ok'){
   			Ext.Ajax.request({
                            url: "<?php echo site_url('Tbl_faculty_evaluation_session/deleteTbl_faculty_evaluation_session') ?>",
							params:{ id: id},
							method: "POST",
							timeout:300000000,
			                success: function(responseObj){
                		    	var response = Ext.decode(responseObj.responseText);
						if(response.success == true)
						{
							Tbl_faculty_evaluation_session.app.Grid.getStore().load({params:{start:0, limit: 25}});
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

	 Ext.onReady(Tbl_faculty_evaluation_session.app.init, Tbl_faculty_evaluation_session.app);
	
	</script>
		