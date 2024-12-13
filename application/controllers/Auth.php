<?php
class Auth extends CI_Controller
{
	public $form_validation, $input, $Auth_model, $session, $user;
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Auth_model');
	}

	public function register()
	{
		$this->form_validation->set_rules('name', 'Nama', 'required|min_length[3]', [
			'required' => 'Nama Harus diisi',
			'min_length' => 'Nama minimal 3 karakter'
		]);

		$this->form_validation->set_rules('email', 'Email', 'required|valid_email', [
			'required' => 'Email wajib diisi',
			'valid_email' => 'Format email tidak valid'
		]);

		$this->form_validation->set_rules('password', 'Password', 'required', [
			'required' => 'Password wajib diisi'
		]);

		$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]', [
			'required' => 'Konfirmasi password wajib diisi',
			'matches' => 'Konfirmasi password tidak cocok dengan password'
		]);

		if ($this->form_validation->run() == FALSE) {
			$this->load->view('auth/register');
		} else {
			$data = [
				'name' => $this->input->post('name'),
				'email' => $this->input->post('email'),
				'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
				'role' => 'user',
				'status' => 'deactive'
			];

			$this->Auth_model->register_user($data);
			$this->session->set_flashdata('success', 'Berhasil registrasi, tunggu persetujuan admin');
			redirect('auth/login');
		}
	}

	public function login()
	{
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email', [
			'required' => 'Email wajib diisi',
			'valid_email' => 'Format email tidak valid'
		]);

		$this->form_validation->set_rules('password', 'Password', 'required', [
			'required' => 'Password wajib diisi'
		]);

		if ($this->form_validation->run() == FALSE) {
			$this->load->view('auth/login');
		} else {
			$email = $this->input->post('email');
			$password = $this->input->post('password');
			$user = $this->Auth_model->login_user($email, $password);

			if ($user) {
				if ($user->status == 'deactive') {
					$this->session->set_flashdata('error', 'Akun anda tidak aktif, hubungi admin');
					redirect('auth/login');
				}


				$this->session->set_userdata([
					'user_id' => $user->id,
					'name' => $user->name,
					'role' => $user->role,
					'logged_in' => TRUE,
				]);

				if ($user->role == 'admin') {
					redirect('admin/dashboard');
				} else {
					redirect('shop');
				}
			} else {
				$this->session->set_flashdata('error', 'Email atau password salah');
				redirect('auth/login');
			}
		}
	}

	public function create_admin()
	{

		$data = [
			'name' => 'Admin Name',
			'email' => 'admin@example.com',
			'password' => password_hash('adminpassword', PASSWORD_DEFAULT), // Enkripsi password
			'role' => 'admin', // Role admin
			'status' => 'active', // Akun aktif
		];

		$this->Auth_model->register_user($data);
		echo "Admin account has been created successfully!";
	}


	public function logout()
	{
		$this->session->sess_destroy();
		redirect('auth/login');
	}
}
