
		<div id="mainBody"></div>
		<script type="text/javascript">
		 Ext.namespace("Question");
		 Question.app = function()
		 {
		 	return{
	 		init: function()
	 		{
	 			ExtCommon.util.init();
	 			ExtCommon.util.quickTips();
	 			this.getGrid();
	 			Question.app._wheight = 275;
	 		},
	 		getGrid: function()
	 		{
	 			ExtCommon.util.renderSearchField('searchby');
	
	 			var Objstore = new Ext.data.Store({
	 						proxy: new Ext.data.HttpProxy({
	 							url: "<?php echo site_url('Question/getQuestion') ?>",
	 							method: "POST"
	 							}),
	 						reader: new Ext.data.JsonReader({
	 								root: "data",
	 								id: "id",
	 								totalProperty: "totalCount",
	 								fields: [
		{ name: 'id'},{ name: 'exam_id'},{ name: 'classification'},{ name: 'description'},{ name: 'category'}
		]
 						}),
 						remoteSort: true,
 						baseParams: {start: 0, limit: 25}
 					});
		
		var colModel = new Ext.grid.ColumnModel([
		{header: "ID", width: 75, sortable: true, dataIndex: 'id'},
		{header: "Question", width: 200, sortable: true, dataIndex: 'description'},
		{header: "Classification", width: 150, sortable: true, dataIndex: 'classification'},
		{header: "Category", width: 150, sortable: true, dataIndex: 'category'}
		
		
		]);

 			var grid = new Ext.grid.GridPanel({
 				id: 'Questiongrid',
 				height: 245,
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
 				        displayMsg: 'Displaying Questions {0} - {1} of {2}',
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

 					     	handler: Question.app.Add

 					 	},'-',{
 					     	xtype: 'tbbutton',
 					     	text: 'EDIT',
							icon: '/images/icons/application_edit.png',
 							cls:'x-btn-text-icon',

 					     	handler: Question.app.Edit

 					 	},'-',{
 					     	xtype: 'tbbutton',
 					     	text: 'DELETE',
							icon: '/images/icons/application_delete.png',
 							cls:'x-btn-text-icon',

 					     	handler: Question.app.Delete
 					 	},'-',{
 					     	xtype: 'tbbutton',
 					     	text: 'CATEGORIES',
							icon: '/images/icons/folder_page.png',
 							cls:'x-btn-text-icon',

 					     	handler: FILEQUCA.app.getGrid
 					     		
 					     	
 					 	}
 	    			 ],
 	    			 listeners: {
 	    			 	rowclick: function(grid, r, e){
 	    			 		var record = grid.getStore().getAt(r);  

						    var data = record.get("id");
						   // console.log(data);
 	    			 		Tbl_question_choices.app.Grid.getStore().setBaseParam("question_id", data);
 	    			 		Tbl_question_choices.app.Grid.getStore().load();
 	    			 	}
 	    			 }
 	    	});

 			Question.app.Grid = grid;
 		//	Question.app.Grid.getStore().load({params:{start: 0, limit: 25}});

 			/*var _window = new Ext.Panel({
 		        title: 'Question',
 		        width: '100%',
 		        height:'auto',
 		        renderTo: 'mainBody',
 		        draggable: false,
 		        layout: 'fit',
 		        items: [Question.app.Grid],
 		        resizable: false
 	        });

 	        _window.render();*/

 		},
		
		setForm: function(){

 		    var form = new Ext.form.FormPanel({
 		        labelWidth: 150,
 		        url: "<?php echo site_url('Question/addQuestion') ?>",
 		        method: 'POST',
 		        defaultType: 'textfield',
 		        frame: true,
 		        items: [ {
 					xtype:'fieldset',
 					title:'Fields w/ Asterisks are required.',
 					width:'auto',
 					height:'auto',
 					defaults: {
 						selectOnFocus: true
 					},
 					items:[
				ExtCommon.util.createCombo("classification", "classification_id", "95%", "<?php echo site_url("Question/getClassificationCombo")?>", "Question Type", false, false),
				ExtCommon.util.createCombo("category", "category_id", "95%", "<?php echo site_url("FILEQUCA/getCategoryCombo")?>", "Category", true, false),
				{
                    xtype:'numberfield',
 		            fieldLabel: 'Order position*',
 		            name: 'order_position',
 		            allowBlank:false,
 		            anchor:'95%',  // anchor width by percentage
 		            id: 'position'
 		      },
				{
                    xtype:'textarea',
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

 		    Question.app.Form = form;
 		},
		
 		Add: function(){
			if(ExtCommon.util.validateSelectionGrid(exam.app.Grid.getId(), "Please select a set")){//check if user has selected an item in the grid
 			Question.app.setForm();
 			
 			var sm = exam.app.Grid.getSelectionModel();
 			var id = sm.getSelected().data.id;
			//console.log(sm);
 		  	var _window;

 		    _window = new Ext.Window({
 		        title: 'New Question',
 		        width: 510,
 		        height: Question.app._wheight,
 		        layout: 'fit',
 		        plain:true,
 		        modal: true,
 		        bodyStyle:'padding:5px;',
 		        buttonAlign:'center',
 		        items: Question.app.Form,
 		        buttons: [{
 		         	text: 'Save',
                    icon: '/images/icons/disk.png',  
                    cls:'x-btn-text-icon',
 	                handler: function () {
 			            if(ExtCommon.util.validateFormFields(Question.app.Form)){//check if all forms are filled up
 		                Question.app.Form.getForm().submit({
 		                	params: {id: id},
 			                success: function(f,action){
                 		    	Ext.MessageBox.alert('Status', action.result.data);
                  		    	 Ext.Msg.show({
  								     title: 'Status',
 								     msg: action.result.data,
  								     buttons: Ext.Msg.OK,
  								     icon: 'icon'
  								 });
 				                ExtCommon.util.refreshGrid(Question.app.Grid.getId());
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
 		  	}
 		},
		
		Edit: function(){
 			if(ExtCommon.util.validateSelectionGrid(Question.app.Grid.getId())){//check if user has selected an item in the grid
 			var sm = Question.app.Grid.getSelectionModel();
 			var id = sm.getSelected().data.id;

 			Question.app.setForm();
 		    _window = new Ext.Window({
 		        title: 'Update Question Details',
 		        width: 510,
 		        height:Question.app._wheight,
 		        layout: 'fit',
 		        plain:true,
 		        modal: true,
 		        bodyStyle:'padding:5px;',
 		        buttonAlign:'center',
 		        items: Question.app.Form,
 		        buttons: [{
 		         	text: 'Save',
                    icon: '/images/icons/disk.png',  
                    cls:'x-btn-text-icon',
 		            handler: function () {
 			            if(ExtCommon.util.validateFormFields(Question.app.Form)){//check if all forms are filled up
 		                Question.app.Form.getForm().submit({
 			                url: "<?php echo site_url('Question/updateQuestion') ?>",
 			                params: {id: id},
 			                method: 'POST',
 			                success: function(f,action){
                 		    	Ext.MessageBox.alert('Status', action.result.data);
 				                ExtCommon.util.refreshGrid(Question.app.Grid.getId());
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

 		  	Question.app.Form.getForm().load({
 				url: "<?php echo site_url('Question/loadQuestion') ?>",
 				method: 'POST',
 				params: {id: id},
 				timeout: 300000,
 				waitMsg:'Loading...',
 				success: function(form, action){
                                    _window.show();
                                    Ext.get("classification_id").dom.value = action.result.data.classification_id;
                                    Ext.get("category_id").dom.value = action.result.data.category_id;
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


			if(ExtCommon.util.validateSelectionGrid(Question.app.Grid.getId())){//check if user has selected an item in the grid
			var sm = Question.app.Grid.getSelectionModel();
			var id = sm.getSelected().data.id;
			Ext.Msg.show({
   			title:'Delete Selected',
  			msg: 'Are you sure you want to delete this record?',
   			buttons: Ext.Msg.OKCANCEL,
   			fn: function(btn, text){
   			if (btn == 'ok'){
   			Ext.Ajax.request({
                            url: "<?php echo site_url('Question/deleteQuestion') ?>",
							params:{ id: id},
							method: "POST",
							timeout:300000000,
			                success: function(responseObj){
                		    	var response = Ext.decode(responseObj.responseText);
						if(response.success == true)
						{
							Question.app.Grid.getStore().load({params:{start:0, limit: 25}});
							Tbl_question_choices.app.Grid.getStore().load({params:{start:0, limit: 25}});
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

	 Ext.onReady(Question.app.init, Question.app);
	
	</script>
		