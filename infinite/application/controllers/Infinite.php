<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Infinite extends CI_Controller {

 function index()
 {
  $this->load->view('scroll_pagination');
 }


 public function fetch()
{
    $this->load->model('scroll_pagination_model');
    $data = $this->scroll_pagination_model->fetch_data($this->input->post('limit'), $this->input->post('start'));
    $output = array();

    if($data->num_rows() > 0)
    {
        foreach($data->result() as $row)
        {
            $output[] = array(
                'status' => $row->status,
                'created_at' => $row->created_at,
                'effective_date' => $row->effective_date,
                'account' => $row->account_owner_id,
            );
        }
    }

    header('Content-Type: application/json');
    echo json_encode($output);
}

}