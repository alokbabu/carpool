<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Carpool-us.com</title>
<link href="<?php echo base_url();?>css/carpooling_style.css" rel="stylesheet" type="text/css" />
<!-- jQuery library -->
<script type="text/javascript" src="<?php echo base_url();?>js/jquery-1.7.2.min.js"></script>
<link href="<?php echo base_url();?>css/jquery-ui.css" rel="stylesheet" type="text/css"/>
<!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script> -->
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>

</head>
<!-- Pop up-->
	<script src="<?php echo base_url();?>js/jquery.reveal.js"></script>

	<script type="text/javascript">
		$(document).ready(function() {
			$('#login').click(function(e) { // Button which will activate our modal
			   	$('#modal').reveal({ // The item which will be opened with reveal
				  	animation: 'fade',                   // fade, fadeAndPop, none
					animationspeed: 600,                       // how fast animtions are
					closeonbackgroundclick: true,              // if you click background will modal close?
					dismissmodalclass: 'close'    // the class of a button or element that will close an open modal
				});
			return false;
			});
		});
	
	</script>
<!-- Pop up-->
<!-- FB style drop down menu -->
<script type="text/javascript" >
	$(document).ready(function()
	{
	$(".account").click(function()
	{
	var X=$(this).attr('id');
	
	if(X==1)
	{
	$(".submenu").hide();
	$(this).attr('id', '0');	
	}
	else
	{
	
	$(".submenu").show();
	$(this).attr('id', '1');
	}
		
	});
	
	//Mouseup textarea false
	$(".submenu").mouseup(function()
	{
	return false
	});
	$(".account").mouseup(function()
	{
	return false
	});
	
	
	//Textarea without editing.
	$(document).mouseup(function()
	{
	$(".submenu").hide();
	$(".account").attr('id', '');
	});
		
	});
</script>
<!-- end of FB style drop down menu script -->

<body>
<div id="wrapper">
<div id="container">
<div id="header">
<div id="headerleft">
<img src="<?php echo base_url();?>images/headerbgg.png" width="765" height="36" />
</div> <!--ends headerleft -->
<div id="headeright">
<!-- Menu -->
<?php
$username = $this->session->userdata('username');
$firstname = $this->session->userdata('firstname');
$lastname = $this->session->userdata('lastname');
?>	
<ul class = "header_right_menu_ul">		
<!-- <li><a id="<?if ($username == '') { echo "login";} else{echo"logout";} ?>" href="<?if ($username == '') { echo "#";} else{echo base_url()."user/logout";} ?>"><? if ($username == '') { echo "Login";} else{echo"Logout ".$username;} ?></a></li> -->
<!-- <li><a id="login" href="#">Login</a></li> -->
<?php if ($username != '')
{
	echo "<li class ='header_right_menu_li'>
	<div class='dropdown'>
	<a class='account' >
	<span>".$firstname." ".$lastname."</span>
	</a>
	<div class='submenu' style='display: none; '>

	  <ul class='root'>
	
		    <li >
		      <a href='".base_url().'user/profile/'.$username."'>Profile</a>
		    </li>

		    <li >
		      <a href='".base_url().'user/drives/'.$username."' >My drives</a>
		    </li>
		    
		    <li >
		      <a href='".base_url().'user/rides/'.$username."'>My rides</a>
		    </li>
		   
		    <li>
		      <a href='#feedback'>Send Feedback</a>
		    </li>
		    
		    <li>
		      <a href='".base_url().'user/logout/'."'>Sign Out</a>
		    </li>
	  </ul>
	</div> <!-- end of submenu -->
	</div> <!-- end of dropdown -->
</li>";
}
else 
{
	echo "<li class = header_right_menu_li><a class='signup' href=".base_url()."user/signup>Sign up</a></li><li class = 'header_right_menu_li'><a id = 'login' href='#login'>Login</a></li>";	
}

	if($this->router->fetch_class() == 'welcome')
	{
		
	}
	else 
	{
		echo "<li style = 'padding-top: 20px; list-style:none; padding-bottom:20px;'><form id='form1' name='form1' method='post' action=".base_url()."post>
      <input class='button' type='submit' name='button' id='postride' value='Post A ride' /></li></form>";
	}

?>


<!-- Pop up-->
<div id="modal">
	<div id="heading">
		Login to Carpooling-US
	</div>

	<div id="popupcontent">
		<div id="logincontent">
		<?php echo form_open('user/login')?>
		<?php
			$username = array(
				'name'		=> 'username',
				'id'		=> 'username',
				'class'		=> 'registration_textbox',
				'maxlength' =>	'50',
				'placeholder'=> 'Enter user name',
				'value'		=> set_value('username')
				);
				
			$password = array(
				'name'		=> 'password',
				'id'		=> 'password',
				'class'		=> 'registration_textbox',
				'maxlength' =>	'50',
				'placeholder'=> 'Enter password',
				'style' => 'float:left',
				);
			$login = array(
				'name'		=> 'btnlogin',
				'id'		=> 'btnlogin',
				'value'		=> 'login',	
				'class'		=>	'button',
				'style'       => 'float:left',	
				);	
				
			$keep_signed_in = array(
				'name'		=> 'cbk_keep_signed_in',
				'id'		=> 'cbk_keep_signed_in',
				'value'       => 'true',
			    'checked'     => FALSE,
			    'style'       => 'margin:7px 10px 0px 16px; float:left',
				);
			?>
			<div class="registration_label">Username</div>
			<?php echo form_input($username); ?>
			<div class="registration_label">Password</div>
			<?php echo form_password($password); ?>
			<a style = "padding:7px 3px 20px 206px; display:block; font-size : 12px;" href= "<?php echo base_url().'user/recovery_wizard'?>">Forgot password?</a>
			<?php echo form_submit($login);?>
			<?php echo form_checkbox($keep_signed_in);?>
			<div style = "padding:7px 12px 0 26px; font-size:12px;" class="registration_label">Stay signed in</div>
			<?php echo form_close();?>
			<li style = "padding:12px 2px 0px; font-size:12px; list-style:none; color: #898989;">OR</li>
		</div>
		<a href = "<?php echo base_url().'user/fblogin'; ?>"><img style = "padding-left: 32px; padding-top:0px;" src = "<?php echo base_url().'images/login-facebook.png';?>"/></a>
	</div>
</div>
<!-- Pop up-->
</div> <!--ends headeright-->
</div> <!--ends header div here-->