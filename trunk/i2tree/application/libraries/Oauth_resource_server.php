<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * OAuth 2.0 resource server library
 *
 * @category  Library
 * @package   CodeIgniter
 * @author    Alex Bilbie <alex@alexbilbie.com>
 * @copyright 2012 Alex Bilbie
 * @license   MIT Licencse http://www.opensource.org/licenses/mit-license.php
 * @version   Version 0.2
 * @link      https://github.com/alexbilbie/CodeIgniter-OAuth-2.0-Server
 */
class Oauth_resource_server {

    /**
     * The access token.
     * 
     * @var $_access_token
     * @access private
     */
    private $_access_token = NULL;

    /**
     * The scopes the access token has access to.
     * 
     * @var $_scopes
     * @access private
     */
    private $_scopes = array();

    /**
     * The type of owner of the access token.
     * 
     * @var $_type
     * @access private
     */
    private $_type = NULL;

    /**
     * The ID of the owner of the access token.
     * 
     * @var $_type_id
     * @access private
     */
    private $_type_id = NULL;

    /**
     * Constructor
     * 
     * @access public
     * @return void
     */
    public function __construct() {
        $this->ci = get_instance();
        $this->init();
    }

    /**
     * Init function
     * 
     * @access public
     * @return void
     */
    public function init() {

        switch ($this->ci->input->server('REQUEST_METHOD')) {
            default:
                $access_token = $this->ci->input->get('access_token');
                break;

            case 'PUT':
                $access_token = $this->ci->put('access_token'); // assumes you're using https://github.com/philsturgeon/codeigniter-restserver
                break;

            case 'POST':
                $access_token = $this->ci->input->post('access_token');
                break;

            case 'DELETE':
                $access_token = $this->ci->delete('access_token'); // https://github.com/philsturgeon/codeigniter-restserver
                break;
        }

        if ($access_token) {
            $session_query = $this->ci->db->get_where('oauth_sessions', array('access_token' => $access_token, 'stage' => 'granted'));

            if ($session_query->num_rows() === 1) {
                $session = $session_query->row();
                $this->_access_token = $session->access_token;
                $this->_type = $session->type;
                $this->_type_id = $session->type_id;

                $scopes_query = $this->ci->db->get_where('oauth_session_scopes', array('access_token' => $access_token));
                if ($scopes_query->num_rows() > 0) {
                    foreach ($scopes_query->result() as $scope) {
                        $this->_scopes[] = $scope->scope;
                    }
                }
//                var_dump($scopes_query); exit;
            } else {
                $output = json_encode(array('error_message' => 'Invalid access token'));
                header('HTTP/1.1: 403');
                header('Status: 403');
                header('Content-Type: application/json');
                header('Content-Length: ' . strlen($output));
                echo $output;
                exit;
            }
        } else {
            $output = json_encode(array('error_message' => 'Missing access token'));
            header('HTTP/1.1: 403');
            header('Status: 403');
            header('Content-Type: application/json');
            header('Content-Length: ' . strlen($output));
            echo $output;
            exit;
        }
    }

    /**
     * Test if the access token represents a user
     * 
     * @access public
     * @return string|bool
     */
    public function is_user() {
        if ($this->_type === 'user') {
            return $this->_type_id;
        }

        return FALSE;
    }

    /**
     * Test if the access token represents an applicatiom
     * 
     * @access public
     * @return string|bool
     */
    public function is_anon() {
        if ($this->_type === 'anon') {
            return $this->_type_id;
        }

        return FALSE;
    }

    /**
     * Test if the access token has a specific scope
     * 
     * @param mixed $scopes Scope(s) to check
     * 
     * @access public
     * @return string|bool
     */
    public function has_scope($scopes) {
        if (is_string($scopes)) {
            if (in_array($scopes, $this->_scopes)) {
                return TRUE;
            }

            return FALSE;
        } elseif (is_array($scopes)) {
            foreach ($scopes as $scope) {
                if (!in_array($scope, $this->_scopes)) {
                    return FALSE;
                }
            }

            return TRUE;
        }

        return FALSE;
    }

}

// END Oauth_resource_server class

// End of file Oauth_resource_server.php
// Location: ./application/libraries/Oauth_resource_server.php