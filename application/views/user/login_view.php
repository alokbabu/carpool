<?php $this->load->view('header'); ?>
<div class="breadcrump">
	<li><a href = "<?php echo base_url().'welcome'?>">Home &raquo;</a></li>
	<li><a href = "<?php $_SERVER['SERVER_NAME'] . '/' . $_SERVER['REQUEST_URI']; ?>">Login</a></li>
</div>
<div id = "content">
<?php echo "<div class='registration_error'>".$message."</div>"; ?>
<div class="registration_label">Username</div>
	<?php 
	echo form_open('user/login');
	
	$username =  array(
				'id' => 'username',
				'class' => 'registration_textbox',
				'max'	=>	'20',
				'name' => 'username',
				'placeholder' => 'Enter username',
	
	);
	
	$password = array(
						'id' => 'password',
						'class' => 'registration_textbox',
						'max'	=>	'20',
						'name' => 'password',
						'placeholder' => 'Enter password',					
						);
						
	$submit  = array('id' => 'submit',
					'value' => 'login',
					'name'	=> 'submit',
					'class' => 'button',
					
	
	);
	
	echo form_input($username);
	
	?>

<div class="registration_label">Password</div>
	<?php echo form_password($password);
	echo "<br /><br />";
	echo form_submit($submit);
	echo form_close();
	?>
	

</div>

<?php $this->load->view('footer'); ?>
