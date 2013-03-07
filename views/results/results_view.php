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
	 							url: "<?php echo site_url('exam/getExam') ?>",
	 							method: "POST"
	 							}),
	 						reader: new Ext.data.JsonReader({
	 								root: "data",
	 								id: "id",
	 								totalProperty: "totalCount",
	 								fields: [
										{ name: 'id'},
										{ name: 'name'},
										{ name: 'description'},
										{ name: 'timePerQuestion'}
		]
 						}),
 						remoteSort: true,
 						baseParams: {start: 0, limit: 25}
 					});
		
		var colModel = new Ext.grid.ColumnModel([
			{header: "ID", width: 75, sortable: true, dataIndex: 'id'},
			{header: "Name", width: 150, sortable: true, dataIndex: 'name'},
			{header: "Description", width: 250, sortable: true, dataIndex: 'description'},
			{header: "Time Per Question", width: 100, sortable: true, dataIndex: 'timePerQuestion'}
		]);

 			var grid = new Ext.grid.GridPanel({
 				id: 'examgrid',
 				height: 490,
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
 	    			 ],
 	    			 listeners: {
 	    			 	rowclick: function(grid, r, e){
 	    			 		var record = grid.getStore().getAt(r);  

						    var data = record.get("id");
						   // console.log(data);
 	    			 		Question.app.Grid.getStore().setBaseParam("exam_id", data);
 	    			 		Question.app.Grid.getStore().load();
 	    			 		Tbl_question_choices.app.Grid.getStore().setBaseParam("question_id", '');
 	    			 		Tbl_question_choices.app.Grid.getStore().load();
 	    			 		
 	    			 	}
 	    			 }
 	    	});

 			exam.app.Grid = grid;
 			exam.app.Grid.getStore().load({params:{start: 0, limit: 25}});
		
 			var _window = new Ext.Panel({
 		        title: 'Question Set',
 		        width: 'auto',
 		        height: 520,
 		        renderTo: 'mainBody',
 		        draggable: false,
 		        layout: 'fit',
 		        items: [
 		        {
 		        	layout: 'column',
 		        	height: 'auto',
 		        	items: [
 		        	{
 		        		columnWidth: .55,
 		        		layout: 'form',
 		        		height: 'auto',
 		        		items: exam.app.Grid
 		        	},
 		        	{
 		        		columnWidth: .45,
 		        		layout: 'form',
 		        		height: 'auto',
 		        		items: [
 		        			exam.app.qGrid,
 		        			exam.app.cGrid
 		        			]
 		        		
 		        	}
 		        	]
 		        }],
 		        resizable: false
 	        });

 	        _window.render();


 		},
		
		setForm: function(){

 		    var form = new Ext.form.FormPanel({
 		        labelWidth: 150,
 		        url: "<?php echo site_url('exam/addExam') ?>",
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
 		            fieldLabel: 'Name*',
 		            name: 'name',
 		            allowBlank:false,
 		            anchor:'95%',  // anchor width by percentage
 		            id: 'name'
 		        },
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
 		            fieldLabel: 'Time Per Question*',
 		            name: 'timePerQuestion',
 		            allowBlank:true,
 		            value: 0,
 		            anchor:'95%',  // anchor width by percentage
 		            id: 'timePerQuestion'
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
 		        title: 'New Exam',
 		        width: 510,
 		        height: 210,
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
 		        title: 'Update Exam Details',
 		        width: 510,
 		        height: 210,
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
 			                url: "<?php echo site_url('exam/updateExam') ?>",
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
 				url: "<?php echo site_url('exam/loadExam') ?>",
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
                            url: "<?php echo site_url('exam/deleteExam') ?>",
							params:{ id: id},
							method: "POST",
							timeout:300000000,
			                success: function(responseObj){
                		    	var response = Ext.decode(responseObj.responseText);
						if(response.success == true)
						{
							exam.app.qGrid.getStore().load({params:{start:0, limit: 25}});
							exam.app.cGrid.getStore().load({params:{start:0, limit: 25}});
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


		}/*,
		
		setFormQ: function(){

 		    var form = new Ext.form.FormPanel({
 		        labelWidth: 150,
 		        //url: "<--?php echo site_url('exam/addquestion') ?>",
 		        method: 'POST',
 		        defaultType: 'textfield',
 		        frame: true,
 		        items: [ {
 					xtype:'fieldset',
 					title:'Fields w/ Asterisks are required.',
 					width:'auto',
 					height:'auto',
 					items:[
				ExtCommon.util.createCombo("classification", "classification_id", "95%", "<--?php echo site_url("filereference/getCombo/FILEQUCL/QUCLCODE/DESCRIPTION/DESCRIPTION")?>", "Question Type", false, false),
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

 		    exam.app.Form2 = form;
 	},
		
		qAdd: function(){
			if(ExtCommon.util.validateSelectionGrid(exam.app.Grid.getId())){//check if user has selected an item in the grid
 			var sm = exam.app.Grid.getSelectionModel();
 			var id = sm.getSelected().data.id;
			
			exam.app.setFormQ();

 		  	var _window;

 		    _window = new Ext.Window({
 		        title: 'New Question',
 		        width: 510,
 		        height: 210,
 		        layout: 'fit',
 		        plain:true,
 		        modal: true,
 		        bodyStyle:'padding:5px;',
 		        buttonAlign:'center',
 		        items: exam.app.Form2,
 		        buttons: [{
 		         	text: 'Save',
                    icon: '/images/icons/disk.png',  
                    cls:'x-btn-text-icon',
 	                handler: function () {
 			            if(ExtCommon.util.validateFormFields(exam.app.Form2)){//check if all forms are filled up
 		                exam.app.Form2.getForm().submit({
 		                	params: {id: id},
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
			
		}
		}*/
		
		}
		}();

	 Ext.onReady(exam.app.init, exam.app);
	
	</script>
		