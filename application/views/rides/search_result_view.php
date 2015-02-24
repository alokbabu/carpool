<?php $this->load->view('header.php'); ?>
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
<?php
		$source = urldecode($_GET['source']);
		$destination = urldecode($_GET['destination']);
		$date = urldecode($_GET['date']);
?>

<div class="breadcrump">
	<li><a href = "<?php echo base_url().'Welcome'?>">Home &raquo;</a></li>
	<li><a href = "<?php $_SERVER['SERVER_NAME'] . '/' . $_SERVER['REQUEST_URI']; ?>">Search results</a></li>
</div>

<div id = "content">
<div id = "search_form">
	<form name="frm_search" method = "get" action="<?php echo base_url()."ride/search"?>">
		<label class = "pin_start" for="source"></label>
		<input name = "source" id = "source" style = "width: 200px; float : left; padding-left: 22px; margin-right: 12px;" type="text" size="50" height="50" placeholder="To" autocomplete="on" value = "<?=$source;?>"/>
		<label class = "pin_end" for="destination"></label>
		<input name="destination" id = "destination" style = "width: 200px; float : left; padding-left: 22px; margin-right: 12px;" type="text" size="50" height="50" placeholder="From" autocomplete="on" value = "<?=$destination;?>"/>
		<label class = "calendar" for="date"></label>
		<input name = "date" class="date" style = "width: 200px; float : left; padding-left: 22px; margin-right: 12px;" id="date" placeholder="Date" type = "text" name ="date" maxlength = "20" value='<?=$date; ?>'  >
		<input class="button" type="submit" name="submit" value="search"/>
		<input type= "hiddden" name = "view" value="list" style="visibility: hidden; position: absolute"/>
		<?php
		function get_current_url()
		{
			$pageURL = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
			if ($_SERVER["SERVER_PORT"] != "80")
			{
			    $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
			} 
			else 
			{
			    $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
			}
			return $pageURL;
		}
		//echo get_current_url();
		$view_type = $_GET['view'];
		if($view_type == "detailed")
		{
			$cur_url = get_current_url();
			$switch = str_replace('view=detailed', 'view=list', $cur_url);
		}
		else
			{
				$cur_url = get_current_url();
				$switch = str_replace('view=list', 'view=detailed', $cur_url);
			}
		?>
		<a href = "<?=$switch?>">Switch View</a>
		<!-- <input type= "submit" name = "view" value="" class = "view"/> -->
		
	</form>
	
</div> <!-- end of search form -->


<?php 

$view = $_GET['view'];

if($view == 'list')
{
	require('search_list_view.php');
}
else if ($view == "detailed")
{
	require('search_detail_view.php');
}
else 
{
	require('search_list_view.php');
}
?>

		
	
</div> <!-- end of content -->


<?php $this->load->view('footer.php'); ?>