
		<div id="mainBody"></div>
		<script type="text/javascript">
		 Ext.namespace("FILEQUCA");
		 FILEQUCA.app = function()
		 {
		 	return{
	 		init: function()
	 		{
	 			ExtCommon.util.init();
	 			ExtCommon.util.quickTips();
	 		},
	 		getGrid: function()
	 		{
	 			ExtCommon.util.renderSearchField('searchby');
	
	 			var Objstore = new Ext.data.Store({
	 						proxy: new Ext.data.HttpProxy({
	 							url: "<?php echo site_url('FILEQUCA/getFILEQUCA') ?>",
	 							method: "POST"
	 							}),
	 						reader: new Ext.data.JsonReader({
	 								root: "data",
	 								id: "id",
	 								totalProperty: "totalCount",
	 								fields: [
		{ name: 'QUCACODE'},{ name: 'QUCAIDNO'},{ name: 'DESCRIPTION'},{ name: 'ORDER_BY'}
		]
 						}),
 						remoteSort: true,
 						baseParams: {start: 0, limit: 25}
 					});
		
		var colModel = new Ext.grid.ColumnModel([
			{header: "QUCACODE", width: 100, sortable: true, dataIndex: 'QUCACODE'},
			{header: "QUCAIDNO", width: 100, sortable: true, dataIndex: 'QUCAIDNO'},
			{header: "Description", width: 250, sortable: true, dataIndex: 'DESCRIPTION'},
			{header: "Order", width: 100, sortable: true, dataIndex: 'ORDER_BY'}
		]);

 			var grid = new Ext.grid.GridPanel({
 				id: 'FILEQUCAgrid',
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

 					     	handler: FILEQUCA.app.Add

 					 	},'-',{
 					     	xtype: 'tbbutton',
 					     	text: 'EDIT',
							icon: '/images/icons/application_edit.png',
 							cls:'x-btn-text-icon',

 					     	handler: FILEQUCA.app.Edit

 					 	},'-',{
 					     	xtype: 'tbbutton',
 					     	text: 'DELETE',
							icon: '/images/icons/application_delete.png',
 							cls:'x-btn-text-icon',

 					     	handler: FILEQUCA.app.Delete

 					 	}
 	    			 ]
 	    	});

 			FILEQUCA.app.Grid = grid;
 			FILEQUCA.app.Grid.getStore().load({params:{start: 0, limit: 25}});

 			var _window = new Ext.Window({
 		        title: 'Question Categories',
 		        width: 600,
 		        height: 300,
 		        draggable: false,
 		        layout: 'fit',
 		        items: [FILEQUCA.app.Grid],
 		        resizable: false
 	        }).show();

			FILEQUCA.app._window = _window;
 		},
		setForm: function(){

 		    var form = new Ext.form.FormPanel({
 		        labelWidth: 150,
 		        url: "<?php echo site_url('FILEQUCA/addFILEQUCA') ?>",
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
 		            fieldLabel: 'ID Number*',
 		            name: 'QUCAIDNO',
 		            allowBlank:false,
 		            anchor:'95%',  // anchor width by percentage
 		            id: 'QUCAIDNO'
 		        },
				{
                    xtype:'textfield',
 		            fieldLabel: 'Description*',
 		            name: 'DESCRIPTION',
 		            allowBlank:false,
 		            anchor:'95%',  // anchor width by percentage
 		            id: 'DESCRIPTION'
 		        },
				{
                    xtype:'textfield',
 		            fieldLabel: 'Order by*',
 		            name: 'ORDER_BY',
 		            allowBlank:false,
 		            anchor:'95%',  // anchor width by percentage
 		            id: 'ORDER_BY'
 		        }
 		        

 		        		]
 					}
 					]
 		    });

 		    FILEQUCA.app.Form = form;
 		},
		
 		Add: function(){

 			FILEQUCA.app.setForm();

 		  	var _window;

 		    _window = new Ext.Window({
 		        title: 'New FILEQUCA',
 		        width: 510,
 		        height: 230,
 		        layout: 'fit',
 		        plain:true,
 		        modal: true,
 		        bodyStyle:'padding:5px;',
 		        buttonAlign:'center',
 		        items: FILEQUCA.app.Form,
 		        buttons: [{
 		         	text: 'Save',
                    icon: '/images/icons/disk.png',  
                    cls:'x-btn-text-icon',
 	                handler: function () {
 			            if(ExtCommon.util.validateFormFields(FILEQUCA.app.Form)){//check if all forms are filled up
 		                FILEQUCA.app.Form.getForm().submit({
 			                success: function(f,action){
                 		    	Ext.MessageBox.alert('Status', action.result.data);
                  		    	 Ext.Msg.show({
  								     title: 'Status',
 								     msg: action.result.data,
  								     buttons: Ext.Msg.OK,
  								     icon: 'icon'
  								 });
 				                ExtCommon.util.refreshGrid(FILEQUCA.app.Grid.getId());
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
 			if(ExtCommon.util.validateSelectionGrid(FILEQUCA.app.Grid.getId())){//check if user has selected an item in the grid
 			var sm = FILEQUCA.app.Grid.getSelectionModel();
 			var id = sm.getSelected().data.QUCACODE;

 			FILEQUCA.app.setForm();
 		    _window = new Ext.Window({
 		        title: 'Update Classification',
 		        width: 510,
 		        height:340,
 		        layout: 'fit',
 		        plain:true,
 		        modal: true,
 		        bodyStyle:'padding:5px;',
 		        buttonAlign:'center',
 		        items: FILEQUCA.app.Form,
 		        buttons: [{
 		         	text: 'Save',
                    icon: '/images/icons/disk.png',  
                    cls:'x-btn-text-icon',
 		            handler: function () {
 			            if(ExtCommon.util.validateFormFields(FILEQUCA.app.Form)){//check if all forms are filled up
 		                FILEQUCA.app.Form.getForm().submit({
 			                url: "<?php echo site_url('FILEQUCA/updateFILEQUCA') ?>",
 			                params: {id: id},
 			                method: 'POST',
 			                success: function(f,action){
                 		    	Ext.MessageBox.alert('Status', action.result.data);
 				                ExtCommon.util.refreshGrid(FILEQUCA.app.Grid.getId());
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

 		  	FILEQUCA.app.Form.getForm().load({
 				url: "<?php echo site_url('FILEQUCA/loadFILEQUCA') ?>",
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


			if(ExtCommon.util.validateSelectionGrid(FILEQUCA.app.Grid.getId())){//check if user has selected an item in the grid
			var sm = FILEQUCA.app.Grid.getSelectionModel();
			var id = sm.getSelected().data.QUCACODE;
			Ext.Msg.show({
   			title:'Delete Selected',
  			msg: 'Are you sure you want to delete this record?',
   			buttons: Ext.Msg.OKCANCEL,
   			fn: function(btn, text){
   			if (btn == 'ok'){
   			Ext.Ajax.request({
                            url: "<?php echo site_url('FILEQUCA/deleteFILEQUCA') ?>",
							params:{ id: id},
							method: "POST",
							timeout:300000000,
			                success: function(responseObj){
                		    	var response = Ext.decode(responseObj.responseText);
						if(response.success == true)
						{
							FILEQUCA.app.Grid.getStore().load({params:{start:0, limit: 25}});
							Question.app.Grid.getStore().load({params:{start:0, limit: 25}});
							ExtCommon.util.refreshGrid(Question.app.Grid.getId());
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

	 Ext.onReady(FILEQUCA.app.init, FILEQUCA.app);
	
	</script>
		