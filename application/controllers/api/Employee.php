<?php  
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
//To Solve File REST_Controller not found
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Employee extends REST_Controller{

    public function index_get(){
        
        $nomor = $_GET;
        if(empty($nomor)){
            $nomor = $nomor;
        }else{
            $nomor = $nomor['id'];
        }   
        
        $this->load->model('Employee_model');
        $Employee = $this->Employee_model->getEmployee($nomor);
     
        // jika ketemu $Employee maka confer to json
        if ($Employee){
            $this->response([
                'status' => true,'data' => $Employee
            ], REST_Controller::HTTP_OK); 
        } else{
            $this->response([
                'status' => false,'message' => 'data not found'
            ], REST_Controller::HTTP_NOT_FOUND); 
        }    
    
    }

    public function index_delete(){
        $this->load->model('Employee_model');
        $Employee_id = $this->delete('Employee_id');

        //handle error
        if($Employee_id === null){
            $this->response([
                'status' => false,'message' => 'required id'
            ], REST_Controller::HTTP_BAD_REQUEST); 

        }else
        if($this->Employee_model->deleteEmployee($Employee_id) > 0) {

            $this->response([
                'status' => true,'Employee' => $Employee_id,'message' => 'employee deleted'
            ], REST_Controller::HTTP_OK); 
        }else{
            $this->response([
                'status' => false,'message' => 'Employee not found'
            ], REST_Controller::HTTP_NOT_FOUND); 
        
        }
        
    }

    public function index_post(){
        $this->load->model('Employee_model');

        $data = [
            'Employee_id'=> $this->post('Employee_id'),
            'First_Name'=> $this->post('First_Name'),
            'Date_of_join'=> $this->post('Date_of_join'),
            'Date_of_Expired'=> $this->post('Date_of_Expired'),
            'Dept_Id'=>$this->post('Dept_Id'),
            'Code_Id'=>$this->post('Code_Id')
        ];

        if ($this->Employee_model->postEmployee($data) > 0 ){
            //ok
            $this->response([
                'status' => true,'Employee' => $data['Employee_id'],'message' => 'employee post'
            ], REST_Controller::HTTP_CREATED); 
        }else
            //post fail
            $this->response([
                'status' => false,'message' => 'post fail'
            ], REST_Controller::HTTP_BAD_REQUEST); 

    }

    public function index_put(){
        $this->load->model('Employee_model');
        $Employee_id = $this->put('Employee_id');

        $data = [
            
            'First_Name'=> $this->put('First_Name'),
            'Date_of_join'=> $this->put('Date_of_join'),
            'Date_of_Expired'=> $this->put('Date_of_Expired'),
            'Dept_Id'=>$this->put('Dept_Id'),
            'Code_Id'=>$this->put('Code_Id')
        ];

        if ($this->Employee_model->editEmployee($data,$Employee_id) > 0 ){
            //ok
            $this->response([
                'status' => true,'Employee' => $Employee_id,'message' => 'employee edit'
            ], REST_Controller::HTTP_OK); 
        }else
            //post fail
            $this->response([
                'status' => false,'message' => 'update data fail'
            ], REST_Controller::HTTP_BAD_REQUEST); 
    }
}
?>