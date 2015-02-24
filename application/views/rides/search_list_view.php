<?php foreach ($data as $row): ?>
<? $depart_date = $row->depart_date;?>
<? endforeach; ?>
<h3 class="firstpost" style = "width : 922px;">Departing <em><?=$depart_date; ?></em><span> <?=date('l, F Y', strtotime($depart_date)); ?></span></h3>
<table id = "search_results" class = "results_table">

	<thead>
		<tr>
			<th>Type</th>
			<th>From</th>
			<th>To</th>
			<th>Date</th>
			<th>Time</th>
			<th>Price</th>
			<th>Pl.Details</th>
		</tr>
		<tbody>
			<?php $x = 0; ?>
			<?php foreach ($data as $row): ?>
				<?php 
				
				$x++; 

				$class = ($x%2 == 0)? 'even': 'odd';
				
				 if($row->seats == '')
				 {
				 	$ride_type = "Rider";
				 }
				 else
				 {
					$ride_type = "Driver";
				 }
				?>
			
			<tr class = <?=$class?>>
				<td><?=$ride_type;?></td>
				<td><?=$row->source;?></td>
				<td><?=$row->destination; ?></td>
				<td><?=$row->depart_date; ?></td>
				<td><?=$row->depart_time; ?></td>
				<td>$<?=$row->amount; ?></td>
				<td><?=$row->firstname; ?></td>				
			</tr>
			<? endforeach; ?>

		</tbody>
	</thead>
</table>
<?php echo $this->pagination->create_links();?>	
