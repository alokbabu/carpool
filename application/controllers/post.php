<?php

Class Post extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('add_ride');
	}
	
	public function index()
	{
		$this->load->view('rides/postride_view.php');
	}
	
	public function validate_post()
	{
		if ($this->is_user_logged_in())
		{
			$this->load->library('form_validation');
			$this->form_validation->set_rules('txtsource', 'Source', 'required');
			$this->form_validation->set_rules('txtdestination', 'Destination', 'xss_clean|required');
			$this->form_validation->set_rules('txtdepartdate', 'Departure date', 'xss_clean|required');
			$this->form_validation->set_rules('txtdeparttime', 'Departure date', 'xss_clean|required');
			$this->form_validation->set_rules('txtareanotes', 'Notes', 'xss_clean');
			$this->form_validation->set_rules('amount', 'Amount', 'xss_clean');
			$is_checked_noreturn = $this->input->post('noreturn');
			
			//echo $is_checked_noreturn;
			if ($is_checked_noreturn == "")
			{
				$this->form_validation->set_rules('txtreturndate', 'Return date', 'required');
			}
			
			if ($this->form_validation->run() == FALSE)
			{
				return FALSE;
			}
			else
			{
				return TRUE;
			}
			
			
		}
		else
	    {
	    	$data = array('message' => 'Please login to post rides');
			$this->load->view('user/login_view',$data);
			
			
		}
	}
	
	
	public function add()
	{
		
		if ($this->validate_post())
		{
			//add data
			//get rider type
		 $ride_type = $this->input->post('ride_type');
		 
		 	if($ride_type == "rider")
			{
				//insert into riders table
				$user_id = $this->session->userdata('userid');
				$source = $this->input->post('txtsource');
				$destination = $this->input->post('txtdestination');
				$depart_date = $this->input->post('txtdepartdate');
				$return_date = $this->input->post('txtreturndate');
				$depart_time = $this->input->post('txtdeparttime');
				$return_time = $this->input->post('txtreturntime');
				$smoker = $this->input->post('smoker');
				$note = $this->input->post('txtareanotes');
				
				$amount = $this->input->post('amount');
				$amount = trim($amount,'$');
				
				if($return_date == "")
				{
					$return_date = NULL;
					$return_time = NULL;
				}
				if($note == "")
				{
					$note = NULL;
				}
				
				//calling model function to insert into database
				$this->add_ride->add_rider($source,$destination,$depart_date,$depart_time,$return_date,$return_time,$smoker,$note,$amount);
				$this->add_ride->add_rider_rider($user_id);
				// $this->session->set_flashdata(array('notice'=>'Your post is added!'));
		    	// redirect('post/add#notice');
		    	redirect('user/profile/'.$this->session->userdata('username'));
			}
			else if($ride_type == "driver") 
			{
				//insert into drivers	
				$user_id = $this->session->userdata('userid');
				$source = $this->input->post('txtsource');
				$destination = $this->input->post('txtdestination');
				$depart_date = $this->input->post('txtdepartdate');
				$return_date = $this->input->post('txtreturndate');
				$depart_time = $this->input->post('txtdeparttime');
				$return_time = $this->input->post('txtreturntime');
				$seats = $this->input->post('seats');
				$smoker = $this->input->post('smoker');
				$note = $this->input->post('txtareanotes');
				
				$amount = $this->input->post('amount');
				$amount = trim($amount,'$');
				
				if($return_date == "")
				{
					$return_date = NULL;
					$return_time = NULL;
				}
				if($note == "")
				{
					$note = NULL;
				}
				
				$this->add_ride->add_rider($source,$destination,$depart_date,$depart_time,$return_date,$return_time,$smoker,$note,$amount);
				$this->add_ride->add_rider_driver($user_id,$seats);
				//$this->session->set_flashdata(array('notice'=>'Your post is added!'));
		    	//redirect('post/add#notice');
				redirect('user/profile/'.$this->session->userdata('username'));
			}
		}
		else if ($this->is_user_logged_in())
		{
			
			//echo validation errors
			$this->load->view('rides/postride_view');	
		}
		

		
	}
	
	   //check if user is logged in
		public function is_user_logged_in()
		{
			if ($this->session->userdata('username') != "" && $this->session->userdata('logged_in') == TRUE)
			{
				return true;
			}
			else 
			{
				return false;
			}
			
		}
		
		public function is_user_owns_ride($rideid,$username)
		{
			$this->load->model('search_model');
			$ride = $this->search_model->get_ride_by_rideid($rideid);
			foreach ($ride as $row) 
			{
				$ride_owner = $row->username;	
			}
			//$session_owner = $this->session->userdata('username');
			
			if($ride_owner == $username)
			{
				return TRUE;
				// user owns this ride
			}
			else
				{
					// Security Breach : This owner does not owns this ride
					return FALSE;
					
				}
			
		}
		
		
		public function find_ride_type($rideid)
		{
			//check the ride is in driver or rider
				$this->load->model('search_model');
				$ride_result = $this->search_model->get_ride_by_rideid($rideid);
				
				foreach($ride_result as $row) // if there are seats, then the ride is a drive else its a ride
				{
					$seats = $row->seats;
				}
				
				if($seats == "")
				{
					return "ride";
				}
				else 
				{
					return "drive";
				}
	
		}
		
		
	
		public function update_ride($rideid)
		{
			$username = $this->session->userdata('username');
			if($this->is_user_owns_ride($rideid, $username))
			{
				if ($this->validate_post())
					{
						//get rider type
		 				$ride_type = $this->input->post('ride_type');
		 
					 	if($ride_type == "rider")
						{
							//update into riders table
							$user_id = $this->session->userdata('userid');
							$source = $this->input->post('txtsource');
							$destination = $this->input->post('txtdestination');
							$depart_date = $this->input->post('txtdepartdate');
							$return_date = $this->input->post('txtreturndate');
							$depart_time = $this->input->post('txtdeparttime');
							$return_time = $this->input->post('txtreturntime');
							$smoker = $this->input->post('smoker');
							$note = $this->input->post('txtareanotes');
							
							$amount = $this->input->post('amount');
							$amount = trim($amount,'$');
							
	
							if($return_date == "")
							{
								$return_date = NULL;
								$return_time = NULL;
							}
							if($note == "")
							{
								$note = NULL;
							}
							
							//update rider data
							//check the ride is in driver or rider
							
							if($this->find_ride_type($rideid) == "ride")
							{
								//this is previously a ride
								//update ride; nothng to do
								$this->add_ride->update_ride_rider($source,$destination,$depart_date,$depart_time,$return_date,$return_time,$smoker,$amount,$note,$rideid);
								redirect('user/profile/'.$this->session->userdata('username'));
								//echo "ride updated";
								
							}
							
							else 
							{
								//this is previously a drive - Converting from driver to rider.
								//should change from drive to ride. remove from driver feild by id and insert the ride to rider table
								$userid = $this->session->userdata('userid');
								//echo $userid;
								$this->add_ride->update_ride_rider($source,$destination,$depart_date,$depart_time,$return_date,$return_time,$smoker,$amount,$note,$rideid);
								$this->add_ride->change_ride_from_driver_to_ride($rideid,$userid);
								redirect('user/profile/'.$this->session->userdata('username'));
								//echo "Ride changed from driver to ride and updated";
							}
				
				
								//echo "ride updated";
								//redirect
							}
							
							else if($ride_type == "driver") 
							{
								//insert into drivers	
								$user_id = $this->session->userdata('userid');
								$source = $this->input->post('txtsource');
								$destination = $this->input->post('txtdestination');
								$depart_date = $this->input->post('txtdepartdate');
								$return_date = $this->input->post('txtreturndate');
								$depart_time = $this->input->post('txtdeparttime');
								$return_time = $this->input->post('txtreturntime');
								$seats = $this->input->post('seats');
								$smoker = $this->input->post('smoker');
								$note = $this->input->post('txtareanotes');
								
								$amount = $this->input->post('amount');
								$amount = trim($amount,'$');
								
								if($return_date == "")
								{
									$return_date = NULL;
									$return_time = NULL;
								}
								if($note == "")
								{
									$note = NULL;
								}
								
								//update rider data
								//check the ride is in driver or rider
								$this->load->model('search_model');
								$ride_result = $this->search_model->get_ride_by_rideid($rideid);
								
								if($this->find_ride_type($rideid) == "drive")
								{
								//just update driver, is already a drive
								$this->add_ride->update_ride_rider($source,$destination,$depart_date,$depart_time,$return_date,$return_time,$smoker,$amount,$note,$rideid);
								$this->add_ride->update_ride_driver_seats($seats,$rideid);
								redirect('user/profile/'.$this->session->userdata('username'));
								//echo"driver updated";
								}
								
								else 
								{
									//change from rider to driver
									//insert seats
									$userid = $this->session->userdata('userid');
									$this->add_ride->update_ride_rider($source,$destination,$depart_date,$depart_time,$return_date,$return_time,$smoker,$amount,$note,$rideid);
									$this->add_ride->change_ride_from_ride_to_drive($rideid,$userid,$seats);
									redirect('user/profile/'.$this->session->userdata('username'));
									
								}
				
				//update driver data and redirect
							}
			}//validation
			else
				
			{
				//incomplete
				//echo "Validation errors";
				$this->load->model('search_model');
				$user_ride['data'] = $this->search_model->get_ride_by_rideid($rideid);
				//print_r($user_ride);

				$this->load->view('user/edit_ride_view',$user_ride);
			}
				
			}
			else // Wrong user trying to update ride
				{
					echo "Warning ! Security Breach detected";
				}
		
			
			
		
		}




}



