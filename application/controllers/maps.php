<?php

/**
 * 
 */
class Maps extends CI_Controller
{
	 public function __construct()
       {
            parent::__construct();
            // Your own constructor code
         //  $this->load->model('register_user');
       }
	   
	   public function view_map($source,$destination)
	   {
	   	$var_source = $this->input->get('source');
		$var_destination = $this->input->get('destination');
		$data =  array(
			'source' => $source,
			'destination' => $destination,
		);
	   	$this->load->view('view_map.php',$data);
	   }
       
       
       
}

 ?>