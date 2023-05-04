<?php
$CI = & get_instance();
$CI->load->database();
//print_r($CI); exit();

function encripted($data){
    $key1 = '644CBEF595BC9';
    $final_data = $key1.'|'.$data;
    $val = base64_encode(base64_encode(base64_encode($final_data)));
    return $val;
}
function decripted($data){
    $val = base64_decode(base64_decode(base64_decode($data)));
    $final_data = explode('|', $val);
    return $final_data[1];
}
function isLogin($param=''){
    $CI = & get_instance();
    if($param=='backoffice'){
        $logged_in = $CI->session->userdata('admin_logged_in');
        if(!$logged_in) {
            $CI->session->set_flashdata('error_msg', 'Please login first');
            redirect( $param.'/login' );
        }
    }else{
        $logged_in = $CI->session->userdata('logged_in');
        if(!$logged_in) {
            $CI->session->set_flashdata('error_msg', 'Please login first');
            redirect( 'pages/login' );
        }            
    }
}
function loginCheck($user_type='user'){
    $CI = & get_instance();
    if($user_type=='backoffice'){
        $admin_logged_in = $CI->session->userdata('admin_logged_in');
    }else{
        $admin_logged_in = $CI->session->userdata('logged_in');
    }
    if($admin_logged_in == 1) {
        return true;
    } else{
        return false;
    }
}
function isUserType($param){
    $CI = & get_instance();
    if(strtolower($param)==strtolower($CI->session->userdata('user_type'))){
        return true;
    } else{
        return false;
    }
}
function get_current_user_id(){
    $CI = & get_instance();
    $user_id = $CI->session->userdata('user_id');
    if($user_id) {
        return $user_id;
    } else{
        return false;
    }
}
if (!function_exists('message')){
    function message($params){
        $mode = $params['flag'];
        $var = $params['msg'];

        switch($mode){
            case 1:$var='<div class="alert alert-success"><a data-dismiss="alert" class="close"><i class="fas fa-times"></i></a> '.$var.'</div>';	//Success
                            break;
            case 2:$var='<div class="alert alert-danger"><a data-dismiss="alert" class="close"><i class="fas fa-times"></i></a> '.$var.'</div>';	//Error
                            break;
            case 3:$var='<div class="alert alert-info"><a data-dismiss="alert" class="close"><i class="btn btn-tool"></i></a> '.$var.'</div>';	//Message
                            break;
            case 4:$var='<div class="alert"><a data-dismiss="alert" class="close"><i class="btn btn-tool"></i></a> '.$var.'</div>';	//Critical
                            break;
            default:$var='<div class="alert alert-info"><a data-dismiss="alert" class="close"><i class="btn btn-tool"></i></a> '.$var.'</div>';	//Message
                            break;
        }
        
        return $var;	
    }
}
function send_mail_by_admin($from_name, $from_email, $subject,$message){
    $CI = & get_instance();
    $CI->load->library('email');
    $config = Array(
        //'protocol' => 'Smtp',
        //'smtp_host' => '',
        //'smtp_port' => '',
        //'smtp_crypto' => '',
        //'smtp_user' => '',
        //'smtp_pass' => '',
        'mailtype' => 'html',
        'charset' => 'iso-8859-1',
        'wordwrap' => TRUE
    );
    $CI->email->initialize($config);
    $CI->email->set_mailtype("html");
    $CI->email->set_newline("\r\n");
    $htmlContent = $message;
    //$to = 'arghya.mitra@mailinator.com';
    $CI->email->to($to);
    $CI->email->from($from_email,$from_name);
    $CI->email->subject($subject);
    $CI->email->message($htmlContent);
    //print_r($CI->email->send()); exit();
    if($CI->email->send())
        return true;
    else
        return false;
}
function send_mail_by_user($to,$subject,$message){
    $CI = & get_instance();
    $CI->load->library('email');
    $config = Array(
        //'protocol' => 'Smtp',
        //'smtp_host' => '',
        //'smtp_port' => '',
        //'smtp_crypto' => '',
        //'smtp_user' => '',
        //'smtp_pass' => '',
        'mailtype' => 'html',
        'charset' => 'iso-8859-1',
        'wordwrap' => TRUE
    );
    $CI->email->initialize($config);
    $CI->email->set_mailtype("html");
    $CI->email->set_newline("\r\n");
    $htmlContent = $message;
    $CI->email->to($to);
    //$CI->email->from('arghya.mitra@mailinator.com','Indian Stores Supplying');
    $CI->email->subject($subject);
    $CI->email->message($htmlContent);
    //print_r($CI->email->send()); exit();
    if($CI->email->send())
        return true;
    else
        return false;
}
function image_upload($file,$input_name, $path='uploads',$allowed_types='jpg|png|svg|jpeg|gif',$max_size='5242880'){
    $rtntext='';
    //print_r(FCPATH); exit();
    $CI = & get_instance();
    if(!empty($file[$input_name]['name'])){
        $upload_path=$path;
        $CI->load->library('upload');
        if (!file_exists(FCPATH .$upload_path)) {
            mkdir(FCPATH .$upload_path, 0777, true);
        }
        $config['upload_path'] = FCPATH . $upload_path . '/';
        $config['allowed_types'] = $allowed_types;
        $config['max_size'] = $max_size; //default: 5MB max     = '*';
        $config['encrypt_name'] = True;
        $CI->upload->initialize($config);

        //echo "string"; exit();
        if (!$CI->upload->do_upload($input_name)) {
            //print_r($CI->upload->display_errors()); exit();
            $CI->session->set_flashdata('msg', $CI->upload->display_errors());
            $CI->session->set_flashdata('msg_type', 'Error');
            $rtntext = false;

        }else{
            $ufile = $CI->upload->data();
            $rtntext= $ufile['file_name'];
        }
    }
    return $rtntext;
}
function get_image($image, $path){
    $rtn_text=($image!='') ? base_url('/').$path.$image : base_url('assets/images/no-image.png');
    return $rtn_text;
}
function get_date_yr($val){
    $rtn_text =($val!='') ? date('Y-m-d', strtotime($val)) : '';
    return $rtn_text;
}
function get_data_count($table){
    $rtntxt='0';
    $CI = & get_instance();
    $CI->db->select('id');
    $CI->db->where('is_deleted','0');
    $CI->db->from($table);
    $queries=$CI->db->get();
    $rowcount = $queries->num_rows();
    //$values= $queries->result();

    if($rowcount > 0){
        $rtntxt=$rowcount;
    }else{
        $rtntxt= '0';
    }
    
    return $rtntxt;
}