<style type="text/css">
.selected{
   background-color: blue !important;
   color: white !important;
}
</style>
		<div id="mainBody"></div>
		<script type="text/javascript">
		 Ext.namespace("FacultyEvaluation");
		 FacultyEvaluation.app = function()
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
	 							url: "<?php echo site_url('FacultyEvaluation/getFacultyEvaluation') ?>",
	 							method: "POST"
	 							}),
	 						reader: new Ext.data.JsonReader({
	 								root: "data",
	 								id: "id",
	 								totalProperty: "totalCount",
	 								fields: [
	 									{ name: "id"},
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
 				id: 'FacultyEvaluationgrid',
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
 					     	text: 'ADD',
							icon: '/images/icons/application_add.png',
 							cls:'x-btn-text-icon',

 					     	handler: FacultyEvaluation.app.Add

 					 	},'-',{
 					     	xtype: 'tbbutton',
 					     	text: 'EDIT',
							icon: '/images/icons/application_edit.png',
 							cls:'x-btn-text-icon',

 					     	handler: FacultyEvaluation.app.Edit

 					 	}
 	    			 ]
 	    	});

 			FacultyEvaluation.app.Grid = grid;
 			FacultyEvaluation.app.Grid.getStore().load({params:{start: 0, limit: 25}});
 			
 			
 			var filter_form = new Ext.form.FormPanel({
 				labelWidth: 80,
 		        url:"",
 		        method: 'POST',
 		        defaultType: 'textfield',
 		        frame: true,
				// height: 100,
                id: 'teacherForm',
                // autoScroll: true,
                // width: 900,
 		        items: [{
 		        	xtype:'fieldset',
 					width:'auto',
 					height:'auto',
 					items: []    	
 		        }],
 		        buttons: [{
 		         	text: 'Refresh List',
                    icon: '/images/icons/arrow_rotate_clockwise.png',
 	                handler: function(){
                    	//if(ExtCommon.util.validateFormFields(filter_form)){//check if all forms are filled up
                        	FacultyEvaluation.app.Grid.getStore().load();
						//}else return;
					}
 	            }]
 			});
 			
 			FacultyEvaluation.app.filter_form = filter_form;

 			var _window = new Ext.Panel({
 		        title: 'Faculty Evaluation Schedule',
 		        width: '100%',
 		        height:'auto',
 		        renderTo: 'mainBody',
 		        draggable: false,
 		        layout: 'fit',
 		        items: [FacultyEvaluation.app.Grid],
 		        resizable: false
 	        });

 	        _window.render();


 		},
		
		setForm: function(){
			FacultyEvaluation.app.studentGrid();
			
 		    var form = new Ext.form.FormPanel({
 		        url: "<?php echo site_url('FacultyEvaluation/addFacultyEvaluation') ?>",
 		        method: 'POST',
 		        defaultType: 'textfield',
 		        frame: true,
 		        items: [ {
 					xtype:'fieldset',
 					//title:'Fields w/ Asterisks are required.',
 					width:'auto',
 					height:'auto',
 					items:[
 					{
 						layout: 'column',
 						width: 'auto',
 						items: [
 							{
 								columnWidth: .5,
 								layout: 'form',
 								items: [
 								FacultyEvaluation.app.questionSetCombo(),
 								{
 									xtype: 'textarea',
 									id: 'qs_description',
 									name: 'qs_description',
 									anchor: '95%',
 									fieldLabel: 'Description',
 									readOnly: true
 								}
 								]
 							},
 							{
 								columnWidth: .5,
 								layout: 'form',
 								items: [
 								{
 									xtype: "button",
 									text: "View Questions",
 									handler: function(){
 										
 									}
 								}
 								]
 							}
 						]
 					}
 		        		]
 					},
 					{
 					xtype:'fieldset',
 					width:'auto',
 					height:'auto',
 					labelWidth: 75,
 					items:[
 					{
 						layout: 'column',
 						width: 'auto',
 						items: [
 							{
 								columnWidth: .5,
 								layout: 'form',
 								items: [
 									
 										ExtCommon.util.createCombo("faculty_set", "faculty_id", "95%", "<?php echo site_url("FacultyEvaluation/getFacultyCombo");?>", "Faculty*", false, false)
 					
 								]
 							}
 						]
 					},{
 						layout: 'column',
 						width: 'auto',
 						items: [
 							{
			            		columnWidth: .5,
	 	 			        	layout: 'form',
	 	 			        	items: [
	 	 			        		FacultyEvaluation.app.subjectCombo()
	 	 			        	]
			            	},{
			            		columnWidth: .5,
	 	 			        	layout: 'form',
	 	 			        	items: [
	 	 			        		FacultyEvaluation.app.scheduleCombo()
	 	 			        	]
			            	}
 						]
 					},
 					{
 						layout: 'column',
 						width: 'auto',
 						items: [
 							{
 								columnWidth: .30,
 								layout: 'form',
 								defaults: {
	 	 			        	 msgTarget: 'qtip'
	 	 			        	},
 								items: [
 								{
	 								xtype: 'datefield',
			 	 			        fieldLabel: 'Start Date*',
			 	 			        name: 'start_date',
			 	 			        id: 'start_date',
			 	 			        allowBlank: false,
			 	 			        format: 'Y-m-d',
			 	 			        anchor: '100%',
                                    vtype: 'daterange',
                                    endDateField: 'end_date'
								}
 								]
 							},
 							{
 								columnWidth: .20,
 								layout: 'form',
 								labelWidth: 1,
 								defaults: {
	 	 			        	 msgTarget: 'qtip'
	 	 			        	},
 								items: [
 								{
                                   xtype: 'timefield',
                                   name: 'start_time',
                                   id: 'start_time',
                                   allowBlank: false,
                                   minValue: '00:00:00',
                                   maxValue: '23:00:00',
                                   increment: 5,
                                   format: 'H:i:s',
                                   anchor: '87.8%',
                                   vtype: 'timerange',
                                   endTimeField: 'end_time'
                                }
 								]
 							},
 							{
 								columnWidth: .30,
 								layout: 'form',
 								defaults: {
	 	 			        	 msgTarget: 'qtip'
	 	 			        	},
 								items: [
 								{
	 								xtype: 'datefield',
			 	 			        fieldLabel: 'End Date*',
			 	 			        name: 'end_date',
			 	 			        id: 'end_date',
			 	 			        allowBlank: false,
			 	 			        format: 'Y-m-d',
			 	 			        anchor: '100%',
			 	 			        msgTarget: 'qtip',
                                   vtype: 'daterange',
                                   startDateField: 'start_date'
								}
 								]
 							},
 							{
 								columnWidth: .20,
 								layout: 'form',
 								labelWidth: 1,
 								defaults: {
	 	 			        	 msgTarget: 'qtip'
	 	 			        	},
 								items: [
 								{
                                   xtype: 'timefield',
                                   name: 'end_time',
                                   id: 'end_time',
                                   allowBlank: false,
                                   minValue: '00:00:00',
                                   maxValue: '23:00:00',
                                   increment: 5,
                                   format: 'H:i:s',
                                   anchor: '87.8%',
                                   msgTarget: 'qtip',
                                   vtype: 'timerange',
                                   startTimeField: 'start_time'
                                }
 								]
 							}
 							
 						]
 					}
 		        		]
 					},
 					/*{
 					xtype:'fieldset',
 					width:'auto',
 					height:'auto',
 					labelWidth: 75,
 					items:[
 						{
 						layout:'column',
			            width: 'auto',
			            items: [{
			            	columnWidth:.33,
	 	 			        layout: 'form',
	 	 			        defaults: {
	 	 			        	 msgTarget: 'qtip'
	 	 			        },
	 	 			        items: [
	 	 			        	FacultyEvaluation.app.yearCombo()
	 	 			        	
	 	 			        ]
			            },{
		            		columnWidth:.33,
 	 			          	layout: 'form',
 	 			          	items: [
 	 			          		FacultyEvaluation.app.sectionCombo()
 	 			          		
                           	]
			            },{
			            	columnWidth:.33,
	 	 			        layout: 'form',
	 	 			        items: [
	 	 			        	ExtCommon.util.createCombo("gender", "gender_id", "95%", "<--?php echo site_url("FacultyEvaluation/getGenderCombo")?>", "Gender*", true, false)
	 	 			        ]
			            }]
 					}/*,
 					{
 						layout:'column',
			            width: 'auto',
			            items: [{
			            	columnWidth:.33,
	 	 			        layout: 'form',
	 	 			        defaults: {
	 	 			        	 msgTarget: 'qtip'
	 	 			        },
	 	 			        items: [
	 	 			        	FacultyEvaluation.app.subjectCombo()
	 	 			        	
	 	 			        ]
			            },{
		            		columnWidth:.66,
 	 			          	layout: 'form',
 	 			          	items: [
 	 			          		{
 	 			          			xtype: 'textfield',
 	 			          			id: 's_description',
 	 			          			name: 's_description',
 	 			          			fieldLabel: 'Description',
 	 			          			anchor: '97.5%',
 	 			          			readOnly: true
 	 			          		}
 	 			          		
                           	]
			            }]
 					}
 					
 					]
 					
 					},*/
 					FacultyEvaluation.app.sGrid
 					]
 		    });

 		    FacultyEvaluation.app.Form = form;
 		},
		
 		Add: function(){

 			FacultyEvaluation.app.setForm();
 			

 		  	var _window;

 		    _window = new Ext.Window({
 		        title: 'Schedule New Faculty Evaluation',
 		        width: 800,
 		        height: 600,
 		        layout: 'fit',
 		        plain:true,
 		        modal: true,
 		        bodyStyle:'padding:5px;',
 		        buttonAlign:'center',
 		        items: FacultyEvaluation.app.Form,
 		        buttons: [{
 		         	text: 'Save',
                    icon: '/images/icons/disk.png',  
                    cls:'x-btn-text-icon',
 	                handler: function () {
 			            if(ExtCommon.util.validateFormFields(FacultyEvaluation.app.Form)){//check if all forms are filled up
 			            	/*
 			            	if(FacultyEvaluation.app.sGrid.getStore().getTotalCount()){
 									FacultyEvaluation.app.sGrid.getStore().each(
 										function(f){
 											var st = FacultyEvaluation.app.selectedStudents.data.indexOf(f.data.STUDCODE);
					                        if(st == -1){
					                         FacultyEvaluation.app.selectedStudents.data.push(f.data.STUDCODE);
					                        }
					                        
 										}, this
 									);
 									FacultyEvaluation.app.sGrid.getStore().load();
 									console.log(FacultyEvaluation.app.selectedStudents.data);
 								}else{
 									Ext.Msg.show({
  								     title: 'Status',
 								     msg: "No records in the grid",
  								     buttons: Ext.Msg.OK,
  								     icon: Ext.Msg.WARNING
  								 });
 								}
 			            	*/
 			            	
 		                FacultyEvaluation.app.Form.getForm().submit({
 		                	params: {students: Ext.util.JSON.encode(FacultyEvaluation.app.selectedStudents)},
 			                success: function(f,action){
                 		    	Ext.MessageBox.alert('Status', action.result.data);
                  		    	 Ext.Msg.show({
  								     title: 'Status',
 								     msg: action.result.data,
  								     buttons: Ext.Msg.OK,
  								     icon: 'icon'
  								 });
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
 			if(ExtCommon.util.validateSelectionGrid(FacultyEvaluation.app.Grid.getId())){//check if user has selected an item in the grid
 			var sm = FacultyEvaluation.app.Grid.getSelectionModel();
 			var id = sm.getSelected().data.id;

 			FacultyEvaluation.app.setForm();
 		    _window = new Ext.Window({
 		        title: 'Update Faculty Evaluation Schedule',
 		        width: 510,
 		        height:190,
 		        layout: 'fit',
 		        plain:true,
 		        modal: true,
 		        bodyStyle:'padding:5px;',
 		        buttonAlign:'center',
 		        items: FacultyEvaluation.app.Form,
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

 		  	FacultyEvaluation.app.Form.getForm().load({
 				url: "<?php echo site_url('FacultyEvaluation/loadFacultyEvaluation') ?>",
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


			if(ExtCommon.util.validateSelectionGrid(FacultyEvaluation.app.Grid.getId())){//check if user has selected an item in the grid
			var sm = FacultyEvaluation.app.Grid.getSelectionModel();
			var id = sm.getSelected().data.id;
			Ext.Msg.show({
   			title:'Delete Selected',
  			msg: 'Are you sure you want to delete this record?',
   			buttons: Ext.Msg.OKCANCEL,
   			fn: function(btn, text){
   			if (btn == 'ok'){
   			Ext.Ajax.request({
                            url: "<?php echo site_url('FacultyEvaluation/deleteFacultyEvaluation') ?>",
							params:{ id: id},
							method: "POST",
							timeout:300000000,
			                success: function(responseObj){
                		    	var response = Ext.decode(responseObj.responseText);
						if(response.success == true)
						{
							FacultyEvaluation.app.Grid.getStore().load({params:{start:0, limit: 25}});
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
		
		sectionCombo: function(){

		return {
			xtype:'combo',
			id:'SECTION',
			hiddenName: 'SECTIDNO',
            hiddenId: 'SECTIDNO',
			name: 'SECTION',
			valueField: 'id',
			displayField: 'name',
			 msgTarget: 'qtip',
			//width: 100,
			anchor: '95%',
			triggerAction: 'all',
			minChars: 2,
			forceSelection: true,
			enableKeyEvents: true,
			pageSize: 10,
			resizable: true,
			readOnly: false,
			minListWidth: 300,
			allowBlank: false,
			store: new Ext.data.JsonStore({
			id: 'idsocombo',
			root: 'data',
			totalProperty: 'totalCount',
			fields:[{name: 'id'}, {name: 'name'}],
			url: "<?php echo site_url("FacultyEvaluation/getSectionCombo"); ?>",
			baseParams: {start: 0, limit: 10}

			}),
			listeners: {
				beforequery: function(qe){
									if (Ext.get("yearlevel_id").dom.value == "")
											return false;
									
								    this.store.baseParams = {YEAR: Ext.getCmp("yearlevel").getRawValue()};
								    
									//Ext.get("SUBJIDNO").dom.value  = '';
                                  //  Ext.getCmp("subject").setRawValue("");
                                    
                                    delete qe.combo.lastQuery;
				},
			select: function (combo, record, index){
			this.setRawValue(record.get('name'));
			Ext.get(this.hiddenName).dom.value  = record.get('id');
			FacultyEvaluation.app.sGrid.getStore().load();
			
			},
			blur: function(){
			var val = this.getRawValue();
			this.setRawValue.defer(1, this, [val]);
			this.validate();
			},
			render: function() {
			this.el.set({qtip: 'Type at least ' + this.minChars + ' characters to search for a section'});
			},
			keypress: {buffer: 100, fn: function() {
			Ext.get(this.hiddenName).dom.value  = '';
			if(!this.getRawValue()){
			this.doQuery('', true);
		}
			}}
			},
			fieldLabel: 'Section*'

			}
	},
	questionSetCombo: function(){

		return {
			xtype:'combo',
			id:'question_set',
			hiddenName: 'question_set_id',
            hiddenId: 'question_set_id',
			name: 'question_set',
			valueField: 'id',
			displayField: 'name',
			anchor: '95%',
			triggerAction: 'all',
			minChars: 2,
			forceSelection: true,
			enableKeyEvents: true,
			pageSize: 10,
			 msgTarget: 'qtip',
			resizable: true,
			readOnly: false,
			minListWidth: 300,
			allowBlank: false,
			store: new Ext.data.JsonStore({
			id: 'idsocombo',
			root: 'data',
			totalProperty: 'totalCount',
			fields:[{name: 'id'}, {name: 'name'}, {name: 'description'}],
			url: "<?php echo site_url("FacultyEvaluation/getQuestionSetCombo"); ?>",
			baseParams: {start: 0, limit: 10}
			}),
			listeners: {
            beforequery: function(qe)
			{
			delete qe.combo.lastQuery;
			},
			select: function (combo, record, index){
			this.setRawValue(record.get('name'));
			Ext.get(this.hiddenName).dom.value  = record.get('id');
			Ext.getCmp("qs_description").setValue(record.get("description"));
			},
			blur: function(){
			var val = this.getRawValue();
			this.setRawValue.defer(1, this, [val]);
			this.validate();
			},
			render: function() {
			this.el.set({qtip: 'Type at least ' + this.minChars + ' characters to search for a question set'});

			},
			keypress: {buffer: 100, fn: function() {
			Ext.get(this.hiddenName).dom.value  = '';
			if(!this.getRawValue()){
			this.doQuery('', true);
			}
			}}
			},
			fieldLabel: 'Question Set*'

			}
	},
	subjectCombo: function(){

		return {
			xtype:'combo',
			id:'subject',
			hiddenName: 'SUBJIDNO',
            hiddenId: 'SUBJIDNO',
			name: 'subject',
			valueField: 'id',
			displayField: 'name',
			//width: 100,
			anchor: '95%',
			 msgTarget: 'qtip',
			triggerAction: 'all',
			minChars: 2,
			forceSelection: true,
			enableKeyEvents: true,
			pageSize: 10,
			resizable: true,
			readOnly: false,
			minListWidth: 300,
			allowBlank: true,
			store: new Ext.data.JsonStore({
			id: 'idsocombo',
			root: 'data',
			totalProperty: 'totalCount',
			fields:[{name: 'id'}, {name: 'name'}, {name: 'description'}],
			url: "<?php echo site_url("FacultyEvaluation/getSubjectCombo"); ?>",
			baseParams: {start: 0, limit: 10}

			}),
			listeners: {
                        beforequery: function(qe)
					{
						if (Ext.get("faculty_id").dom.value == "")
							return false;
					delete qe.combo.lastQuery;
				    this.store.baseParams = {faculty_id: Ext.get("faculty_id").dom.value};
					},

			select: function (combo, record, index){
			this.setRawValue(record.get('name'));
			Ext.get(this.hiddenName).dom.value  = record.get('id');
                        //ogs_grade_entry.app.Grid.getStore().setBaseParam("SCHEIDNO", record.get('id'));


			},
			blur: function(){
			var val = this.getRawValue();
			this.setRawValue.defer(1, this, [val]);
			this.validate();
			},
			render: function() {
			this.el.set({qtip: 'Type at least ' + this.minChars + ' characters to search for a subject'});

			},
			keypress: {buffer: 100, fn: function() {
			Ext.get(this.hiddenName).dom.value  = '';
			if(!this.getRawValue()){
			this.doQuery('', true);
			}
			}}
			},
			fieldLabel: 'Subject*'

			}
	},
	scheduleCombo: function(){

		return {
			xtype:'combo',
			id:'schedule',
			hiddenName: 'SCHEIDNO',
            hiddenId: 'SCHEIDNO',
			name: 'schedule',
			valueField: 'SCHEIDNO',
			displayField: 'DAYS',
			//width: 100,
			anchor: '95%',
			 msgTarget: 'qtip',
			triggerAction: 'all',
			minChars: 2,
			forceSelection: true,
			enableKeyEvents: true,
			pageSize: 10,
			resizable: true,
			readOnly: false,
			minListWidth: 300,
			allowBlank: true,
			store: new Ext.data.JsonStore({
			id: 'idsocombo',
			root: 'data',
			totalProperty: 'totalCount',
			fields:[{name: 'SCHEIDNO'}, {name: 'DAYSIDNO'}, {name: 'TIMEIDNO'}, {name: 'TIME'}, {name: 'DAYS'}],
			url: "<?php echo site_url("FacultyEvaluation/getScheduleCombo"); ?>",
			baseParams: {start: 0, limit: 10}

			}),
			listeners: {
                        beforequery: function(qe)
					{
						if (Ext.get("SUBJIDNO").dom.value == "")
							return false;
					delete qe.combo.lastQuery;
				    this.store.baseParams = {SUBJIDNO: Ext.get("SUBJIDNO").dom.value};

					},

			select: function (combo, record, index){
			this.setRawValue(record.get('DAYS'));
			Ext.get(this.hiddenName).dom.value = record.get('DAYSIDNO');
			Ext.get(this.hiddenName).dom.value = record.get('TIMEIDNO');
			Ext.get(this.hiddenName).dom.value = record.get('SCHEIDNO');
			FacultyEvaluation.app.sGrid.getStore().load();
                        //ogs_grade_entry.app.Grid.getStore().setBaseParam("SCHEIDNO", record.get('id'));


			},
			blur: function(){
			var val = this.getRawValue();
			this.setRawValue.defer(1, this, [val]);
			this.validate();
			},
			render: function() {
			this.el.set({qtip: 'Type at least ' + this.minChars + ' characters to search for a subject'});

			},
			keypress: {buffer: 100, fn: function() {
			Ext.get(this.hiddenName).dom.value  = '';
			if(!this.getRawValue()){
			this.doQuery('', true);
			}
			}}
			},
			fieldLabel: 'Schedule*'

			}
	},
	yearCombo: function(){

		return {
			xtype:'combo',
			id:'yearlevel',
			hiddenName: 'yearlevel_id',
            hiddenId: 'yearlevel_id',
			name: 'yearlevel',
			valueField: 'id',
			displayField: 'name',
			//width: 100,
			anchor: '95%',
			 msgTarget: 'qtip',
			triggerAction: 'all',
			minChars: 2,
			forceSelection: true,
			enableKeyEvents: true,
			pageSize: 10,
			resizable: true,
			readOnly: false,
			minListWidth: 300,
			allowBlank: true,
			store: new Ext.data.JsonStore({
			id: 'idsocombo',
			root: 'data',
			totalProperty: 'totalCount',
			fields:[{name: 'id'}, {name: 'name'}, {name: 'description'}, {name: 'UNITS_TTL'}, {name: 'ADVISER'}, {name: 'SECTION'}, {name: 'COURSE'}],
			url: "<?php echo site_url("FacultyEvaluation/getYearLevelCombo"); ?>",
			baseParams: {start: 0, limit: 10}

			}),
			listeners: {
                        beforequery: function(qe)
					{
					Ext.get("SECTIDNO").dom.value  = '';
                    Ext.getCmp("SECTION").setRawValue("");
					delete qe.combo.lastQuery;
				 
					},

			select: function (combo, record, index){
			this.setRawValue(record.get('name'));
			Ext.get(this.hiddenName).dom.value  = record.get('id');
                        //ogs_grade_entry.app.Grid.getStore().setBaseParam("SCHEIDNO", record.get('id'));


			},
			blur: function(){
			var val = this.getRawValue();
			this.setRawValue.defer(1, this, [val]);
			this.validate();
			},
			render: function() {
			this.el.set({qtip: 'Type at least ' + this.minChars + ' characters to search for a year'});

			},
			keypress: {buffer: 100, fn: function() {
			Ext.get(this.hiddenName).dom.value  = '';
			if(!this.getRawValue()){
			this.doQuery('', true);
			}
			}}
			},
			fieldLabel: 'Year*'

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
			
			FacultyEvaluation.app.selectedStudents = {data: new Array()};
	
	 		var Objstore = new Ext.data.Store({
	 						proxy: new Ext.data.HttpProxy({
	 							url: "<?php echo site_url('FacultyEvaluation/getStudents') ?>",
	 							method: "POST"
	 							}),
	 						reader: new Ext.data.JsonReader({
	 								root: "data",
	 								id: "id",
	 								totalProperty: "totalCount",
	 								fields: [
	 									{ name: "STUDCODE"},
                                        { name: "IDNO"},
                                        { name: "NAME"}
                                        
		]
 						}),
 						remoteSort: true,
 						baseParams: {start: 0, limit: 100},
 						listeners: {
 							beforeload: function(s){
 								if(isSet(Ext.get("SCHEIDNO").dom.value) && isSet(isSet(Ext.get("SUBJIDNO").dom.value))){
 									//s.setBaseParam("YEAR", Ext.getCmp("yearlevel").getRawValue());
 									//s.setBaseParam("SECTIDNO", Ext.get("SECTIDNO").dom.value);
 									s.setBaseParam("SCHEIDNO", Ext.get("SCHEIDNO").dom.value);
 									
 									//if(isSet(Ext.get("gender_id").dom.value) && isSet(Ext.getCmp("gender").getRawValue()))
 										//s.setBaseParam("GENDIDNO", Ext.get("gender_id").dom.value);
 									//else
 										//s.setBaseParam("GENDIDNO", "");
 									
 									//if(isSet(Ext.get("SUBJIDNO").dom.value) && isSet(Ext.getCmp("subject").getRawValue()))
 									//	s.setBaseParam("SUBJIDNO", Ext.get("SUBJIDNO").dom.value);
 									//else
 									//	s.setBaseParam("SUBJIDNO", "");
 										
 									return 1;
 								}else{
 									return false;
 								}
 							}
 						}
 					});
 					
 		
 	     
		var gridView = new Ext.grid.GridView({ 
                getRowClass : function (row, index) { 
                    var cls = '',
                    data = row.data,
                    student = FacultyEvaluation.app.selectedStudents.data.indexOf(data.STUDCODE);
                    
                    if(student != -1){
                    	cls = 'selected';
                    }
                    return cls; 
                } 
        });
        
		var colModel = new Ext.grid.ColumnModel([
			{ header: "ID No.", width: 100, sortable: true, dataIndex: "IDNO" },
			{ header: "Name", width: 250, sortable: true, dataIndex: "NAME" }/*,
			{
                xtype: 'actioncolumn',
                width: 50,
                items: [{
                    icon   : '/images/icons/delete.png',  // Use a URL in the icon config
                    tooltip: 'Remove Filter',
                    handler: function(grid, rowIndex, colIndex) {
                        var rec = Objstore.getAt(rowIndex);
                        var row = FacultyEvaluation.app.selectedStudents.data.indexOf(rec.get('STUDCODE'));
                       // console.log(rec.get('id')+ " " + row);
                        if(row != - 1){
                        FacultyEvaluation.app.selectedStudents.data.splice(row, 1);
                        FacultyEvaluation.app.sGrid.getStore().load();
                        }
                    //    console.log(FacultyEvaluation.app.selectedStudents.data);
                       // console.log(rec.get('id')+ " " + row);
                    }
                }, {
                    icon   : '/images/icons/add.png',  // Use a URL in the icon config
                    tooltip: 'Add Filter',
                    handler: function(grid, rowIndex, colIndex) {
                        var rec = Objstore.getAt(rowIndex),
                        student = FacultyEvaluation.app.selectedStudents.data.indexOf(rec.get('STUDCODE'));
                        if(student == -1){
                         FacultyEvaluation.app.selectedStudents.data.push(rec.get('STUDCODE'));
                        // hrisv2_my_whereabouts.app.Grid.getStore().setBaseParam("employees", Ext.util.JSON.encode(hrisv2_my_whereabouts.app.employees));
                         FacultyEvaluation.app.sGrid.getStore().load();
                        }
                       // console.log(FacultyEvaluation.app.selectedStudents);
                    }
                }]
            }*/
		]);

 			var grid = new Ext.grid.GridPanel({
 				id: 's_grid',
 				height: 270,
 				width: '100%',
 				border: true,
 				view: gridView,
 				ds: Objstore,
 				cm:  colModel,
 				sm: new Ext.grid.RowSelectionModel({singleSelect:true}),
 	        	loadMask: true,
 	        	bbar:
 	        		new Ext.PagingToolbar({
 		        		autoShow: true,
 				        pageSize: 100,
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

                })/*, {
					xtype:'tbtext',
					text:'Search:'
				},'   ', new Ext.app.SearchField({ store: Objstore, width:250}),
 					    {
 					     	xtype: 'tbfill'
 					 	},{
 					     	xtype: 'tbbutton',
 					     	text: 'SELECT ALL',
							icon: '/images/icons/application_add.png',
 							cls:'x-btn-text-icon',
 							handler: function(){
 								if(FacultyEvaluation.app.sGrid.getStore().getTotalCount()){
 									FacultyEvaluation.app.sGrid.getStore().each(
 										function(f){
 											var st = FacultyEvaluation.app.selectedStudents.data.indexOf(f.data.STUDCODE);
					                        if(st == -1){
					                         FacultyEvaluation.app.selectedStudents.data.push(f.data.STUDCODE);
					                        }
					                        
 										}, this
 									);
 									FacultyEvaluation.app.sGrid.getStore().load();
 									console.log(FacultyEvaluation.app.selectedStudents.data);
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
 								FacultyEvaluation.app.selectedStudents = {data: new Array()};
 								FacultyEvaluation.app.sGrid.getStore().load();
 							}

 					 	}*/
 	    			 ]
 	    	});

 			FacultyEvaluation.app.sGrid = grid;
 			
	}
		
		}
		}();

	 Ext.onReady(FacultyEvaluation.app.init, FacultyEvaluation.app);
	
	</script>
		