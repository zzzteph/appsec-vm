<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

	private $data;
    function setSession()
    {
		$this->data['login']=$this->session->userdata('login');
		$this->data['id']=$this->session->userdata('id');
	}
	
	public function index()
	{
		$this->setSession();
	    $data['posts']=$this->Posts->load();	
		$this->load->view('header',$this->data);
		$this->load->view('main',$data);
		$this->load->view('footer');
	}

	
		public function post($post_id)
	{
		$this->setSession();
	    $data['post']=$this->Posts->getPost($post_id);
		$data['isliked']=$this->Posts->checkLike($post_id,$this->session->userdata('id'));
		$data['user_id']=$this->session->userdata('id');
		$this->load->view('header',$this->data);
		$this->load->view('post',$data);
		$this->load->view('footer');
	}

	
	
	public function addcomment()
	{
	
	
			if($this->Posts->getPost($this->input->post('post_id'))==FALSE)
		{
			redirect('/');
			return;
		}
		
	
		if($this->session->userdata('id')==NULL)
		{
			redirect('/posts/'.$this->input->post('post_id'));	
			return;
		}
		

		
		if($this->input->post('post_id')!=NULL && $this->input->post('comment')!=NULL)
		{
				$this->Posts->addComment($this->input->post('post_id'),$this->session->userdata('id'),$this->input->post('comment'));
		}

		redirect('/posts/'.$this->input->post('post_id'));		

		
					
	}

	  
	  
	  

	    public function auth()
	{		

			$this->load->view('header');
			$this->load->view('login');
			$this->load->view('footer');

    }
    

	

	

	
    
     public function logout()
	{		
		$this->session->sess_destroy();
		redirect('/');
    }
    
    
    
    
    public function login()
	{
		if($this->input->post('password')!=NULL && $this->input->post('login')!=NULL)
		{
			$hpassword = md5($this->input->post('password'));
			$status=$this->Users->login($this->input->post('login'),$hpassword);
			if($status!==FALSE)
			{
				$this->session->set_userdata($status);
				redirect('/');
				return;
			}
			else
			{
				$data['error']="login or password incorrect";
			}
		}
		else
		{
			$data['error']="login or password not set";
		}
		$this->load->view('header');
		$this->load->view('login',$data);
		$this->load->view('footer');
		
    }


	
	
	
	public function addlike($id)
	{

			if($this->Posts->getPost($id)==FALSE)
		{
			redirect('/');
			return;
		}



		if($this->session->userdata('id')==NULL)
		{
			redirect('/');
			redirect('/posts/'.$id);
			return;
		}
	
		
			$this->Posts->addlike($this->session->userdata('id'),$id);
			redirect('/posts/'.$id);
		
	}
	
		public function dislike($id)
	{

			if($this->Posts->getPost($id)==FALSE)
		{
			redirect('/');
			return;
		}



		if($this->session->userdata('id')==NULL)
		{
			redirect('/');
			redirect('/posts/'.$id);
			return;
		}
			$this->Posts->dislike($this->session->userdata('id'),$id);
			redirect('/posts/'.$id);
		
	}
	
}
