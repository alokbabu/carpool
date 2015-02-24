<?php $this->load->view('header'); ?>
<?php 
$user = $this->session->userdata('username');
$username = $this->uri->segment(3, 0);
$firstname = $this->session->userdata('firstname');
$lastname = $this->session->userdata('lastname');
 ?>
<style>
	
	.status_message
	{
		font-size : 12px;
		color : #696969;
	}
	
	#profile li
	{
		    color: #969696;
		    font-family: Arial;
		    font-size: 12px;
		    list-style: none outside none;
		    padding-bottom: 8px;
	}
	
	.float-left
	{
		float:left;
		clear:both;
	}
	
	#name
	{
		color: #696969;
	    font-size: 18px;
	    padding-bottom: 8px;
	}
	
	
	.profile_img
	{
		border: 1px solid #DADADA;
	    float: left;
	    height: 120px;
	    margin: 13px 13px 100px;
	    padding: 4px;
	}
	
	
	#profile_data
	{
		padding: 12px;
		float: left;
		width : 420px;
	}
	
	
	#profile span
	{
		color : #666666;
    	font-size: 12px;
	}
	
	#profile_address
	{
		padding-top: 35px;
	}
	
	#profile
	{
		border-bottom: 1px solid #C9C9C9;
		padding-bottom: 220px;
		margin-bottom: 30px;
	}
	
	#my_rides
	{
		height : 200px;
	}
	
	#content table
	{
		margin:0px;
		padding:0px;
		width: 100%;
		background: none repeat scroll 0 0 #FFE58F;
	}
	
	#content table td
	{
	 
	    font-size: 12px;
	    padding: 14px;
	    text-align: center;
	}
	
	#content table th
	{
		 background: none repeat scroll 0 0 #FFFFFF;
	    color: #707070;
	    font-size: 12px;
	    height: 0;
	    padding: 4px;
	    text-align: center;
	}
		
	#my_drives
	{
		padding-bottom : 60px;
	}
	
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
	<li><a href = "<?php echo base_url().'user/profile/'.$this->session->userdata('username'); ?>">Profile &raquo;</a></li>
	<li><a href = "<?php $_SERVER['SERVER_NAME'] . '/' . $_SERVER['REQUEST_URI']; ?>">User rides</a></li>
</div>
	
<div id="content">
	<a style = "font-size : 12px;" href = "<?php echo base_url().'user/profile/'.$username?>">&larr; back to my profile</a>
	<div id = "profile">
		<?php foreach ($profile as $row): ?>
		<div id="image_wraper">
		<img class="profile_img" src = "<?= $row->image;?>" href = "#"></img>
		</div>
		<div id = "profile_data">
		<div id="name"><?php echo $row->firstname. " ".$row->lastname; ?></div>
		<!-- <span>Status Message</span><li>Hello, I am <?php echo $this->session->userdata('firstname'); ?>. Ass gas or trash. No one rides for free.</li> -->
		<span>Gender:</span><li><?php echo $row->gender; ?></li>
		<span>Birthday:</span><li><?php echo $row->dob; ?></li>
		<span>Contact:</span><li><?php echo $row->phone; ?></li>
		<span>Email:</span><li><?php echo $row->email; ?></li>
		<?php 
			if($user == $username)
			{
				echo "<span><a href = ".base_url().'user/edit/'.$user.">edit profile</a></span>";
			}
			else 
			{
				echo "";
			}
		?>
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

<!-- Zimride -->
<div id = "name">My rides</div>
<div id="results">
     <div class="ride_list">
       <?php foreach ($ride_data as $row): ?>
       <a href = "<?php echo base_url()."ride/viewride?ride=".$row->rideid;?>">
       <h3 class="headline ">Departing <em><?= $row->depart_date?></em> <span>&mdash; <?php $date = $row->depart_date;   $extended_date = date('l, F Y', strtotime($date)); echo $extended_date; ?></span></h3>     
          <div class="entry">
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
        <h3><span class="inner"><?= $row->source?><span class="<?=$trip_type;?>"></span><?= $row->destination?></span></h3>
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
</div> <!-- end results -->

<?php echo $this->pagination->create_links();?>		


<!-- Zimride -->







</div> <!-- contents -->
	


<?php $this->load->view('footer'); ?>
