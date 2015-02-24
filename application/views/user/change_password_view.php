<?php $this->load->view('header'); ?>
<div class="breadcrump">
	<li><a href = "<?php echo base_url().'welcome'?>">Home &raquo;</a></li>
	<li><a href = "<?php $_SERVER['SERVER_NAME'] . '/' . $_SERVER['REQUEST_URI']; ?>">Change password</a></li>
</div>
<div id = "content">
	<?php

	$password = array(
				'name'		=> 'password',
				'id'		=> 'password',
				'class'		=> 'registration_textbox',
				'maxlength' =>	'50',
				'placeholder'=> 'Create a password',
				'style' 	=> 'margin-right:8px'
				);
				
	$confpassword = array(
				'name'		=> 'confpassword',
				'id'		=> 'confpassword',
				'class'		=> 'registration_textbox',
				'maxlength' =>	'50',
				'placeholder'=> 'Confirm your password',
				);	
				
	$login = array(
				'name'		=> 'btnlogin',
				'id'		=> 'btnlogin',
				'value'		=> 'Change password',	
				'class'		=>	'button',
				'style'		=> 'margin-top:20px'
				);						
	?>
	
	<form id = "changepassword" name = "changepassword" action="<?php echo base_url().'user/create_new_password'; ?>" method ="post">
	<div class="registration_label">Enter new password</div>
	<li  class="registration_li"><?php echo form_password($password); ?></li>
	<li class="registration_error"><?php echo form_error('password');?></li>
	<div class="registration_label">Confirm password</div>
	<li class="registration_li"><?php echo form_password($confpassword);?></li>
	<li class="registration_error"><?php echo form_error('confpassword');?></li>
	<?php echo form_submit($login);?>
	</form>
	<div style= "padding-top:24px;" class = "registration_error"><?php echo $message; ?></div>
</div>

<?php $this->load->view('footer'); ?>