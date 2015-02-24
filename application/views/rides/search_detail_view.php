<div id="results" style = "width:920px;">
     <div class="ride_list">  
     	<?php foreach ($data as $row): ?>
     	<? $depart_date = $row->depart_date;?>
     	<? endforeach; ?>
     	<h3 class="firstpost" style = "width : 922px;">Departing <em><?=$depart_date; ?></em><span> <?=date('l, F Y', strtotime($depart_date)); ?></span></h3>  
       <?php foreach ($data as $row): ?>
       	<a href = "<?php echo base_url()."ride/viewride?ride=".$row->rideid;?>">    
          <div class="entry">
          	
          	<?php 
          		if($row->seats == '')
				{
					echo "<div class='passenger_box'>
                    <p><span class='icon'></span> $row->firstname is a <strong>passenger</strong></p>
                    </div>";
				}
				else 
				{
					echo " <div class='price_box'>
                <div class='seats'>
                    <span class='count'>$row->seats</span>
                        <span class='left'>seats left</span>
                 </div>
                <p><b>$$row->amount</b> / seat</p>
              </div>";
				}
          	
          	?>
          	
             <div class="userpic">
               <div class="username"><?php echo $row->firstname." ".$row->lastname; ?></div> 
                <img alt="Profile Picture" src="<?=$row->image?>">
                 <span class="passenger"></span>
                </div>
        <div class="inner_content">
        		<?php 
        	// Changes the Class type
        	if($row->return_date == NULL)
			{
				$trip_type = "trip_type one_way";
			}
			else
			{
				$trip_type = "trip_type two_way";	
			}
        	?>
        <h3><span class="inner"><?= $row->source ?><span class="<?=$trip_type;?>"></span><?= $row->destination ?></span></h3>
        <h4><?php if($row->return_date != NULL){echo "Return : ". $row->return_date."&nbsp; &nbsp; / &nbsp;";}?> Departs <?= $row->depart_time ?></h4>
    </div>
   
</div>  
   

<?php endforeach; ?>
</div>
</a> 
</div> <!-- end of results -->
	<?php echo $this->pagination->create_links();?>	