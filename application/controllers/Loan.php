<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Loan extends CI_Controller {
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
      //amount, loan_type, agent_id, rate_interest, duration
      $response = array();

      $amount = $this->input->post('amount');
      $loanType = $this->input->post('loan_type');
      $agent_id = $this->input->post('agent_id');
      $rateInterest = $this->input->post('rate_interest');
      $duration = $this->input->post('duration');

      if($amount != '' && $loanType != '' && $agent_id != '' && $duration != '' ){
        $data = array(
              'amount'  => $amount,
              'loanType'  => $loanType,
              'agent_id'  => $agent_id,
              'rateInterest'  => $rateInterest,
              'duration'  => $duration
          );

        $result = $this->api_model->add_table_data($data,'loan');

        if($result){
            $response['data']  = $this->api_model->get_table_data_by_id($result,'loan');
            $response['flag']  = 1;
            $response['message'] = 'Loan has been succesfully Submitted';

        }else{
            $response['flag']  = 0;
            $response['message'] = 'Loan has been not succesfully Submitted';

        }
      }else{
        $response['flag']  = 0;
        $response['message'] = 'Something Wrong..';
      }
      
      echo json_encode($response);
    }
    public function edit() {
      //loan_id, amount, loan_type, agent_id, rate_interest, duration
      $response = array();

      $loan_id = $this->input->post('loan_id');
      $amount = $this->input->post('amount');
      $loanType = $this->input->post('loan_type');
      $agent_id = $this->input->post('agent_id');
      $rateInterest = $this->input->post('rate_interest');
      $duration = $this->input->post('duration');

      if($loan_id != '' && $amount != '' && $loanType != '' && $agent_id != '' && $duration != '' ){
        $data = array(
              'amount'  => $amount,
              'loanType'  => $loanType,
              'agent_id'  => $agent_id,
              'rateInterest'  => $rateInterest,
              'duration'  => $duration,
              'updateAt'  => date('Y-m-d h:i:s')
          );

        $result = $this->api_model->update_table_data($data, $loan_id, 'loan');

        if($result){
            $response['data']  = $this->api_model->get_table_data_by_id($loan_id,'loan');
            $response['flag']  = 1;
            $response['message'] = 'Loan has been updated succesfully';

        }else{
            $response['flag']  = 0;
            $response['message'] = 'Loan has been not updated succesfully';

        }
      }else{
        $response['flag']  = 0;
        $response['message'] = 'Something Wrong..';
      }
      
      echo json_encode($response);
    }
    public function delete() {
      //loan_id
      $response = array();

      $loan_id = $this->input->post('loan_id');

      if($loan_id != ''){
        $data = array(
              'is_deleted'  => '1',
          );

        $result = $this->api_model->update_table_data($data, $loan_id, 'loan');

        if($result){
            $response['flag']  = 1;
            $response['message'] = 'Loan has been deleted succesfully';

        }else{
            $response['flag']  = 0;
            $response['message'] = 'Loan has been not deleted succesfully';

        }
      }else{
        $response['flag']  = 0;
        $response['message'] = 'Something Wrong..';
      }
      
      echo json_encode($response);
    }
    public function listing() {
      $response = array();
      
      $return  = $this->api_model->listing_table_data('loan');
        
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
    public function get_loan_by_id(){
      //loan_id
      $response = array();

      $loan_id = $this->input->post('loan_id');

      if($loan_id != '' ){
        $return  = $this->api_model->get_table_data_by_id($loan_id,'loan');

        $data = array(
          'loan_id'  => $loan_id
        );
        $transaction_list  = $this->api_model->list_table_data_by_values($data,'transaction');
        
        $resp_data = array();
        if($return){
            $resp_data['loan']  = $return;
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
    public function get_loan_by_agentId() {
      //agent_id
      $response = array();

      $agent_id = $this->input->post('agent_id');

      if($agent_id != '' ){
        $data = array(
          'agent_id'  => $agent_id
        );
        $return  = $this->api_model->list_table_data_by_values($data,'loan');
        
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
    public function get_loan_by_agentId_with_transaction() {
      //agent_id
      $response = array();

      $agent_id = $this->input->post('agent_id');

      if($agent_id != '' ){
        $data = array(
          'agent_id'  => $agent_id
        );
        $returns  = $this->api_model->list_table_data_by_values($data,'loan');
        
        $resp_data = array();
        $resp_datas = array();
        if($returns){
          foreach ($returns as $key => $value) {
            $resp_data['loan'] = $value;

            $data = array(
              'loan_id'  => $value['id']
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
