<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php
/*
 * Author: Alok Babu
 * Company : Rivulets Technologies
 * Year : 2012
 * Framework : Code Igniter
 * All rights reserved © Rivulets Technologies
 * www.rivulets.in
 * Version : 1.0
 */
 
class User extends CI_Controller{	
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('model_user');
		$this->load->model('register_user');
		//form validation library
		$this->load->library('form_validation');
		$this->load->helper('PHPMailer');
		
	}
	
	public function index()
	{
		$data['message'] = "";
		$this->load->view('user/login_view',$data);
	}
	
	
	/*
	 * Function : Login user by username and password
	 * Creates session upon successful Login
	 */
	 
	public function login()
	{
		//getting post variables
	 	$username = $this->input->post('username');
		$password = $this->input->post('password');
		$password = sha1($password);
		// Selecting username and password using Model login_user->loginuser
		$fetch_user = $this->model_user->loginuser($username,$password);
		

		if($fetch_user->num_rows >0)
		{
			foreach($fetch_user->result() as $key)
			{
				$user_id = $key->userid;
			}
			
			if($this->check_if_email_already_verified($user_id))
			{
		
			//echo "Login Successful";
			
			foreach ($fetch_user->result() as $row)
				{
				    $userid =  $row->userid;
					$username = $row->username;
					$firstname = $row->firstname;
					$lastname = $row->lastname;
					$login_details = array
					('username' => $username,
					'userid'  => $userid,
					'firstname' => $firstname,
					'lastname' =>$lastname,
					'logged_in' => 'true',
					'is_fb_user' => '0',
					);
					// Creating session with username, userid, firsname, logged_in
					$this->session->set_userdata($login_details);
				}
			redirect('welcome');
			}
			else
				{
					$data['message'] = "You have not verified your email yet. Please verify to continue.";
					$this->load->view('user/login_view',$data);
				}
						
		}
		else // If username and password is wrong
		{
			//unsuccessful Login
			$data['message'] = "Unsuccessful login attempt, Please login again.";
			$this->load->view('user/login_view',$data);
		}
		

	}
	
	/*
	 * Function : Validate user Sign Up
	 * Returns true upon successful validation, Returns false if validation is unsuccessful
	 */
	 
	public function validate_user()
	
	{
		
		//removing default CI error style : refer documentation.
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');		
		//validation rules
		$this->form_validation->set_rules('firstname', 'First name', 'trim|required|alpha|xss_clean');
		$this->form_validation->set_rules('lastname', 'Last Name', 'trim|required|alpha|xss_clean');
		$this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[5]|max_length[20]|alpha|callback_username_exists');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]|trim|xss_clean');
		$this->form_validation->set_rules('confpassword', 'Confirmation Password', 'trim|required|min_length[6]|xss_clean|matches[password]');
		$this->form_validation->set_rules('datepicker', 'Birthday', 'required|trim|xss_clean');
		$this->form_validation->set_rules('dd_gender', 'Gender', 'required|trim|xss_clean');
		$this->form_validation->set_rules('mobile_phone', 'Phone Number', 'required|numeric|trim|xss_clean|min_length[10]|max_length[15]');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email|callback_email_exists|trim|xss_clean');
		$this->form_validation->set_rules('recaptcha_response_field','captcha','callback_is_recaptcha_entered_correct');
		
		//end of validation rules
		
		//if form validation result is false
		if ($this->form_validation->run() == FALSE)
			{
				return FALSE;
		
			}
		else
			{
				return TRUE;
			}	
	}


	public function is_recaptcha_entered_correct()
	{
		  $this->load->helper('recaptchalib_helper');
		  $privatekey = "6Lecd9oSAAAAAI6A6e3ixhgmaYaYIQgjYAFGYGyg";
		  $resp = recaptcha_check_answer ($privatekey,
		                                $_SERVER["REMOTE_ADDR"],
		                                $_POST["recaptcha_challenge_field"],
		                                $_POST["recaptcha_response_field"]);
		
		  if (!$resp->is_valid) 
		  {
		  	$this->form_validation->set_message('is_recaptcha_entered_correct', 'The characters you entered did not match the word verification. Please try again.');
		   	return FALSE; 
		  } 
		  else 
		  {
		  	return TRUE;
		    // Your code here to handle a successful verification
		  }
	}

	
		/* custom validation functions username_exists_callbacks refer documentation
		 * check if username already exists before signing up
		 * Return FALSE if username exists, return TRUE if username does not exists
		 */
		 
		function username_exists($username)
		{
			//setting message for callback validation
			$this->form_validation->set_message('username_exists','username '.$username.' already exists.Please try another username');
			
			if($this->register_user->check_username_exists($username))
				{
					return FALSE;
				}
				
			else
				{
					return TRUE;
				}
			
		}
		
		function username_exists_ajax()
		{
			//setting message for callback validation
			$username = $_GET['username'];
			//$this->form_validation->set_message('username_exists','username '.$username.' already exists.Please try another username');
			
			if($this->register_user->check_username_exists($username))
				{
					print "username already exists";
				}
				
			else
				{
					print "username available";
				}
			
		}

	/* custom validation functions email_exists_callbacks refer documentation
	 * check if emailid already exists before signing up
	 * Return FALSE if emailid exists, return TRUE if email does not exists
	 */
	function email_exists($email)
		{
				$this->form_validation->set_message('email_exists', 'This email is already registered.');
				if($this->register_user->check_email_exists($email))
				{
					return false;
				}
				else 
				{	
					return true;
				}
		}
		
	
	
		
	/* Function : Signup a user
	 * 
	 * 
	 */
	
	public function signup()
	{
		$this->load->model('register_user');
		if($this->validate_user())
		{
			$firstname = $this->input->post('firstname');
			$lastname = $this->input->post('lastname');
			$username = $this->input->post('username');
			$password = $this->input->post('password');
			$dob	 = 	$this->input->post('datepicker');
			$gender = $this->input->post('dd_gender');
			$phone = $this->input->post('mobile_phone');
			$email = $this->input->post('email');
			$is_no_anonymous = $this->input->post('is_no_anonymous');
			$is_email_anonymous = $this->input->post('is_email_anonymous');
			$preferred_contact_method = $this->input->post('dd_contact_method');
			
			//Custom settings for the first time
			$is_smoker = "no"; // Not in user requirements. Set to no by default.
			$is_mail_verified = "no";
			$is_fb_user = "no";
			//generating email verification code
			$secret_code = "lilsnitch";
			$email_verification_code = md5($this->session->userdata('session_id')).md5($secret_code);
			$password_reset_code = NULL;
			$last_login = NULL;
			
		
			//Model - signup_user, insert values
			$this->register_user->signup_user($firstname,$lastname,$username,$password,$dob,$gender,$phone,$email);
			$user_id = $this->db->insert_id();
			$this->register_user->setup_user_preferences($is_smoker, $is_mail_verified, $is_fb_user, $email_verification_code, $password_reset_code, $is_no_anonymous, $is_email_anonymous, $preferred_contact_method, $last_login);

			//send verification code to email : 
				// $to      = $email;
				// $subject = 'Verification your email address - Carpool-US.com';
				// $message = "Click this link to verify.  http://carpool-us.com/carpool-us/test/user/verify_email?id=".$user_id."&code=".$email_verification_code;
				// $headers = 'From: verification@carpool-us.com' . "\r\n" .
				    // 'Reply-To: noreply@carpool-us.com' . "\r\n" .
				    // 'X-Mailer: PHP/' . phpversion();
 				// mail($to, $subject, $message, $headers);
							
				######################## - Php Mailer - ##########################
				$mail = new PHPMailer(); 				
				$mail->From     = "no-reply@nextuz.com";
				$mail->FromName   = "Carpool";
				
				############### SMTP SETTINGS - GO DADDY #######################
				$mail->IsSMTP(); // Telling PHP Mailer that is SMTP
				//$mail->Host = "smtpout.asia.secureserver.net";
				$this->load->config('phpmailer');
				$mail->Host = $this->config->item('Host');
				$mail->SMTPDebug = $this->config->item('SMTPDebug');
				$mail->SMTPAuth = $this->config->item('SMTPAuth');
				$mail->SMTPSecure = $this->config->item('SMTPSecure'); 
				//$mail->Port = 80;
				$mail->Port = $this->config->item('Port');
				$mail->Username = $this->config->item('UserName');
				$mail->Password = $this->config->item('Password');
				$mail_from = $this->config->item('SetFrom');
				$mailer_name = $this->config->item('MailerName');
				$mail->SetFrom($mail_from,$mailer_name);
				$reply_to = $this->config->item('ReplyTo');
				$mail->AddReplyTo($reply_to);				
 				############### SMTP SETTINGS #######################			
				$mail->AddAddress($email); 				
				$mail->Subject  = "Verify your email address - carpool-us.com";
				$mail->Body     = "Welcome to carpool-us, \nClick this link to verify \n http://carpool-us.com/carpool-us/test/user/verify_email?id=".$user_id."&code=".$email_verification_code.
				"\n \n Thank You,\nWish you happy ride.\n\n\n\nIf you're not ". $firstname." ".$lastname. " or didn't request verification you can ignore this email.";
				$mail->WordWrap = 120;				
				
				if(!$mail->Send()) 
				{
					$data['message'] = "Something went wrong. Mail cannot send. Our engineers are working on it.";
					$this->load->view('user/login_view',$data);
				} 
				else 
				{
					$data['message'] = "To activate your account, please click the link in the activation email which has been sent to you. Make sure that you have checked your spam folder.";
					$this->load->view('user/login_view',$data);
				}											
				######################## - Phpmailer - ##########################		
			

		}
		else
			 {
				$this->load->view('header');
				$this->load->view('user/registration_form_view');
			 }
			
			
		
	}
		
		public function check_if_email_already_verified($user_id)
		{
			$is_email_verified_already = $this->register_user->check_if_email_is_verified_already($user_id)->result();
			foreach ($is_email_verified_already as $key)
			{
				$data = $key->is_mail_verified;
				
			}
			 if($data == 'yes')
			 {
			 	return TRUE;
			 }
			 else
			 {
			 	return FALSE;
			 }
		}
	
	
		public function verify_email()
		{
			
			$user_id = $_GET['id'];
			$verification_code_from_email = $_GET['code'];			
	
			if($this->check_if_email_already_verified($user_id))
			{
				$data['message'] = "Your email is already verified. Please login here.";
				$this->load->view('user/login_view',$data);
			}
			else 
			{
					$verification_code_from_db = $this->register_user->get_verification_code_by_user_id($user_id)->result();
					foreach($verification_code_from_db as $key)
					{
						$verification_code_from_db = $key->email_verification_code;
					}
					
					if($verification_code_from_email == $verification_code_from_db)
					{
						$result = $this->register_user->email_is_verified($user_id);		
						if($result)
						{
							$data['message'] = "Your email is now verified. Please login here.";
							$this->load->view('user/login_view',$data);
						}
					}
					else
					{
							$data['message'] = "Verification failed. Please try again.";
							$this->load->view('user/login_view',$data);
					}
			}
		}


	
	
	
	
	/* Function : Logout User
	 * unset session variables and redirect to welcome page
	 * 
	 */
	
		public function logout()
		
		{

			if($this->session->userdata('is_fb_user'))
			{

				redirect('user/fblogout');
			  // $config = array();
			  // $config['appId'] = '344330512330259';
			  // $config['secret'] = '420878c2fb52569d3390c77093a66566';
			  // $this->load->library('facebook', $config);
			  // $params = array('next' => 'http://www.carpool-us.com/user/fblogout');
			  // redirect($this->facebook->getLogoutUrl($params)); // $params is optional.

			}
			
			else				
			{
				$this->session->sess_destroy();
				redirect('welcome');
			}

		}
		
		public function fblogout()
		{
				//Refer PHP Manual
				// Initialize the session.
				// If you are using session_name("something"), don't forget it now!
				session_start();

				// Unset all of the session variables.
				$_SESSION = array();

				// If it's desired to kill the session, also delete the session cookie.
				// Note: This will destroy the session, and not just the session data!
				if (ini_get("session.use_cookies")) {
				    $params = session_get_cookie_params();
				    setcookie(session_name(), '', time() - 42000,
				        $params["path"], $params["domain"],
				        $params["secure"], $params["httponly"]
				    );
				}

				// Finally, destroy the session.
				session_destroy();

				$this->session->sess_destroy();
			 	
				// foreach ($_COOKIE as $key => $value) {
    			// print $key . "=" . $value . "</br>";
				// }
			redirect('welcome');
		}


		
	/* Function : Check if any user is logges in
	 * Return true if user is logged in, Return false if user is not logged in
	 * 
	 */
		
		public function is_user_logged_in()
		{
			$username =  $this->uri->segment(3, 0);
			if ($this->session->userdata('username') == $username && $this->session->userdata('logged_in') == TRUE)
			{
				return true;
			}
			else 
			{
				return false;
			}
			
		}
		
		
		
		/*
		 * Function : Loads profile of user and view it on profile_view
		 * @username 
		 */
		public function profile($username="")
		{				
			if($this->register_user->check_username_exists($username))
			{
					
				//Customise here if you want to disable view for unregistered users
				
				//username exists showing the user data
				$next = 0; // pagination variables
				$per_page = 3;	
				$profile_data ['profile'] = $this->model_user->view_profile($username);
				$profile_data['drive_data'] = $this->model_user->get_user_drive($username,$next,$per_page)->result();
				$profile_data['ride_data'] = $this->model_user->get_user_ride($username,$next,$per_page)->result();
				$this->load->view('user/user_profile_view',$profile_data);
				
			}
			else if ($username == "")
			{
				//throw 404
				show_404();
			}
			else 
			{
				//username does not exist yet	
				show_404();
			}
			
			
		}
		
		/*
		 * Function : Edit User profile
		 * @username 
		 */
	
		public function edit($username)
		{
			if($this->is_user_logged_in())
			{
				$next = 0;
				$per_page = 5;
				$profile_data ['profile'] = $this->model_user->view_profile($username);
				//$profile_data['drive_data'] = $this->model_user->get_user_drive($username);
				//$profile_data['ride_data'] = $this->model_user->get_user_ride($username);
				$this->load->view('user/user_profile_edit_view',$profile_data);
			}
			else 
			{
				$data['message'] = "Please login";
				$this->load->view('user/login_view',$data);
			}
		}
		
		/*
		 * Function : Validation rules for edit user page
		 * 
		 */
			public function validate_edit_user()
	
			{
				
				//form validation library
				$this->load->library('form_validation');
				//removing default CI error style : refer documentation.
				$this->form_validation->set_error_delimiters('<div class="error">', '</div>');		
				//validation rules
				
				$this->form_validation->set_rules('usr_frst_name', 'First name', 'trim|required|alpha|xss_clean');
				$this->form_validation->set_rules('usr_scnd_name', 'Last Name', 'trim|required|alpha|xss_clean');
				$this->form_validation->set_rules('usr_abt_me', 'About me','xss_clean');
				$this->form_validation->set_rules('usr_work', 'Work','xss_clean');
				$this->form_validation->set_rules('usr_edu', 'Education','xss_clean');
				$this->form_validation->set_rules('usr_car', 'Car','xss_clean');				
				$this->form_validation->set_rules('usr_dob', 'Birthday', 'required|trim|xss_clean');
				$this->form_validation->set_rules('usr_gender', 'Gender', 'required|trim|xss_clean');
				$this->form_validation->set_rules('usr_location', 'Location','xss_clean');						
				$this->form_validation->set_rules('usr_mob', 'Mobile Number', 'required|is_natural|trim|xss_clean|min_length[10]|max_length[15]');
			
				//end of validation rules
				
				//if form validation result is false
				if ($this->form_validation->run() == FALSE)
					{
						return FALSE;
				
					}
				else
					{
						return TRUE;
					}	
			}
		
		/*
		 * Function : Upload profile pic under baseurl()/userpic
		 * filename : username-userid
		 * 
		 */
		
		function do_upload()
			{
				$userid = $this->session->userdata('userid');
				$username = $this->session->userdata('username');
				$config['upload_path'] = './userpic/';
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$config['max_size']	= '1024';
				// $config['max_width']  = '1024';
				// $config['max_height']  = '768';
				$config['overwrite']  = 'TRUE';
				$config['file_name'] = $username."-".$userid;
				$this->load->library('upload', $config);
				
				//on error
				if ( ! $this->upload->do_upload())
				{
					$error = array('error' => $this->upload->display_errors());
					$username = $this->session->userdata('username');
					redirect("user/edit/".$username."?upload_error=1");
					//$this->edit($username);
				}
				
				else
				{
					$this->load->helper('array');
					$userid = $this->session->userdata('userid');
					//view profile page
					//insert full path into database
					$file_attributes =  $this->upload->data();
					$file_url =  base_url()."userpic/".element('orig_name', $file_attributes);
					$this->model_user->update_profile_pic($file_url,$userid);
					$username = $this->session->userdata('username');
					//$this->profile($username);
				}
			}
		
		/*
		 * Function : Update user profile
		 * filename : username-userid
		 * 
		 */
		
		public function update($username)
		{
			
			if($this->is_user_logged_in())
			{
					if($this->validate_edit_user())
					{
					//update data

					$username = $this->session->userdata('username');
					$firstname = $this->input->post('usr_frst_name');
					$lastname = $this->input->post('usr_scnd_name');
					$about_me = $this->input->post('usr_abt_me');
					$work = $this->input->post('usr_work');
					$edu = $this->input->post('usr_edu');
					$car = $this->input->post('usr_car');					
					$dob	 = 	$this->input->post('usr_dob');
					$gender = $this->input->post('usr_gender');
					$phone = $this->input->post('usr_mob');
					$location = $this->input->post('usr_location');
					if(isset($_FILES['usr_img']))
					{
						$uploaded_file_name = basename($_FILES['usr_img']['name']);
					}
					else 
					{
						$uploaded_file_name = "";
					}
					
					
					// echo $username."<br />".$firstname."<br />".$lastname."<br />".$about_me."<br />".$work."<br />".$edu
					// ."<br />".$car."<br />".$dob."<br />".$gender."<br />".$location."</br>".$uploaded_file_name;
					
					
					
					if (empty($uploaded_file_name)) // If file is not selected; Update
					{
						
						//$this->model_user->update_profile($username,$firstname,$lastname,$dob,$gender,$phone);
						
						//Check if user has already inserted his user details. If already inserted update$userid = $this->session->userdata('userid');
						$userid = $this->session->userdata('userid');
						$num_of_rows = $this->model_user->get_user_details_by_userid($userid);
						//print_r($num_of_rows); 
						if($num_of_rows->num_rows() > 0 )
						{
							//number of rows greater than 0 : userdetails already inserted
							//update user
							$this->model_user->update_profile($username,$firstname,$lastname,$dob,$gender,$phone);
							//updating user_details
							//$userid,$user_about,$user_work,$user_education,$user_location,$car_name)
							$this->model_user->update_user_details_by_userid($userid,$about_me,$work,$edu,$location,$car);
						}
						else 
						{
							//update user
							$this->model_user->update_profile($username,$firstname,$lastname,$dob,$gender,$phone);
							//Insert query	
							$this->model_user->insert_user_details($userid,$about_me,$work,$edu,$location,$car);
						}
						
						redirect('user/profile/'.$username);
					}
					else// If file is selected update and save image
					{	
						  $this->model_user->update_profile($username,$firstname,$lastname,$dob,$gender,$phone);		
						  $this->do_upload();	
					      redirect('user/profile/'.$username);
					}
					
					
					}
						else //error validating
							{
								$username = $this->session->userdata('username');
								//validation errors
								$this->edit($username);
							}
				
							
			}
			else//user not logged in
				 {
					$data['message'] = "Please login to edit your profile";
					$this->load->view('user/login_view',$data);
				 }
				
		}
		
		
		public function drives($username = "")
		{	
			if($this->register_user->check_username_exists($username))
			{
			
			$url = base_url();
			//pagination configuration for get_user_drive
			$num_rows =  $this->model_user->get_user_drive($username,0,1000)->num_rows;
			//$config['base_url'] = $url.'/user/profile/'.$username;
			$config['base_url'] = $url."user/drives/".$username;
			$config['total_rows'] = $num_rows;
			$config['per_page'] = 10; 
			$config['uri_segment'] = 4;
			//$config['page_query_string'] = TRUE;
			//$config['query_string_segment'] = 'drive';
			
			$this->pagination->initialize($config); 
			
			$next = intval($this->uri->segment(4,0));	
			$per_page = $config['per_page'];
			
			$profile_data ['profile'] = $this->model_user->view_profile($username);
			$profile_data['drive_data'] = $this->model_user->get_user_drive($username,$next,$per_page)->result();
			$this->load->view('user/all_user_drives_view',$profile_data);
			}
			else if($username == "")
			{
				show_404();
				
			}
			else 
			{
				show_404();
			}
		}

		public function rides($username = "")
		{
					
			if($this->register_user->check_username_exists($username))
			{
			$url = base_url();
			//pagination configuration for get_user_drive
			$num_rows =  $this->model_user->get_user_ride($username,0,1000)->num_rows;
			//$config['base_url'] = $url.'/user/profile/'.$username;
			$config['base_url'] = $url."user/rides/".$username;
			$config['total_rows'] = $num_rows;
			$config['per_page'] = 10; 
			$config['uri_segment'] = 4;
			//$config['page_query_string'] = TRUE;
			//$config['query_string_segment'] = 'drive';
			
			$this->pagination->initialize($config); 
			
			$next = intval($this->uri->segment(4,0));	
			$per_page = $config['per_page'];
			
			$profile_data ['profile'] = $this->model_user->view_profile($username);
			$profile_data['ride_data'] = $this->model_user->get_user_ride($username,$next,$per_page)->result();
			$this->load->view('user/all_user_rides_view',$profile_data);
			}
			else if($username == "")
			{
				show_404();
			}
			else 
			{
				show_404();	
			}
		}
		
		public function delete_user_commute($ride_id)
		{
			
			$this->load->model('add_ride');
			$this->load->helper('array');
			
			$username_by_rideid = $this->add_ride->get_username_by_ride_id($ride_id);
			
			foreach ($username_by_rideid->result() as $row)
			{
				$ride_owner = $row->username;
			}
			
			$loggedin_user = $this->session->userdata('username');
			
			if($loggedin_user == $ride_owner) // Claiming ownership of the ride
			{
			$this->add_ride->delete_commute($ride_id);
			$next = $this->uri->segment(4,0);
			
				if($next == "drive")
					{
						redirect('user/drives/'.$loggedin_user);
					}

				else
					{
						redirect('user/rides/'.$loggedin_user);
					}
			}
			else // unknown user 
			{
				show_404();
			}
			
		}
		
		
		//CHECK IF THE USER OWNS THE RIDE
		
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
			
		//Hides the edit page for others ride

		public function edit_user_ride($rideid)
		{
			$username = $this->session->userdata('username');
			if($this->is_user_owns_ride($rideid, $username))
			{
			$this->load->model('search_model');
			$user_ride['data'] = $this->search_model->get_ride_by_rideid($rideid);
			//print_r($user_ride);
			$this->load->view('user/edit_ride_view.php',$user_ride);
			}
			else 
			{
				show_404();
			}
			
		}
		
		public function fblogin()
		{
			
			  $config = array();
			  $config['appId'] = '344330512330259';
			  $config['secret'] = '420878c2fb52569d3390c77093a66566';
			  $this->load->library('facebook', $config);
	 	   	  
			   $user = $this->facebook->getUser();
				
					if($user)
					{
			            try 
			            {
			                $user_info = $this->facebook->api('/me');
							//getting user profile pic url
							$url_fb_pic = json_decode(file_get_contents('http://graph.facebook.com/'.$user.'/picture?type=large&redirect=false&width=400&height=400'));
							//insert into the db and respond back to login							
							$this->load->model('register_user');
							$fb_first_name = $user_info['first_name'];
							$fb_last_name = $user_info['last_name'];
							$fb_user_name = $user_info['username'];
							$fb_gender = $user_info['gender'];
							$fb_image = $url_fb_pic->data->url;
							$fb_email = $user_info['email'];
							$fb_birthday = $user_info['birthday'];
							$fb_userid = $user_info['id'];
//echo $fb_userid.$fb_first_name."<br/>".$fb_last_name."<br/>".$fb_user_name."</br>".$fb_gender."<br/>".$fb_email."<br/>".$fb_birthday;
			
							$is_user_exist = $this->model_user->is_user_exists($fb_userid)->result();
							foreach ($is_user_exist as $row) 
							{
								$userid = $row->userid;
							}

							// echo $userid;
							// print_r($is_user_exist);
							if(!empty($is_user_exist))
							{
								//user exists
								$login_details = array
									('username' => $fb_userid,
									'userid'  => $userid,
									'firstname' => $fb_first_name,
									'lastname'	=> $fb_last_name,
									'logged_in' => 'true',
									'is_fb_user' => '1',
									);
									// Creating session with username, userid, firsname, logged_in
									$this->session->set_userdata($login_details);
									//redirecting to welcome
									redirect('welcome');
							}

							else
						    {
								//inserting values into the user table
								$this->register_user->signup_fb_user($fb_first_name,$fb_last_name,$fb_userid,$fb_birthday,$fb_gender,$fb_email,$fb_image);
								//for getting the new userid
								$is_user_exist = $this->model_user->is_user_exists($fb_userid)->result();
								foreach ($is_user_exist as $row) 
								{
									$userid = $row->userid;
								}
								$login_details = array
									('username' => $fb_userid,
									'userid'  => $userid,
									'firstname' => $fb_first_name,
									'lastname'	=> $fb_last_name,
									'logged_in' => 'true',
									'is_fb_user' => '1',
									);
									// Creating session with username, userid, firsname, logged_in -> loggin in user
									$this->session->set_userdata($login_details);
									//redirecting to welcome page
									redirect('welcome');
							}
			             // echo '<pre>'.htmlspecialchars(print_r($user_info, true)).'</pre>'; //test values return JSON array
			            } 
			            catch(FacebookApiException $e) 
			            {
			                echo '<pre>'.htmlspecialchars(print_r($e, true)).'</pre>';
			                $user = null;
			            }
			        }
			        //User never authorized the app before
			        else 
			        {
						$data = array(
							'redirect_uri' => 'http://carpool-us.com/carpool-us/test/user/fblogin',
							'scope'		   => 'email,user_hometown,user_birthday'
						);
			           redirect($this->facebook->getLoginUrl($data));
			        }
	 	   

	}

	public function recovery_wizard()
	{
		$data['message'] = "";
		$this->load->view('user/forget_password_view.php',$data);
	}
	
	public function recover_password()
	{
		//$user_name = $_GET['username'];
		
		if($this->model_user->is_user_exists($_GET['username'])->num_rows > 0)
		{
			$user_result = $this->model_user->is_user_exists($_GET['username'])->result();
			foreach($user_result as $key)
			{
				$db_user_id = $key->userid;
				$db_firstname = $key->firstname;
				$db_username = $key->username;
				$db_dob = $key->dob;
				$db_email = $key->email;
			}
			
			//echo $db_user_id;
			// echo $_GET['username'] . " = ".$db_username;
			// echo $_GET['datepicker'] . " = ". $db_dob;
			// echo $_GET['email'] . " = ". $db_email;
			
			if($_GET['username'] == $db_username && $_GET['datepicker'] == $db_dob && $_GET['email'] == $db_email)
			{
				$password_reset_code = $this->generate_password_reset_code($db_user_id);
				//create password recovery secret code
				//send email
				######################## - Php Mailer - ##########################
				$mail = new PHPMailer(); 				
				$mail->From     = "no-reply@carpool-us.com";
				$mail->FromName   = "Carpool-US";
				
				############### SMTP SETTINGS - GO DADDY #######################
				$mail->IsSMTP(); // Telling PHP Mailer that is SMTP
				//$mail->Host = "smtpout.asia.secureserver.net";
				$this->load->config('phpmailer');
				$mail->Host = $this->config->item('Host');
				$mail->SMTPDebug = $this->config->item('SMTPDebug');
				$mail->SMTPAuth = $this->config->item('SMTPAuth');
				$mail->SMTPSecure = $this->config->item('SMTPSecure'); 
				//$mail->Port = 80;
				$mail->Port = $this->config->item('Port');
				$mail->Username = $this->config->item('UserName');
				$mail->Password = $this->config->item('Password');
				$mail_from = $this->config->item('SetFrom');
				$mailer_name = $this->config->item('MailerName');
				$mail->SetFrom($mail_from,$mailer_name);
				$reply_to = $this->config->item('ReplyTo');
				$mail->AddReplyTo($reply_to);					
 				############### SMTP SETTINGS #######################
 						
				$mail->AddAddress($db_email); 				
				$mail->Subject  = "Change password request - carpool-us.com";
				
				$mail->Body     = " Hello ".$db_firstname. ",\nWe have recieved your request for changing the password. If you haven't requested for a new password please ignore this mail.
\nClick this link to change your password.\nhttp://carpool-us.com/carpool-us/test/user/change_password?id=".$db_user_id."&code=".$password_reset_code."\nThank you,\ncarpool-us.";
				$mail->WordWrap = 100;				
				
				if(!$mail->Send()) 
				{
					$data['message'] = "Something went wrong. Mail cannot send. Our engineers are working on it.";
					$this->load->view('user/forget_password_view.php',$data);
				} 
				else 
				{
					$data['message'] = "An email is sent to the registered email, please click on the provided link and follow the instructions.";
					$this->load->view('user/forget_password_view.php',$data);
				}											
				######################## - Phpmailer - ##########################			
				
				

			}
			else 
			{
				$data['message'] = "The information which you provided does not match the information in our database. Please try again.";
				$this->load->view('user/forget_password_view.php',$data);
			}
		}
		else
		{
			$data['message'] = "The information which you provided does not match the information in our database. Please try again.";
			$this->load->view('user/forget_password_view.php',$data);		
		}
		
	}	
	
	public function generate_password_reset_code($userid)
	{		
		$secret_code = "passwordlilsnitch";
		$password_reset_code = md5($this->session->userdata('session_id').$secret_code);		
		$this->register_user->insert_password_reset_code($userid,$password_reset_code);
		return $password_reset_code;
	}
	
	public function change_password()
	{
		//check reset_code with database if true expire the code.
		$userid = $_GET['id'];
		$reset_password_result = $this->register_user->get_password_reset_code_by_id($_GET['id']);
		foreach ($reset_password_result->result() as $key) 
		{
			$reset_password_code_db = $key->password_reset_code;
		}
		if($reset_password_code_db == '0')
		{
			$data['message'] = "This password reset token is expired. Please request a new one.";
			$this->load->view('user/forget_password_view.php',$data);
		}
		else
		{
			if($_GET['code'] == $reset_password_code_db)
			{
				$reset_password_session = array (
							'id' => $_GET['id'],
							'code' => $_GET['code'],
				);
				$this->session->set_userdata($reset_password_session);
					
				
				$data['message'] = '';
				$this->load->view('user/change_password_view',$data);
			}
			else
				{
					$data['message'] = "This password reset token is either expired or invalid.";
					$this->load->view('user/forget_password_view.php',$data);
				}
		}
	}
	
	public function create_new_password()
	{
		if($this->session->userdata('code') == '')
		{
			$data['message'] = "Your session expired. Please try again.";
			$this->load->view('user/forget_password_view.php',$data);
		}
		else 
		{
			
			if($this->validate_new_password())
			{
				$userid = $this->session->userdata('id');
				$code = $this->session->userdata('code');
				$password = $_POST['confpassword'];
				$this->register_user->insert_new_password($password,$userid);
				$data['message'] = "Password changed successfully. Please login.";
				$this->load->view('user/login_view',$data);
				$destroy_session = array('id' => '', 'code' => '');
				$this->session->unset_userdata($destroy_session);
				//expire password reset code
				$this->register_user->insert_password_reset_code($userid,'0');	
				//get_email_address
				$user = $this->model_user->get_user_by_id($userid);
				foreach ($user->result() as $key) 
				{
					$user_first_name = $key->firstname;
					$user_email = $key->email;
				}
				

				######################## - Php Mailer - ##########################
				$mail = new PHPMailer(); 				
				$mail->From     = "no-reply@carpool-us.com";
				$mail->FromName   = "Carpool-US";
				
				############### SMTP SETTINGS - GO DADDY #######################				
				$mail->IsSMTP(); // Telling PHP Mailer that is SMTP
				//$mail->Host = "smtpout.asia.secureserver.net";
				$this->load->config('phpmailer');
				$mail->Host = $this->config->item('Host');
				$mail->SMTPDebug = $this->config->item('SMTPDebug');
				$mail->SMTPAuth = $this->config->item('SMTPAuth');
				$mail->SMTPSecure = $this->config->item('SMTPSecure'); 
				//$mail->Port = 80;
				$mail->Port = $this->config->item('Port');
				$mail->Username = $this->config->item('UserName');
				$mail->Password = $this->config->item('Password');
				$mail_from = $this->config->item('SetFrom');
				$mailer_name = $this->config->item('MailerName');
				$mail->SetFrom($mail_from,$mailer_name);
				$reply_to = $this->config->item('ReplyTo');
				$mail->AddReplyTo($reply_to);								
 				############### SMTP SETTINGS #######################
 						
				$mail->AddAddress($user_email); 				
				$mail->Subject  = "Password changed - carpool-us.com";
				
				$mail->Body     = " Hello ".$user_first_name. ",\nWe have recieved your request for changing the password. Your password is changed.\n\nThank you,\ncarpool-us.";
				$mail->WordWrap = 100;				
				
				if(!$mail->Send()) 
				{
					$data['message'] = "Something went wrong. Mail cannot send. Our engineers are working on it.";
					$this->load->view('user/change_password_view',$data);
				} 
				else 
				{
					// $data['message'] = 'Your password changed successfully, please login.';
					// $this->load->view('user/change_password_view',$data);
				}											
				######################## - Phpmailer - ##########################	
				######################## - Classic Mail - ##########################
				// $to      = $user_email;
				// $subject = 'Password changed- Carpool-US.com';
				// $message = "
				// Hello ".$user_first_name.
				// " your password has changed successfully.";
				// $headers = 'From: no-reply@carpool-us.com' . "\r\n" .
				    // 'Reply-To: noreply@carpool-us.com' . "\r\n" .
				    // 'X-Mailer: PHP/' . phpversion();
 				// mail($to, $subject, $message, $headers);
				######################## - Classic Mail - ##########################
			}
			else //on validation error
			{
				$data['message'] = '';
				$this->load->view('user/change_password_view',$data);
			}
		}
	}
	
	public function validate_new_password()
	{
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]|trim|xss_clean');
		$this->form_validation->set_rules('confpassword', 'Confirmation Password', 'trim|required|min_length[6]|xss_clean|matches[password]');
	    if ($this->form_validation->run() == FALSE)
			{
				return FALSE;
		
			}
		else
			{
				return TRUE;
			}	
	}
	
}


/* End of file user.php */
/* Location: ./application/controller/user.php */