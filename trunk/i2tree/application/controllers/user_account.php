<?php

class user_account extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    /**
     * index
     *
     * @return void
     * @author Mathew
     * */
    function index() {
        redirect('user_account/status');
    }

    /**
     * activate
     * doesn't currently work
     *
     * @return void
     * @author Mathew
     * */
    function activate() {
        $this->form_validation->set_rules('code', 'Verification Code', 'required');
        $this->form_validation->set_error_delimiters('<p class="error">', '</p>');

        if ($this->form_validation->run() == false) {
            $data['content'] = $this->load->view('user_account/activate', null, true);
            $this->load->view('user_account/template', $data);
        } else {
            $code = $this->input->post('code');
            $activate = $this->redux_auth->activate($code);

            if ($activate) {
                $this->session->set_flashdata('message', '<p class="success">Your Account is now activated, please login.</p>');
                redirect('user_account/activate');
            } else {
                $this->session->set_flashdata('message', '<p class="error">Your account is already activated or doesn\'t need activating.</p>');
                redirect('user_account/activate');
            }
        }
    }

    /**
     * register
     *
     * @return void
     * @author Mathew
     * */
    function register() {
        $this->form_validation->set_rules('username', 'Username', 'required|callback_username_check');
        $this->form_validation->set_rules('email', 'Email Address', 'required|callback_email_check|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_error_delimiters('<p class="error">', '</p>');

        if ($this->form_validation->run() == false) {
            $data['content'] = $this->load->view('user_account/register', null, true);
            $this->load->view('user_account/template', $data);
        } else {
            $username = $this->input->post('username');
            $email = $this->input->post('email');
            $password = $this->input->post('password');

            $register = $this->redux_auth->register($username, $password, $email);

            if ($register) {
                $this->session->set_flashdata('message', '<p class="success">You have now registered. Please login.</p>');
                redirect('user_account/register');
            } else {
                $this->session->set_flashdata('message', '<p class="error">Something went wrong, please try again or contact the helpdesk.</p>');
                redirect('user_account/register');
            }
        }
    }

    /**
     * Username check
     *
     * @return void
     * @author Mathew
     * */
    public function username_check($username) {
        $check = $this->redux_auth_model->username_check($username);

        if ($check) {
            $this->form_validation->set_message('username_check', 'The username "' . $username . '" already exists.');
            return false;
        } else {
            return true;
        }
    }

    /**
     * Email check
     *
     * @return void
     * @author Mathew
     * */
    public function email_check($email) {
        $check = $this->redux_auth_model->email_check($email);

        if ($check) {
            $this->form_validation->set_message('email_check', 'The email "' . $email . '" already exists.');
            return false;
        } else {
            return true;
        }
    }

    /**
     * login
     *
     * @return void
     * @author Mathew
     * */
    function login() {
        $this->form_validation->set_rules('email', 'Email Address', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_error_delimiters('<p class="error">', '</p>');

        if ($this->redux_auth->logged_in() == TRUE && isset($_GET['url_redirect'])) {
            $url_redirect = $_GET['url_redirect'];
            redirect($url_redirect);
            return;
        }
        if ($this->form_validation->run() == false) {
            $data['content'] = $this->load->view('user_account/login', null, true);
            $this->load->view('user_account/template', $data);
        } else {
            $email = $this->input->post('email');
            $password = $this->input->post('password');
            $login = $this->redux_auth->login($email, $password);
            if ($this->redux_auth->logged_in() == TRUE) {
                $url_redirect = $this->input->post('url_redirect');
                redirect($url_redirect);
            } else {
                redirect('user_account/login');
            }
        }
    }

    /**
     * logout
     *
     * @return void
     * @author Mathew
     * */
    function logout() {
        $this->redux_auth->logout();
        redirect('welcome');
    }

    /**
     * status
     *
     * @return void
     * @author Mathew
     * */
    function status() {
        $data['status'] = $this->redux_auth->logged_in();
        $data['content'] = $this->load->view('user_account/status', $data, true);
        $this->load->view('user_account/template', $data);
    }

    /**
     * change password
     *
     * @return void
     * @author Mathew
     * */
    function change_password() {
        $this->form_validation->set_rules('old', 'Old password', 'required');
        $this->form_validation->set_rules('new', 'New Password', 'required|matches[new_repeat]');
        $this->form_validation->set_rules('new_repeat', 'Repeat New Password', 'required');
        $this->form_validation->set_error_delimiters('<p class="error">', '</p>');

        if ($this->form_validation->run() == false) {
            $data['content'] = $this->load->view('user_account/change_password', null, true);
            $this->load->view('user_account/template', $data);
        } else {
            $old = $this->input->post('old');
            $new = $this->input->post('new');

            $identity = $this->session->userdata($this->config->item('identity'));

            $change = $this->redux_auth->change_password($identity, $old, $new);

            if ($change) {
                $this->logout();
            } else {
                echo "Password Change Failed";
            }
        }
    }

    /**
     * forgotten password
     *
     * @return void
     * @author Mathew
     * */
    function forgotten_password() {
        $this->form_validation->set_rules('email', 'Email Address', 'required');
        $this->form_validation->set_error_delimiters('<p class="error">', '</p>');

        if ($this->form_validation->run() == false) {
            $data['content'] = $this->load->view('user_account/forgotten_password', null, true);
            $this->load->view('user_account/template', $data);
        } else {
            $email = $this->input->post('email');
            $forgotten = $this->redux_auth->forgotten_password($email);

            if ($forgotten) {
                $this->session->set_flashdata('message', '<p class="success">An email has been sent, please check your inbox.</p>');
                redirect('user_account/forgotten_password');
            } else {
                $this->session->set_flashdata('message', '<p class="error">The email failed to send, try again.</p>');
                redirect('user_account/forgotten_password');
            }
        }
    }

    /**
     * forgotten_password_complete
     *
     * @return void
     * @author Mathew
     * */
    public function forgotten_password_complete() {
        $this->form_validation->set_rules('code', 'Verification Code', 'required');
        $this->form_validation->set_error_delimiters('<p class="error">', '</p>');

        if ($this->form_validation->run() == false) {
            redirect('user_account/forgotten_password');
        } else {
            $code = $this->input->post('code');
            $forgotten = $this->redux_auth->forgotten_password_complete($code);

            if ($forgotten) {
                $this->session->set_flashdata('message', '<p class="success">An email has been sent, please check your inbox.</p>');
                redirect('user_account/forgotten_password');
            } else {
                $this->session->set_flashdata('message', '<p class="error">The email failed to send, try again.</p>');
                redirect('user_account/forgotten_password');
            }
        }
    }

    /**
     * Profile
     *
     * @return void
     * @author Mathew
     * */
    public function profile() {
        if ($this->redux_auth->logged_in()) {
            $data['profile'] = $this->redux_auth->profile();
            $data['content'] = $this->load->view('user_account/profile', $data, true);
            $this->load->view('user_account/template', $data);
        } else {
            redirect('user_account/login');
        }
    }

}