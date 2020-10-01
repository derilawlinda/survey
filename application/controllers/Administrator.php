<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Administrator extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		is_logged_in();
	}

	public function index()
	{
	    $db2 = $this->load->database('database2', TRUE);
		$data['merah'] = $db2->where('202006X122X2859 <', 270)->count_all_results('srvy_survey_202006');
		$data['oren'] = $db2->where('202006X122X2859 >=', 270)->where('202006X122X2859 <', 315)->count_all_results('srvy_survey_202006');
		$data['kuning'] = $db2->where('202006X122X2859 >=', 315)->where('202006X122X2859 <', 360)->count_all_results('srvy_survey_202006');
		$data['ijomuda'] = $db2->where('202006X122X2859 >=', 360)->where('202006X122X2859 <', 405)->count_all_results('srvy_survey_202006');
		$data['ijo'] = $db2->where('202006X122X2859 >=', 405)->count_all_results('srvy_survey_202006');
		
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['title_page'] = "Dashboard";
		$this->load->view('templates/sitemain/deskapp-header', $data);
		$this->load->view('templates/sitemain/deskapp-sidebar', $data);
		$this->load->view('templates/sitemain/deskapp-topbar', $data);
		$this->load->view('administrator/deskapp-index', $data);
		$this->load->view('templates/sitemain/deskapp-footer');
	}

	public function role()
	{
		if (!is_null($this->input->post('name'))) {
			$menu = $this->input->post('name');

			// cek apakah role sudah ada atau belum
			$check = $this->db->get_where('user_role', ['role' => $menu])->num_rows();
			if ($check < 1) {
				$this->db->insert('user_role', ['role' => $menu]);
				$this->Flasher_model->flashdata('New role added', 'Success ', 'success');
			} else {
				$this->Flasher_model->flashdata('Role already exist', 'Failed ', 'danger');
			}
		}
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['title_page'] = "Role";
		$data['role'] = $this->db->get('user_role')->result_array();
		$this->load->view('templates/sitemain/deskapp-header', $data);
		$this->load->view('templates/sitemain/deskapp-sidebar', $data);
		$this->load->view('templates/sitemain/deskapp-topbar', $data);
		$this->load->view('administrator/role', $data);
		$this->load->view('templates/sitemain/deskapp-footer');
	}
	
	public function unit()
	{
		if (!is_null($this->input->post('name'))) {
			$menu = $this->input->post('name');

			// cek apakah unit sudah ada atau belum
			$check = $this->db->get_where('user_unit', ['unit' => $menu])->num_rows();
			if ($check < 1) {
				$this->db->insert('user_unit', ['unit' => $menu]);
				$this->Flasher_model->flashdata('UO/AP berhasil ditambahkan', 'Success ', 'success');
			} else {
				$this->Flasher_model->flashdata('UO/AP sudah pernah dibuat', 'Failed ', 'danger');
			}
		}
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['title_page'] = "UO/AP";
		$data['unit'] = $this->db->get('user_unit')->result_array();
		$this->load->view('templates/sitemain/deskapp-header', $data);
		$this->load->view('templates/sitemain/deskapp-sidebar', $data);
		$this->load->view('templates/sitemain/deskapp-topbar', $data);
		$this->load->view('administrator/unit', $data);
		$this->load->view('templates/sitemain/deskapp-footer');
	}

	public function user()
	{
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['title_page'] = "Manage Users";
		
		$this->db->select('user.id,user.name,user.email,user_unit.unit,user_role.role');    
        $this->db->from('user');
        $this->db->join('user_unit', 'user.unit = user_unit.id');
        $this->db->join('user_role', 'user.role_id = user_role.id');
        $data['users'] = $this->db->get()->result_array();
        
// 		$data['users'] = $this->db->get('user')->result_array();
		$data['role'] = $this->db->get('user_role')->result_array();
		$data['unit'] = $this->db->get('user_unit')->result_array();
        
		$this->load->view('templates/sitemain/deskapp-header', $data);
		$this->load->view('templates/sitemain/deskapp-sidebar', $data);
		$this->load->view('templates/sitemain/deskapp-topbar', $data);
		$this->load->view('administrator/user', $data);
		$this->load->view('templates/sitemain/deskapp-footer');
	}

	public function roleacces($id = -1)
	{
		$data['title_page'] = "Role";
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['role'] = $this->db->get_where('user_role', ['id' => $id])->row_array();

		$this->db->where('id !=', 1);
		$data['menu'] = $this->db->get('user_menu')->result_array();

		$this->load->view('templates/sitemain/deskapp-header', $data);
		$this->load->view('templates/sitemain/deskapp-sidebar', $data);
		$this->load->view('templates/sitemain/deskapp-topbar', $data);
		$this->load->view('administrator/roleacces', $data);
		$this->load->view('templates/sitemain/deskapp-footer');
	}

	public function roleedit()
	{
		$id = htmlspecialchars($this->input->post('id'));
		// cek apakah ada data yang dikirimkan atau tidak
		if (is_null($this->input->post('id'))) {
			redirect('administrator/role');
		}
		if ($id == 1 || $id == 2) {
			$this->Flasher_model->flashdata('Role not be edited', 'Failed', 'danger');
			redirect('administrator/role');
		}
		$name = htmlspecialchars($this->input->post('name'));
		$menu = $this->db->get_where('user_role', ['role' => $name])->row_array();
		// di cek apakah nama sudah digunakan atau belum
		if (is_null($menu)) {
			$this->db->set('role', $name);
			$this->db->where('id', $id);
			$this->db->update('user_role');
			$this->Flasher_model->flashdata('Role Renamed', 'Succes', 'success');
			redirect('administrator/role');
		} else {
			$this->Flasher_model->flashdata('Role already exist', 'Failed', 'danger');
			redirect('administrator/role');
		}
	}
	
	public function unitedit()
	{
		$id = htmlspecialchars($this->input->post('id'));
		// cek apakah ada data yang dikirimkan atau tidak
		if (is_null($this->input->post('id'))) {
			redirect('administrator/unit');
		}
		$name = htmlspecialchars($this->input->post('name'));
		$menu = $this->db->get_where('user_unit', ['unit' => $name])->row_array();
		// di cek apakah nama sudah digunakan atau belum
		if (is_null($menu)) {
			$this->db->set('unit', $name);
			$this->db->where('id', $id);
			$this->db->update('user_unit');
			$this->Flasher_model->flashdata('UO/AP Berhasil diubah', 'Success', 'success');
			redirect('administrator/unit');
		} else {
			$this->Flasher_model->flashdata('UO/AP sudah pernah dibuat', 'Failed', 'danger');
			redirect('administrator/unit');
		}
	}

	public function useredit()
	{
		$id = htmlspecialchars($this->input->post('id'));
		// cek apakah ada data yang dikirimkan atau tidak
		if (is_null($this->input->post('id'))) {
			redirect('administrator/user');
		}
		$id = $this->input->post('id');
		$name = $this->input->post('inputName');
		$email = $this->input->post('inputEmail');
		$unit = $this->input->post('inputUnit');	
		$role = $this->input->post('inputRole');
		$this->db->set('name', $name);
		$this->db->set('email', $email);
		$this->db->set('unit', $unit);
		$this->db->set('role_id', $role);
		$this->db->where('id', $id);
		$this->db->update('user');
		$this->Flasher_model->flashdata('User profile has been updated', 'Success', 'success');
		redirect('administrator/user');
	}

	public function roledelete($id = -1)
	{
		if ($id == 1 || $id == 2) {
			$this->Flasher_model->flashdata('Role not be deleted', 'Failed', 'danger');
			redirect('administrator/role');
		}
		if ($this->db->get_where('user_role', ['id' => $id])->num_rows() < 1) {
			$this->Flasher_model->flashdata('Role not exist', 'Failed', 'danger');
			redirect('administrator/role');
		}
		$this->db->delete('user_role', ['id' => $id]);
		$this->Flasher_model->flashdata('Role deleted', 'Success ', 'warning');
		redirect('administrator/role');
	}
	
	public function unitdelete($id = -1)
	{
		if ($this->db->get_where('user_unit', ['id' => $id])->num_rows() < 1) {
			$this->Flasher_model->flashdata('UO/AP tidak ada', 'Failed', 'danger');
			redirect('administrator/unit');
		}
		$this->db->delete('user_unit', ['id' => $id]);
		$this->Flasher_model->flashdata('UO/AP berhasil dihapus', 'Success ', 'warning');
		redirect('administrator/unit');
	}

	public function userdelete($id = -1)
	{
		if ($this->db->get_where('user', ['id' => $id])->num_rows() < 1) {
			$this->Flasher_model->flashdata('User not exist', 'Failed', 'danger');
			redirect('administrator/user');
		}
		$this->db->delete('user', ['id' => $id]);
		$this->Flasher_model->flashdata('User deleted', 'Success ', 'warning');
		redirect('administrator/user');
	}

	public function changeaccess()
	{
		$data = [
			'role_id' => $this->input->post('roleId'),
			'menu_id' => $this->input->post('menuId')
		];

		$result = $this->db->get_where('user_access_menu', $data)->num_rows();
		if ($result < 1) {
			$this->Flasher_model->flashdata('Access Change', 'Success ', 'success');
			$this->db->insert('user_access_menu', $data);
		} else {
			$this->db->delete('user_access_menu', $data);
			$this->Flasher_model->flashdata('Access Change', 'Success ', 'success');
		}
	}

	public function detail()
	{
		echo json_encode($this->db->get_where('user_role', ['id' => $this->input->post('id')])->row_array());
	}
	
	public function unitdetail()
	{
		echo json_encode($this->db->get_where('user_unit', ['id' => $this->input->post('id')])->row_array());
	}

	public function userdetail()
	{
		echo json_encode($this->db->get_where('user', ['id' => $this->input->post('id')])->row_array());
	}
}
