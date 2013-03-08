
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
		{ name: 'id'},{ name: 'description'}
 										{ name: "STUDIDNO"},
                                        { name: "IDNO"},
                                        { name: "NAME"}
		]
 						}),
 						remoteSort: true,
 						baseParams: {start: 0, limit: 25}
 					});
		
		var colModel = new Ext.grid.ColumnModel([
		{header: "id", width: 100, sortable: true, dataIndex: 'id'},{header: "description", width: 100, sortable: true, dataIndex: 'description'}
			{ header: "Student Name", width: 300, sortable: true, dataIndex: "NAME" },
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

 					 	},'-',{
 					     	xtype: 'tbbutton',
 					     	text: 'DELETE',
							icon: '/images/icons/application_delete.png',
 							cls:'x-btn-text-icon',

 					     	handler: FacultyEvaluation.app.Delete

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
 					items: [{
 						layout:'column',
			            width: 'auto',
			            items: [{
			            	columnWidth:.33,
	 	 			        layout: 'form',
	 	 			        items: [
	 	 			        	ExtCommon.util.createCombo("yearlevel", "yearlevel_id", "95%", "<?php echo site_url("FacultyEvaluation/getYearLevelCombo")?>", "Year Level*", false, false),
	 	 			        	ExtCommon.util.createCombo("gender", "gender_id", "95%", "<?php echo site_url("FacultyEvaluation/getGenderCombo")?>", "Gender*", false, false)
	 	 			        ]
			            },{
		            		columnWidth:.33,
 	 			          	layout: 'form',
 	 			          	items: [
 	 			          		FacultyEvaluation.app.sectionCombo()
 	 			          		//ExtCommon.util.createCombo("section", "section_id", "95%", "<--?php echo site_url("FacultyEvaluation/getSectionCombo")?>", "Section*", false, false),
                           	]
			            },{
			            	columnWidth:.33,
	 	 			        layout: 'form',
	 	 			        items: [
	 	 			        	FacultyEvaluation.app.subjectCombo()
	 	 			        	//ExtCommon.util.createCombo("subject", "subject_id", "95%", "<--?php echo site_url("FacultyEvaluation/getSubjectCombo")?>", "Subject*", false, false)
	 	 			        ]
			            }]
 					}]    	
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

 		    var form = new Ext.form.FormPanel({
 		        labelWidth: 150,
 		        url: "<?php echo site_url('FacultyEvaluation/addFacultyEvaluation') ?>",
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
 		            fieldLabel: 'description*',
 		            name: 'description',
 		            allowBlank:false,
 		            anchor:'95%',  // anchor width by percentage
 		            id: 'description'
 		        }    
 		        

 		        		]
 					}
 					]
 		    });

 		    FacultyEvaluation.app.Form = form;
 		},
		
 		Add: function(){

 			FacultyEvaluation.app.setForm();

 		  	var _window;

 		    _window = new Ext.Window({
 		        title: 'Schedule New Faculty Evaluation',
 		        width: 510,
 		        height: 190,
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
							
									Ext.get("SUBJIDNO").dom.value  = '';
                                    Ext.getCmp("subject").setRawValue("");
				},
			select: function (combo, record, index){
			this.setRawValue(record.get('name'));
			Ext.get(this.hiddenName).dom.value  = record.get('id');

			},
			blur: function(){
			var val = this.getRawValue();
			this.setRawValue.defer(1, this, [val]);
			this.validate();
			},
			render: function() {
			this.el.set({qtip: 'Type at least ' + this.minChars + ' characters to search for a course'});

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
			fields:[{name: 'id'}, {name: 'name'}, {name: 'description'}, {name: 'UNITS_TTL'}, {name: 'ADVISER'}, {name: 'SECTION'}, {name: 'COURSE'}],
			url: "<?php echo site_url("FacultyEvaluation/getSubjectCombo"); ?>",
			baseParams: {start: 0, limit: 10}

			}),
			listeners: {
                        beforequery: function(qe)
					{
						if (Ext.get("SECTIDNO").dom.value == "")
							return false;
					delete qe.combo.lastQuery;
				    this.store.baseParams = {SECTIDNO: Ext.get("SECTIDNO").dom.value};

			            /*var o = {start: 0, limit:10};
			            this.store.baseParams = this.store.baseParams || {};
			            this.store.baseParams[this.paramName] = '';
			            this.store.load({params:o, timeout: 300000});*/
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
		
		}
		}();

	 Ext.onReady(FacultyEvaluation.app.init, FacultyEvaluation.app);
	
	</script>
		