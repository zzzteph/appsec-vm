<?php
class Users extends CI_Model {


		
        public function registerUser($login,$password)
        {
                $this->db->select('*');
				$this->db->from('users');
				$this->db->where('login', $login);
                if($this->db->count_all_results()==0)
                {
					$data = array('login' => $login,'password' => $password);
					$this->db->insert('users', $data);
					if($this->db->affected_rows()>0)
					{
						$id=$this->db->insert_id();
						
						if($id!==1)
						$this->message->write(1,$id,"Hello! If you got any questions i will answer. I always monitor chats and read <b><a href='/latest'>LATEST</a></b> messages). ");
						return array('login' => $login,'id' => $id);
					}
				}
				
				return FALSE; 
        }

		

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


        public function getUserInfo($id)
        {
				$query=$this->db->get_where('users', array('id' => $id));	
				foreach ($query->result() as $row)
				{
					$data['id']=$row->id;
					$data['avatar']=$row->avatar;
					$data['info']=$row->info;
					$data['login']=$row->login;
					return $data;
				}
				return FALSE; 
        }
		
		
		
		public function updateInfo($id,$info)
		{
				$data = array('info' => $info);

				$this->db->where('id', $id);
				$this->db->update('users', $data);
		}
	
		public function updateAvatar($id,$path)
		{
				$data = array('avatar' => $path);
				$this->db->where('id', $id);
				$this->db->update('users', $data);
		}



		public function changeUserPassword($id,$password)
        {
				$data = array(
						'id' => $id,
						'password' => $password
				);

				$this->db->where('id', $id);
				$this->db->update('users', $data);
        }
		
		



		
		
}
