<style type="text/css">
.selected{
   background-color: blue !important;
   color: white !important;
}
</style>
		<div id="mainBody"></div>
		<script type="text/javascript">
		 Ext.namespace("results");
		 results.app = function()
		 {
		 	return{
	 		init: function()
	 		{
	 			ExtCommon.util.init();
	 			ExtCommon.util.quickTips();
	 			this.getGrid();
	 		},
	 		getGrid: function(){	
	 			ExtCommon.util.renderSearchField('searchby');
	
	 			var Objstore = new Ext.data.Store({
	 						proxy: new Ext.data.HttpProxy({
	 							url: "<?php echo site_url('FacultyEvaluation/getFacultyEvaluation') ?>",
	 							method: "POST"
	 							}),
	 						reader: new Ext.data.JsonReader({
	 								root: "data",
	 								id: "id",
	 								totalProperty: "totalCount",
	 								fields: [
	 									{name: "id"},
 										{ name: "title"},
                                        { name: "description"},
                                        { name: "start_date"},
                                        { name: "end_date"},
                                        { name: "faculty_id"},
                                        { name: "faculty"},
                                        { name: "subject"},
                                        { name: "schedule"}
                                        
		]
 						}),
 						remoteSort: true,
 						baseParams: {start: 0, limit: 25}
 					});
		
		var colModel = new Ext.grid.ColumnModel([
			{ header: "Title", width: 170, sortable: true, dataIndex: "title" },
			{ header: "Description", width: 300, sortable: true, dataIndex: "description" },
			{ header: "Start Date", width: 125, sortable: true, dataIndex: "start_date" },
			{ header: "End Date", width: 125, sortable: true, dataIndex: "end_date" },
			{ header: "Faculty", width: 200, sortable: true, dataIndex: "faculty" },
			{ header: "Subject", width: 300, sortable: true, dataIndex: "subject" },
			{ header: "Schedule", width: 300, sortable: true, dataIndex: "schedule" }
		]);

 			var grid = new Ext.grid.GridPanel({
 				id: 'resultsgrid',
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
 					     	text: 'VIEW PER STUDENT',
							icon: '/images/icons/application_view_columns.png',
 							cls:'x-btn-text-icon',

 					     	handler: results.app.ViewPerStudent

 					 	}
 	    			 ]
 	    	});

 			results.app.Grid = grid;
 			results.app.Grid.getStore().load({params:{start: 0, limit: 25}});

 			var _window = new Ext.Panel({
 		        title: 'Faculty Evaluation Result View',
 		        width: '100%',
 		        height:'auto',
 		        renderTo: 'mainBody',
 		        draggable: false,
 		        layout: 'fit',
 		        items: [results.app.Grid],
 		        resizable: false
 	        });
 	        _window.render();
 		},
		
 		ViewPerStudent: function(){
			
			if(ExtCommon.util.validateSelectionGrid(results.app.Grid.getId())){//check if user has selected an item in the grid
			
			var _window;
			sm = results.app.Grid.getSelectionModel();
			id = sm.getSelected().data.id;
 			results.app.studentGrid();
			results.app.employeeGrid();
 		  	
 		    _window = new Ext.Window({
 		        title: 'View Result Per Student',
 		        width: 1000,
 		        height: 500,
 		        layout: 'form',
 		        plain:true,
 		        modal: true,
 		        bodyStyle:'padding:5px;',
 		        buttonAlign:'center',
 		        items: [results.app.sGrid, results.app.eGrid],
 		        buttons: [{
 		            text: 'Close',
                    icon: '/images/icons/cancel.png', 
                    cls:'x-btn-text-icon',
 		            handler: function(){
 			            _window.destroy();
 		            }
 		        }]
 		    });
 		  	_window.show();
 		  	
 		  	results.app.sGrid.getStore().setBaseParam("evaluation_id", id);
 		  	results.app.sGrid.getStore().load();
 		}
 		},
		
		
		studentGrid: function(){
			function isSet(me)
	 	    {
	 	      if (me == null || me == '')
	 	       return 0;
	 	      else
	 	       return 1;
	 	    }
	 	    
 			ExtCommon.util.renderSearchField('searchby');
 			
 			results.app.selectedStudents = {data: new Array()};

 			var Objstore = new Ext.data.Store({
 						proxy: new Ext.data.HttpProxy({
 							url: "<?php echo site_url("results/getStudents"); ?>",
 							method: "POST"
 						}),
 						reader: new Ext.data.JsonReader({
 								root: "data",
 								id: "id",
 								totalProperty: "totalCount",
 								fields: [
 							{ name: "IDNO"},
 							{ name: "STUDCODE"},
							{ name: "NAME"}
 										]
 						}),
 						remoteSort: true,
 						baseParams: {start: 0, limit: 25}
 					});
 					
 			var gridView = new Ext.grid.GridView({ 
                getRowClass : function (row, index) { 
                    var cls = '',
                    data = row.data,
                    student = results.app.selectedStudents.data.indexOf(data.STUDCODE);
                    
                    if(student != -1){
                    	cls = 'selected';
                    }
                    return cls; 
                } 
        });		
			
			var colModel = new Ext.grid.ColumnModel([
				{ header: "ID No", width: 100, sortable: true, dataIndex: "IDNO" },
 				{ header: "Name", width: 300, sortable: true, dataIndex: "NAME"},
 				{
                	xtype: 'actioncolumn',
                	width: 50,
                	items: [{
                    	icon   : '/images/icons/delete.png',  // Use a URL in the icon config
                    	tooltip: 'Remove Filter',
                    	handler: function(grid, rowIndex, colIndex) {
                        	var rec = Objstore.getAt(rowIndex);
                        	var row = results.app.selectedStudents.data.indexOf(rec.get('STUDCODE'));
                        
                        	if(row != - 1){
                        		results.app.selectedStudents.data.splice(row, 1);
                        		results.app.sGrid.getStore().load({params:{start: 0, limit: 25}});
                        		results.app.eGrid.getStore().setBaseParam("selectedStudents", results.app.selectedStudents.data.toString());
                         		results.app.eGrid.getStore().load({params:{start: 0, limit: 25}});
                        	}
                    	}	
                	}, {
                    	icon   : '/images/icons/add.png',  // Use a URL in the icon config
                    	tooltip: 'Add Filter',
                    	handler: function(grid, rowIndex, colIndex) {
                        	var rec = Objstore.getAt(rowIndex);
                        	var student = results.app.selectedStudents.data.indexOf(rec.get('STUDCODE'));
                        
                        	if(student == -1){
                         		results.app.selectedStudents.data.push(rec.get('STUDCODE'));
                         		results.app.sGrid.getStore().load({params:{start: 0, limit: 25}});
                         		results.app.eGrid.getStore().setBaseParam("selectedStudents", results.app.selectedStudents.data.toString());
                         		results.app.eGrid.getStore().load({params:{start: 0, limit: 25}});
                        	}
                    }
                }]
            }
			])

 			var sgrid = new Ext.grid.GridPanel({
 				id: 's_grid',
 				height: 205,
 				width: 600,
 				border: true,
 				view: gridView,
 				ds: Objstore,
 				cm: colModel,
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
					//store: Objstore,
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
 					 	}, {
 					     	xtype: 'tbbutton',
 					     	text: 'SELECT ALL',
							icon: '/images/icons/application_add.png',
 							cls:'x-btn-text-icon',
 							handler: function(){
 								if(results.app.sGrid.getStore().getTotalCount()){
 									results.app.sGrid.getStore().each(
 										function(f){
 											var st = results.app.selectedStudents.data.indexOf(f.data.STUDCODE);
					                        if(st == -1){
					                         results.app.selectedStudents.data.push(f.data.STUDCODE);
					                        }
 										}, this
 									);
 									results.app.sGrid.getStore().load({params:{start: 0, limit: 25}});
 									console.log(results.app.selectedStudents.data);
 									results.app.eGrid.getStore().setBaseParam("selectedStudents", results.app.selectedStudents.data.toString());
                         			results.app.eGrid.getStore().load({params:{start: 0, limit: 25}});
 								}else{
 									Ext.Msg.show({
  								     title: 'Status',
 								     msg: "No records in the grid",
  								     buttons: Ext.Msg.OK,
  								     icon: Ext.Msg.WARNING
  								 });
 								}
 								//
 							}

 					 	},'-',{
 					     	xtype: 'tbbutton',
 					     	text: 'CLEAR SELECTION',
							icon: '/images/icons2/delete.png',
 							cls:'x-btn-text-icon',
 							handler: function(){
 								results.app.selectedStudents = {data: new Array()};
 								results.app.sGrid.getStore().load({params:{start: 0, limit: 25}});
 								results.app.eGrid.getStore().setBaseParam("selectedStudents", results.app.selectedStudents.data.toString());
                         		results.app.eGrid.getStore().load({params:{start: 0, limit: 25}});
 							}

 					 	}
 	    			 ]/*, listeners: {
 	    			 	rowclick: function(grid, r, e){
 	    			 		var record = grid.getStore().getAt(r);
						    var data = record.get("STUDCODE");
 	    			 		results.app.eGrid.getStore().load();
 	    			 	}rid.getStore().setBaseParam("STUDCODE", data);
 	    			 		results.app.eG
 	    			 }*/
 	    	});

 			results.app.sGrid = sgrid;
		},
		
		
		employeeGrid: function(){
			
 			ExtCommon.util.renderSearchField('searchby');

 			var Objstore = new Ext.data.Store({
 						proxy: new Ext.data.HttpProxy({
 							url: "<?php echo site_url("results/getQuestion"); ?>",
 							method: "POST"
 							}),
 						reader: new Ext.data.JsonReader({
 								root: "data",
 								id: "id",
 								totalProperty: "totalCount",
 								fields: [
 							{ name: "category"},
							{ name: "description"},
							{ name: "classification"},
							{ name: "answer"},
							{ name: "answer_text"},
							{ name: "correct_flag"},
							{ name: "date_answered"}
 										]
 						}),
 						remoteSort: true,
 						baseParams: {start: 0, limit: 25}
 					});


 			var egrid = new Ext.grid.GridPanel({
 				id: 'employee_grid',
 				height: 205,
 				width: '100%',
 				border: true,
 				ds: Objstore,
 				cm:  new Ext.grid.ColumnModel(
 						[
                          { header: "Category", width: 150, sortable: true, dataIndex: "category" },
 						  { header: "Question", width: 200, sortable: true, dataIndex: "description"},
 						  { header: "Classification", width: 150, sortable: true, dataIndex: "classification"},
 						  { header: "Answer", width: 100, sortable: true, dataIndex: "answer"},
 						  { header: "Answer Text", width: 100, sortable: true, dataIndex: "answer_text"},
 						  { header: "Is Correct", width: 100, sortable: true, dataIndex: "correct_flag"},
 						  { header: "Date Answered", width: 100, sortable: true, dataIndex: "date_answered"}
 						]
 				),
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
					//store: Objstore,
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
 					 	},
 					 	 {
                                                }
 	    			 ]
 	    	});
 			results.app.eGrid = egrid;
		}
	
		 //end of functions
	
		
		}
		}();

	 Ext.onReady(results.app.init, results.app);
	
	</script>
		