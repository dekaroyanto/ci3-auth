<?php
class Auth_model extends CI_Model
{

	public function register_user($data)
	{
		return $this->db->insert('users', $data);
	}

	public function login_user($email, $password)
	{
		$this->db->where('email', $email);
		$user = $this->db->get('users')->row();

		if ($user && password_verify($password, $user->password)) {
			return $user;
		}

		return NULL;
	}
}
