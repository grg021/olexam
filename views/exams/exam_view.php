<div id="mainBody"></div>
<script type="text/javascript">
 Ext.namespace("olexam_category");
 olexam_category.app = function()
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
 							url: "http://www.lithefire.net/dev/ils/filereference/getCategory",
 							method: "POST"
 							}),
 						reader: new Ext.data.JsonReader({
 								root: "data",
 								id: "id",
 								totalProperty: "totalCount",
 								fields: [
 											{ name: "CATECODE"},
 											{ name: "DESCRIPTION"},
 											{ name: "ACRONYM"},
 											{ name: "FINE"},
 											{ name: "DAYSALLO"},
 											{ name: "CATEIDNO"}
 										]
 						}),
 						remoteSort: true,
 						baseParams: {start: 0, limit: 25}
 					});
    var myData = [
        ['001','Apple','5/22 12:00am','9/1 12:00am'],
        ['002','Ext','5/22 12:00am','9/12 12:00am'],
        ['003','Google','5/22 12:00am','10/1 12:00am'],
        ['004','Microsoft','5/22 12:00am','7/4 12:00am'],
        ['005','Yahoo!','5/22 12:00am','5/22 12:00am']
    ];

    var ds = new Ext.data.SimpleStore({
        fields: [
            {name: 'code'},
            {name: 'title'},
            {name: 'dateCreated', type: 'date', dateFormat: 'n/j h:ia'},
            {name: 'lastChange', type: 'date', dateFormat: 'n/j h:ia'}
        ]
    });
    
    ds.loadData(myData);
    var colModel = new Ext.grid.ColumnModel([
        {header: "Code", width: 120, sortable: true, dataIndex: 'code'},
        {header: "Title", width: 90, sortable: true, dataIndex: 'title'},
        {header: "Date Created", width: 120, sortable: true,
            renderer: Ext.util.Format.dateRenderer('m/d/Y'),
                        dataIndex: 'dateCreated'},
        {header: "Last Updated", width: 120, sortable: true,
            renderer: Ext.util.Format.dateRenderer('m/d/Y'),
                        dataIndex: 'lastChange'}
    ]);

 			var grid = new Ext.grid.GridPanel({
 				id: 'olexam_categorygrid',
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
 					 	},{
 					     	xtype: 'tbbutton',
 					     	text: 'ADD',
							icon: '/images/icons/application_add.png',
 							cls:'x-btn-text-icon',

 					     	handler: olexam_category.app.Add

 					 	},'-',{
 					     	xtype: 'tbbutton',
 					     	text: 'EDIT',
							icon: '/images/icons/application_edit.png',
 							cls:'x-btn-text-icon',

 					     	handler: olexam_category.app.Edit

 					 	},'-',{
 					     	xtype: 'tbbutton',
 					     	text: 'DELETE',
							icon: '/images/icons/application_delete.png',
 							cls:'x-btn-text-icon',

 					     	handler: olexam_category.app.Delete

 					 	}
 	    			 ]
 	    	});

 			olexam_category.app.Grid = grid;
 			olexam_category.app.Grid.getStore().load({params:{start: 0, limit: 25}});

 			var _window = new Ext.Panel({
 		        title: 'Manage Exams',
 		        width: '100%',
 		        height:'auto',
 		        renderTo: 'mainBody',
 		        draggable: false,
 		        layout: 'fit',
 		        items: [olexam_category.app.Grid],
 		        resizable: false

 			    /*listeners : {
 				    	  close: function(p){
 					    	  window.location="../"
 					      }
 			       	} */
 	        });

 	        _window.render();


 		},
 			setForm: function(){
 			var author_store = new Ext.data.Store({
 						proxy: new Ext.data.HttpProxy({
 							url: "http://www.lithefire.net/dev/ils/book/getTempBookAuthor",
 							method: "POST"
 							}),
 						reader: new Ext.data.JsonReader({
 								root: "data",
 								id: "id",
 								totalProperty: "totalCount",
 								fields: [
 											{ name: "AUTHIDNO"},
 											{ name: "AUTHOR"}
 										]
 						}),
 						remoteSort: true,
 						baseParams: {start: 0, limit: 25}
 					});	
 			var question_grid = new Ext.grid.GridPanel({
 				id: 'question_grid',
 				height: 150,
 				width: '100%',
 				border: true,
 				style: {marginBottom: '10px'},
 				ds: author_store,
 				cm:  new Ext.grid.ColumnModel(
 						[
                                                    
 						  { header: "Code", width: 60, sortable: true, dataIndex: "AUTHOR" },
 						  { header: "Question", width: 300, sortable: true, dataIndex: "AUTHOR" }
 						]
 				),
 				sm: new Ext.grid.RowSelectionModel({singleSelect:true}),
 	        	loadMask: true,
 	        	bbar:
 	        		new Ext.PagingToolbar({
 		        		autoShow: true,
 				        pageSize: 25,
 				        store: author_store,
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
				},'   ', new Ext.app.SearchField({ store: author_store, width:250}),
 					    {
 					     	xtype: 'tbfill'
 					 	},{
 					     	xtype: 'tbbutton',
 					     	text: 'ADD',
							icon: '/images/icons/application_add.png',
 							cls:'x-btn-text-icon',

 					     	handler: olexam_category.app.AddAuthor,
 					     	//disabled: true,
 					     	id: 'add_author_button'
 					     	

 					 	},'-',{
 					     	xtype: 'tbbutton',
 					     	text: 'DELETE',
							icon: '/images/icons/application_delete.png',
 							cls:'x-btn-text-icon',

 					     	handler: olexam_category.app.DeleteAuthor,
 					     	//disabled: true,
 					     	id: 'delete_author_button'

 					 	}
 	    			 ]
 	    	});
			olexam_category.app.Qgrid = question_grid;
 		    var form = new Ext.form.FormPanel({
 		        labelWidth: 150,
 		        url:"http://www.lithefire.net/dev/ils/filereference/addCategory",
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
 		            fieldLabel: 'Code *',
                            autoCreate : {tag: "input", type: "text", size: "20", autocomplete: "off", maxlength: "128"},
 		            name: 'DESCRIPTION',
 		            allowBlank:false,
 		            anchor:'95%',  // anchor width by percentage
 		            id: 'DESCRIPTION'
 		        },
 		        		{

                            xtype:'textfield',
 		            fieldLabel: 'Title *',
                            autoCreate : {tag: "input", type: "text", size: "20", autocomplete: "off", maxlength: "128"},
 		            name: 'ACRONYM',
 		            allowBlank:false,
 		            anchor:'95%',  // anchor width by percentage
 		            id: 'ACRONYM'
 		        },
 		        		{

                            xtype:'combo',
 		            fieldLabel: 'Category *',
                    autoCreate : {tag: "input", type: "text", size: "20", autocomplete: "off", maxlength: "128"},
 		            name: 'category',
 		            allowBlank:false,
 		            anchor:'95%',  // anchor width by percentage
 		            id: 'category'
 		        }

 		        		]
 					},
						{
						xtype: 'tabpanel',
						activeTab: 0,
						items: [
							{
								xtype: 'panel',
								title: 'Questions',
								height: 420,
								items: olexam_category.app.Qgrid
							},
							{
								xtype: 'panel',
								title: 'Answer Sheet'
							},
							{
								xtype: 'panel',
								title: 'Permission'
							}
						]
					}
 					]
 		    });

 		    olexam_category.app.Form = form;
 		},
 		Add: function(){

 			olexam_category.app.setForm();

 		  	var _window;

 		    _window = new Ext.Window({
 		        title: 'New Exam',
 		        width: 510,
 		        height: 420,
 		        layout: 'fit',
 		        plain:true,
 		        modal: true,
 		        bodyStyle:'padding:5px;',
 		        buttonAlign:'center',
 		        items: olexam_category.app.Form,
 		        buttons: [{
 		         	text: 'Save',
                                icon: '/images/icons/disk.png',  cls:'x-btn-text-icon',

 	                handler: function () {
 			            if(ExtCommon.util.validateFormFields(olexam_category.app.Form)){//check if all forms are filled up

 		                olexam_category.app.Form.getForm().submit({
 			                success: function(f,action){
                 		    	Ext.MessageBox.alert('Status', action.result.data);
                  		    	 Ext.Msg.show({
  								     title: 'Status',
 								     msg: action.result.data,
  								     buttons: Ext.Msg.OK,
  								     icon: 'icon'
  								 });
 				                ExtCommon.util.refreshGrid(olexam_category.app.Grid.getId());
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
                            icon: '/images/icons/cancel.png', cls:'x-btn-text-icon',

 		            handler: function(){
 			            _window.destroy();
 		            }
 		        }]
 		    });
 		  	_window.show();
 		},
 		Edit: function(){


 			if(ExtCommon.util.validateSelectionGrid(olexam_category.app.Grid.getId())){//check if user has selected an item in the grid
 			var sm = olexam_category.app.Grid.getSelectionModel();
 			var id = sm.getSelected().data.CATEIDNO;

 			olexam_category.app.setForm();
 		    _window = new Ext.Window({
 		        title: 'Update Category',
 		        width: 510,
 		        height:250,
 		        layout: 'fit',
 		        plain:true,
 		        modal: true,
 		        bodyStyle:'padding:5px;',
 		        buttonAlign:'center',
 		        items: olexam_category.app.Form,
 		        buttons: [{
 		         	text: 'Save',
                                icon: '/images/icons/disk.png',  cls:'x-btn-text-icon',

 		            handler: function () {
 			            if(ExtCommon.util.validateFormFields(olexam_category.app.Form)){//check if all forms are filled up
 		                olexam_category.app.Form.getForm().submit({
 			                url: "http://www.lithefire.net/dev/ils/filereference/updateCategory",
 			                params: {id: id},
 			                method: 'POST',
 			                success: function(f,action){
                 		    	Ext.MessageBox.alert('Status', action.result.data);
 				                ExtCommon.util.refreshGrid(olexam_category.app.Grid.getId());
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

 		  	olexam_category.app.Form.getForm().load({
 				url: "http://www.lithefire.net/dev/ils/filereference/loadCategory",
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


			if(ExtCommon.util.validateSelectionGrid(olexam_category.app.Grid.getId())){//check if user has selected an item in the grid
			var sm = olexam_category.app.Grid.getSelectionModel();
			var id = sm.getSelected().data.CATEIDNO;
			Ext.Msg.show({
   			title:'Delete',
  			msg: 'Are you sure you want to delete this record?',
   			buttons: Ext.Msg.OKCANCEL,
   			fn: function(btn, text){
   			if (btn == 'ok'){

   			Ext.Ajax.request({
                            url: "http://www.lithefire.net/dev/ils/filereference/deleteCategory",
							params:{ id: id},
							method: "POST",
							timeout:300000000,
			                success: function(responseObj){
                		    	var response = Ext.decode(responseObj.responseText);
						if(response.success == true)
						{
							Ext.Msg.show({
								title: 'Status',
								msg: "Record deleted successfully",
								icon: Ext.Msg.INFO,
								buttons: Ext.Msg.OK
							});
							olexam_category.app.Grid.getStore().load({params:{start:0, limit: 25}});

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

 Ext.onReady(olexam_category.app.init, olexam_category.app);

</script>