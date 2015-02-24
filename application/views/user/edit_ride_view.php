<?php $this->load->view('header'); ?>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery/ui.core.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery/ui.spinner.js"></script>

<!----------- CSS Spinner ------------->
<style type="text/css">

.ui-spinner {
  	background: url("images/spinner-bg.gif") repeat-x scroll left bottom #FEFEFE;
    border: 1px solid #C9C9C9;
    display: block;
    overflow: hidden;
    padding: 0 6px;
    position: relative;
    width: 18em;
}

.ui-spinner-disabled {
	background: #F4F4F4;
	color: #CCC;
}

.ui-spinner-box {
    background: none repeat scroll 0 0 transparent;
    border: medium none;
    color: #898989;
    float: left;
    font-size: 16px;
    height: 100%;
    padding: 4px 4px 4px 8px;
}

.ui-spinner-up,
.ui-spinner-down {
	width: 10%;
	height: 50%;
	font-size: 0.5em;
	padding: 0;
	margin: 0;
	z-index: 100;
	text-align: center;
	vertical-align: middle;
	position: absolute;
	right: 0;
	cursor: default;
	border: 1px solid #999;
	border-right: none;
	border-top: none;
}

.ui-spinner-down {
	bottom: 0;
	border-bottom: 0;
}

.ui-spinner-pressed {
	background: #FEFEFE;
}

.ui-spinner-list,
.ui-spinner-listitem {
	margin: 0;
	padding: 0;
}

</style>



<!------------ CSS  Spinner------------->

<!------------ Java Sript  Spinner------------->
<script type="text/javascript">
$(function(){

	var itemList = [];

	var opts = {
		's1': {decimals:2},
		's2': {stepping: 0.25},
		's3': {currency: '$'},
		's4': {},
		's5': {
			//
			// Two methods of adding external items to the spinner
			//
			// method 1: on initalisation call the add method directly and format html manually
			init: function(e, ui) {
				for (var i=0; i<itemList.length; i++) {
					ui.add('<a href="'+ itemList[i].url +'" target="_blank">'+ itemList[i].title +'</a>');
				}
			},

			// method 2: use the format and items options in combination
			format: '%(title) <a href="%(url)" target="_blank">&raquo;</a>',
			items: itemList
		}
	};

	for (var n in opts)
		$("#"+n).spinner(opts[n]);

	$("button").click(function(e){
		var ns = $(this).attr('id').match(/(s\d)\-(\w+)$/);
		if (ns != null)
			$('#'+ns[1]).spinner( (ns[2] == 'create') ? opts[ns[1]] : ns[2]);
	});

});
</script>
<!------------ Javascript Spinner------------->



<!--Google Places -->
<script src="http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places" type="text/javascript"></script>
<script type="text/javascript">

   function initialize(){
      var input = document.getElementById('source');
      var input2 = document.getElementById('destination');
     var options = 
     {
        types: ['(cities)'],
        componentRestrictions: {country: 'us'}
     }
      var autocomplete = new google.maps.places.Autocomplete(input,options); // enable to provide country filtering
     // var autocomplete = new google.maps.places.Autocomplete(input);
     // var autocomplete2 = new google.maps.places.Autocomplete(input2); // enable to remove country filtering
       var autocomplete2 = new google.maps.places.Autocomplete(input2,options); 
   }
      google.maps.event.addDomListener(window, 'load', initialize);
 
 
</script>

<!--Date Picker -->

<script>
 $(document).ready(function() {
 $("#departdate").datepicker({ dateFormat: 'yy-mm-dd', minDate: 0, maxDate: "+12M +10D", numberOfMonths: 1, showAnim: "slideDown"});
  });
  
 $(document).ready(function() {
 $("#returndate").datepicker({ dateFormat: 'yy-mm-dd', minDate: 0, maxDate: "+12M +10D", numberOfMonths: 1, showAnim: "slideDown"});
  });
</script>

<!-- Toggle no of seats -->
<script type="text/javascript">
	
	$(function() {
  $("#ddcommutetype").change(function() {
    ToggleDropdown();
  });
  ToggleDropdown(); // Done to ensure correct hiding/showing on page reloads due to validation errors
});

function ToggleDropdown() {
  if ($("#ddcommutetype").val() == "driver") {
    $("#ddseats").show();
     $("#labelseats").show();
  } else {
    $("#ddseats").hide();
     $("#labelseats").hide();
  }
}; 
	

$(document).ready(function() {
 $("#cbnoreturn").click(function() {
   if ($(this).is(":checked")) {
      $("#noreturn").prop("disabled", true);  
       $("#returndate").prop("disabled", true);  
   } else {
       $("#noreturn").prop("disabled", false);
        $("#returndate").prop("disabled", false);  
   }
 });
});

