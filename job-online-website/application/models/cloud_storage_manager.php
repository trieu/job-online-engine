<?php

require_once 'application/libraries/class_mapper.php';

/**
 *
 * @property CI_Loader $load
 * @property CI_DB_active_record $db
 */
class cloud_storage_manager extends Model {

    private $table_name = 'cloud_authentications';

    public function __construct() {
        parent::__construct();
        $this->class_mapper = new class_mapper();
    }

    //usually the first one
    public function getDefaultAccount() {
        $this->db->select("$this->table_name.*");
        $this->db->from($this->table_name);
        $this->db->where(array('provider' => 'google.com'));
        $this->db->limit(1);

        $query = $this->db->get();
        return $query->result();
    }

    public function addLoginAccount($login, $pass, $provider = 'google.com') {
        $data = array(
            'login' => $login,
            'password' => $pass,
            'provider' => $provider
        );
        $this->db->insert($this->table_name, $data);
    }

    

}
