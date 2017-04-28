<?php 
	$filepath = realpath(dirname(__FILE__));
	include_once ($filepath.'/../lib/Database.php');
	include_once ($filepath.'/../helpers/Format.php');
?>
    

<?php 
	/**
	* 
	*/
	class Message{
		private $db;
		private $fm;
		public function __construct()
		{
			$this->db = new Database();
			$this->fm = new Format();
		}
		public function sendMessage($data){
			$name = mysqli_real_escape_string($this->db->link,$data['name']);
			$company = mysqli_real_escape_string($this->db->link,$data['company']);
			$phone = mysqli_real_escape_string($this->db->link,$data['phone']);
			$email = mysqli_real_escape_string($this->db->link,$data['email']);
			$message = mysqli_real_escape_string($this->db->link,$data['message']);
			$query = "INSERT INTO tbl_contact(name,company,phone,
		    	email,message) VALUES('$name','$company','$phone','$email','$message')";
		    $inserted_row = $this->db->insert($query);
			if($inserted_row){
				$msg = "<span class='success'>Message Sent Successfully</span>";
				return $msg;
			}else{
				$msg = "<span class='error'>Message Does Not Sent </span>";
				return $msg;
	
			}
		}
		public function getAllMessage(){
			$query = "SELECT * FROM tbl_contact WHERE status = '0'ORDER BY id DESC";
			$result = $this->db->select($query);
			return $result;
		}
		public function sendToSeenBox($id,$time){
			
			$id = mysqli_real_escape_string($this->db->link,$id);
			$date = mysqli_real_escape_string($this->db->link,$time);
			$query = "UPDATE tbl_contact
				SET
				status = '1'
				WHERE id = '$id' AND date = '$date'";
				$updated_row = $this->db->update($query);
				if($updated_row){
					$msg = "<span class='success'> Updated Successfully</span>";
					return $msg;
				}else{
					$msg="<span class='error'> Not Updated!</span>";
					return $msg;
				}
		}
		public function getAllSeenMessage(){
			$query = "SELECT * FROM tbl_contact WHERE status = '1'ORDER BY id DESC";
			$result = $this->db->select($query);
			return $result;
		}
		public function delSeenMsg($id,$time){
			$id = mysqli_real_escape_string($this->db->link,$id);
			$date = mysqli_real_escape_string($this->db->link,$time);
			$query = "DELETE FROM  tbl_contact WHERE id = '$id' AND date = '$date'";
			$deldata = $this->db->delete($query);
			if ($deldata) {
				$msg = "<span class='success'>Data Deleted Successfully</span>";
					return $msg;
			}else{
				$msg="<span class='error'> Data Not Deleted!</span>";
					return $msg;
			}
		}	
	
		public function getAllMessageById($id){
			$query = "SELECT * FROM tbl_contact WHERE id = '$id'";
			$result = $this->db->select($query);
			return $result;
		}
		
		
      
}
 ?>

