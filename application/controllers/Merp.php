<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Merp extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		is_logged_in();
        $this->load->helper(array('email'));
        $this->load->library(array('email'));
	}

	public function index()
	{
	    $post = $this->input->post();
		if (!is_null($post['id'])) {
		  //  $id       = $post['id'];
			$unit_id  = $post['unit_id'];
			$nilai  = $post['nilai'];
			$persen  = ($post['nilai']/450)*100;
			$status  = "Request";
			$survey_id = $post['survey_id'];
			
            $this->load->helper('date');
            date_default_timezone_set('Asia/Jakarta');
            $datestring = '%Y-%m-%d %H:%i:%s';
            $time = time();
            
            $created_at = mdate($datestring, $time);
            $updated_at = mdate($datestring, $time);

          $data = [
              'unit_id' => $unit_id,
              'nilai' => $nilai,
              'persen' => $persen,
              'status' => $status,
              'created_at' => $created_at,
              'updated_at' => $updated_at,
              'survey_id' => $survey_id
          ];


			// cek apakah unit sudah ada atau belum
			$check = $this->db->get_where('merp', ['unit_id' => $unit_id, 'status' => 'Request'])->num_rows();
			// if ($check < 1) {
				$this->db->insert('merp', $data);
				$this->Flasher_model->flashdata('Survey telah di ajukan', 'Success ', 'success');
			    redirect('merp');
			// } else {
			// 	$this->Flasher_model->flashdata('Terdapat survey yang belum di tindak lanjuti', 'Failed ', 'danger');
			//     redirect('merp');
			// }
		}
		$this->db->select('pertamin_survey.srvy_survey_202006.id,pertamin_dashboard.user_unit.unit,pertamin_survey.srvy_survey_202006.202006X125X2916,pertamin_survey.srvy_survey_202006.202006X122X2859,pertamin_survey.srvy_survey_202006.startdate');    
        $this->db->from('pertamin_survey.srvy_survey_202006');
        $this->db->join('pertamin_dashboard.user_unit', 'pertamin_survey.srvy_survey_202006.202006X125X2916 = user_unit.id');
        // $this->db->join('pertamin_dashboard.user','pertamin_survey.srvy_survey_202006.202006X125X2916 = user.unit');
        $data['merp'] = $this->db->group_by('unit')->get()->result_array();
        
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['title_page'] = "Medical Emergency Response Readiness Assesment Tool";
		$this->load->view('templates/sitemain/deskapp-header', $data);
		$this->load->view('templates/sitemain/deskapp-sidebar', $data);
		$this->load->view('templates/sitemain/deskapp-topbar', $data);
		$this->load->view('merp/index', $data);
		$this->load->view('templates/sitemain/deskapp-footer');
	}
	
	public function uoap()
	{
	    $post = $this->input->post();
		if (!is_null($post['id'])) {
		  //  $id       = $post['id'];
			$unit_id  = $post['unit_id'];
			$nilai  = $post['nilai'];
			$persen  = ($post['nilai']/450)*100;
			$status  = "Request";
			$survey_id = $post['survey_id'];
			
            $this->load->helper('date');
            date_default_timezone_set('Asia/Jakarta');
            $datestring = '%Y-%m-%d %H:%i:%s';
            $time = time();
            
            $created_at = mdate($datestring, $time);
            $updated_at = mdate($datestring, $time);
            
			$created_by = $post['created_by'];
			$approver = $post['approver'];

          $data = [
              'unit_id' => $unit_id,
              'nilai' => $nilai,
              'persen' => $persen,
              'status' => $status,
              'created_at' => $created_at,
              'updated_at' => $updated_at,
              'created_by' => $created_by,
              'approver' => $approver,
              'survey_id' => $survey_id
          ];

            // cek apakah unit sudah ada atau belum
			$check = $this->db->get_where('merp', ['unit_id' => $unit_id, 'status' => 'Request'])->num_rows();
			if ($check < 1) {
			    //$this->sendMail('submitpic');
			    //$this->sendMail('submitpictoapprover');
				$this->db->insert('merp', $data);
				$this->Flasher_model->flashdata('Survey telah di ajukan', 'Success ', 'success');
			    redirect('merp/uoap');
			} else {
				$this->Flasher_model->flashdata('Terdapat survey yang belum di tindak lanjuti', 'Failed ', 'danger');
			    redirect('merp/uoap');
			}
		}
		$this->db->select('pertamin_survey.srvy_survey_202006.id,pertamin_dashboard.user_unit.unit,pertamin_survey.srvy_survey_202006.202006X125X2916,pertamin_survey.srvy_survey_202006.202006X122X2859,pertamin_survey.srvy_survey_202006.startdate');    
        $this->db->from('pertamin_survey.srvy_survey_202006');
        $this->db->join('pertamin_dashboard.user_unit', 'pertamin_survey.srvy_survey_202006.202006X125X2916 = user_unit.id');
        $this->db->join('pertamin_dashboard.user','pertamin_survey.srvy_survey_202006.202006X125X2916 = user.unit');
        $data['merp'] = $this->db->group_by('unit')->get()->result_array();
        
		$data['unit'] = $this->db->get_where('user_unit', ['id' => $this->session->userdata('unit')])->row_array();
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['userapp'] = $this->db->get_where('user', ['role_id' => 10, 'unit' => $this->session->userdata('unit')])->row_array();
		$data['title_page'] = "Medical Emergency Response Readiness Assesment Tool";
		$this->load->view('templates/sitemain/deskapp-header', $data);
		$this->load->view('templates/sitemain/deskapp-sidebar', $data);
		$this->load->view('templates/sitemain/deskapp-topbar', $data);
		$this->load->view('merp/uoap', $data);
		$this->load->view('templates/sitemain/deskapp-footer');
	}

	public function approval()
	{
		$post = $this->input->post();
		$id = htmlspecialchars($post['id']);
		// cek apakah ada data yang dikirimkan atau tidak
		if (!is_null($post['id'])) {
			$reason  = $post['reason'];
			$status  = $post['status'];
					
			$this->load->helper('date');
			date_default_timezone_set('Asia/Jakarta');
			$datestring = '%Y-%m-%d %H:%i:%s';
			$time = time();
			
			$updated_at = mdate($datestring, $time);
			$updated_by  = $post['updated_by'];

			$data = [
				'reason' => $reason,
				'status' => $status,
				'updated_at' => $updated_at,
				'updated_by' => $updated_by
			];
			// di cek apakah nama sudah digunakan atau belum
			
			if($status == "Terima") {
			    //$this->sendMail('acceptbyapprover');
				$this->db->update('merp', $data, array('id' => $post['id']));
				$this->Flasher_model->flashdata('Data berhasil di approve', 'Sukses', 'success');
				redirect('merp/approval');
			}elseif($status == "Tolak"){
			    //$this->sendMail('rejectbyapprover');
				$this->db->update('merp', $data, array('id' => $post['id']));
				$this->Flasher_model->flashdata('Data telah anda tolak', 'Sukses', 'success');
				redirect('merp/approval');
			}else{
				$this->Flasher_model->flashdata('Anda belum memilih tindakan', 'Failed', 'danger');
				redirect('merp/approval');
			}
		}

		$this->db->select('merp.*,user_unit.unit');    
		$this->db->from('merp');
		$this->db->join('user_unit', 'merp.unit_id = user_unit.id');
		// $this->db->join('user','merp.unit_id = user.unit');
		$data['merp'] = $this->db->group_by('unit_id')->get()->result_array();
		$data['approve'] = $this->db->get_where('merp', ['id' => $this->input->post('id')])->row_array();
		$data['unit'] = $this->db->get_where('user_unit', ['id' => $this->session->userdata('unit')])->row_array();
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['userapp'] = $this->db->get_where('user', ['unit' => $this->session->userdata('unit')])->row_array();
		$data['title_page'] = "Halaman Persetujuan Survey";
		$this->load->view('templates/sitemain/deskapp-header', $data);
		$this->load->view('templates/sitemain/deskapp-sidebar', $data);
		$this->load->view('templates/sitemain/deskapp-topbar', $data);
		$this->load->view('merp/approval', $data);
		$this->load->view('templates/sitemain/deskapp-footer');
	}

	public function surveydetail()
	{
		echo json_encode(
		    $this->db->get_where('pertamin_survey.srvy_survey_202006', ['id' => $this->input->post('id')])->row_array()
		);
	}
	
	public function approvedetail()
	{
		echo json_encode(
		    $this->db->get_where('merp', ['id' => $this->input->post('id')])->row_array()
		);
	}

	public function approvedelete($id = -1)
	{
		if ($this->db->get_where('merp', ['id' => $id])->num_rows() < 1) {
			$this->Flasher_model->flashdata('Survey yang dipilih tidak ada', 'Gagal', 'danger');
			redirect('merp/approval');
		}
		$this->db->delete('merp', ['id' => $id]);
		$this->Flasher_model->flashdata('Survey berhasil dihapus', 'Sukses ', 'warning');
		redirect('merp/approval');
	}
	
    public function sendMail($type)
    {
        $emailpic = $this->input->post('created_by');
        $emailapprover = $this->input->post('approver');
        $lokasi = $this->input->post('lokasi');
        // Konfigurasi email
        $config = [
            'mailtype'  => 'html',
            // 'protocol' => 'sendmail',
            // 'mailpath' => '/usr/sbin/sendmail',
            // 'charset' => 'utf-8',
            // 'wordwrap' => TRUE,
            'charset'   => 'utf-8',
            'protocol'  => 'smtp',
            'smtp_host' => 'mailbox.pertamina-pdc.com',
            'smtp_user' => 'sabichul@pertamina-pdc.com',  // Email gmail
            'smtp_pass'   => 'pdcpdcpdc2018',  // Password gmail
            'smtp_crypto' => 'ssl',
            'smtp_port'   => 465,
            'crlf'    => "\r\n",
            'newline' => "\r\n"
        ];
    
        // Load library email dan konfigurasinya
        $this->load->library('email', $config);
        $this->email->initialize($config);
    
        $this->email->from('no-reply@pertamina.com', 'No Reply MERP');
        
        if ($type == 'submitpic') {
            $this->email->to($emailpic);
			$this->email->subject('Online Self Assesment MERP');
			$this->email->message('Dengan Hormat,<br><br>Terima kasih telah melakukan pengisian Self Assesment Medical Emergency Response Plan untuk Area/Lokasi <b>'.$lokasi.'</b>.<br>Untuk melihat hasil pengisian Self Assesment tersebut <a href="https://s.id/merp2020">Silahkan klik link berikut</a>.<br><br>Demikian, terima kasih atas perhatiannya<br><br>Admin,<br><b>Online Survey MERP</b>');
		}elseif($type == 'submitpictoapprover') {
            $this->email->to($emailapprover);
			$this->email->subject('Online Self Assesment MERP');
			$this->email->message('Dengan Hormat,<br><br>Bersama ini disampaikan bahwa Self Assesment Medical Emergency Response Plan untuk Area/Lokasi <b>'.$lokasi.'</b> telah selesai di isi.<br>Untuk melihat hasil/pencapaian dan melakukan approval Self Assesment tersebut <b><i><a href="https://s.id/merp2020">Silahkan klik link berikut</a></i></b>.<br><br>Demikian, terima kasih atas perhatiannya<br><br>Admin,<br><b>Online Survey MERP</b>');
		}elseif($type == 'rejectbyapprover') {
            $this->email->to($emailpic);
            $this->email->cc($emailapprover);
			$this->email->subject('Online Self Assesment MERP');
			$this->email->message('Dengan Hormat,<br><br>Bersama ini disampaikan bahwa Self Assesment Medical Emergency Response Plan untuk Area/Lokasi <b>'.$lokasi.'</b> telah dikembalikan (Reject).<br>Untuk melihat komentar dan melakukan update pada Self Assesment tersebut <b><i><a href="https://s.id/merp2020">Silahkan klik link berikut</a></i></b>.<br><br>Demikian, terima kasih atas perhatiannya<br><br>Admin,<br><b>Online Survey MERP</b>');
		}elseif($type == 'acceptbyapprover') {
            $this->email->to($emailpic);
            $this->email->cc($emailapprover);
			$this->email->subject('Online Self Assesment MERP');
			$this->email->message('Dengan Hormat,<br><br>Terima kasih telah menyelesaikan semua proses pengisian Self Assesment Medical Emergency Response Plan untuk Area/Lokasi <b>'.$lokasi.'</b>.<br>Untuk melihat hasil pengisian Self Assesment tersebut <b><i><a href="https://s.id/merp2020">Silahkan klik link berikut</a></i></b>.<br><br>Demikian, terima kasih atas perhatiannya<br><br>Admin,<br><b>Online Survey MERP</b>');
		}
        
        //Jika Sukses
        if ($this->email->send()) {
			return true;
		} else {
			echo $this->email->print_debugger();
			die;
		}
    }

}