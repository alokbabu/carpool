<?php $this->load->view('header'); ?>
<?php 
$user = $this->session->userdata('username');
$username = $this->uri->segment(3, 0);
$firstname = $this->session->userdata('firstname');
$lastname = $this->session->userdata('lastname');
?>

 <!--Google Places -->
<script src="http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places" type="text/javascript"></script>
<script type="text/javascript">
   function initialize() {
      var input = document.getElementById('usr_location');
     var options = 
     {
        types: ['(cities)'],
        componentRestrictions: {country: 'us'}
     }
      var autocomplete = new google.maps.places.Autocomplete(input,options); // enable to provide country filtering
     // var autocomplete = new google.maps.places.Autocomplete(input);
     // var autocomplete2 = new google.maps.places.Autocomplete(input2); // enable to remove country filtering
   }
      google.maps.event.addDomListener(window, 'load', initialize);


</script>
<!--Google Places -->

<!--Date Picker -->

<script>
 $(document).ready(function() {
 $("#dob").datepicker({ dateFormat: 'yy-mm-dd', minDate: 0, maxDate: "+12M +10D", numberOfMonths: 1, showAnim: "slideDown"});
  });
</script>
<!-- Date Picker -->

<script>
	$(function() {
   //get all delete links (Note the class I gave them in the HTML)
   $(".delete").click(function() {
       return confirm("Are you sure you want to delete this ride? This action cannot be undone");
   });
});
	
</script>	
<div class="breadcrump">
	<li><a href = "<?php echo base_url().'welcome'?>">Home &raquo;</a></li>
	<li><a href = "<?php echo base_url().'user/profile/'.$this->session->userdata('username'); ?>">Profile &raquo;</a></li>
	<li><a href = "<?php $_SERVER['SERVER_NAME'] . '/' . $_SERVER['REQUEST_URI']; ?>">Edit profile</a></li>
</div>	
<div id="content">
	
	<div id = "profile">
		<?php foreach ($profile as $row): ?>
		<div class = "panel">
		<div id="image_wraper">
		<img class="profile_img" src = "<?= $row->image;?>" href = "#"></img>
		</div> <!-- Image Wrapper end -->
		<ul class = "panel_user_details">
		<li class ="age"><?= $row->dob; ?></li>
		<li class="location"><?= $row->user_location; ?></li>
		<li class="member_since"><?= $row->regdate ?></li>
		<li class="last_login">Last Loging : 12 mins ago</li>
		</ul>
		</div> <!-- Panel End -->
		<div id = "profile_data">
		<div id="name_banner"><?php echo $row->firstname. " ".$row->lastname; ?></div>
		
		<?php echo form_open_multipart('user/update/'.$user) ?>
		<div id="user_information">
		
		<table id = "user_information_table">
			<tr>
				<td><span>First name</span></td>
				<td><li><input class="text_user_info" name= "usr_frst_name" value = "Alok" /></li></td>
			</tr>
			<tr>
				<td><span>Second name</span></td>
				<td><li><input class="text_user_info" name= "usr_scnd_name" value = "Babu" /></li></td>
			</tr>
			<tr>
				<td><span>About me</span></td>
				<td><li><textarea rows="2" class = "ta_about_me" name="usr_abt_me"><?= $row->user_about; ?></textarea></li></td>
			</tr>
			<tr>
				<td><span>Work</span></td>
				<td><li><input class="text_user_info" name= "usr_work" value = "<?= $row->user_work; ?>" /></li></td>
			</tr>
			<tr>
				<td><span>Education</span></td>
				<td><li><input class="text_user_info" name= "usr_edu" value = "<?= $row->user_education; ?>" /></li></td>
			</tr>
			<tr>
				<td><span>My car</span></td>
				<td><li><input class="text_user_info" name= "usr_car" value = "<?= $row->car_name; ?>" /></li></td>
			</tr>
			<tr>
				<td><span>Birthdate</span></td>
				<td><li><input id = "dob" class="text_user_info" name= "usr_dob" value = "<?= $row->dob; ?>" /></li></td>
			</tr>
			<tr>
				<td><span>Mobile</span></td>
				<td><li><input  class="text_user_info" name= "usr_mob" value = "<?= $row->phone; ?>" /></li></td>
			</tr>
			<tr>
				<td><span>Gender</span></td>
				<td><li><select name="usr_gender">
					<option>Male</option>
					<option>Female</option>
					<option>Other</option>
				</select>
				</td>
			</tr>
			<tr>
				<td><span>Location</span></td>
				<td><li><input class="text_user_info" id="usr_location" name= "usr_location" value = "<?= $row->user_location; ?>" /></li></td>
			</tr>
			<tr>
				<td>
					<span>Upload photo</span>
				</td>
				<td><input type="file" name="usr_img" size="20" /></td>
			</tr>
			<tr style = "padding-top:34px; display: block;">
				<td><input class = "button" type="submit" value = "update"/></td>
			</tr>

		</table>	
		</div><!-- end of user information -->
		</form>
		<!-- <span><a href = "<?php echo base_url().'user/edit/'.$user;?>">edit profile</a></span> -->
		</div> <!-- end of profile data -->
		

		<?php endforeach; ?>
		




</div> <!-- end profile -->
<?//print_r($drive_data); ?>

<style type = "text/css">
	
	.err
	{
		color: #CD0A0A;
	    font-size: 12px;
	    line-height: 16px;
	    padding-left: 540px;
	    padding-top: 64px;
	
</style>

		<div id = "error" class = "err">
			<?php echo validation_errors(); ?>
			<!-- <li class="registration_error"><?php echo form_error('usr_frst_name');?></li>
			<li class="registration_error"><?php echo form_error('usr_scnd_name');?></li>
			<li class="registration_error"><?php echo form_error('usr_abt_me');?></li>
			<li class="registration_error"><?php echo form_error('usr_work');?></li>
			<li class="registration_error"><?php echo form_error('usr_edu');?></li>
			<li class="registration_error"><?php echo form_error('usr_car');?></li>
			<li class="registration_error"><?php echo form_error('usr_dob');?></li>	
			<li class="registration_error"><?php echo form_error('usr_gender');?></li>
			<li class="registration_error"><?php echo form_error('usr_mob');?></li>
			<li class="registration_error"><?php echo form_error('usr_location');?></li>	 -->	
		</div>

</div> <!-- contents -->
	


<?php $this->load->view('footer'); ?>
