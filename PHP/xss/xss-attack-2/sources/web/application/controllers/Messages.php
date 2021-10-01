<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Messages extends CI_Controller {

    private $data;
    function setSession()
    {
		$this->data['login']=$this->session->userdata('login');
		$this->data['id']=$this->session->userdata('id');
	}
    
    public function index()
	{
		$this->setSession();
		if($this->session->userdata('id')==NULL)
		{
			redirect('/');
			return;
		}

		$data['dialog']=$this->message->getAll($this->session->userdata('id'));
		$data['address_book']=$this->message->knownAddresses($this->session->userdata('id'));
		$this->load->view('header',$this->data);
		$this->load->view('messages',$data);
		$this->load->view('footer');
		
	}
    
    
	 public function writemessage($id)
	{
		$this->setSession();
		if($this->session->userdata('id')==NULL)
		{
			redirect('/');
			return;
		}
		if($id==1 && $this->session->userdata('id')!=2)
		{
			redirect('/');
			return;
		}
		
		
		if($this->input->post('info')!=NULL)
		{
			$this->message->write($this->session->userdata('id'),$id,$this->input->post('info'));
		}
		
		$data['dialog']=$this->message->getAll($this->session->userdata('id'));
		$data['destination']=$this->users->getUserInfo($id);
		$data['source']=$this->users->getUserInfo($this->session->userdata('id'));
		$data['id']=$id;
		$data['address_book']=$this->message->knownAddresses($this->session->userdata('id'));
		if($data['source']==FALSE || $data['destination']==FALSE|| $id==$this->session->userdata('id'))
		{
			redirect('/');
			return;
		}

		$this->load->view('header',$this->data);
		$this->load->view('write',$data);
		$this->load->view('footer');
	}
	
	public function latestMessage()
	{
		$this->setSession();
		$this->load->view('header',$this->data);
		$data['message']=$this->message->getLatest($this->session->userdata('id'));
		$this->load->view('latest',$data);
		$this->load->view('footer');
	}
	
	
	
}
