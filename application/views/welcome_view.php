<?php $this->load->view('header'); ?>

<!--Google Places -->
<script src="http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places" type="text/javascript"></script>
<script type="text/javascript">
   function initialize() {
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
<!--Google Places -->

<!--Date Picker -->

<script>
 $(document).ready(function() {
 $("#date").datepicker({ dateFormat: 'yy-mm-dd', minDate: 0, maxDate: "+12M +10D", numberOfMonths: 1, showAnim: "slideDown"});
  });
</script>


<div id="content" style = "height:400px; box-shadow: none;">
<div id="postaride">
<!-- <form id="form1" name="form1" method="post" action="<?php echo base_url()."post"; ?>">
      <input class="button" type="submit" name="button" id="postride" value="Post A ride" />
</form> -->


</div><!--ends postaride div here-->

	<div id = "logo">
    <!-- <img src = "<?php echo base_url()."/images/carpool-logo.png";?>"/> -->
    </div>

<form id = "search" name="frm_search" method = "get" action = "<?php echo base_url()."ride/search"?>">
<!-- <div id="contentform"> -->
<table id = "search_table" width="200" border="0" cellpadding="2" cellspacing="10">
  <tr>  
    <td>
    	<label class = "pin_start" for="source" style = "margin:0px;"></label>
    	<input name="source" id="source" type="text" size="50" placeholder="From" autocomplete="on">
    </td>
  </tr>
  <tr>
 
  <td>
  	<label name = "source" class = "pin_end" for="destination" style = "margin:0px;"></label>
  	<input name = "destination" id="destination" type="text" size="50" height="50" placeholder="To" autocomplete="on">
  </td>
  </tr>
  
  <tr>   
   <td>
   	<label class = "calendar" for="date" style = "margin:0px;"></label>
   	<input class="date"  id="date" placeholder="Date" type = "text" name ="date" maxlength = "20" value='<?= date('Y-m-d')?>'>
   </td>
  </tr>  
  
      <tr>
      	<td>
      		<input class="button" type="submit" name="submit" value="search"/>
      		<input type= "hiddden" name = "view" value="list" style="visibility: hidden; position: absolute"/>
      		</form>
      		<form id="frmPostARide" name="postride" method="post" action="<?php echo base_url()."post"; ?>">
      		<input style= "float:right; top:-26px; position: relative;" class="button" type="submit" name="button" id="postride" value="Post A ride" /></form>
      		
      	</td>
      	<td></td>
      </tr>
</table>
</div> <!-- end of search wraper -->

<!-- </div>  --><!--ends contentform-->
</div> 
<!--ends content div here-->
<?php $this->load->view('footer'); ?>
