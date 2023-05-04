<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Transaction extends CI_Controller {
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
    public function loan() {
      //loan_id, amount, from_account, to_account, status ('1'=>'Send', '2'=>'Received')
      $response = array();

      $loan_id = $this->input->post('loan_id');
      $amount = $this->input->post('amount');
      $fromAccount = $this->input->post('from_account');
      $toAccount = $this->input->post('to_account');
      $status = $this->input->post('status');

      if($loan_id != '' && $amount != '' && $fromAccount != '' && $toAccount != '' && $status != '' ){
        $data = array(
              'loan_id'  => $loan_id,
              'amount'  => $amount,
              'fromAccount'  => $fromAccount,
              'toAccount'  => $toAccount,
              'status'  => $status
          );

        $result = $this->api_model->add_table_data($data,'transaction');

        if($result){
            $response['data']  = $this->api_model->get_table_data_by_id($result,'transaction');
            $response['flag']  = 1;
            $response['message'] = 'Transaction Completed';

        }else{
            $response['flag']  = 0;
            $response['message'] = 'Transaction did not Completed';

        }
      }else{
        $response['flag']  = 0;
        $response['message'] = 'Something Wrong..';
      }
      
      echo json_encode($response);
    }
    public function insurance() {
      //insurance_id, amount, from_account, to_account, status('1'=>'Send', '2'=>'Received')
      $response = array();

      $insurance_id = $this->input->post('insurance_id');
      $amount = $this->input->post('amount');
      $fromAccount = $this->input->post('from_account');
      $toAccount = $this->input->post('to_account');
      $status = $this->input->post('status');

      if($insurance_id != '' && $amount != '' && $fromAccount != '' && $toAccount != '' && $status != '' ){
        $data = array(
              'insurance_id'  => $insurance_id,
              'amount'  => $amount,
              'fromAccount'  => $fromAccount,
              'toAccount'  => $toAccount,
              'status'  => $status
          );

        $result = $this->api_model->add_table_data($data,'transaction');

        if($result){
            $response['data']  = $this->api_model->get_table_data_by_id($result,'transaction');
            $response['flag']  = 1;
            $response['message'] = 'Transaction Completed';

        }else{
            $response['flag']  = 0;
            $response['message'] = 'Transaction did not Completed';

        }
      }else{
        $response['flag']  = 0;
        $response['message'] = 'Something Wrong..';
      }
      
      echo json_encode($response);
    }
    public function delete() {
      //transaction_id
      $response = array();

      $transaction_id = $this->input->post('transaction_id');

      if($transaction_id != ''){
        $data = array(
              'is_deleted'  => '1',
          );

        $result = $this->api_model->update_table_data($data, $transaction_id, 'transaction');

        if($result){
            $response['flag']  = 1;
            $response['message'] = 'Transaction has been deleted succesfully';

        }else{
            $response['flag']  = 0;
            $response['message'] = 'Transaction has been not deleted successfully';

        }
      }else{
        $response['flag']  = 0;
        $response['message'] = 'Something Wrong..';
      }
      
      echo json_encode($response);
    }
    
    
}
