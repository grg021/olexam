<style>

	.questionlabel{

		font-weight: bold;

		font-size: 11pt;

		font-family: helvetica;

		margin-left: 20px;

		color: #dd7b33;

		

	}

	

	.radioOdd{

		

		font-family: helvetica;

		color: #334466;

		margin-left: 50px;

		margin-top: 20px;

		margin-right: 5%;



	}

	

	.columnOdd{

		background: #e7eaef;

		border-left: 1px solid #334466;
		border-right: 1px solid #334466;

	}

	.columnEven{

		background: #f0f4f7;

		

	}

	#evalform .x-panel-mc { padding-top: 25px; }

	#evalform .x-column-inner .x-form-item { padding-left: 10px; }

	#evalform .x-column-inner .x-form-item .x-form-cb-label { padding-left: 5px; }

</style>

<div id="mainBody"></div>

		<script type="text/javascript">

		 Ext.namespace("Evaluation");

		 Evaluation.app = function()

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

	 		var form = new Ext.form.FormPanel({

 		        url: "<?php echo site_url('eStudent/saveEvaluation') ?>",

 		        method: 'POST',

 		        defaultType: 'textfield',

 		        frame: true,

 		        labelAlign: 'top',

 		        labelWidth: 50,

 		        autoScroll: true,

 		        buttonAlign: 'center',

 		        id: 'evalform',

 		        title: 'Evaluation Form',

 		        items: [<?php echo $fields; ?>, {xtype: 'hidden', name: 'question_set_id', value: <?php echo $question_set_id; ?>}, {xtype: 'hidden', name: 'evaluation_id', value: <?php echo $evaluation_id; ?>}],

 		        buttons: [

 		        {

 					     	xtype: 'tbbutton',

 					     	text: 'Save Changes',

							icon: '/images/icons/disk.png',

 							cls:'x-btn-text-icon',



 					     	handler: function(){

 					     		if(ExtCommon.util.validateFormFields(form)){//check if all forms are filled up

			 		                form.getForm().submit({

			 			                url: "<?php echo site_url('eStudent/saveEvaluation') ?>",

			 			                method: 'POST',

			 			                success: function(f,action){

			                 		    	Ext.Msg.show({

			 									title: 'Status',

			 									msg: action.result.data,

			 									icon: Ext.Msg.INFO,

			 									buttons: Ext.Msg.OK

			 								});

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



 					 	}

 		        ]

 		    });



 			var _window = new Ext.Panel({

 		        width: '100%',

 		        height:500,

 		        renderTo: 'mainBody',

 		        draggable: false,

 		        layout: 'fit',

 		        items: [form],

 		        resizable: false

 		        /*,

 		        bbar: [

 		        	{

 					     	xtype: 'tbfill'

 					 	},{

 					     	xtype: 'tbbutton',

 					     	text: 'Save Changes',

							icon: '/images/icons/disk.png',

 							cls:'x-btn-text-icon',



 					     	handler: function(){

 					     		if(ExtCommon.util.validateFormFields(form)){//check if all forms are filled up

			 		                form.getForm().submit({

			 			                url: "<?php echo site_url('eStudent/saveEvaluation') ?>",

			 			                method: 'POST',

			 			                success: function(f,action){

			                 		    	Ext.Msg.show({

			 									title: 'Status',

			 									msg: action.result.data,

			 									icon: Ext.Msg.INFO,

			 									buttons: Ext.Msg.OK

			 								});

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



 					 	}

 		        ]*/

 	        });



 	        _window.render();

 	        

 	        form.getForm().load({

 				url: "<?php echo site_url('eStudent/loadAnswers') ?>",

 				method: 'POST',

 				params: {question_set_id: <?php echo $question_set_id; ?>, evaluation_id: <?php echo $evaluation_id; ?>},

 				timeout: 300000,

 				waitMsg:'Loading...',

 				success: function(form, action){

                	

 				},

 				failure: function(form, action) {

         			

     			}

 			});





 		}

 		

}

		}();



	 Ext.onReady(Evaluation.app.init, Evaluation.app);

	

	</script>

 		