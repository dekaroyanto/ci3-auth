<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

		// Cek apakah pengguna sudah login dan hanya admin yang bisa mengakses
		if (!$this->session->userdata('logged_in') || $this->session->userdata('role') != 'admin') {
			redirect('auth/login');
		}
	}

	public function index()
	{
		$data = [
			'name' => $this->session->userdata('name'),
			'content' => 'admin/dashboard'
		];
		$this->load->view('layouts/navbar', $data);
	}
}
