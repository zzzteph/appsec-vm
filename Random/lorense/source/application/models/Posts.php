<?php
class Posts extends CI_Model {



        public function createPost($uid,$title,$info)
        {
            	   $data = array(
						'title' => $title,
						'info' => $info,
						'uid' => $uid
					);
					$this->db->insert('posts', $data);
                    return $this->db->insert_id();
        }
		 
		
		 
		 public function getPost($id)
        {
			     
				$query=$this->db->get_where('posts', array('id' => $id));	
				foreach ($query->result() as $row)
				{
					$data['id']=$row->id;
					$data['title']=$row->title;
					$data['info']=$row->info;
					return $data;
				}
				return FALSE; 
        }
		

		public function deletePost($uid,$id)
		{
			$this->db->delete('posts', array('id' => $id,'uid'=>$uid));	
		}
		
		
		public function load($uid)
		{
			$query = $this->db->select('id,title,info')
                ->where('uid', $uid)
                ->get('posts');
			return $query->result_array();	
			
		}
		
		public function updatePost($id,$title,$info)
		{
							$data = array(
						'title' => $title,
						'info' => $info
				);
			
				$this->db->where('id', $id);
				$this->db->update('posts', $data);
		}
		
		
}
