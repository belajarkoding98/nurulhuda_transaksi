<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Import extends CI_Controller
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->library('input');
        $this->load->model('cron_model');
        $this->load->helper(array('form', 'url'));
        $this->load->library("pagination");
    }

    /**
     * This function is used to update the age of users automatically
     * This function is called by cron job once in a day at midnight 00:00
     */
    public function updateExcel()
    {
        /* is_cli_request() is provided by default input library of codeigniter */
        if ($this->input->is_cli_request()) {
            $this->cron_model->cron_job();
        } else {
            echo "You dont have access";
        }
    }
}
