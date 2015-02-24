<?php

class Model_user extends CI_Model
{

	
	public function loginuser($username,$password)
	{
		$query = "SELECT userid, username,firstname,lastname FROM user where username=? AND password=?";	
		$result = $this->db->query($query,array($username,$password));		
		return $result; //returns an array with username => '' and userid => ''

	}
	
	public function get_user_by_id($userid)
	{
		$query = "SELECT username,firstname,lastname,email FROM user where userid=?";	
		$result = $this->db->query($query,array($userid));		
		return $result; //returns an array with username => '' and userid => ''

	}

	public function is_user_exists($username)
	{
		$query = "SELECT userid, username,firstname,dob,email FROM user where username=?";	
		$result = $this->db->query($query,array($username));		
		return $result; //returns an array with username => '' and userid => ''
	}
	
	
	public function view_profile($username)
	{
		$query = "SELECT user.firstname, user.lastname, user.username, user.gender, 
			user.dob, user.phone, user.email, user.image, user.regdate, user_details.user_about, user_details.user_work,
			user_details.user_education, user_details.user_location, user_details.car_name
			FROM user 
			INNER JOIN user_details ON user_details.userid = user.userid
			WHERE username = ?";
			
		$query_result = $this->db->query($query,array($username));
		return $query_result->result();
	}
	
	public function get_user_drive($username,$next,$per_page)
	{
		$query = "
		SELECT ride.rideid, ride.source, ride.destination, ride.depart_date,ride.depart_time, ride.return_date, ride.return_time, 
		ride.smoker, driver.seats, driver.userid, ride.post_date, user.username, user.image, user.firstname, user.lastname, ride.amount
		FROM ride
		INNER JOIN driver on ride.rideid = driver.rideid
		INNER JOIN user on driver.userid = user.userid
		AND user.username = ? LIMIT ?, ?";
		
		$query_result = $this->db->query($query,array($username,$next,$per_page));
		return $query_result;
	}
	
	public function get_user_ride($username,$next_ride,$per_page_ride)
	{
		$query = "select ride.rideid, ride.source, ride.destination, ride.depart_date, ride.depart_time, ride.return_date, ride.return_time, ride.smoker,
				ride.post_date,user.image,user.firstname, user.lastname,ride.amount from ride
				INNER JOIN rider on ride.rideid = rider.rideid
				INNER JOIN user on user.userid = rider.userid
				AND user.username = ? LIMIT ?, ?";
		
		$db_object_data = $this->db->query($query,array($username,$next_ride,$per_page_ride));
		return $db_object_data;
		
	}
	
	public function update_profile($username,$firstname,$lastname,$dob,$gender,$phone)
	{
		$query = "UPDATE user SET firstname = ?, lastname = ?, dob= ?, gender =  ?, phone = ?
		WHERE username = ?;";
		$db_object_date = $this->db->query($query,array($firstname,$lastname,$dob,$gender,$phone,$username));
	
	}
	
	public function update_profile_pic($file_url,$userid)
	{
		$query = "UPDATE user SET image = ?
		WHERE userid = ?;";
		$db_object_date = $this->db->query($query,array($file_url,$userid));
	}
	
	public function get_user_details_by_userid($userid)
	{
		$query = "SELECT user_about,user_work,user_education,user_location,car_name FROM user_details WHERE userid = ?";
		$db_object_data = $this->db->query($query,array($userid));
		return $db_object_data;
	}
	
	public function update_user_details_by_userid($userid,$user_about,$user_work,$user_education,$user_location,$car_name)
	{
		$query = "UPDATE user_details SET user_about = ?, user_work = ?, user_education = ?, user_location = ?, car_name = ? 
		WHERE userid = ?";
		$result = $this->db->query($query, array($user_about,$user_work,$user_education,$user_location,$car_name,$userid));
	}
	
	public function insert_user_details($userid,$user_about,$user_work,$user_education,$user_location,$car_name)
	{
		$query = "INSERT INTO user_details (userid, user_about, user_work, user_education,user_location,car_name) 
		VALUES (?, ?, ?, ?, ?, ?)";
		$result = $this->db->query($query,array($userid,$user_about,$user_work,$user_education,$user_location,$car_name));
	}
	
}
