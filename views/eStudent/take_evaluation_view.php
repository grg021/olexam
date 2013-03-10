<div id="mainBody"></div>
		<script type="text/javascript">
		 Ext.namespace("StudentEvaluation");
		 StudentEvaluation.app = function()
		 {
		 	return{
	 		init: function()
	 		{
	 			ExtCommon.util.init();
	 			ExtCommon.util.quickTips();
	 			ExtCommon.util.validations();
	 			this.getGrid();
	 		},
	 		getGrid: function()
	 		{
	 			ExtCommon.util.renderSearchField('searchby');
	
	 			var Objstore = new Ext.data.Store({
	 						proxy: new Ext.data.HttpProxy({
	 							url: "<?php echo site_url('eStudent/getFacultyEvaluation') ?>",
	 							method: "POST"
	 							}),
	 						reader: new Ext.data.JsonReader({
	 								root: "data",
	 								id: "id",
	 								totalProperty: "totalCount",
	 								fields: [
	 									{ name: "id"},
	 									{ name: "question_set_id"},
 										{ name: "title"},
                                        { name: "description"},
                                        { name: "start_date"},
                                        { name: "end_date"},
                                        { name: "faculty_id"},
                                        { name: "faculty"},
                                        { name: "status"}
                                        
		]
 						}),
 						remoteSort: true,
 						baseParams: {start: 0, limit: 25}
 					});
		
		var colModel = new Ext.grid.ColumnModel([
			{ header: "Title", width: 170, sortable: true, dataIndex: "title" },
			{ header: "Description", width: 300, sortable: true, dataIndex: "description" },
			{ header: "Start Date", width: 150, sortable: true, dataIndex: "start_date" },
			{ header: "End Date", width: 150, sortable: true, dataIndex: "end_date" },
			{ header: "Faculty", width: 200, sortable: true, dataIndex: "faculty" },
			{ header: "Status", width: 100, sortable: true, dataIndex: "status" }
		]);

 			var grid = new Ext.grid.GridPanel({
 				id: 'StudentEvaluationgrid',
 				height: 500,
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
 					     	text: 'TAKE EVALUATION',
							icon: '/images/icons/pencil.png',
 							cls:'x-btn-text-icon',

 					     	handler: StudentEvaluation.app.TakeEvaluation

 					 	}
 	    			 ]
 	    	});

 			StudentEvaluation.app.Grid = grid;
 			StudentEvaluation.app.Grid.getStore().load();

 			var _window = new Ext.Panel({
 		        title: 'Faculty Evaluation',
 		        width: '100%',
 		        height:'auto',
 		        renderTo: 'mainBody',
 		        draggable: false,
 		        layout: 'fit',
 		        items: [StudentEvaluation.app.Grid],
 		        resizable: false
 	        });

 	        _window.render();


 		},
 		
		setForm: function(){
		

 		},
 		TakeEvaluation: function(){
 			if(ExtCommon.util.validateSelectionGrid(StudentEvaluation.app.Grid.getId())){//check if user has selected an item in the grid
 			var sm = StudentEvaluation.app.Grid.getSelectionModel(),
 			id = sm.getSelected().data.id,
 			question_set_id = sm.getSelected().data.question_set_id;
 				window.location= "<?php echo site_url("eStudent/evaluation"); ?>/"+question_set_id+"/"+id;
 			}
 		},
 		TakeEvaluation2: function(){
 			if(ExtCommon.util.validateSelectionGrid(StudentEvaluation.app.Grid.getId())){//check if user has selected an item in the grid
 			var sm = StudentEvaluation.app.Grid.getSelectionModel(),
 			id = sm.getSelected().data.id,
 			question_set_id = sm.getSelected().data.question_set_id;
 			
 			var form = new Ext.form.FormPanel({
 		        url: "<?php echo site_url('eStudent/saveEvaluation') ?>",
 		        method: 'POST',
 		        defaultType: 'textfield',
 		        frame: true,
 		        items: []
 		    });
 		    
 		    

 			
 		    _window = new Ext.Window({
 		        title: 'Take Evaluation',
 		        width: 800,
 		        height:600,
 		        layout: 'fit',
 		        plain:true,
 		        modal: true,
 		        bodyStyle:'padding:5px;',
 		        buttonAlign:'center',
 		        items: [form],
 		        buttons: [{
 		         	text: 'Save',
                    icon: '/images/icons/disk.png',  
                    cls:'x-btn-text-icon',
 		            handler: function () {
 			            if(ExtCommon.util.validateFormFields(FacultyEvaluation.app.Form)){//check if all forms are filled up
 		                FacultyEvaluation.app.Form.getForm().submit({
 			                url: "<?php echo site_url('FacultyEvaluation/updateFacultyEvaluation') ?>",
 			                params: {id: id},
 			                method: 'POST',
 			                success: function(f,action){
                 		    	Ext.MessageBox.alert('Status', action.result.data);
 				                ExtCommon.util.refreshGrid(FacultyEvaluation.app.Grid.getId());
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
 		    
 		    form.getForm().load({
 				url: "<?php echo site_url('eStudent/loadQuestions') ?>",
 				method: 'POST',
 				params: {question_set_id: question_set_id},
 				timeout: 300000,
 				waitMsg:'Loading...',
 				success: function(form, action){
                	
 				},
 				failure: function(form, action) {
         			
     			}
 			});
 			_window.show();

 		  	
 			}else return;
 		}//end of functions
 		
 		
		}
		}();

	 Ext.onReady(StudentEvaluation.app.init, StudentEvaluation.app);
	
	</script>
 		