$(document).ready(function() {
	if ($("#cbnoreturn").is(":checked")) 
	{
	       $("#noreturn").prop("disabled", true);
           $("#returndate").prop("disabled", true); 
    }
    else
    {
    	 $("#noreturn").prop("disabled", false);
         $("#returndate").prop("disabled", false); 
    }
});



</script>



<?php
$departdate= array(
				'anytime'	=> 'anytime',
				'12am-8am'	=> 'early (12am-8am)',
				'8am-12am'	=> 'morning (12am-8am)',
				'12pm-5pm' => 'afternoon(12pm-5pm)',
				'5pm-9pm'	=>'evening(5pm-9pm)',
				'01:00AM'	=> '01:00AM',
				'02:00AM'	=> '02:00AM',
				'03:00AM'	=> '03:00AM',
				'04:00AM'	=> '04:00AM',
				'05:00AM'	=> '05:00AM',
				'06:00AM'	=> '06:00AM',
				'07:00AM'	=> '07:00AM',
				'08:00AM'	=> '08:00AM',
				'08:00AM'	=> '08:00AM',
				'09:00AM'	=> '09:00AM',
				'10:00AM'	=> '10:00AM',
				'11:00AM'	=> '11:00AM',
				'noon'		=> 'noon',
				'01:00PM'	=> '01:00PM',
				'02:00PM'	=> '02:00PM',
				'03:00PM'	=> '03:00PM',
				'04:00PM'	=> '04:00PM',
				'05:00PM'	=> '05:00PM',
				'06:00PM'	=> '06:00PM',
				'07:00PM'	=> '07:00PM',
				'08:00PM'	=> '08:00PM',
				'08:00PM'	=> '08:00PM',
				'09:00PM'	=> '09:00PM',
				'10:00PM'	=> '10:00PM',
				'11:00PM'	=> '11:00PM',
							);	
							

$returndate= array(
				'anytime'	=> 'anytime',
				'12am-8am'	=> 'early (12am-8am)',
				'8am-12am'	=> 'morning (12am-8am)',
				'12pm-5pm' => 'afternoon(12pm-5pm)',
				'5pm-9pm'	=>'evening(5pm-9pm)',
				'01:00AM'	=> '01:00AM',
				'02:00AM'	=> '02:00AM',
				'03:00AM'	=> '03:00AM',
				'04:00AM'	=> '04:00AM',
				'05:00AM'	=> '05:00AM',
				'06:00AM'	=> '06:00AM',
				'07:00AM'	=> '07:00AM',
				'08:00AM'	=> '08:00AM',
				'08:00AM'	=> '08:00AM',
				'09:00AM'	=> '09:00AM',
				'10:00AM'	=> '10:00AM',
				'11:00AM'	=> '11:00AM',
				'noon'		=> 'noon',
				'01:00PM'	=> '01:00PM',
				'02:00PM'	=> '02:00PM',
				'03:00PM'	=> '03:00PM',
				'04:00PM'	=> '04:00PM',
				'05:00PM'	=> '05:00PM',
				'06:00PM'	=> '06:00PM',
				'07:00PM'	=> '07:00PM',
				'08:00PM'	=> '08:00PM',
				'08:00PM'	=> '08:00PM',
				'09:00PM'	=> '09:00PM',
				'10:00PM'	=> '10:00PM',
				'11:00PM'	=> '11:00PM',
				);	
							
$notes =  array (
				'name'		=> 'notes',
				'id'		=> 'notes',
				'rows'		=> '30',
				'column'	=>	'60',
				'placeholder'=> 'Enter notes - Eg : Pickup time, Pickup Location',	
				);	
				
$commute_type = array(
					'rider' => 'Passenger only',
					'driver'   => 'Willing to drive',
					);
					
$no_of_seats = array(
						'1' => '1 seat',
						'2' => '2 seats',
						'3' => '3 seats',
						'4' => '4 seats',
						'5' => '5 seats',
						'6' => '6 seats',
						'7' => '7 seats',
						'8' => '8 seats',
						'9' => '9 seats',
				
					);	
					
$no_return = array(
					'name' => 'noreturn',
					//'value' => 'noreturn',
					//'checked'=> FALSE,


				   );

$smoker = array (
					
					'Nonsmoker' => 'Nonsmoker',
					'Smoker' => 'Smoker'
				);

					
?>
<div class="breadcrump">
	<li><a href = "<?php echo base_url().'welcome'?>">Home &raquo;</a></li>
	<li><a href = "<?php echo base_url().'user/profile/'.$this->session->userdata('username'); ?>">Profile &raquo;</a></li>
	<li><a href = "<?php $_SERVER['SERVER_NAME'] . '/' . $_SERVER['REQUEST_URI']; ?>">Edit ride</a></li>
