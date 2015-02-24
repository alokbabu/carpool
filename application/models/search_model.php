<?php

class Search_model extends CI_Model
{

	public function search_by_source_destination_date($source,$destination,$depart_date,$next,$per_page)
	{

		$query = "select ride.rideid, ride.source, ride.destination, ride.depart_date, ride.depart_time, 
		ride.return_date, ride.return_time, ride.smoker, driver.seats,
		ride.post_date, user.username, user.firstname, user.lastname, user.userid, user.image,ride.amount FROM ride

						LEFT JOIN rider on ride.rideid = rider.rideid
						LEFT JOIN driver on ride.rideid = driver.rideid	
						LEFT JOIN user on user.userid = driver.userid or rider.userid = user.userid
									
		WHERE ride.source = ? and ride.destination = ? AND ride.depart_date = ? LIMIT ?, ?";
		
			$query_result = $this->db->query($query,array($source,$destination,$depart_date,$next,$per_page));
			return $query_result;
		
	}
	
	public function search_all_results_today($today,$next,$per_page)
	{
		$query = "select ride.rideid, ride.source, ride.destination, ride.depart_date, ride.depart_time, 
		ride.return_date, ride.return_time, ride.smoker, driver.seats,
		ride.post_date, user.username, user.firstname, user.lastname, user.userid,user.image,ride.amount FROM ride

						LEFT JOIN rider on ride.rideid = rider.rideid
						LEFT JOIN driver on ride.rideid = driver.rideid	
						LEFT JOIN user on user.userid = driver.userid or rider.userid = user.userid
						WHERE ride.depart_date = ? LIMIT ?, ?";
						
						
		$query_result = $this->db->query($query,array($today,$next,$per_page));
		return $query_result;
	}
	//returns only source results
	public function search_by_source($source,$next,$per_page)
	{
		$query = "select ride.rideid, ride.source, ride.destination, ride.depart_date, ride.depart_time, 
		ride.return_date, ride.return_time, ride.smoker, driver.seats,
		ride.post_date, user.username, user.firstname, user.lastname, user.userid, user.image,ride.amount FROM ride

						LEFT JOIN rider on ride.rideid = rider.rideid
						LEFT JOIN driver on ride.rideid = driver.rideid	
						LEFT JOIN user on user.userid = driver.userid or rider.userid = user.userid
									
		WHERE ride.source = ? LIMIT ?, ?";
		
			$query_result = $this->db->query($query,array($source,$next,$per_page));
			return $query_result;
	}
	
	public function search_by_destination($destination,$next,$per_page)
	{
		$query = "select ride.rideid, ride.source, ride.destination, ride.depart_date, ride.depart_time, 
		ride.return_date, ride.return_time, ride.smoker, driver.seats,
		ride.post_date, user.username, user.firstname, user.lastname, user.userid,user.image,ride.amount FROM ride

						LEFT JOIN rider on ride.rideid = rider.rideid
						LEFT JOIN driver on ride.rideid = driver.rideid	
						LEFT JOIN user on user.userid = driver.userid or rider.userid = user.userid
									
		WHERE ride.destination = ? LIMIT ?, ?";
		
			$query_result = $this->db->query($query,array($destination,$next,$per_page));
			return $query_result;
	}
	
	public function search_by_date($date,$next,$per_page)
	{
		$query = "select ride.rideid, ride.source, ride.destination, ride.depart_date, ride.depart_time, 
		ride.return_date, ride.return_time, ride.smoker, driver.seats,
		ride.post_date, user.username, user.firstname, user.lastname, user.userid,user.image,ride.amount FROM ride

						LEFT JOIN rider on ride.rideid = rider.rideid
						LEFT JOIN driver on ride.rideid = driver.rideid	
						LEFT JOIN user on user.userid = driver.userid or rider.userid = user.userid
									
		WHERE ride.depart_date = ? LIMIT ?, ?";
		
			$query_result = $this->db->query($query,array($date,$next,$per_page));
			return $query_result;
	}
	
	public function get_ride_by_rideid($rideid)
	{
		$query = "select ride.rideid, ride.source, ride.destination, ride.depart_date, ride.depart_time, 
		ride.return_date, ride.return_time, ride.smoker, driver.seats,
		ride.post_date, user.username, user.firstname, user.lastname, user.userid, user.lastname, user.phone, ride.note, user.email,user.dob,user.gender,user.image,ride.amount FROM ride

						LEFT JOIN rider on ride.rideid = rider.rideid
						LEFT JOIN driver on ride.rideid = driver.rideid	
						LEFT JOIN user on user.userid = driver.userid or rider.userid = user.userid
									
		WHERE ride.rideid = ?";
		$query_result = $this->db->query($query,array($rideid));
		return $query_result->result();
	}
}