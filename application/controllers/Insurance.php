<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/API_Controller.php';

class Insurance extends CI_Controller {
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
    public function add() {
      //amount, insurance_type, agent_id, duration
      $response = array();

      $amount = $this->input->post('amount');
      $insuranceType = $this->input->post('insurance_type');
      $agent_id = $this->input->post('agent_id');
      $duration = $this->input->post('duration');

      if($amount != '' && $insuranceType != '' && $agent_id != '' && $duration != '' ){
        $data = array(
              'amount'  => $amount,
              'insuranceType'  => $insuranceType,
              'agent_id'  => $agent_id,
              'duration'  => $duration
          );

        $result = $this->api_model->add_table_data($data,'insurance');

        if($result){
            $response['data']  = $this->api_model->get_table_data_by_id($result,'insurance');
            $response['flag']  = 1;
            $response['message'] = 'Insurance has been succesfully Submitted';

        }else{
            $response['flag']  = 0;
            $response['message'] = 'Insurance has been not succesfully Submitted';

        }
      }else{
        $response['flag']  = 0;
        $response['message'] = 'Something Wrong..';
      }
      
      echo json_encode($response);
    }
    public function edit() {
      //insurance_id, amount, insurance_type, agent_id, duration
      $response = array();

      $insurance_id = $this->input->post('insurance_id');
      $amount = $this->input->post('amount');
      $insuranceType = $this->input->post('insurance_type');
      $agent_id = $this->input->post('agent_id');
      $duration = $this->input->post('duration');

      if($insurance_id != '' && $amount != '' && $insuranceType != '' && $agent_id != '' && $duration != '' ){
        $data = array(
              'amount'  => $amount,
              'insuranceType'  => $insuranceType,
              'agent_id'  => $agent_id,
              'duration'  => $duration,
              'updateAt'  => date('Y-m-d h:i:s')
          );

        $result = $this->api_model->update_table_data($data, $insurance_id, 'insurance');

        if($result){
            $response['data']  = $this->api_model->get_table_data_by_id($insurance_id,'insurance');
            $response['flag']  = 1;
            $response['message'] = 'Insurance has been updated succesfully';

        }else{
            $response['flag']  = 0;
            $response['message'] = 'Insurance has been not updated succesfully';

        }
      }else{
        $response['flag']  = 0;
        $response['message'] = 'Something Wrong..';
      }
      
      echo json_encode($response);
    }
    public function delete() {
      //insurance_id
      $response = array();

      $insurance_id = $this->input->post('insurance_id');

      if($insurance_id != ''){
        $data = array(
              'is_deleted'  => '1',
          );

        $result = $this->api_model->update_table_data($data, $insurance_id, 'insurance');

        if($result){
            $response['flag']  = 1;
            $response['message'] = 'Insurance has been deleted succesfully';

        }else{
            $response['flag']  = 0;
            $response['message'] = 'Insurance has been not deleted succesfully';

        }
      }else{
        $response['flag']  = 0;
        $response['message'] = 'Something Wrong..';
      }
      
      echo json_encode($response);
    }
    public function listing() {
      //insurance_id
      $response = array();
      
      $return  = $this->api_model->listing_table_data('insurance');
        
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
    public function get_insurance_by_id(){
      //insurance_id
      $response = array();

      $insurance_id = $this->input->post('insurance_id');

      if($insurance_id != '' ){
        $return  = $this->api_model->get_table_data_by_id($insurance_id,'insurance');

        $data = array(
          'insurance_id'  => $insurance_id
        );
        $transaction_list  = $this->api_model->list_table_data_by_values($data,'transaction');
        
        $resp_data = array();
        if($return){
            $resp_data['insurance']  = $return;
            $resp_data['transaction']  = $transaction_list;

            $response['data']  = $resp_data;
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
    public function get_insurance_by_agentId() {
      //agent_id
      $response = array();

      $agent_id = $this->input->post('agent_id');

      if($agent_id != '' ){
        $data = array(
          'agent_id'  => $agent_id
        );
        $return  = $this->api_model->list_table_data_by_values($data,'insurance');
        
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
    public function get_insurance_by_agentId_with_transaction() {
      //agent_id
      $response = array();

      $agent_id = $this->input->post('agent_id');

      if($agent_id != '' ){
        $data = array(
          'agent_id'  => $agent_id
        );
        $returns  = $this->api_model->list_table_data_by_values($data,'insurance');
        
        $resp_data = array();
        $resp_datas = array();
        if($returns){
          foreach ($returns as $key => $value) {
            $resp_data['insurance'] = $value;

            $data = array(
              'insurance_id'  => $value['id']
            );
            $transaction_list  = $this->api_model->list_table_data_by_values($data,'transaction');

            $resp_data['transaction'] = $transaction_list;

            $resp_datas[] = $resp_data;
          }

          $response['data']  = $resp_datas;
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
}
