<?php $this->load->view('header'); ?>
 
   <body style="font-family: Arial; font-size: 12px;">
   <script type="text/javascript" 
           src="http://maps.google.com/maps/api/js?sensor=false"></script>
   	<?php 
	foreach ($data as $row) 
	{
		$source = $row->source;
		$destination = $row->destination;
	}
	?>
	
<div class="breadcrump">
	<li><a href = "<?php echo base_url().'Welcome'?>">Home &raquo;</a></li>
	<li><a href = "<?php echo base_url().'ride/search?source=&destination=&date=&submit=search&view=list' ?>">Search Results &raquo;</a></li>
	<li><a href = "<?php $_SERVER['SERVER_NAME'] . '/' . $_SERVER['REQUEST_URI']; ?>">Ride</a></li>
</div>

   <div id = "content">
   	<a href = "<?php echo base_url()."/welcome" ?>">&larr; Back to home</a>
   	<div id = "ride_heading">
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
   	<h3><span class="inner"><?= $source?><span class="<?=$trip_type;?>"></span><?= $destination?></span></h3>

   	</div>
   <div id = "map_wraper"style="width: 600px; overflow:hidden">
   	<div id = "map_header" style = "width:600px;">
   	   	<!-- Depart date -->
   	<h3 class="inner ">Departing <em><?= $row->depart_date?></em> <span>&mdash; <?php $date = $row->depart_date;   $extended_date = date('l, F Y', strtotime($date)); echo $extended_date; 
     		
     		if($row->seats == "")
			{
				echo "";
			
			}
			else
				{
					echo "&nbsp; &nbsp; &nbsp; Seats available : ".$row->seats;
				}
     		
     		?>
     		
    </span></h3>
    <!-- Depart date -->
   	
	<h4><?php if($row->return_date != NULL){echo "Return : ". $row->return_date."&nbsp; &nbsp; / &nbsp;";}?> Departs <?=$row->depart_time;?> &nbsp; / &nbsp; Smoker : <?=$row->smoker;?>  </h4>
    <h4>Posted on : <?= $row->post_date; ?> </h4>
    <span class = "note"><?= $row->note; ?></span>
   	</div>
     <div id="map" style="width: 600px; height: 350px;"></div> 
     <!-- <div id="panel" style="width: 300px; float: right;"></div>  -->
     <div id = "map_footer">
     	<h3 class="inner ">Departing <em><?= $row->depart_date?></em> <span>&mdash; <?php $date = $row->depart_date;   $extended_date = date('l, F Y', strtotime($date)); echo $extended_date; 
     		
     		if($row->seats == "")
			{
				echo "";
			
			}
			else
				{
					echo "&nbsp; &nbsp; &nbsp; Seats available : ".$row->seats;
				}
     		
     		?>
     		
     		</span></h3>
     	
     </div>
   </div>
      	<?php foreach ($data as $row) ?>
   <div id = "user_profile">
   <div id = "user_profile_inner">
   	<!-- <img id = "profile_img_view_ride" style = "height: 58px; margin: 0 32px 400px 16px;" src = "http://3.bp.blogspot.com/_QP-Sq0tCmv4/S3YQg9vbcXI/AAAAAAAAGTQ/2zuSk6HIBk4/s320/facebook.jpg" href = "#"></img> -->
   	<a href = "<?php echo base_url()."user/profile/".$row->username ?>">
   	<div class="userpic" style = "margin-bottom:400px; margin-right : 32px;">
               <div class="username"><?=$row->firstname." ".$row->lastname;?></div> 
                <img src="<?= $row->image;?>" alt="Profile Picture">
                 <span class="passenger"></span>
    </div> <!-- end of user pic -->
    </a>
    <?php 
    if ($row->seats == "")
	{
		$ride_type = "Passenger";
		$ride_class = "ride_type_passenger";
	}
	else 
	{
		$ride_type = "Driver";	
		$ride_class = "ride_type_driver";
	}
    
    ?>
    <div class = "<?=$ride_class?>"><?=$ride_type;?></div>
   <!--  <h3><?=$ride_type;?></h3> -->
   	<span>Name</span>
   	<li><?= $row->firstname. " ".$row->lastname ?></li>
   	<span>Birthday</span>
   	<li><?=$row->dob?></li>
   	<span>Gender</span>
   	<li><?=$row->gender?></li>
   	<!-- <span>Community</span>
   	<li>Christian</li> -->
   	<span>Smoker</span>
   	<li><?=$row->smoker?></li>
   	<span>Contact</span>
   	<li><?=$row->phone?></li>
   	<span>Email</span>
   	<li><?=$row->email?></li>
<!--     <span>Verifications</span>
    <li><?php if($this->session->userdata('is_fb_user')) { echo "&#10004; Connected via Facebook";}?></li> -->
   </div><!-- end of user_profile_inner -->
   </div>
   <div id = "content_bottom"></div>
	</div> <!-- end of content -->

	<?php 
	foreach ($data as $row) 
	{
		$source = $row->source;
		$destination = $row->destination;
	}
	
	//echo $destination. ' '.$source;
	?>
   <script type="text/javascript"> 

     var directionsService = new google.maps.DirectionsService();
     var directionsDisplay = new google.maps.DirectionsRenderer();

     var map = new google.maps.Map(document.getElementById('map'), {
       zoom:8,
       mapTypeId: google.maps.MapTypeId.ROADMAP
     });

     directionsDisplay.setMap(map);
     directionsDisplay.setPanel(document.getElementById('panel'));

     var request = {
       origin: '<?php echo $source;?>', 
       destination: '<?php echo $destination;?>',
       travelMode: google.maps.DirectionsTravelMode.DRIVING
     };

     directionsService.route(request, function(response, status) {
       if (status == google.maps.DirectionsStatus.OK) {
         directionsDisplay.setDirections(response);
       }
     });
   </script> 
   
<?php $this->load->view('footer'); ?>