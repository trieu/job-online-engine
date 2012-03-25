<?php

/**
 * @property CI_DB_active_record $db
 * @property CI_DB_forge $dbforge
 * @property CI_Benchmark $benchmark
 * @property CI_Calendar $calendar
 * @property CI_Cart $cart
 * @property CI_Config $config
 * @property CI_Controller $controller
 * @property CI_Email $email
 * @property CI_Encrypt $encrypt
 * @property CI_Exceptions $exceptions
 * @property CI_Form_validation $form_validation
 * @property CI_Ftp $ftp
 * @property CI_Hooks $hooks
 * @property CI_Image_lib $image_lib
 * @property CI_Input $input
 * @property CI_Language $language
 * @property CI_Loader $load
 * @property CI_Log $log
 * @property CI_Model $model
 * @property CI_Output $output
 * @property CI_Pagination $pagination
 * @property CI_Parser $parser
 * @property CI_Profiler $profiler
 * @property CI_Router $router
 * @property CI_Session $session
 * @property CI_Sha1 $sha1
 * @property CI_Table $table
 * @property CI_Trackback $trackback
 * @property CI_Typography $typography
 * @property CI_Unit_test $unit_test
 * @property CI_Upload $upload
 * @property CI_URI $uri
 * @property CI_User_agent $user_agent
 * @property CI_Validation $validation
 * @property CI_Xmlrpc $xmlrpc
 * @property CI_Xmlrpcs $xmlrpcs
 * @property CI_Zip $zip
 */
class User_model extends CI_Model {


	var $user_id  = 0;//   int unsigned not null,
	var $first_name = '';//           varchar(100) not null,
	var $last_name = '';//     varchar(100) not null default '',
	var $email = '';//       varchar(100) not null,
	var $password = '';//       varchar(50) not null,
	var $birthday  = '';//         char(10) not null,
	var $gender = 0;//              tinyint not null,
	var $phone_number = '';//          varchar(15),
	var $zipcode = '';//              varchar(10),
	var $phone_notification = 0;//   tinyint,
	var $creation_date = 0; // bigint
	var $update_date = 0; // bigint
	var $location_id = 0;//          bigint not null,
	var $mem_id    = 0;//           int,


	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}

	function get_last_ten_entries()
	{
		$query = $this->db->get('entries', 10);
		return $query->result();
	}

	function insert_entry()
	{
		$this->first_name = $this->input->post('first_name');
		$this->last_name = $this->input->post('last_name');
		$this->creation_date    = time();
		$this->update_date    = $this->creation_date;

		$this->db->insert('users', $this);
	}

	function update_entry()
	{
		$this->title   = $_POST['title'];
		$this->content = $_POST['content'];
		$this->date    = time();

		$this->db->update('entries', $this, array('id' => $_POST['id']));
	}

}