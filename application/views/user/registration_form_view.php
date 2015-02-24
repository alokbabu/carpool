<script type="text/javascript">
									
$(function() {
        $( "#datepicker" ).datepicker({
            dateFormat : 'mm/dd/yy',
            changeMonth : true,
            changeYear : true,
            yearRange: '-100y:c+nn',
            maxDate: '-1d'
        });
    });
</script>
<script>
function loadXMLDoc()
{
var xmlhttp;
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("username_error").innerHTML=xmlhttp.responseText;
    }
  }
  //alert(document.getElementById("user").value);
xmlhttp.open("GET","<?php echo base_url().'/user/username_exists_ajax?username='?>"+document.getElementById('user').value,true);
xmlhttp.send();
}
</script>

<div class="breadcrump">
	<li><a href = "<?php echo base_url().'welcome'?>">Home &raquo;</a></li>
	<li><a href = "<?php $_SERVER['SERVER_NAME'] . '/' . $_SERVER['REQUEST_URI']; ?>">Sign up</a></li>
</div>
<div id="content">
<script type="text/javascript">
 var RecaptchaOptions = {
    theme : 'clean'
 };
 </script>
<div class="registration_form" id="registration">
<?php echo form_open_multipart('user/signup'); ?>

<?php

$firstname = array(
              'name'        => 'firstname',
              'id'          => 'firstname',
              'class'		=> 'registration_textbox',
              'maxlength'   => '50',
              'placeholder'=> 'First Name',
              'value'		=> set_value('firstname')
            );
			
$lastname = array(
				'name'		=> 'lastname',
				'id'		=> 'lastname',
				'class'		=> 'registration_textbox',
				'maxlength' =>	'50',
				'placeholder'=> 'Second Name',
				'value'		=> set_value('lastname')
				);
				
				
$username = array(
				'name'		=> 'username',
				'id'		=> 'user',
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
																
$datepicker = array(
				'name'		=> 'datepicker',
				'id'		=> 'datepicker',
				'class'		=> 'registration_textbox',
				'placeholder'=> 'Select your birthday',
				'value'		=> set_value('datepicker')
				);	

$gender= array(
				'male'		=> 'Male',
				'female'	=> 'Female',
				'other'		=> 'Other',
				);		
				
$mobile_phone = array(
				'name'		=> 'mobile_phone',
				'id'		=> 'mobile_phone',
				'class'		=> 'registration_textbox',
				'maxlength' =>	'14',
				'placeholder'=> 'Your phone number',
				'value'		=> set_value('mobile_phone')
				);

$keep_no_anonymous =  array(
			    'name'        => 'is_no_anonymous',
			    'id'          => 'is_no_anonymous',
			    'value'       => 'true',
			    'checked'     => FALSE,
			    'style'       => 'margin:14px 12px 0px 26px; float:left',
			    );

$keep_email_anonymous =  array(
			    'name'        => 'is_email_anonymous',
			    'id'          => 'is_email_anonymous',
			    'value'       => 'true',
			    'checked'     => FALSE,
			    'style'       => 'margin:14px 12px 0px 26px; float:left',
			    );
								
$email = array(
				'name'		=> 'email',
				'id'		=> 'email',
				'class'		=> 'registration_textbox',
				'maxlength' =>	'50',
				'placeholder'=> 'Your E-mail address',
				'value'		=> set_value('email')
				);	
				
$contact_method = array(
				'both'		=> 'both',
				'email'	=> 'email',
				'phone'		=> 'phone',
				);		

$submit = array(
				'name'		=> 'submit',
				'id'		=> 'signup',
				'value'		=> 'Sign up',
				'class'		=>	'button',			
				);	

$js = 'onchange="loadXMLDoc()"';

?>
<div class="registration_label">*Name</div>
<li style = "float:left;" class="registration_li"><?php echo form_input($firstname); ?></li>
<li class="registration_li"><?php echo form_input($lastname);?></li>
<li class="registration_error" style = "float:left;"><?php echo form_error('firstname');?></li>
<li class="registration_error" style = "margin-left: 194px;"><?php echo form_error('lastname');?></li>
<div class="registration_label">*Choose your username</div>
<!-- <li class="registration_li"><input id="user" name="username" class="registration_textbox" placeholder = "Enter username" value = "" onchange="loadXMLDoc()"></li> -->
<li class="registration_li"><?php echo form_input($username,"",$js);?></li>
<li id = "username_error" class="registration_error"><?php echo form_error('username');?></li>
<div class="registration_label">*Create a password</div>
<li style = "float:left;" class="registration_li"><?php echo form_password($password);?></li>
<!-- <div class="registration_label">Confirm your password</div> -->
<li class="registration_li"><?php echo form_password($confpassword);?></li>
<li class="registration_error" style = "float:left;"><?php echo form_error('password');?></li>
<li class="registration_error" style = "margin-left:194px;"><?php echo form_error('confpassword');?></li>
<div class="registration_label">*Birthday</div>
<li class="registration_li"><?php echo form_input($datepicker);?></li>
<li class="registration_error"><?php echo form_error('datepicker');?></li>
<div class="registration_label">*Gender</div>
<li class="registration_li"><?php echo form_dropdown('dd_gender',$gender); ?></li>
<div class="registration_label">*Mobile Phone</div>
<li style = "float:left;" class="registration_li"><?php echo form_input($mobile_phone); ?></li>
<li class="registration_li"><?php echo form_checkbox($keep_no_anonymous)?></li>
<div class="registration_label">keep my number anonymous</div>
<li class="registration_error"><?php echo form_error('mobile_phone');?></li>
<div class="registration_label">*Your current email address</div>
<li style = "float:left;" class="registration_li"><?php echo form_input($email); ?></li>
<li class="registration_li"><?php echo form_checkbox($keep_email_anonymous)?></li>
<div class="registration_label">keep my email anonymous</div>
<li class="registration_error"><?php echo form_error('email');?></li>
<div class="registration_label">Preferred method of contact</div>
<li class="registration_error"><?php echo form_dropdown('dd_contact_method',$contact_method);?></li>
<div class="registration_label">*Prove that you are human</div>
<li class="registration_li"><? $this->load->helper('recaptchalib');
							  $publickey = "6Lecd9oSAAAAAKa26JXjCgxGxv-H7tnkWnHOsMGH"; // you got this from the signup page
							  echo recaptcha_get_html($publickey);?></li>
<li class="registration_error"><?php echo form_error('recaptcha_response_field');?></li>
<li style = "clear:both; padding-top:26px;"class="registration_li"><?php echo form_submit($submit, 'Sign Up'); ?></li>
<?php echo form_close();?>
<div id = "notice"><?php echo $this->session->flashdata('notice'); ?></div>
</div> <!-- end registration form -->
</div> <!-- end content form -->
<?php $this->load->view('footer'); ?>
