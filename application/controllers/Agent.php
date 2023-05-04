<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Agent extends CI_Controller {
    public function __construct(){
      parent::__construct();
      $this->load->model('api_model');
      $this->load->database();

      header("Access-Control-Allow-Origin: *");
      header("Content-Type: application/json; charset=UTF-8");
      header("Access-Control-Allow-Methods: POST");
      header("Access-Control-Max-Age: 3600");
      header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    }
    public function email_checked() {
      //email
      $response = array();

      $email = $this->input->post('email');

      if($email != '' ){
        $data = array(
                'email'  => $email
            );
        $return  = $this->api_model->get_table_data_by_values($data,'agent');
        
        if($return){
            $response['flag']  = 1;
            $response['message'] = 'Email already exists';

        }else{
            $response['flag']  = 0;
            $response['message'] = 'Email does not exists';

        }
      }else{
        $response['flag']  = 0;
        $response['message'] = 'Something Wrong..';
      }  

      echo json_encode($response);
    }
    public function phone_checked() {
      //phone
      $response = array();

      $phone = $this->input->post('phone');

      if($phone != '' ){
        $data = array(
                'phoneNum'  => $phone
            );
        $return  = $this->api_model->get_table_data_by_values($data,'agent');
        
        if($return){
            $response['flag']  = 1;
            $response['message'] = 'Phone No. already exists';

        }else{
            $response['flag']  = 0;
            $response['message'] = 'Phone No. does not exists';
        }
      }else{
        $response['flag']  = 0;
        $response['message'] = 'Something Wrong..';
      }  

      echo json_encode($response);
    }
    private function hashPassword($pass, $salt=FALSE) {
        //  The following will put the $salt at the begining, middle, and end of the password.
        //  A little extra salt never hurt.
        if (!empty($salt)) $pass = $salt . implode($salt, str_split($pass, floor(strlen($pass)/2))) . $salt;
        return md5( $pass );
    }
    public function signup() {
      //name, email, phone, password, occupation, adhar_number, annual_income, agent(0=>'No',1=>'Yes'), dob, address
      $response = array();

      $name = $this->input->post('name');
      $email = $this->input->post('email');
      $phone = $this->input->post('phone');
      $password = $this->input->post('password');
      $occupation = $this->input->post('occupation');
      $adharNumber = $this->input->post('adhar_number');
      $annualIncome = $this->input->post('annual_income');
      $agent = $this->input->post('agent');
      $dob = $this->input->post('dob');
      $address = $this->input->post('address');

      if($name != '' && $email != '' && $phone != '' && $password != '' ){
        $data = array(
              'name'  => $name,
              'email'  => $email,
              'phoneNum'  => $phone,
              'password'  => $this->hashPassword($password, 'arghya'),
              'occupation'  => $occupation,
              'adharNumber'  => $adharNumber,
              'annualIncome'  => $annualIncome,
              'agent'  => $agent,
              'dob'  => $dob,
              'address'  => $address
          );

        $result = $this->api_model->add_table_data($data,'agent');

        if($result){
            $response['data']  = $this->api_model->get_table_data_by_id($result,'agent');
            $response['flag']  = 1;
            $response['message'] = 'User registration succesfully done';

        }else{
            $response['flag']  = 0;
            $response['message'] = 'User registration not succesfully done';

        }
      }else{
        $response['flag']  = 0;
        $response['message'] = 'Something Wrong..';
      }
      
      echo json_encode($response);
    }
    public function login() {
      //phone, password, agent(0=>'No',1=>'Yes')
      $response = array();

      $phone = $this->input->post('phone');
      $password = $this->input->post('password');
      $agent = $this->input->post('agent');

      if( $phone != '' && $password != '' ){
        $data = array(
                'phoneNum'  => $phone,
                'password'  => $this->hashPassword($password, 'arghya'),
                'agent'  => $agent
            );
        $return  = $this->api_model->get_table_data_by_values($data,'agent');

        if($return){
            $response['data']  = $return;
            $response['flag']  = 1;
            $response['message'] = 'Success';

        }else{
            $response['flag']  = 0;
            $response['message'] = 'Error';
        }
      }else{
        $response['flag']  = 0;
        $response['message'] = 'Something Wrong..';
      }
        
      echo json_encode($response);
    }
    public function get_user_data() {
      //user_id, agent(0=>'No',1=>'Yes')
      $response = array();

      $user_id = $this->input->post('user_id');
      $agent = $this->input->post('agent');

      if($user_id != '' ){
        $data = array(
                'id'  => $user_id,
                'agent'  => $agent
            );
        $return  = $this->api_model->get_table_data_by_values($data,'agent');
        
        if($return){
            $response['data']  = $return;
            $response['flag']  = 1;
            $response['message'] = 'Success';

        }else{
            $response['flag']  = 0;
            $response['message'] = 'Error';
        }
      }else{
        $response['flag']  = 0;
        $response['message'] = 'Something Wrong..';
      }

      echo json_encode($response);
    }
    public function agent_listing(){
      $response = array();

        $data = array(
          'agent'  => '1'
        );
        $return  = $this->api_model->list_table_data_by_values($data,'agent');
        
        if($return){
            $response['data']  = $return;
            $response['flag']  = 1;
            $response['message'] = 'Success';

        }else{
            $response['flag']  = 0;
            $response['message'] = 'Error';
        }

      echo json_encode($response);
    }
    
}
