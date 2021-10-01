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

		$this->load->view('header',$this->data);
		$this->load->view('main');
		$this->load->view('footer');
	}




}
