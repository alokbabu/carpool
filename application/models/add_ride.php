<?php

	class Add_ride extends CI_Model
		{
			
			public function add_rider($source,$destination,$depart_date,$depart_time,$return_date,$return_time,$smoker,$note,$amount)
			{
			
				$query = "INSERT INTO ride (source,destination,depart_date,depart_time,return_date,return_time,smoker,note,amount,post_date) VALUES(?,?,?,?,?,?,?,?,?,CURDATE())";
				$this->db->query($query,array($source,$destination,$depart_date,$depart_time,$return_date,$return_time,$smoker,$note,$amount));
				
			}
			
			
			//Inserting foreign keys into table rider
			public function add_rider_rider($user_id)
			{
				$ride_id = $this->db->insert_id();
				$data = array ('rideid' => $ride_id, 'userid' => $user_id);
				$this->db->insert('rider',$data);
			}
			
			//inserting foregin_key into table driver
			public function add_rider_driver($user_id,$seats)
			{
				$ride_id = $this->db->insert_id();
				$data = array ('rideid' => $ride_id, 'userid' => $user_id, 'seats' => $seats);
				$this->db->insert('driver',$data);
			}
			
			public function delete_commute($rideid)
			{
	
				$query_delete_rider = "DELETE FROM rider WHERE rideid = ?";
				$query_result_rider = $this->db->query($query_delete_rider,array($rideid));
				
				$query_delete_driver = "DELETE FROM driver WHERE rideid = ?";
				$query_result_driver = $this->db->query($query_delete_driver,array($rideid));
				
				$query_delete_ride = "DELETE FROM ride WHERE rideid =?";
				$query_result_ride = $this->db->query($query_delete_ride,array($rideid));
			}
			
			public function get_username_by_ride_id($rideid)
			{
				$get_username_query = "select  user.username FROM ride

						LEFT JOIN rider on ride.rideid = rider.rideid
						LEFT JOIN driver on ride.rideid = driver.rideid	
						LEFT JOIN user on user.userid = driver.userid or rider.userid = user.userid
						WHERE ride.rideid = ?;";
						
				$query_result = $this->db->query($get_username_query,array($rideid));
				return $query_result;
								
			}
			
			public function update_ride_rider($source,$destination,$depart_date,$depart_time,$return_date,$return_time,$smoker,$amount,$note,$rideid)
			{
				
				$query = "update ride set source = ?, destination = ?, depart_date = ?, depart_time = ?, return_date = ?, return_time = ?,
				note = ?, amount = ?, smoker = ?, post_date = CURDATE() WHERE rideid = ?";
				$query_result = $this->db->query($query,array($source,$destination,$depart_date,$depart_time,$return_date,$return_time,$note,$amount,$smoker,$rideid));		
			}
			
			public function update_ride_driver_seats($seats,$rideid)
			{
				$query = "UPDATE driver SET seats = ? WHERE rideid = ?";
				$query_result = $this->db->query($query,array($seats,$rideid));
			}
			
			public function change_ride_from_driver_to_ride($rideid,$userid)
			{
				//delete drive and insert to ride
				$query = "DELETE from driver WHERE rideid = ? and userid = ?";
				$query_result = $this->db->query($query,array($rideid,$userid));
				$query_insert_rider = "INSERT INTO rider VALUES(?,?)";
				$query_insert_result = $this->db->query($query_insert_rider,array($rideid,$userid));
				
				
			}
			
			public function change_ride_from_ride_to_drive($rideid,$userid,$seats)
			{
				$query = "DELETE from rider WHERE rideid = ? and userid = ?";
				$query_result = $this->db->query($query,array($rideid,$userid));
				$query_insert_driver = "INSERT INTO driver VALUES(?,?,?)";
				$query_insert_results = $this->db->query($query_insert_driver,array($rideid,$userid,$seats));
				
			}
		
		}
