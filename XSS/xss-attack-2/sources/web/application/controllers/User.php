<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    private $data;
    function setSession()
    {
		$this->data['login']=$this->session->userdata('login');
		$this->data['id']=$this->session->userdata('id');
	}
    
    
    public function index()
	{		
		$this->setSession();
		if($this->data['login']==NULL)
		{
			redirect('/login');
		}
		else
		{
			$data=$this->users->getUserInfo($this->data['id']);
			$data['sid']=$this->data['id'];
			$this->load->view('header',$this->data);
			$this->load->view('userpage',$data);
			$this->load->view('footer');

			
		}
    }
    
     public function userpage($id)
	{	
		$this->setSession();
		$data=$this->users->getUserInfo($id);
		$data['sid']=$this->data['id'];
		$this->load->view('header',$this->data);
		$this->load->view('userpage',$data);
		$this->load->view('footer');
    }
    
	public function setting_page()
	{	

		$this->setSession();
		if($this->session->userdata('login')==NULL)
		{
			redirect('/login');
			return 0;
		}
		
		
		
		$data=$this->users->getUserInfo($this->session->userdata('id'));
		$data['sid']=$this->data['id'];
		if($this->input->post('password')!=NULL && $this->input->post('cpassword')!=NULL)
		{
			if($this->input->post('password')==$this->input->post('cpassword'))
			$result=$this->users->changeUserPassword($this->data['id'],do_hash($this->input->post('password'),'md5'));
		}
		
		
		$this->load->view('header',$this->data);
		$this->load->view('edituser',$data);
		$this->load->view('footer');
    }

    
     public function logout()
	{		
		$this->session->sess_destroy();
		redirect('/');
    }
    
    
    
    
    public function login()
	{
		$this->setSession();
		if($this->session->userdata('login')!=NULL)
		{
			redirect('/user/'.$this->session->userdata('id'));
		}
		$data['password']=$this->input->post('password');
		$data['login']=$this->input->post('login');
		if($data['login']!=NULL && $data['password']!=NULL)
		{
		
			
			$hpassword = do_hash($data['password'], 'md5');
			$status=$this->users->login($data['login'],$hpassword);
			if($status!==FALSE)
			{
				$this->session->set_userdata($status);
				redirect('/user/'.$status['id']);
			}
			else
			{
				$data['error']="login or password incorrect";
			}
		}
		
		$this->load->view('header',$this->data);
		$this->load->view('login',$data);
		$this->load->view('footer');
		
    }
    

	
    
    
    public function registration()
	{
		
		$this->setSession();
		if($this->session->userdata('login')!=NULL)
		{
			redirect('/user/'.$this->session->userdata('id'));
		}
		
		$data['password']=$this->input->post('password');
		$data['cpassword']=$this->input->post('cpassword');
		$data['login']=$this->input->post('login');
	
		if($data['login']!=NULL && $data['password']!=NULL)
		{
			if($data['password']!=$data['cpassword'])
			{
				$data['error']="PASSWORDS are not the same";
			}
			else
			{
				$hpassword = do_hash($data['password'], 'md5');
				$status=$this->users->registerUser($data['login'],$hpassword);
				if($status!==FALSE)
				{
					$this->session->set_userdata($status);
				
					redirect('/user/'.$status['id']);
				}
			}
		}
		$this->load->view('header',$this->data);
		$this->load->view('registration',$data);
		$this->load->view('footer');
	}
	
	public function DragHU8t27C6n9ff()
	{
		$this->setSession();
		if($this->data['id']!=1)
		{
			echo "ACCESS FORBIDDEN!";
			die();
		}
		if ($this->input->server('REQUEST_METHOD') != 'GET')
		{
			echo "ACCESS FORBIDDEN!";
			die();
		}
		if ($this->input->is_ajax_request()) {
			echo "ACCESS FORBIDDEN! BUT YOU NEAR!";
			die();
		}
		
		echo "You are awesome - Yu_d0nt_need_c00kies";
	}

	
}
