<?php $this->load->view('header'); ?>

<script type="text/javascript">
									
$(function() {
        $( "#datepicker" ).datepicker({
            dateFormat : 'yy-mm-dd',
            changeMonth : true,
            changeYear : true,
            yearRange: '-100y:c+nn',
            maxDate: '-1d'
        });
    });
</script>
<div class="breadcrump">
	<li><a href = "<?php echo base_url().'welcome'?>">Home &raquo;</a></li>
	<li><a href = "<?php $_SERVER['SERVER_NAME'] . '/' . $_SERVER['REQUEST_URI']; ?>">Forgot password</a></li>
</div>
<div id =  'content'>
	<?php
			$username = array(
				'name'		=> 'username',
				'id'		=> 'username',
				'class'		=> 'registration_textbox',
				'maxlength' =>	'50',
				'placeholder'=> 'Enter username',
				'value'		=> set_value('username')
				);
				
				$datepicker = array(
				'name'		=> 'datepicker',
				'id'		=> 'datepicker',
				'class'		=> 'registration_textbox',
				'placeholder'=> 'Enter your date of birth',
				'value'		=> set_value('datepicker')
				);	
				
				$email = array(
				'name'		=> 'email',
				'id'		=> 'email',
				'class'		=> 'registration_textbox',
				'maxlength' =>	'50',
				'placeholder'=> 'Your E-mail address',
				'value'		=> set_value('email')
				);	
				
				$login = array(
				'name'		=> 'btnlogin',
				'id'		=> 'btnlogin',
				'value'		=> 'Recover Password',	
				'class'		=>	'button',
				'style'		=> 'margin-top:20px'
				);			
	?>
			
			<form id = "recoverpassword" name = "recoverpassword" action="<?php echo base_url().'user/recover_password' ?>" method ="get">
			<div class="registration_label">Username</div>
			<li class="registration_li"><?php echo form_input($username); ?></li>
			<div class="registration_label">Birthday</div>
			<li class="registration_li"><?php echo form_input($datepicker);?></li>
			<div class="registration_label">Your email</div>
			<li class="registration_li"><?php echo form_input($email); ?></li>
			<?php echo form_submit($login);?>
			</form>
			<div style= "padding-top:24px;" class = "registration_error"><?php echo $message; ?></div>
</div>


<?php $this->load->view('footer'); ?>