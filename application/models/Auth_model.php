<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_model extends CI_Model {

    /**
     * Auth_model constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->auth = $this->load->database('auth', TRUE);

        if (is_logged() && $this->checkAccountExist() == 0)
        {
            $this->synchronizeAccount();
        }
    }

    public function arraySession($id)
    {
        $data = array(
			'blizz_sess_username' => $this->getSiteUsernameID($id),
			'blizz_sess_rank'=> $this->getRankWeb($id),
            'wow_sess_username'  => $this->getUsernameID($id),
            'wow_sess_email'     => $this->getEmailID($id),
            'wow_sess_id'        => $id,
            'wow_sess_expansion'	=> $this->getExpansionID($id),
            'wow_sess_last_ip'   => $this->getLastIPID($id),
            'wow_sess_last_login'=> $this->getLastLoginID($id),
            'logged_in' => TRUE
        );

        return $this->sessionConnect($data);
    }

	public function getRankSpecify($id)
	{
		return $this->db->select('rank')->where('id', $id)->get('users');
	}

    public function getGmSpecify($id)
    {
        return $this->auth->select('id')->where('id', $id)->get('account_access');
    }

    public function randomUTF()
    {
        return rand(0, 999999999);
    }

    public function getUsernameID($id)
    {
        return $this->auth->select('username')->where('id', $id)->get('account')->row('username');
    }

    public function getSiteUsernameID($id)
    {
        return $this->db->select('username')->where('id', $id)->get('users')->row('username');
    }

    public function getEmailID($id)
    {
        return $this->auth->select('email')->where('id', $id)->get('account')->row('email');
    }

    public function getPasswordAccountID($id)
    {
        return $this->auth->select('sha_pass_hash')->where('id', $id)->get('account')->row('sha_pass_hash');
    }

    public function getPasswordBnetID($id)
    {
        return $this->auth->select('sha_pass_hash')->where('id', $id)->get('battlenet_accounts')->row('sha_pass_hash');
    }

    public function getSpecifyAccount($account)
    {
        $account = strtoupper($account);

        return $this->auth->select('id')->where('username', $account)->get('account');
    }

    public function getSpecifyEmail($email)
    {
        return $this->auth->select('id')->where('email', $email)->get('account');
    }

    public function getIDAccount($account)
    {
        $account = strtoupper($account);

        $qq = $this->auth->select('id')->where('username', $account)->get('account');
        
        if($qq->num_rows())
            return $qq->row('id');
        else
            return '0';
    }

    public function getImageProfile($id)
    {
        return $this->db->select('profile')->where('id', $id)->get('users')->row('profile');
    }

    public function getNameAvatar($id)
    {
        return $this->db->select('name')->where('id', $id)->get('avatars')->row('name');
    }

    public function getIDEmail($email)
    {
        $email = strtoupper($email);

        $qq = $this->auth->select('id')->where('email', $email)->get('account');

        if($qq->num_rows())
            return $qq->row('id');
        else
            return '0';
    }

    public function getExpansionID($id)
    {
        return $this->auth->select('expansion')->where('id', $id)->get('account')->row('expansion');
    }

    public function getLastIPID($id)
    {
        return $this->auth->select('last_ip')->where('id', $id)->get('account')->row('last_ip');
    }

    public function getLastLoginID($id)
    {
        return $this->auth->select('last_login')->where('id', $id)->get('account')->row('last_login');
    }

    public function getJoinDateID($id)
    {
        return $this->auth->select('joindate')->where('id', $id)->get('account')->row('joindate');
    }

	public function getRankWeb($id)
	{
		$qq = $this->db->select('rank')->where('id', $id)->get('users');

		if($qq->num_rows())
			return $qq->row('rank');
		else
			return '0';
	}

    public function getBanStatus($id)
    {
        $qq = $this->auth->select('*')->where('id', $id)->where('active', '1')->get('account_banned');

        if ($qq->num_rows())
            return true;
        else
            return false;
    }

    public function sessionConnect($data)
    {
        $this->session->set_userdata($data);
        return true;
    }

    public function Battlenet($email, $password)
    {
        return strtoupper(bin2hex(strrev(hex2bin(strtoupper(hash("sha256",strtoupper(hash("sha256", strtoupper($email)).":".strtoupper($password))))))));
    }

    public function Account($username, $password)
    {
        if (!is_string($username))
            $username = "";

        if (!is_string($password))
            $password = "";

        $sha_pass_hash = sha1(strtoupper($username).':'.strtoupper($password));

        return strtoupper($sha_pass_hash);
    }

    public function checkAccountExist()
    {
        return $this->db->select('id')->where('id', $this->session->userdata('wow_sess_id'))->get('users')->num_rows();
    }

    public function synchronizeAccount()
    {
        if ($this->checkAccountExist() != 0) {
            return false;
        }

        $this->db->insert('users', array(
            'id' => $this->session->userdata('wow_sess_id'),
            'username' => $this->session->userdata('wow_sess_username'),
            'email' => $this->session->userdata('wow_sess_email'),
            'rank' => 1,
            'joindate' => strtotime($this->getJoinDateID($this->session->userdata('wow_sess_id')))
        ));

        return true;
    }

    public function getMaintenancePermission()
    {
        $qq = $this->db->select('rank')->where('id', $this->session->userdata('wow_sess_id'))->get('users');


        if(is_authorized('acp'))
        {
        	return true;
        }
        else {
        	return false;
        }
    }
}
