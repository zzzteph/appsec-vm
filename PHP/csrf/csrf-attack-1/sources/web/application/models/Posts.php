<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Posts extends CI_Model
{

        public function load()
        {
			$query=$this->db->get('posts');	
			$data=array();
			foreach ($query->result() as $row)
			{
					array_push($data,array(
					'id'=>$row->id,
					'header'=>$row->header,
					'content'=>$row->content,
					'author'=>$this->getUserName($row->user_id),
					'likes'=>$this->likesCount($row->id)));
			}
			return $data;
        }
		
		
		
        public function addComment($post_id,$user_id,$content)
        {
            	   $data = array(
						'post_id' => $post_id,
						'user_id' => $user_id,
						'content' => $content,
					);
					$this->db->insert('comments', $data);
                    return $this->db->insert_id();
        }
		 
		 function getUserName($id)
		 {
				$query=$this->db->get_where('users', array('id' => $id));	
				foreach ($query->result() as $row)
				{
					return $row->login;
				}
		 }
		 
		 function likesCount($id)
		 {
			 $this->db->where('post_id',$id);
			return $this->db->count_all_results('likes');
		 }
		 		 
		 function checkLike($post_id,$user_id)
		 {
			 $this->db->where('post_id',$post_id);
			  $this->db->where('user_id',$user_id);
			if($this->db->count_all_results('likes')>0)return TRUE;
			return FALSE;
		 }

		 public function getPost($id)
        {
			     
				$query=$this->db->get_where('posts', array('id' => $id));	
				foreach ($query->result() as $row)
				{
					$data['id']=$row->id;
					$data['header']=$row->header;
					$data['content']=$row->content;
					$data['author']=$this->getUserName($row->user_id);
					$data['likes']=$this->likesCount($row->id);
				
					$data['comments']=array();
					$this->db->select("*");
					$this->db->from("comments");
					$this->db->order_by('id', 'desc');
				
					$comments=$this->db->get();
					$comments_count=0;
				    foreach ($comments->result() as $comment)
				    {
						array_push($data['comments'],array('id'=> $comment->id,'content'=> $comment->content,'user'=>$this->getUserName($comment->user_id)));
				    }
					return $data;
				}
				return FALSE; 
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
		
		
		public function addlike($user_id,$post_id)
		{
			$data = array(
					'user_id' => $user_id,
					'post_id' => $post_id
			);
			$this->db->where('user_id',  $user_id);
			$this->db->where('post_id', $post_id);
			$this->db->delete('likes');
			$this->db->insert('likes', $data);
			
		}
		public function dislike($user_id,$post_id)
		{
			$data = array(
					'user_id' => $user_id,
					'post_id' => $post_id
			);
			$this->db->where('user_id',  $user_id);
			$this->db->where('post_id', $post_id);
			$this->db->delete('likes');
			
		}
    
}
