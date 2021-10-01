<?php
class Users extends CI_Model {


		//FALSE - user already registered
		
        public function registerUser($login,$password)
        {
                $this->db->select('*');
				$this->db->from('users');
				$this->db->where('login', $login);
                if($this->db->count_all_results()==0)
                {
					$data = array(
						'login' => $login,
						'password' => $password
					);
					$this->db->insert('users', $data);
					$query=$this->db->get_where('users', $data);
					unset($data);
					
					foreach ($query->result() as $row)
					{
							$data['login']=$row->login;
							$data['rights']=$row->rights;
							$data['id']=$row->id;
					}
					return $data;
				}
				
				return FALSE; 
        }

		public function countUsers()
		{
			$this->db->select('*');
			$this->db->from('users');
			return $this->db->count_all_results();
		}
		
		        public function loginBot($login)
        {
				$data = array('login' => $login);
				$query=$this->db->get_where('users', $data);	
				foreach ($query->result() as $row)
				{
					$data['login']=$row->login;
					$data['rights']=$row->rights;
					$data['id']=$row->id;
					return $data;
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
					$data['rights']=$row->rights;
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
					$data['name']=$row->name;
					$data['surname']=$row->surname;
					$data['info']=$row->info;
					$data['login']=$row->login;
					$data['rights']=$row->rights;
					$data['avatar']=$row->avatar;
					$data['password']=$row->password;
					return $data;
				}
				return FALSE; 
        }

		
		public function updateAvatar($image,$id)
		{
			$data = array('avatar' => $image);
			$this->db->where('id', $id);
			$this->db->update('users', $data);
			
			
		}
		
		
		public function updateUserInfo($id,$type,$value)
        {
				$data = array($type => $value);
				$this->db->where('id', $id);
				$this->db->update('users', $data);
        }
        public function updateUserPicture($id,$picture)
        {
				$data = array(
					'avatar' => $picture
				);

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
