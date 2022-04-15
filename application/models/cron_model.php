<?php
header('Access-Control-Allow-Origin: *'); 
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');
class cron_model extends CI_Model 
{    	
    function cron_job()
    {
		$msg = "Hi! Thanks for watching this video. Comments if you want this code.";
		$msg = wordwrap($msg,70);
		// send email
		mail("belajar.koding98@gmail.com","Codeignator cron job by Muhammad Jahidin",$msg);			
    }
}
