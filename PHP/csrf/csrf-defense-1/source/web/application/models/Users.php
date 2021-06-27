<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Users extends CI_Model
{

        public function login($login,$password)
        {
				$data = array('login' => $login,'password' => $password);
				$query=$this->db->get_where('users', $data);	
				foreach ($query->result() as $row)
				{
					$data['login']=$row->login;
					$data['id']=$row->id;
					return $data;
				}
				return FALSE; 
        }

   
    

    
}
