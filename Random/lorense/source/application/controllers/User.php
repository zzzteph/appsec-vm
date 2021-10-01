<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    private $data;
    function setSession()
    {
		$this->data['login']=$this->session->userdata('login');
		$this->data['rights']=$this->session->userdata('rights');
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
			$data['srights']=$this->data['rights'];
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
		$data['srights']=$this->data['rights'];
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
		$data['srights']=$this->data['rights'];
		$this->load->view('header',$this->data);
		$this->load->view('settings_page',$data);
		$this->load->view('footer');
    }
    
	
	
	
	
	public function UserSettings()
	{	
			$this->setSession();
			$data=array();
			if($this->session->userdata('login')==NULL)
			{
				redirect('/login');
			}
			else
			{
							
				if(isset($_FILES['file']))
				{
					if(isset($_FILES['file']['name']))
					{
						if(strlen($_FILES['file']['name'])>0 && $_FILES['file']['size']>0)
						{
							$path_parts = pathinfo($_FILES['file']['name']);
							$extension= strtolower($path_parts['extension']);
							if(($extension==="jpg" ||$extension==="jpeg"||$extension==="png") && $_FILES['file']['size']<1024*1024)
							{
								$uploaddir = '/var/www/html/uploads/';
								$filename=random_string('alnum', 16);
								$uploadfile = $uploaddir.$filename;	
								if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {	
									$this->users->updateAvatar($filename,$this->session->userdata('id'));
								} 	
							}
						}
					}
				}

				if($this->input->post('name')!==NULL)
				{
					$this->users->updateUserInfo($this->session->userdata('id'),"name",$this->input->post('name'));
				}
				if($this->input->post('surname')!==NULL)
				{
					$this->users->updateUserInfo($this->session->userdata('id'),"surname",$this->input->post('surname'));
				}
				
				if($this->input->post('info')!==NULL)
				{
					$this->users->updateUserInfo($this->session->userdata('id'),"info",$this->input->post('info'));
				}
				
							
				$data['user']=$this->users->getUserInfo($this->session->userdata('id'));
				$this->load->view('header',$this->data);
				$this->load->view('usersettings',$data);
				$this->load->view('footer');
				
			}
    }
	
	
	

	
	public function PasswordSettings()
	{	
			$this->setSession();
			$data=array();
			if($this->session->userdata('login')==NULL)
			{
				redirect('/login');
			}
			else
			{
					
				if($this->input->post('password')!=NULL && $this->input->post('cpassword')!=NULL)
				{
					$password=$this->input->post('password');
					$cpassword=$this->input->post('cpassword');
					if($password!=$cpassword)
					{
						$data['error']="PASSWORDS NOT THE SAME";
					}
					else
					{
						$password = do_hash($password, 'md5');
						$result=$this->users->changeUserPassword($this->data['id'],$password);
						redirect('/user/change/password');
					}
				}
				else{
					$data=$this->users->getUserInfo($this->data['id']);
					$this->load->view('header',$this->data);
					$this->load->view('passwordsettings',$data);
					$this->load->view('footer');
				}
			}
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
		$data['password']=$this->input->post('passwd');
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
		
		if($this->input->post('login')!=NULL && $data['password']!=NULL)
		{
			if($data['password']!=$data['cpassword'])
			{
				$data['error']="PASSWORDS are not the same";
			}
			else
			{
				$hpassword = do_hash($data['password'], 'md5');
				$status=$this->users->registerUser($this->input->post('login'),$hpassword);
				
				if($status!==FALSE)
				{

					$this->session->set_userdata($status);
					redirect('/user/'.$status['id']);
				}
			}
		}
		$data['login']=NULL;
		$this->load->view('header',$data);
		$this->load->view('registration',$data);
		$this->load->view('footer');
		
	}
	
	

	
	
}
