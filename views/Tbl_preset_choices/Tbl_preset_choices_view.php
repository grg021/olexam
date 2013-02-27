
		<div id="mainBody"></div>
		<script type="text/javascript">
		 Ext.namespace("Tbl_preset_choices");
		 Tbl_preset_choices.app = function()
		 {
		 	return{
	 		init: function()
	 		{
	 			ExtCommon.util.init();
	 			ExtCommon.util.quickTips();
	 			//this.getGrid();
	 		},
	 		getGrid: function()
	 		{
	 			ExtCommon.util.renderSearchField('searchby');
	
	 			var Objstore = new Ext.data.Store({
	 						proxy: new Ext.data.HttpProxy({
	 							url: "<?php echo site_url('Tbl_preset_choices/getTbl_preset_choices') ?>",
	 							method: "POST"
	 							}),
	 						reader: new Ext.data.JsonReader({
	 								root: "data",
	 								id: "id",
	 								totalProperty: "totalCount",
	 								fields: [
		{ name: 'id'},{ name: 'question_id'},{ name: 'description'},{ name: 'correct_flag'}
		]
 						}),
 						remoteSort: true,
 						baseParams: {start: 0, limit: 25}
 					});
		
		var colModel = new Ext.grid.ColumnModel([
		{header: "ID", width: 75, sortable: true, dataIndex: 'id'},
		{header: "Description", width: 200, sortable: true, dataIndex: 'description'},
		{header: "Correct Flag", width: 100, sortable: true, dataIndex: 'correct_flag'}
		]);

 			var grid = new Ext.grid.GridPanel({
 				id: 'Tbl_preset_choicesgrid',
 				height: 365,
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
				},'   ', new Ext.app.SearchField({ store: Objstore, width:150}),
 					    {
 					     	xtype: 'tbfill'
 					 	},/*{
 					     	xtype: 'tbbutton',
 					     	text: 'ADD',
							icon: '/images/icons/application_add.png',
 							cls:'x-btn-text-icon',

 					     	handler: Tbl_preset_choices.app.Add

 					 	},'-',*/{
 					     	xtype: 'tbbutton',
 					     	text: 'OPERATIONS',
							icon: '/images/icons/wrench.png',
 							cls:'x-btn-text-icon',
 							menu: [
 							{
 								text: 'ADD',
								icon: '/images/icons/add.png',
								handler: Tbl_preset_choices.app.Add
 							},
 							{
 								text: 'EDIT',
								icon: '/images/icons/pencil.png',
								handler: Tbl_preset_choices.app.Edit
 							},
 							{
 								text: 'DELETE',
								icon: '/images/icons/delete.png',
								handler: Tbl_preset_choices.app.Delete
 							}
 							]
 					 	}/*,'-',{
 					     	xtype: 'tbbutton',
 					     	text: 'DELETE',
							icon: '/images/icons/application_delete.png',
 							cls:'x-btn-text-icon',

 					     	handler: Tbl_preset_choices.app.Delete

 					 	}*/
 	    			 ]
 	    	});

 			Tbl_preset_choices.app.Grid = grid;
 		//	Tbl_preset_choices.app.Grid.getStore().load({params:{start: 0, limit: 25}});


 		},
		
		setForm: function(){

 		    var form = new Ext.form.FormPanel({
 		        labelWidth: 150,
 		        url: "<?php echo site_url('Tbl_preset_choices/addTbl_preset_choices') ?>",
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
 		            fieldLabel: 'Description*',
 		            name: 'description',
 		            allowBlank:false,
 		            anchor:'95%',  // anchor width by percentage
 		            id: 'description'
 		        },
				{
                    xtype:'textfield',
 		            fieldLabel: 'Correct Flag*',
 		            name: 'correct_flag',
 		            allowBlank:false,
 		            anchor:'95%',  // anchor width by percentage
 		            id: 'correct_flag'
 		        }    
 		        

 		        		]
 					}
 					]
 		    });

 		    Tbl_preset_choices.app.Form = form;
 		},
		
 		Add: function(){
			if(ExtCommon.util.validateSelectionGrid(Tbl_preset.app.Grid.getId(), "Please select an entry on the left grid")){//check if user has selected an item in the grid
 			var sm = Tbl_preset.app.Grid.getSelectionModel();
 			var id = sm.getSelected().data.id;
 			
 			Tbl_preset_choices.app.setForm();

 		  	var _window;

 		    _window = new Ext.Window({
 		        title: 'New Entry',
 		        width: 510,
 		        height: 185,
 		        layout: 'fit',
 		        plain:true,
 		        modal: true,
 		        bodyStyle:'padding:5px;',
 		        buttonAlign:'center',
 		        items: Tbl_preset_choices.app.Form,
 		        buttons: [{
 		         	text: 'Save',
                    icon: '/images/icons/disk.png',  
                    cls:'x-btn-text-icon',
 	                handler: function () {
 			            if(ExtCommon.util.validateFormFields(Tbl_preset_choices.app.Form)){//check if all forms are filled up
 		                Tbl_preset_choices.app.Form.getForm().submit({
 		                	params: {
 		                		preset_id: id
 		                	},
 			                success: function(f,action){
                 		    	Ext.MessageBox.alert('Status', action.result.data);
                  		    	 Ext.Msg.show({
  								     title: 'Status',
 								     msg: action.result.data,
  								     buttons: Ext.Msg.OK,
  								     icon: 'icon'
  								 });
 				                ExtCommon.util.refreshGrid(Tbl_preset_choices.app.Grid.getId());
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
 		  	}else return;
 		},
		
		Edit: function(){
 			if(ExtCommon.util.validateSelectionGrid(Tbl_preset_choices.app.Grid.getId())){//check if user has selected an item in the grid
 			var sm = Tbl_preset_choices.app.Grid.getSelectionModel();
 			var id = sm.getSelected().data.id;

 			Tbl_preset_choices.app.setForm();
 		    _window = new Ext.Window({
 		        title: 'Update Preset Choice Details',
 		        width: 510,
 		        height: 185,
 		        layout: 'fit',
 		        plain:true,
 		        modal: true,
 		        bodyStyle:'padding:5px;',
 		        buttonAlign:'center',
 		        items: Tbl_preset_choices.app.Form,
 		        buttons: [{
 		         	text: 'Save',
                    icon: '/images/icons/disk.png',  
                    cls:'x-btn-text-icon',
 		            handler: function () {
 			            if(ExtCommon.util.validateFormFields(Tbl_preset_choices.app.Form)){//check if all forms are filled up
 		                Tbl_preset_choices.app.Form.getForm().submit({
 			                url: "<?php echo site_url('Tbl_preset_choices/updateTbl_preset_choices') ?>",
 			                params: {id: id},
 			                method: 'POST',
 			                success: function(f,action){
                 		    	Ext.MessageBox.alert('Status', action.result.data);
 				                ExtCommon.util.refreshGrid(Tbl_preset_choices.app.Grid.getId());
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

 		  	Tbl_preset_choices.app.Form.getForm().load({
 				url: "<?php echo site_url('Tbl_preset_choices/loadTbl_preset_choices') ?>",
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


			if(ExtCommon.util.validateSelectionGrid(Tbl_preset_choices.app.Grid.getId())){//check if user has selected an item in the grid
			var sm = Tbl_preset_choices.app.Grid.getSelectionModel();
			var id = sm.getSelected().data.id;
			Ext.Msg.show({
   			title:'Delete Selected',
  			msg: 'Are you sure you want to delete this record?',
   			buttons: Ext.Msg.OKCANCEL,
   			fn: function(btn, text){
   			if (btn == 'ok'){
   			Ext.Ajax.request({
                            url: "<?php echo site_url('Tbl_preset_choices/deleteTbl_preset_choices') ?>",
							params:{ id: id},
							method: "POST",
							timeout:300000000,
			                success: function(responseObj){
                		    	var response = Ext.decode(responseObj.responseText);
						if(response.success == true)
						{
							Tbl_preset_choices.app.Grid.getStore().load({params:{start:0, limit: 25}});
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

	 Ext.onReady(Tbl_preset_choices.app.init, Tbl_preset_choices.app);
	
	</script>
		