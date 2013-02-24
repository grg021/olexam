<?php $this->load->view('Tbl_preset_choices/Tbl_preset_choices_view');?>

		<div id="mainBody"></div>
		<script type="text/javascript">
		 Ext.namespace("Tbl_preset");
		 Tbl_preset.app = function()
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
	 			if(ExtCommon.util.validateSelectionGrid(Question.app.Grid.getId(), "Please select a question!")){
	 			ExtCommon.util.renderSearchField('searchby');
	
	 			var Objstore = new Ext.data.Store({
	 						proxy: new Ext.data.HttpProxy({
	 							url: "<?php echo site_url('Tbl_preset/getTbl_preset') ?>",
	 							method: "POST"
	 							}),
	 						reader: new Ext.data.JsonReader({
	 								root: "data",
	 								id: "id",
	 								totalProperty: "totalCount",
	 								fields: [
		{ name: 'id'},{ name: 'description'}
		]
 						}),
 						remoteSort: true,
 						baseParams: {start: 0, limit: 25}
 					});
		
		var colModel = new Ext.grid.ColumnModel([
			{header: "ID", width: 75, sortable: true, dataIndex: 'id'},
			{header: "Description", width: 250, sortable: true, dataIndex: 'description'}
		]);

 			var grid = new Ext.grid.GridPanel({
 				id: 'Tbl_presetgrid',
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
 					 	},{
 					     	xtype: 'tbbutton',
 					     	text: 'OPERATIONS',
							icon: '/images/icons/wrench.png',
 							cls:'x-btn-text-icon',
							menu: [
							{
 								text: 'SELECT',
								icon: '/images/icons/accept.png',
								handler: Tbl_preset.app.SelectPreset
	 						},
	 						{
 								text: 'ADD',
								icon: '/images/icons/add.png',
								handler: Tbl_preset.app.Add
 							},
 							{
 								text: 'EDIT',
								icon: '/images/icons/pencil.png',
								handler: Tbl_preset.app.Edit
 							},
 							{
 								text: 'DELETE',
								icon: '/images/icons/delete.png',
								handler: Tbl_preset.app.Delete
 							}
							]
 					 	}
 	    			 ],
 	    			 listeners: {
 	    			 	rowclick: function(grid, r, e){
 	    			 		var record = grid.getStore().getAt(r);  

						    var data = record.get("id");
						   // console.log(data);
 	    			 		Tbl_preset_choices.app.Grid.getStore().setBaseParam("preset_id", data);
 	    			 		Tbl_preset_choices.app.Grid.getStore().load();
 	    			 	}
 	    			 }
 	    	});

 			Tbl_preset.app.Grid = grid;
 			Tbl_preset.app.Grid.getStore().load({params:{start: 0, limit: 25}});
 			Tbl_preset_choices.app.getGrid();
 			Tbl_preset.app.pcGrid = Tbl_preset_choices.app.Grid;

 			var _window = new Ext.Window({
 		        title: 'Preset Choices',
 		        width: 800,
 		        height: 400,
 		        draggable: false,
 		        layout: 'fit',
 		        items: [
 		        {
 		        	layout: 'column',
 		        	height: 'auto',
 		        	items: [
 		        	{
 		        		columnWidth: .50,
 		        		layout: 'form',
 		        		height: 'auto',
 		        		items: Tbl_preset.app.Grid
 		        	},
 		        	{
 		        		columnWidth: .50,
 		        		layout: 'form',
 		        		height: 'auto',
 		        		items: Tbl_preset.app.pcGrid
 		        		
 		        	}
 		        	]
 		        }],
 		        resizable: false
 	        }).show(); 	      
 	        
			//_window.render();
			Tbl_preset.app._window = _window;
			}else return;
 		},
		
		setForm: function(){

 		    var form = new Ext.form.FormPanel({
 		        labelWidth: 150,
 		        url: "<?php echo site_url('Tbl_preset/addTbl_preset') ?>",
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
 		        }
 		        		]
 					}
 					]
 		    });

 		    Tbl_preset.app.Form = form;
 		},
 		Add: function(){

 			Tbl_preset.app.setForm();

 		  	var _window;

 		    _window = new Ext.Window({
 		        title: 'New Tbl_preset',
 		        width: 510,
 		        height: 290,
 		        layout: 'fit',
 		        plain:true,
 		        modal: true,
 		        bodyStyle:'padding:5px;',
 		        buttonAlign:'center',
 		        items: Tbl_preset.app.Form,
 		        buttons: [{
 		         	text: 'Save',
                    icon: '/images/icons/disk.png',  
                    cls:'x-btn-text-icon',
 	                handler: function () {
 			            if(ExtCommon.util.validateFormFields(Tbl_preset.app.Form)){//check if all forms are filled up
 		                Tbl_preset.app.Form.getForm().submit({
 		                	url: "<?php echo site_url('Tbl_preset/add') ?>",
 			                success: function(f,action){
                 		    	Ext.MessageBox.alert('Status', action.result.data);
                  		    	 Ext.Msg.show({
  								     title: 'Status',
 								     msg: action.result.data,
  								     buttons: Ext.Msg.OK,
  								     icon: 'icon'
  								 });
 				                ExtCommon.util.refreshGrid(Tbl_preset.app.Grid.getId());
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
 		
 		AddPreset: function(){
 			if(ExtCommon.util.validateSelectionGrid(Question.app.Grid.getId(), "Please select a question!")){//check if user has selected an item in the grid
 			var sm = Question.app.Grid.getSelectionModel();
 			var id = sm.getSelected().data.id;
 			
			if(Tbl_question_choices.app.Grid.getStore().getTotalCount() > 0){
 			Tbl_preset.app.setForm();

 		  	var _window;

 		    _window = new Ext.Window({
 		        title: 'New Preset',
 		        width: 510,
 		        height: 160,
 		        layout: 'fit',
 		        plain:true,
 		        modal: true,
 		        bodyStyle:'padding:5px;',
 		        buttonAlign:'center',
 		        items: Tbl_preset.app.Form,
 		        buttons: [{
 		         	text: 'Save',
                    icon: '/images/icons/disk.png',  
                    cls:'x-btn-text-icon',
 	                handler: function () {
 			            if(ExtCommon.util.validateFormFields(Tbl_preset.app.Form)){//check if all forms are filled up
 		                Tbl_preset.app.Form.getForm().submit({
 		        			params: {id: id},
 			                success: function(f,action){
                 		    	Ext.MessageBox.alert('Status', action.result.data);
                  		    	 Ext.Msg.show({
  								     title: 'Status',
 								     msg: action.result.data,
  								     buttons: Ext.Msg.OK,
  								     icon: 'icon'
  								 });
 				                //ExtCommon.util.refreshGrid(Tbl_preset.app.Grid.getId());
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
 		  	}else{
 		  		Ext.Msg.show({
 									title: 'Error Alert',
 									msg: "No items in grid",
 									icon: Ext.Msg.ERROR,
 									buttons: Ext.Msg.OK
 								});
 								
 		  		return;
 		  	}
 		  	}
 		},
		
		Edit: function(){
 			if(ExtCommon.util.validateSelectionGrid(Tbl_preset.app.Grid.getId())){//check if user has selected an item in the grid
 			var sm = Tbl_preset.app.Grid.getSelectionModel();
 			var id = sm.getSelected().data.id;

 			Tbl_preset.app.setForm();
 		    _window = new Ext.Window({
 		        title: 'Update Preset Details',
 		        width: 510,
 		        height:160,
 		        layout: 'fit',
 		        plain:true,
 		        modal: true,
 		        bodyStyle:'padding:5px;',
 		        buttonAlign:'center',
 		        items: Tbl_preset.app.Form,
 		        buttons: [{
 		         	text: 'Save',
                    icon: '/images/icons/disk.png',  
                    cls:'x-btn-text-icon',
 		            handler: function () {
 			            if(ExtCommon.util.validateFormFields(Tbl_preset.app.Form)){//check if all forms are filled up
 		                Tbl_preset.app.Form.getForm().submit({
 			                url: "<?php echo site_url('Tbl_preset/updateTbl_preset') ?>",
 			                params: {id: id},
 			                method: 'POST',
 			                success: function(f,action){
                 		    	Ext.MessageBox.alert('Status', action.result.data);
 				                ExtCommon.util.refreshGrid(Tbl_preset.app.Grid.getId());
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

 		  	Tbl_preset.app.Form.getForm().load({
 				url: "<?php echo site_url('Tbl_preset/loadTbl_preset') ?>",
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


			if(ExtCommon.util.validateSelectionGrid(Tbl_preset.app.Grid.getId())){//check if user has selected an item in the grid
			var sm = Tbl_preset.app.Grid.getSelectionModel();
			var id = sm.getSelected().data.id;
			Ext.Msg.show({
   			title:'Delete Selected',
  			msg: 'Are you sure you want to delete this record?',
   			buttons: Ext.Msg.OKCANCEL,
   			fn: function(btn, text){
   			if (btn == 'ok'){
   			Ext.Ajax.request({
                            url: "<?php echo site_url('Tbl_preset/deleteTbl_preset') ?>",
							params:{ id: id},
							method: "POST",
							timeout:300000000,
			                success: function(responseObj){
                		    	var response = Ext.decode(responseObj.responseText);
						if(response.success == true)
						{
							Tbl_preset.app.Grid.getStore().load({params:{start:0, limit: 25}});
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


		},
		
		SelectPreset: function(){
			if(ExtCommon.util.validateSelectionGrid(Tbl_preset.app.Grid.getId())){//check if user has selected an item in the grid
				if(ExtCommon.util.validateSelectionGrid(Question.app.Grid.getId())){
				
			var sm = Tbl_preset.app.Grid.getSelectionModel();
			var id = sm.getSelected().data.id;
			
			var sm2 = Question.app.Grid.getSelectionModel();
			var id2 = sm2.getSelected().data.id;
			
			if(Tbl_question_choices.app.Grid.getStore().getTotalCount() > 0){
			Ext.MessageBox.buttonText.yes = "Append";
			Ext.MessageBox.buttonText.no = "Replace";
			Ext.Msg.show({
   			title:'Select Preset',
  			msg: 'Do you want to append or replace the current choices?',
   			buttons: Ext.Msg.YESNOCANCEL,
   			fn: function(btn, text){
   			if (btn == 'no'){
   			Ext.Ajax.request({
                            url: "<?php echo site_url('Tbl_preset/selectTbl_preset') ?>",
							params:{ id: id, id2: id2},
							method: "POST",
							timeout:300000000,
			                success: function(responseObj){
                		    	var response = Ext.decode(responseObj.responseText);
						if(response.success == true)
						{
							//_window.destroy();
							Tbl_question_choices.app.Grid.getStore().load({params:{start:0, limit: 25}});
							return;
						}
						else if(response.success == false)
						{
							Ext.Msg.show({
								title: 'Error!',
								msg: "There was an error encountered. Please try again",
								icon: Ext.Msg.ERROR,
								buttons: Ext.Msg.OK
							});

							return;
						}
							},
			                failure: function(f,a){
								Ext.Msg.show({
									title: 'Error Alert',
									msg: "There was an error encountered. Please try again",
									icon: Ext.Msg.ERROR,
									buttons: Ext.Msg.OK
								});
			                },
			                waitMsg: 'Selecting Data...'
						});
   			}else{
   			if (btn == 'yes'){
   			Ext.Ajax.request({
                            url: "<?php echo site_url('Tbl_preset/appendTbl_preset') ?>",
							params:{ id: id, id2: id2},
							method: "POST",
							timeout:300000000,
			                success: function(responseObj){
                		    	var response = Ext.decode(responseObj.responseText);
						if(response.success == true)
						{
							//_window.destroy();
							Tbl_question_choices.app.Grid.getStore().load({params:{start:0, limit: 25}});
							return;
						}
						else if(response.success == false)
						{
							Ext.Msg.show({
								title: 'Error!',
								msg: "There was an error encountered. Please try again",
								icon: Ext.Msg.ERROR,
								buttons: Ext.Msg.OK
							});

							return;
						}
							},
			                failure: function(f,a){
								Ext.Msg.show({
									title: 'Error Alert',
									msg: "There was an error encountered. Please try again",
									icon: Ext.Msg.ERROR,
									buttons: Ext.Msg.OK
								});
			                },
			                waitMsg: 'Selecting Data...'
						});
   			}
   			}
   			},

   			icon: Ext.MessageBox.QUESTION
			});
			}else{
				Ext.Ajax.request({
                            url: "<?php echo site_url('Tbl_preset/selectTbl_preset') ?>",
							params:{ id: id, id2: id2},
							method: "POST",
							timeout:300000000,
			                success: function(responseObj){
                		    	var response = Ext.decode(responseObj.responseText);
						if(response.success == true)
						{
							//_window.destroy();
							Tbl_question_choices.app.Grid.getStore().load({params:{start:0, limit: 25}});
							return;
						}
						else if(response.success == false)
						{
							Ext.Msg.show({
								title: 'Error!',
								msg: "There was an error encountered. Please try again",
								icon: Ext.Msg.ERROR,
								buttons: Ext.Msg.OK
							});

							return;
						}
							},
			                failure: function(f,a){
								Ext.Msg.show({
									title: 'Error Alert',
									msg: "There was an error encountered. Please try again",
									icon: Ext.Msg.ERROR,
									buttons: Ext.Msg.OK
								});
			                },
			                waitMsg: 'Saving Data...'
						});
			}
				}
	                }else return;


		}
		
		}
		}();

	 Ext.onReady(Tbl_preset.app.init, Tbl_preset.app);
	
	</script>
		