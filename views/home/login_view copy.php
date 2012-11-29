<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title id='title'>Web Points System</title>

        <!-- ** CSS ** -->
        <!-- base library -->
        <link rel="stylesheet" type="text/css" href="/js/ext34/resources/css/ext-all.css" />
        <link rel="stylesheet" type="text/css" href="/js/ext34/resources/css/xtheme-gray.css" />
	<!--<link href="/hrisv2/css/ui_login.css" rel="stylesheet" type="text/css" />-->
 <style type="text/css">
* {margin:0;padding:0}
html,body{height:100%}
#bod
{
	background-color: #FFF;
	background-image: url(/images/bg_login.png);
	background-repeat: repeat;
}
#wrapper{
	height:100%;
	width:100%;
	display:table;
	vertical-align:middle;
}
#ext-comp-1004 { margin: 0 auto; }

p{margin:1em 0}
input{position:relative;background:#ffffcc}

#logo {
display: block;
width: 480px;
height: 300px;
background: url("/images/wps-logo.png") 50% 50% no-repeat;
margin: 0 auto;
}

</style>
<!--[if lt IE 8]>
<style type="text/css">
#formwrap {top:50%}
#form1{top:-50%;}
</style>
<![endif]-->
<!--[if IE 7]>
<style type="text/css">
#wrapper{
position:relative;
overflow:hidden;
}
</style>
<![endif]-->

<body id="bod">
<!-- ** Javascript ** -->
        <!-- ExtJS library: base/adapter -->
        <script type="text/javascript" src="/js/ext34/adapter/ext/ext-base.js"></script>
        <script type="text/javascript" src="/js/commonjs/ExtCommon.js"></script>
        <!-- ExtJS library: all widgets -->
        <script type="text/javascript" src="/js/ext34/ext-all-debug.js"></script>


<script type="text/javascript">
        // Path to the blank image should point to a valid location on your server
        Ext.BLANK_IMAGE_URL = '/js/ext34/resources/images/default/s.gif';

        Ext.onReady(function(){

           function loger()
				        		{
				        		if(ExtCommon.util.validateFormFields(pwd)){
					        		pwd.getForm().submit({
						        		waitMsg: 'Authenticating...',
						        		timeout: 300000,
						        		url: '<?php echo site_url("home/login"); ?>',
						        		method:'POST',
						        		success: function(f,a)
						        		{
							        		Ext.MessageBox.show({title:'Status', msg:a.result.errorMsg});
							        		window.location=a.result.link;
							        		//pwd.getForm.reset();
						        		},
						        		failure: function(f,a)
						        		{
							        		if(a.result.errorMsg){
								        		}else
								        		a.result.errorMsg = "Please try again";
						        			Ext.Msg.show({
						                        title: 'Login Failure',
						                        icon: Ext.Msg.ERROR,
						                        msg: a.result.errorMsg,
						                        buttons: Ext.Msg.OK
						                        });

						                    return;

							        		//Ext.Msg.alert('Status', 'Access Denied', showResult);
							        		//pwd.getForm().reset();
						        		}
					        		});
					        		}else return;
				        		}
				        function showResult(btn){
					        Ext.getCmp('user').focus('', 10);
					    };
						var username = new Ext.form.TextField({
				            enableKeyEvents: true,
				            fieldLabel: 'Username',
							name: 'username',
							id: 'user',
							anchor: '95%',
							allowBlank: false
				        });

				        var password = new Ext.form.TextField({
					        inputType: 'password',
				            enableKeyEvents: true,
				            fieldLabel: 'Password',
							name: 'password',
							id: 'pass',
							anchor: '95%',
							allowBlank: false
				        });
				        password.on('specialkey', function(f, e){
					            if(e.getKey() == e.ENTER){
					                loger();
					            }
				           });
						var pwd = new Ext.FormPanel({
						  labelWidth: 75,
						  layout: 'form',
						  title: 'Please Login',
						  width: 270,
						  height: 130,						
						  frame: true,
						  buttonAlign: 'right',
						  defaultType: 'textfield',
						  id: 'loginForm',
						  items: [username, password],
							buttons: [
							{text: 'Login',

								handler: loger
							},
							{text: 'Reset',

								handler: function (){pwd.getForm().reset();}
							}
							]
		});
var fwin = new Ext.Window({
  layout:'fit',
  closable: false,
  draggable: false,
  resizable: false,
  width: 425,
  plain: true,
  border: false,
  bbar: [{
    xtype: 'tbtext',
    text: '&copy; 2011 Web Point System.'
  }],
  items: [ pwd ]
});
			//fwin.render('loginform_wrapper');
fwin.show();
        }); //end onReady
        </script>
<div id="wrapper">
	<div id="logo"></div>
	<div id="loginform_wrapper"></div>
</div>
</div>



</body>
</html>