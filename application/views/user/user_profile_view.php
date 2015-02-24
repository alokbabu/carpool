<?php $this->load->view('header'); ?>
<?php 
$user = $this->session->userdata('username');
$username = $this->uri->segment(3, 0);
$firstname = $this->session->userdata('firstname');
$lastname = $this->session->userdata('lastname');



 ?>
<style>

	
</style>	

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
	<li><a href = "<?php $_SERVER['SERVER_NAME'] . '/' . $_SERVER['REQUEST_URI']; ?>">Profile</a></li>
</div>	
<div id="content">

	
	<div id = "profile">
		<?php foreach ($profile as $row): ?>
		<div class = "panel">
		<div id="image_wraper">
		<img class="profile_img" src = "<?= $row->image;?>" href = "#"></img>
		</div> <!-- Image Wrapper end -->
		<ul class = "panel_user_details">
		<li class="age"><strong>Age :</strong><?= $row->dob; ?></li>
		<li class="location"><strong>Location</strong><?= $row->dob; ?></li>
		<li class="member_since"><strong>Member since</strong><?= $row->regdate ?></li>
		<li class="last_login"><strong>Last Login</strong> : 12 mins ago</li>
		</ul>
		</div> <!-- Panel End -->
		<div id = "profile_data">
		<div id = "edit_userinfo">
			<?php 
				if($user == $username && $this->session->userdata('is_fb_user') == 0)
				{
					echo "<a href = ".base_url().'user/edit/'.$user."><span class='userinfo_edit'>edit profile</span></a>";
				}
				if ($this->session->userdata('is_fb_user') == 1)
				{
					echo "<div style = 'color:#696969; font-size:12px;'>Connected with Facebook</div>";
				}
			?>
		</div><!-- end of edit info-->
		<div id="name_banner"><?php echo $row->firstname. " ".$row->lastname; ?></div>
		<!-- <span>Status Message</span><li>Hello, I am <?php echo $this->session->userdata('firstname'); ?>. Ass gas or trash. No one rides for free.</li> -->
		<div id="user_information">
		
		<table id = "user_information_table">
			<tr>
				<td><span>About me</span></td>
				<td><li><?= $row->user_about; ?></li></td>
			</tr>
			<tr>
				<td><span>Work</span></td>
				<td><li><?= $row->user_work; ?></li></td>
			</tr>
			<tr>
				<td><span>Education</span></td>
				<td><li><?= $row->user_education; ?></li></td>
			</tr>
			<tr>
				<td><span>Location</span></td>
				<td><li><?= $row->user_location; ?></li></td>
			</tr>
			<tr>
				<td><span>My car</span></td>
				<td><li><?= $row->car_name; ?></li></td>
			</tr>

		</table>	
		</div><!-- end of user information -->
		<!-- <span><a href = "<?php echo base_url().'user/edit/'.$user;?>">edit profile</a></span> -->
		</div> <!-- end of profile data -->

		<?php endforeach; ?>
		
		<!-- <div id = "profile_address">
			<span>Address</span>
			<li>House No</li>
			<li>Street Address</li>
			<li>Street Address 2</li>
			<li>City</li>
		</div> --><!--  end of profile address -->



