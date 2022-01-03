<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

 private $data;
    function setSession()
    {
		$this->data['login']=$this->session->userdata('login');
		$this->data['rights']=$this->session->userdata('rights');
		$this->data['id']=$this->session->userdata('id');
	}
	
	public function decrypt($id)
	{
		if($this->session->userdata('login')!=NULL)
		{
			return $this->supersecurity->decrypt($id);
	
		}
		return 0;
	}	
	
	public function encrypt($id)
	{
		if($this->session->userdata('login')!=NULL)
		{
			return $this->supersecurity->encrypt($id);
	
		}
		return FALSE;
	}
	
	
	public function index()
	{

		$this->setSession();
		$this->load->view('header',$this->data);
			
		if($this->session->userdata('login')!=NULL)
		{
			if($this->input->post('title')!==NULL && $this->input->post('info')!==NULL)
			{
				$this->posts->createPost($this->session->userdata('id'),$this->input->post('title'),$this->input->post('info'));
				
			}	
				$posts=$this->posts->load($this->session->userdata('id'));	
			//encryptPosts
				foreach ($posts as &$post)
				{
					$post['id']=$this->encrypt($post['id']);

				}	
			
			$data['posts']=$posts;
		
			$this->load->view('main',$data);
		}
		else
		{
		$this->load->view('landing');

		}
		$this->load->view('footer');

		
	}

	
	public function edit($id)
	{
		$this->setSession();
		if($this->session->userdata('login')!=NULL)
		{
			$id=$this->decrypt($id);
			if($this->input->post('title')!==NULL && $this->input->post('info')!==NULL )
			{
				$this->posts->updatePost($id,$this->input->post('title'),$this->input->post('info'));
			}			
			$data=$this->posts->getPost($id);
			$data['id']=$this->encrypt($data['id']);
			$this->load->view('header',$this->data);
			$this->load->view('post',$data);
			$this->load->view('footer');
		}
		else
		{
			redirect('/');
		}	
	}

	  
	  
	  
	  
	 function delete($id)
	{

		$this->setSession();
		if($this->session->userdata('login')!=NULL)
		{			
			$this->posts->deletePost($this->session->userdata('id'),$this->decrypt($id));
		}
		redirect('/');
		
	}
	
	
	function admin()
	{
		$this->setSession();
		if($this->session->userdata('id')!='1')
		{
				redirect('/');
				die();
				
		}
		
		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
		{    
				redirect('/');
				die();   
		}
		echo "WOW, You flag is: Lor3nse_flag_1!";
		
		
	}
	
	
	
}
