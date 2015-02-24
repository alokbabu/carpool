<?php 


	class Register_user extends CI_Model
	{
	
		function signup_user($firstname,$lastname,$username,$password,$dob,$gender,$phone,$email)
		{
						
			$this->load->helper('date');
			$date = date('Y-m-d', strtotime(str_replace('-', '/', $dob)));
	
			
			$sha1_password = sha1($password);
			$query = "INSERT INTO user (firstname,lastname,username,password,dob,gender,phone,email,image,regdate) VALUES (?, ?, ?, ?, ?, ?, ?, ?,?, CURDATE())";
			$default_image = base_url()."userpic/no-profile-man.jpg"; 
			$this->db->query($query, array($firstname,$lastname,$username,$sha1_password,$date,$gender,$phone,$email,$default_image));
			
		}
		
		function signup_fb_user($fb_first_name,$fb_last_name,$fb_userid,$fb_birthday,$fb_gender,$fb_email,$fb_image)
		{
			//echo $fb_first_name."<br/>".$fb_last_name."<br/>".$fb_userid."</br>".$fb_gender."<br/>".$fb_email."<br/>".$fb_birthday;
						$this->load->helper('date');
						$fb_birthday = date('Y-m-d', strtotime(str_replace('-', '/', $fb_birthday)));
						$query = "INSERT INTO user (firstname,lastname,username,password,dob,gender,phone,email,image,regdate) VALUES (?, ?, ?, NULL, ?, ?, NULL, ?,?, CURDATE())";
						$this->db->query($query,array($fb_first_name,$fb_last_name,$fb_userid,$fb_birthday,$fb_gender,$fb_email,$fb_image));
		}
		
		
		function setup_user_preferences($is_smoker, $is_mail_verified, $is_fb_user, $email_verification_code,$password_reset_code, $is_no_anonymous, $is_email_anonymous, $preferred_contact_method, $last_login)
		{
			//echo "FROM MODEL - ".$is_smoker."-". $is_mail_verified."-". $is_fb_user."-". $email_verification_code."-". $password_reset_code."-". $is_email_anonymous."-". $is_no_anonymous."-". $preferred_contact_method."-".$last_login;
			$user_id = $this->db->insert_id();
			$query =  "INSERT INTO user_preference VALUES (?,?, ?, ?, ?, ?, ?, ?, ?, ?)";
			$this->db->query($query,array($user_id, $is_smoker, $is_mail_verified, $is_fb_user, $email_verification_code,$password_reset_code, $is_no_anonymous, $is_email_anonymous, $preferred_contact_method, $last_login));
		}
		
		function check_username_exists($username)
		{
			
			$select_query = "SELECT username FROM user WHERE username=?";
			$user_email_query = $this->db->query($select_query, $username);
			if ($user_email_query->num_rows > 0)
			{
				return true;	
			}
			else 
			{
				return false;
			}
			
		}
		
		function check_email_exists($email)
		{
			$select_query = "SELECT email FROM user WHERE email=?";
			$result = $this->db->query($select_query,$email);
			if($result->num_rows > 0)
			{
				return true;
			}
			else 
				
			{
				return false;
			}
		
		}
		
		function get_verification_code_by_user_id($user_id)
		{
			$query = "SELECT email_verification_code FROM user_preference WHERE userid = ?";
			$result = $this->db->query($query,array($user_id));
			return $result;
		}
		
		function email_is_verified($user_id) // Email is verified
		{
			//sets the value is_email_verified to 'yes'
			$query = "UPDATE user_preference SET is_mail_verified =  ? WHERE userid=?";
			$result = $this->db->query($query,array('yes',$user_id));
			return $result;
		}
		
		function check_if_email_is_verified_already($user_id)
		{
			$query = "SELECT is_mail_verified FROM user_preference WHERE userid= ?";
			$result = $this->db->query($query,array($user_id));
			return $result;	
		} 
		
		function insert_password_reset_code($userid,$password_reset_code)
		{
			$query = "UPDATE user_preference SET password_reset_code = ? WHERE userid = ?";
			$result = $this->db->query($query,array($password_reset_code,$userid));
			return $result;
		}
		
		function get_password_reset_code_by_id($userid)
		{
			$query = "SELECT password_reset_code FROM user_preference WHERE userid=?";
			$result = $this->db->query($query,array($userid));
			return $result;
		}
		
		function insert_new_password($password,$userid)
		{
			$password = sha1($password);
			$query = "UPDATE user SET password = ? WHERE userid = ?";
			$result = $this->db->query($query,array($password,$userid));
			return $result;
		}
		
	}

?>
