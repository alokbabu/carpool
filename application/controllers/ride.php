<?php

Class Ride extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('search_model');
		
	}
	
	public function index()
	{
		$this->load->view('rides/search_result_view.php');
	}
	
	public function viewride()
	{
		$rideid = $this->input->get('ride');
		$user_ride_data['data'] = $this->search_model->get_ride_by_rideid($rideid);
		$this->load->view('rides/ride_view.php',$user_ride_data);
	}
	
	
	
	public function search()
	{
		$source =  $this->input->get('source');
		$destination = $this->input->get('destination');
		$depart_date = $this->input->get('date');
		$url = base_url();
		//Pagination Configuration

		if($source == "" && $destination== "" && $depart_date == "") //Search with no values, return todays results
		{
			//If Source, Destination and departure date are empty returns all rides on today
			$today = date("Y-m-d");
			//Pagination Configuration
			
			$num_rows =  $this->search_model->search_all_results_today($today,0,1000)->num_rows;
			$config['base_url'] = $url.'ride/search';
			$config['total_rows'] = $num_rows;
			$config['per_page'] = 10; 
			$this->pagination->initialize($config); 
			
			$next = intval($this->uri->segment(3,0));		
			$per_page = $config['per_page'];
		
			$search_data['data'] = $this->search_model->search_all_results_today($today,$next,$per_page)->result();
			$this->load->view('rides/search_result_view.php',$search_data);
		}
		else if ($destination == "" && $depart_date == "") //search by destination
		{	//If destination and departure date is null return all results starting from source
			//Pagination Configuration
			$num_rows =  $this->search_model->search_by_source($source,0,1000)->num_rows;
			$config['base_url'] = $url."ride/search?source=".$_GET['source']."&destination=&date=&submit=search&view=".$_GET['view'];
			$config['total_rows'] = $num_rows;
			$config['per_page'] = 10;
			$config['page_query_string'] = TRUE;
			$config['query_string_segment'] = 'page';
			$this->pagination->initialize($config);
			
			if (!isset($_GET['page']))
			{
				$next= 0;
			}
			else
			{
				$next = intval($_GET['page']);
			}	
			$per_page = $config['per_page'];
			
			$search_data['data'] = $this->search_model->search_by_source($source,$next,$per_page)->result();
			$this->load->view('rides/search_result_view.php',$search_data);
		}
		
		else if($source == "" && $depart_date == "") //search by destination
		{
			//If source and departure date are null returns all results starting from destination
			//Pagination Configuration
			$num_rows =  $this->search_model->search_by_destination($destination,0,1000)->num_rows;
			$config['base_url'] = $url."ride/search?source=&destination=".$_GET['destination']."&date=&submit=search&view=".$_GET['view'];
			$config['total_rows'] = $num_rows;
			$config['per_page'] = 10;
			$config['page_query_string'] = TRUE;
			$config['query_string_segment'] = 'page';
			$this->pagination->initialize($config);
			
			if (!isset($_GET['page']))
			{
				$next= 0;
			}
			else
			{
				$next = intval($_GET['page']);
			}	
			$per_page = $config['per_page'];
	
			$search_data['data'] = $this->search_model->search_by_destination($destination,$next,$per_page)->result();
			$this->load->view('rides/search_result_view.php',$search_data);
		}
		
		else if($source == "" && $destination == "") // Search by date
		{
			//If source and departure are null returns all results from the particular date
			//Pagination Configuration
			$num_rows =  $this->search_model->search_by_date($depart_date,0,1000)->num_rows;
			$config['base_url'] = $url."ride/search?source=&destination=&date=".$_GET['date']."&submit=search&view=".$_GET['view'];
			$config['total_rows'] = $num_rows;
			$config['per_page'] = 10;
			$config['page_query_string'] = TRUE;
			$config['query_string_segment'] = 'page';
			$this->pagination->initialize($config);
			
			if (!isset($_GET['page']))
			{
				$next= 0;
			}
			else
			{
				$next = intval($_GET['page']);
			}	
			$per_page = $config['per_page'];
			//$date = $this->input->get('date');
			$search_data['data'] = $this->search_model->search_by_date($depart_date,$next,$per_page)->result();
			$this->load->view('rides/search_result_view.php',$search_data);
		}
		
		else // if all values are provided
		{
			//pagination configuration	
			$num_rows =  $this->search_model->search_by_source_destination_date($source,$destination,$depart_date,0,1000)->num_rows;
			$config['base_url'] = $url."ride/search?source=".$_GET['source']."&destination=".$_GET['destination']."&date=".$_GET['date']."&submit=search&view=".$_GET['view'];
			$config['total_rows'] = $num_rows;
			$config['per_page'] = 10;
			$config['page_query_string'] = TRUE;
			$config['query_string_segment'] = 'page';
			$this->pagination->initialize($config);
			
			if (!isset($_GET['page']))
			{
				$next= 0;
			}
			else
			{
				$next = intval($_GET['page']);
			}	
			$per_page = $config['per_page'];
			//$date = $this->input->get('date');
		$search_data['data'] = $this->search_model->search_by_source_destination_date($source,$destination,$depart_date,$next,$per_page)->result();
		$this->load->view('rides/search_result_view.php',$search_data);
		}
	}


	


}