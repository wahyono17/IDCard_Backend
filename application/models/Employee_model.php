<?php  
class Employee_model extends CI_Model{
  
    public function getEmployee($nomor){
        
        if(empty($nomor)){
            $query = $this->db->query('SELECT Employee_id,First_Name,Date_of_join, Date_of_expired, Dept_id, Code_id FROM employee LIMIT 9');//KARENA PAKAI MYSQLDATABASE MAKA PAKAI LIMIT
            return $query->result_array();
        }else {
            $query = $this->db->query('SELECT * FROM employee WHERE Employee_id IN ('.$nomor.')');
            return $query->result_array();            
        }
        
    }
    
    public function deleteEmployee($Employee_id){
        $this->db->where('Employee_id',$Employee_id);
        $this->db->delete('employee');
        return $this->db->affected_rows();
        
    }

    public function postEmployee($data){
        $this->db->insert('Employee',$data);
        return $this->db->affected_rows();
    }

    public function editEmployee($data,$Employee_id){
        
        $this->db->update('employee',$data,['Employee_id'=>$Employee_id]);
        return $this->db->affected_rows();
    }
    
}
?>