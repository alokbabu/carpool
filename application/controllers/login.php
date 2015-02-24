<?php

class Login extends CI_Controller
{
	
	public function userlogin()
	{
		if($this->is_user_logged_in())
		{
		  redirect('welcome');
		}
		else 
		{
			$this->load->view('login_view');
		}
	}
	
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
}