</div> <!-- end profile -->
<?//print_r($drive_data); ?>
<div id = "name">Recent drives</div>
<!-- Zimride -->
<div id="results">
     <div class="ride_list">
       <?php foreach ($drive_data as $row): ?>
       	<a href = "<?php echo base_url()."ride/viewride?ride=".$row->rideid;?>">
       <h3 class="headline ">Departing <em><?= $row->depart_date?></em> <span>&mdash; <?php $date = $row->depart_date;   $extended_date = date('l, F Y', strtotime($date)); echo $extended_date; ?></span></h3>     
          <div class="entry">
          	 <div class="price_box">
                <div class="seats">
                    <span class="count"><?= $row->seats;?></span>
                        <span class="left">seats left</span>
                 </div>
                <p><b><?=$row->amount;?></b> / seat</p>
              </div>
             <div class="userpic">
               <div class="username"><?= $row->firstname." ".$row->lastname; ?></div> 
                <img alt="Profile Picture" src="<?= $row->image;?>">
                 <span class="passenger"></span>
                </div>
        <div class="inner_content">
        	<?php 
        	// Changes the Clas type
        	if($row->return_date == NULL)
			{
				$trip_type = "trip_type one_way";
			}
			else
			{
				$trip_type = "trip_type two_way";	
			}
        	?>
        <h3><span class="inner"><?= $row->source?><span class="<?php echo $trip_type;?>"></span><?= $row->destination?></span></h3>
        <h4><?php if($row->return_date != NULL){echo "Return : ". $row->return_date."&nbsp; &nbsp; / &nbsp;";}?> Departs <?=$row->depart_time;?> &nbsp; / &nbsp; Smoker : <?=$row->smoker;?>  </h4>
        <h4>Posted on : <?= $row->post_date; ?> </h4>
    </div>
</div>     
</a>
<?php 

	if($this->session->userdata('username') === $this->uri->segment(3,0))
	{
		echo "<div class = 'edit_delete'>";
		echo "<a class = 'edit' href =".base_url()."user/edit_user_ride/".$row->rideid."/drive>edit</a>";
		echo "<a class = 'delete' href =".base_url()."user/delete_user_commute/".$row->rideid."/drive>delete</a>";
		echo "</div>";
		
	}

?>

<?php endforeach; ?>

</div> <!-- end ride list -->
<a class="view_more" href = "<?php echo base_url()."user/drives/".$row->username ?>">view all drives &raquo;</a>
</div> <!-- end results -->


<!-- Zimride -->

<!-- Zimride -->
<div id = "name">Recent rides</div>
<div id="results">
     <div class="ride_list">
       <?php foreach ($ride_data as $row): ?>
       	<a href = "<?php echo base_url()."ride/viewride?ride=".$row->rideid;?>">
       <h3 class="headline ">Departing <em><?= $row->depart_date?></em> <span>&mdash; <?php $date = $row->depart_date;   $extended_date = date('l, F Y', strtotime($date)); echo $extended_date; ?></span></h3>     
          <div class="entry">
             <div class="userpic">
               <div class="username"><?=  $row->firstname." ".$row->lastname; ?></div> 
                <img alt="Profile Picture" src="<?= $row->image;?>">
                 <span class="passenger"></span>
                </div>
        <div class="inner_content">
      		<?php 
        	// Changes the Clas type
        	if($row->return_date == NULL)
			{
				$trip_type = "trip_type one_way";
			}
			else
			{
				$trip_type = "trip_type two_way";	
			}

        	?>
        <h3><span class="inner"><?= $row->source?><span class="<?=$trip_type;?>"></span><?= $row->destination?></span></h3>
        <h4><?php if($row->return_date != NULL){echo "Return : ". $row->return_date."&nbsp; &nbsp; / &nbsp;";}?>  Departs <?=$row->depart_time;?> &nbsp; / &nbsp; Smoker : <?=$row->smoker;?>  </h4>
        <h4>Posted on : <?= $row->post_date; ?> </h4>
    </div>
</div>     
</a>

<?php 

	if($this->session->userdata('username') === $this->uri->segment(3,0))
	{
		echo "<div class = 'edit_delete'>";
		echo "<a class = 'edit' href =".base_url()."user/edit_user_ride/".$row->rideid."/drive>edit</a>";
		echo "<a class = 'delete' href =".base_url()."user/delete_user_commute/".$row->rideid."/drive>delete</a>";
		echo "</div>";
		
	}

?>

<?php endforeach; ?>
</div> <!-- end ride list -->
<a class="view_more" href = "<?php echo base_url()."user/rides/".$this->uri->segment(3,0); ?>">view all rides &raquo;</a>
</div> <!-- end results -->



<!-- Zimride -->







</div> <!-- contents -->
	


<?php $this->load->view('footer'); ?>
