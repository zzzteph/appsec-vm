<?php
class Message extends CI_Model {

		 function getUserById($id)
		 {
				$query=$this->db->get_where('users', array('id' => $id));	
				foreach ($query->result() as $row)
				{
					return $row->login;
				}
		 }

	 public function getLatest($id)
        {
			$id=intval($id);
			$this->db->select("*");
			$this->db->from("messages");
			$where = "sid=$id or did=$id";
			$this->db->where($where);
			$this->db->order_by('id', 'desc');
			$this->db->limit(1);
			$messages=$this->db->get();
			$message_count=0;
			$dialog=array();
			foreach ($messages->result() as $message)
			{
					$dialog['id']=$message->id;
					$dialog['sid']=$message->sid;
					$dialog['did']=$message->did;
					$dialog['info']=$message->info;
					$dialog['suser']=$this->getUserById($dialog['sid']);
					$dialog['duser']=$this->getUserById($dialog['did']);
			}
			return $dialog;
        }
		 
		 

        public function getAll($id)
        {
			$id=intval($id);
			$this->db->select("*");
			$this->db->from("messages");
			$where = "sid=$id or did=$id";
			$this->db->where($where);
			$this->db->order_by('id', 'desc');
			$this->db->limit(5);
			$messages=$this->db->get();
			$message_count=0;
			$dialog=array();
			foreach ($messages->result() as $message)
			{
					$dialog[$message_count]['id']=$message->id;
					$dialog[$message_count]['sid']=$message->sid;
					$dialog[$message_count]['did']=$message->did;
					$dialog[$message_count]['info']=$message->info;
					$dialog[$message_count]['suser']=$this->getUserById($dialog[$message_count]['sid']);
					$dialog[$message_count]['duser']=$this->getUserById($dialog[$message_count]['did']);
					$message_count++;
			}
			return $dialog;
        }
		
        public function write($sid,$did,$info)
        {
            	   $data = array(
						'sid' => $sid,
						'did' => $did,
						'info' => $info
					);
					$this->db->insert('messages', $data);
                    return $this->db->insert_id();
        }
		
		public function knownAddresses($id)
        {
            $id=intval($id);
			$this->db->select("sid,did");
			$this->db->from("messages");
			$where = "sid=$id or did=$id";
			$this->db->where($where);
			$addresses=array();
			$address_count=0;
			$messages=$this->db->get();
			foreach ($messages->result() as $message)
			{
				$found=false;
				for($i=0;$i<$address_count;$i++)
				{
					if($addresses[$i]['id']==$message->sid)
						$found=true;
				}
				if($found==false && $message->sid!=$id)
				{
					$addresses[$address_count]['id']=$message->sid;
					$addresses[$address_count]['user']=$this->getUserById($message->sid);
					$address_count++;
				}
				$found=false;
				for($i=0;$i<$address_count;$i++)
				{
					if($addresses[$i]['id']==$message->did)
						$found=true;
				}
				if($found==false && $message->did!=$id)
				{
					
					$addresses[$address_count]['id']=$message->did;
					$addresses[$address_count]['user']=$this->getUserById($message->did);
					$address_count++;
				}
				

			}	
			//left only uniqid
			
			return $addresses;
			
        }
		
		
		
      
}