</div>
<?php foreach ($data as $row)?>
<form method="post" action="<?php echo base_url()."post/update_ride/".$row->rideid?>"/>
<div id = "content">
<div id="post_ride_table_wraper">
<table width="200" border="0" cellpadding="2" cellspacing="10">
	
	<?php 
	
		if($row->seats == "")
		{
			$ride_type = "rider";
		}
		else 
		{
			$ride_type = "driver";	
		}
	?>
	
	<tr>
		<td><span class="select_time" style = "padding:0px;">I am: 	</span> <?php $js = 'id="ddcommutetype" onChange="rider_type_change();"';  echo form_dropdown('ride_type',$commute_type,$ride_type,$js);?></td>
		<td></td>
	</tr>
  <tr>
<td><input style = "padding-left:8px;" class = "post_ride_textbox" name="txtsource" id="source" type="text" size="50" placeholder="From" autocomplete="on" value = "<?=$row->source;?>"></td>
  </tr>
  <tr><td><li class="registration_error"><?php echo form_error('txtsource');?></li></td></tr>
  <tr>
  <td><input style = "padding-left:8px;" class = "post_ride_textbox" name="txtdestination" id="destination" type="text" size="50" height="50" placeholder="To" autocomplete="on" value = "<?=$row->destination;?>"></td>
  </tr>
  <tr><td><li class="registration_error"><?php echo form_error('txtdestination');?></li></td></tr>
  <tr>
 <td>
 <input class = "post_ride_textbox" name = "txtdepartdate"  id="departdate" placeholder="Departure date" type = "text" maxlength = "20" value = "<?=$row->depart_date;?>" >
 <span class="select_time">Select depart time :	</span>
 </td>
 <td>
	<?php echo form_dropdown('txtdeparttime',$departdate,$row->depart_time,'class="postdropdown"'); ?>
 </td>
 </tr>
 <tr>
 	<td><li class="registration_error"><?php echo form_error('txtdepartdate');?></li></td>
 </tr> 
 <tr>
 <td>
 	<?php
 	if($row->return_date == "")
	{
		$checked = TRUE;
		$disabled = "disabled";
	}
	else
	{
		//echo $row->return_date;
		$checked = FALSE;
		$disabled = "enabled";
	}
 	?>
 <input class = "post_ride_textbox"  name= "txtreturndate" class="date"  id="returndate" placeholder="Return Date" type = "text" maxlength = "20" value = "<?=$row->return_date;?>" <?=$disabled?>">
 <span class="select_time">Select return time :	</span>
 </td>
 <td>
 <?php
	 $js = 'id="noreturn" class="postdropdown"';
  echo form_dropdown('txtreturntime',$returndate,$row->return_time,$js); ?>
 </td>
 </tr>
 <tr><td><li class="registration_error"><?php  echo form_error('txtreturndate');?></li></td></tr>
 <tr>
 	<td>
 		 <span style = "padding:0px;"class="select_time">No return</span><?php $js = 'id="cbnoreturn"'; echo form_checkbox($no_return,'val',$checked,$js); ?>
 	</td>
 </tr>
 <tr>
 	<td>
 		<span id = "labelseats" style= "padding : 0px;" class="select_time">Available seats  </span><?php $ddpropertes = 'id="ddseats"'; echo form_dropdown('seats',$no_of_seats,$row->seats,$ddpropertes);?>
 	</td>

 </tr>
 <tr>
 	<td>
 		<span style = "padding :0px;"class="select_time">I am a : </span><?php echo form_dropdown('smoker',$smoker,$row->smoker); ?>
 	</td>
 </tr>
 <tr><td><span style= "padding:4px 0px 12px 0px; display:block;" class="select_time">Amount : </span><input style = "width: 220px; padding: 4px 4px;" name = "amount" id = "s3" type = "text" class = "post_ride_textbox" value = "<?=$row->amount;?>" maxlength="4" ></td>
 </tr>
 <tr> <td><li class="registration_error"><?php  echo form_error('amount');?></li></td></tr>
<td><span style = "padding :0px;"class="select_time">Notes:</span>
</td>
</tr>
 <tr>
 <td>
<textarea id="notes" cols="40" rows="8" name="txtareanotes" class = "notes" ><?=$row->note;?></textarea>
 </td>
 </tr> 
 <tr><td><input id = "btnpostride" class="button" type="submit" name="submit" value="Update"/></td></tr>

</table>
</div>	<!-- end of post_ride_table_wraper -->
</div>

<?php $this->load->view('footer'); ?>
