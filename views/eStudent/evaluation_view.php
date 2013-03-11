<style>
	.questionlabel{
		font-weight: bold;
		font-size: 11pt;
		font-family: helvetica;
		margin-left: 20px;
		
	}
	
	.radioOdd{
		background: #f0f4f7;
		font-family: helvetica;
		color: #dd7b33;
		margin-left: 50px;
		margin-top: 20px;
		margin-bottom: 20px;
	}
	
	.columnOdd{
		background: #e7eaef;
		
	}
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
 		