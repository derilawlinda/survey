<?php
defined('BASEPATH') or exit('No direct script access allowed');

 require APPPATH."/libraries/koolreport/core/autoload.php";

// production
// require APPPATH."../assets/koolreport/core/autoload.php"; 



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
		if (isset($post['id'])) {
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
		$this->db->select('pertamin_survey.srvy_survey_202006.id,pertamin_dashboard.user_unit.unit,pertamin_survey.srvy_survey_202006.202006X125X2916,pertamin_survey.srvy_survey_202006.202006X122X2859,MAX(pertamin_survey.srvy_survey_202006.startdate) as startdate');    
        $this->db->from('pertamin_survey.srvy_survey_202006');
        $this->db->join('pertamin_dashboard.user_unit', 'pertamin_survey.srvy_survey_202006.202006X125X2916 = user_unit.id');
		$this->db->order_by('202006X122X2859 desc'); 
		// $this->db->join('pertamin_dashboard.user','pertamin_survey.srvy_survey_202006.202006X125X2916 = user.unit');
		$data['merp'] = $this->db->group_by('unit')->get()->result_array();
		$data['is_admin'] = false;

		if($this->session->userdata('role_id') == 1){
			$data['is_admin'] = true;
		};
		
		$this->db->select('pertamin_survey.srvy_survey_202006.id,pertamin_dashboard.user_unit.unit,pertamin_survey.srvy_survey_202006.202006X125X2916,pertamin_survey.srvy_survey_202006.202006X122X2859,pertamin_survey.srvy_survey_202006.startdate');    
        $this->db->from('pertamin_survey.srvy_survey_202006');
		$this->db->join('pertamin_dashboard.user_unit', 'pertamin_survey.srvy_survey_202006.202006X125X2916 = user_unit.id','right outer');
		$this->db->order_by('202006X122X2859 desc'); 
		$all_data = $this->db->get()->result_array();
		
		$data['pie_chart'] =array(
			array("category"=>"> 90%","jumlah"=>0),
			array("category"=>"80 - 89%","jumlah"=>0),
			array("category"=>"70 - 79%","jumlah"=>0),
			array("category"=>"60 - 69%","jumlah"=>0),
			array("category"=>"0 - 69% / Belum Mengisi","jumlah"=>0),
		);

		$data['column_chart'] = array();
		$counter = 0;

		foreach($data['merp'] as $dm){
			$percentage = ($dm["202006X122X2859"] / 450 ) * 100;
			array_push($data['column_chart'],array(
				"category" => $dm["unit"],
				"nilai" => $dm["202006X122X2859"]
			));
			if($percentage >= 90){
				$data['column_chart'][$counter]["color"] = "#00b630";
			}elseif($percentage >= 80 && $percentage < 90){
				$data['column_chart'][$counter]["color"] = "#7cff04";
			}elseif($percentage >= 70 && $percentage < 80){
				$data['column_chart'][$counter]["color"] = "#ffec04";
			}elseif($percentage >= 60 && $percentage < 70){
				$data['column_chart'][$counter]["color"] = "#ff8f04";
			}else{
				$data['column_chart'][$counter]["color"] = "#ff0000";
			}
			$counter++;
		}

		foreach($all_data as $ad){
			$percentage = ($ad["202006X122X2859"] / 450 ) * 100;
			if($percentage >= 90){
				$data['pie_chart'][0]["jumlah"]++; 
			}elseif($percentage >= 80 && $percentage < 90){
				$data['pie_chart'][1]["jumlah"]++; 
			}elseif($percentage >= 70 && $percentage < 80){
				$data['pie_chart'][2]["jumlah"]++; 
			}elseif($percentage >= 60 && $percentage < 70){
				$data['pie_chart'][3]["jumlah"]++; 
			}else{
				$data['pie_chart'][4]["jumlah"]++; 
			}
		}




        
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
		if (isset($post['id'])) {
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
			    $this->sendMail('submitpic');
			    $this->sendMail('submitpictoapprover');
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
		
		// cek apakah ada data yang dikirimkan atau tidak
		if (isset($post['id'])) {
			$id = htmlspecialchars($post['id']);
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
			    $this->sendMail('acceptbyapprover');
				$this->db->update('merp', $data, array('id' => $post['id']));
				$this->Flasher_model->flashdata('Data berhasil di approve', 'Sukses', 'success');
				redirect('merp/approval');
			}elseif($status == "Tolak"){
			    $this->sendMail('rejectbyapprover');
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
		$this->load->library('email');
		
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
	
	public function chart(){

		
		
		$this->db->select('merp.*,user_unit.unit');    
		$this->db->from('merp');
		$this->db->join('user_unit', 'merp.unit_id = user_unit.id');

		
		$data['merp'] = $this->db->group_by('unit_id')->get()->result_array();
		$data['approve'] = $this->db->get_where('merp', ['id' => $this->input->post('id')])->row_array();
		$data['unit'] = $this->db->get_where('user_unit', ['id' => $this->session->userdata('unit')])->row_array();
		

		if($this->input->get('kode')){
			$kode = $this->input->get('kode');
			$id_unit = $this->db->get_where('merp', ['survey_id' => $kode])->row_array()["unit_id"];
			$data['unit'] = $this->db->get_where('user_unit', ['id' => $id_unit])->row_array();
			
		}else{
			$kode = $this->db->order_by('updated_at desc')->get_where('merp', ['unit_id' => $this->session->userdata('unit')])->result_array()[0]["survey_id"];
		};
		
		$query = $this->db->select('pertamin_survey.srvy_survey_202006.202006X122X2812, pertamin_survey.srvy_survey_202006.202006X125X2916,pertamin_survey.srvy_survey_202006.202006X122X2813, pertamin_survey.srvy_survey_202006.202006X122X2815, pertamin_survey.srvy_survey_202006.202006X122X2816, pertamin_survey.srvy_survey_202006.202006X122X2817, pertamin_survey.srvy_survey_202006.202006X122X2819, pertamin_survey.srvy_survey_202006.202006X122X2820, pertamin_survey.srvy_survey_202006.202006X122X2822, pertamin_survey.srvy_survey_202006.202006X122X2823, pertamin_survey.srvy_survey_202006.202006X122X2828, pertamin_survey.srvy_survey_202006.202006X122X2829, pertamin_survey.srvy_survey_202006.202006X122X2830, pertamin_survey.srvy_survey_202006.202006X122X2831, pertamin_survey.srvy_survey_202006.202006X122X2832, pertamin_survey.srvy_survey_202006.202006X122X2833, pertamin_survey.srvy_survey_202006.202006X122X2834, pertamin_survey.srvy_survey_202006.202006X122X2835, pertamin_survey.srvy_survey_202006.202006X122X2836, pertamin_survey.srvy_survey_202006.202006X122X2837, pertamin_survey.srvy_survey_202006.202006X122X2838, pertamin_survey.srvy_survey_202006.202006X122X2839, pertamin_survey.srvy_survey_202006.202006X122X2840, pertamin_survey.srvy_survey_202006.202006X122X2841, pertamin_survey.srvy_survey_202006.202006X122X2842, pertamin_survey.srvy_survey_202006.202006X122X2843, pertamin_survey.srvy_survey_202006.202006X122X2857, '.
								   '(pertamin_survey.srvy_survey_202006.202006X122X2812 + pertamin_survey.srvy_survey_202006.202006X122X2813 + pertamin_survey.srvy_survey_202006.202006X122X2815 + pertamin_survey.srvy_survey_202006.202006X122X2816 + pertamin_survey.srvy_survey_202006.202006X122X2817 + pertamin_survey.srvy_survey_202006.202006X122X2819 + pertamin_survey.srvy_survey_202006.202006X122X2820 + pertamin_survey.srvy_survey_202006.202006X122X2822 + pertamin_survey.srvy_survey_202006.202006X122X2823 + pertamin_survey.srvy_survey_202006.202006X122X2828 + pertamin_survey.srvy_survey_202006.202006X122X2829 + pertamin_survey.srvy_survey_202006.202006X122X2830 + pertamin_survey.srvy_survey_202006.202006X122X2831 + pertamin_survey.srvy_survey_202006.202006X122X2832 + pertamin_survey.srvy_survey_202006.202006X122X2833) AS score_procedure,'.
								   '(pertamin_survey.srvy_survey_202006.202006X122X2834 + pertamin_survey.srvy_survey_202006.202006X122X2835 + pertamin_survey.srvy_survey_202006.202006X122X2836 + pertamin_survey.srvy_survey_202006.202006X122X2837 + pertamin_survey.srvy_survey_202006.202006X122X2838) AS score_people,'.
								   '(pertamin_survey.srvy_survey_202006.202006X122X2839 + pertamin_survey.srvy_survey_202006.202006X122X2840 + pertamin_survey.srvy_survey_202006.202006X122X2841 + pertamin_survey.srvy_survey_202006.202006X122X2842 + pertamin_survey.srvy_survey_202006.202006X122X2843 + pertamin_survey.srvy_survey_202006.202006X122X2857) AS score_plant')
					->from('pertamin_survey.srvy_survey_202006')
					->where('pertamin_survey.srvy_survey_202006.id',$kode)
					->get();
		$question_fields = array(
			'procedure' => [12, 13, 15, 16, 17, 19, 20, 22, 23, 28, 29, 30 ,31, 32, 33 ],
			'people' => [34, 35, 36, 37, 38],
			'plant' => [ 39, 40, 41, 42, 43, 57]
		);
		$question_max_scores  = array(
			'procedure' => [10, 30, 10, 15, 25, 10, 20, 15, 20, 20, 15, 15, 15, 10, 20 ],
			'people' => [10, 35, 15, 35, 5],
			'plant' => [ 30, 30, 10, 5, 5, 20]
		);
		if ($query->num_rows() > 0) {
			$result = $query->result_array();
			$data['merp_scores'][0] = array (
				'category' => 'Procedure',
				'score' => $result[0]['score_procedure'],
				'max_score' => 250 );
			$data['merp_scores'][1] = array (
				'category' => 'People',
				'score' => $result[0]['score_people'],
				'max_score' => 100 );
			$data['merp_scores'][2] = array (
				'category' => 'Plant',
				'score' => $result[0]['score_plant'],
				'max_score' => 100 );
			$total = array_reduce($data['merp_scores'], function($carry, $item) {
				foreach($item as $k => $v)
					if(is_numeric($v)){
						$carry[$k] = $v + ($carry[$k] ?? 0);
					}
			
				return $carry;
			}, []);
			$data['merp_scores'][3] = array (
				'category' => 'Total',
				'score' => $total['score'],
				'max_score' => $total['max_score']);	

			$question_number = 0;
			$data['procedure_scores'] = array();
			for ($i = 0; $i < count($question_fields['procedure']); $i++) {
				$question_number++;
				$data['procedure_scores'][$i] = array (
					'category' => $question_number,
					'score' => intval($result[0]['202006X122X28'.$question_fields['procedure'][$i]]),
					'max_score' => intval($question_max_scores['procedure'][$i]));
			};
			$data['people_scores'] = array();
			for ($j = 0; $j < count($question_fields['people']); $j++) {
				$question_number++;
				$data['people_scores'][$j] = array (
					'category' => $question_number,
					'score' => intval($result[0]['202006X122X28'.$question_fields['people'][$j]]),
					'max_score' => intval($question_max_scores['people'][$j]));
			};
			$data['plant_scores'] = array();
			for ($k = 0; $k < count($question_fields['plant']); $k++) {
				$question_number++;
				$data['plant_scores'][$k] = array (
					'category' => $question_number,
					'score' => intval($result[0]['202006X122X28'.$question_fields['plant'][$k]]),
					'max_score' => intval($question_max_scores['plant'][$k]));
			};
		};
		
		// $client = new Client('https://survey.hsse.online/index.php/admin/remotecontrol');
		// $sSessionKey = $client->execute('get_session_key', ['username' => 'mimin', 'password' => '@123456']);
		$data['questions'] = 
		[
			["1","Apakah tersedia manajemen tanggap darurat medis yang terkait dengan operasi dan aktivitas perusahaan?"],
			["2","Apakah tersedia prosedur mengenai rencana tanggap darurat medis berdasarkan tingkat risiko serta sesuai dengan ketentuan regulasi yang ada?"],
			["3","Apakah terdapat rencana tanggap darurat medis (Medical Emergency Respon Plan/MERP) yang diintegrasikan ke dalam prosedur tanggap darurat (Emergency Respon Plan/ERP) Unit Operasi/Anak Perusahaan?"],
			["4","Apakah terdapat rencana tanggap darurat medis yang dikomunikasikan kepada seluruh stakeholder terkait secara efektif?"],
			["5","Apakah rencana tanggap darurat medis dipraktekkan secara teratur dengan latihan (drill) dan di evaluasi?"],
			["6","Apakah terdapat proses untuk memastikan bahwa pelajaran (lesson learned) ditindaklanjuti sebagai hasil evaluasi latihan (drill) atau insiden?"],
			["7","Apakah waktu respon yang sesuai telah ditetapkan untuk pertolongan pertama, perawatan medis darurat dan evakuasi?"],
			["8","Apakah terdapat prosedur untuk menentukan kecukupan klinik dan sarananya (termasuk AED) dalam penanganan tanggap darurat medis sesuai dengan tingkat risiko di lokasi?"],
			["9","Apakah semua stakeholder terkait telah mendapatkan informasi perihal nomor kontak darurat untuk bantuan medis di setiap tempat kerja dan perjalanan bisnis?"],
			["10","Apakah terdapat prosedur pelatihan Pertolongan Pertama Pada Kecelakaan/P3K dengan pelatihan dilaksanakan secara berkala.(Pelatihan dengan sertifikasi Kemenaker diperlukan bagi pekerja yang akan ditunjuk sebagai First Aider)."],
			["11","Apakah terdapat prosedur untuk memastikan klinik, sarana, ambulan, isi dari kotak P3K tersebut telah sesuai dengan standar yang berlaku dan terpelihara dengan baik. (Lihat Pedoman No. A-002/S00000/2017-S9 Rev.0 tentang Tanggap Darurat Medis, Corporate HSSE)?"],
			["11a","Apakah terdapat prosedur untuk memastikan sarana dan peralatan tanggap darurat medis diperiksa dan dipelihara secara berkala?"],
			["13","Apakah terdapat prosedur untuk meminta bantuan organisasi eksternal dalam menangani keadaan darurat?"],
			["14","Apakah terdapat perjanjian kerjasama dengan organisasi lain/eksternal untuk memberikan bantuan personil dan peralatan jika terjadi keadaan darurat?"],
			["15","Apakah dilakukan pengujian dan drill secara periodik sesuai dengan perjanjian kerjasama tersebut dan juga sistem tanggap darurat dari eksternal?"],
			["1","Apakah terdapat First Aider/FA (tersertifikasi Kemenaker) yang ditunjuk perusahaan untuk memenuhi waktu respon yang telah ditetapkan untuk pertolongan pertama (4 menit)?"],
			["2","Apakah distribusi pekerja yang terlatih First Aid sudah sesuai dengan risiko di lokasi kerja?"],
			["3","Apakah tersedia dokter/paramedis untuk melakukan perawatan medis darurat dan evakuasi?"],
			["4","Apakah Dokter dan paramedis telah memiliki sertifikat ACLS/ATLS (bagi dokter) dan BCLS/BTLS (bagi paramedic) yang masih valid?"],
			["5","Apakah terdapat pekerja yang ditunjuk untuk memelihara dan memastikan semua sarana (termasuk AED), isi kotak P3K terpelihara sepanjang waktu?"],
			["1","Apakah tersedia klinik/pos P3K, dan sarana (termasuk AED), yang sesuai dengan standar (risk based) dan terpelihara dengan baik. (Pedoman No. A-002/S00000/2017-S9 Rev.0 tentang Tanggap Darurat Medis, Corporate HSSE)?"],
			["2","Apakah tersedia alat transportasi untuk evakuasi medis (ambulan/kapal/helicopter) yang sesuai standard dan terpelihara dengan baik (Kepmenkes No. 143/Menkes-kesos/SK/II/2001, tentang Standarisasi Kendaraan Pelayanan Medik?"],
			["3","Apakah distribusi AED dan kotak P3K sudah sesuai dengan risiko di tempat kerja?"],
			["4","Apakah AED dan Kotak P3K terlihat dengan baik dan mudah diakses?"],
			["5","Apakah isi kotak P3K tersebut telah sesuai dengan standar yang berlaku dan terpelihara dengan baik.(Permenaker No 15 tahun 2008)?"],
			["6","Apakah RS Jejaring untuk Medevac dapat dijangkau dalam waktu 4 jam?"]

		];

		$data['kode'] = $kode;
		$data['jawaban'] = $this->answer_generator($kode);
		
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['userapp'] = $this->db->get_where('user', ['unit' => $this->session->userdata('unit')])->row_array();
		$data['title_page'] = "MERP Chart";
		$this->load->view('templates/sitemain/deskapp-header', $data);
		$this->load->view('templates/sitemain/deskapp-sidebar', $data);
		$this->load->view('templates/sitemain/deskapp-topbar', $data);
		$this->load->view('merp/chart');
		$this->load->view('templates/sitemain/deskapp-footer');

	}

	public function answer_generator($kode){

		function generate_file_links($file_link_json=null,$tindak_lanjut=null){
			$file_links = "";
			if($file_link_json != null){
				$replacements = [
					"[" => "",
					"]" => "",
				];
				$tks = strtr($file_link_json, $replacements);
				$obj = json_decode($tks,true);
				$arr = json_decode_multi($file_link_json);
				for ($x = 0; $x < count($arr[0]); $x++) {
					$file_links .= ($x+1)."."." <a target='_blank' href=".base_url()."merp/openFile/".$arr[0][$x]->filename."/".trim($arr[0][$x]->ext)."/".rawurlencode(str_replace(".","",$arr[0][$x]->title)).">".$arr[0][$x]->title.".".$arr[0][$x]->ext."</a><br>";
				}
			}
			if($tindak_lanjut != null){
				$file_links .= $tindak_lanjut;
			}
		
			if($file_link_json == null && $tindak_lanjut == null){
				return "-";
			}else {
				return $file_links;
			}
			
			
		}

		function json_decode_multi($txt, $assoc = false, $depth = 512, $options = 0) {
			if(substr($txt, -1) == ',')
				$txt = substr($s, 0, -1);
			return json_decode("[$txt]", $assoc, $depth, $options);
		}

		$query = $this->db->select('*')
					->from('pertamin_survey.srvy_survey_202006')
					->where('id',$kode)
					->get();
		if ($query->num_rows() > 0) {
			$data = $query->result_array()[0]; 
			if($data['202006X97X2735'] == 1){
				$j1 = "Tersedia manajemen tanggap darurat medis";
			}else{
				$j1 = "Belum tersedia manajemen tanggap darurat medis";
			}
			$tl1 = generate_file_links($data['202006X97X2736'],$data['202006X97X2737']);
	
			if($data['202006X97X2736'] != null){
				$txt = $data['202006X97X2736'];//File
				$tl1 = generate_file_links($txt);
			}
	
	
			if($data['202006X97X2861'] != null){
				$rcn1 = date('d/m/Y',strtotime($data['202006X97X2861']));
			}else{
				$rcn1 =  "-";
			}
			if($data['202006X97X2860'] != null){
				$pic1 = $data['202006X97X2860'];
			}else{
				$pic1 = "-";
			}
	
			//-------Soal 2-----------
			$tl2 = "";
			if($data['202006X98X2738'] == 3){
				$j2 = "Prosedur tanggap darurat medis tersedia dan sesuai dengan tingkat risiko serta sesuai dengan regulasi";
			}
			elseif($data['202006X98X2738'] == 2){
				$j2 = "Prosedur tanggap darurat medis tersedia, sesuai dengan regulasi minimal";
			}
			elseif($data['202006X98X2738'] == 1){
				$j2 = "Prosedur tanggap darurat medis tersedia namun belum mengacu pada ketentuan regulasi";
			}else{
				$j2 = "Prosedur tanggap darurat medis belum tersedia";
			}
	
			$tl2 = generate_file_links($data['202006X98X2740'],$data['202006X98X2741']);
	
	
			if($data['202006X98X2889'] != null){
				$rcn2 = date('d/m/Y',strtotime($data['202006X98X2889']));
			}else{
				$rcn2 =  "-";
			}
			if($data['202006X98X2862'] != null){
				$pic2 = $data['202006X98X2862'];
			}else{
				$pic2 = "-";
			}
	
			//-------Soal 3-----------
	
			if($data['202006X99X2742'] == 1){
				$j3 = "Tersedia rencana tanggap darurat medis yang terintegrasi ke dalam prosedur tanggap darurat (Emergency Respon/ERP)";
			}else{
				$j3 = "Belum tersedia manajemen tanggap darurat medis yang terintegrasi ke dalam prosedur tanggap darurat (Emergency Respon/ERP)";
			}
	
			$tl3 = generate_file_links($data['202006X99X2744'],$data['202006X99X2743']);
	
	
			if($data['202006X99X2890'] != null){
				$rcn3 = date('d/m/Y',strtotime($data['202006X99X2890']));
			}else{
				$rcn3 =  "-";
			}
			if($data['202006X99X2863'] != null){
				$pic3 = $data['202006X99X2863'];
			}else{
				$pic3 = "-";
			}
	
			//-------Soal 4-----------
			if($data['202006X100X2745'] == 3){
				$j4 = "Terdapat rencana tanggap darurat medis (MERP) yang telah disosialisasikan kepada seluruh stakeholder menggunakan media yg ada dan dilakukan pemantauan efektivitasnya";
			}
			elseif($data['202006X100X2745'] == 2){
				$j4 = "Terdapat rencana tanggap darurat medis (MERP) yang telah disosialisasikan kepada stakeholder menggunakan media yg ada namun belum dilakukan pemantauan efektivitasnya";
			}
			elseif($data['202006X100X2745'] == 1){
				$j4 = "Terdapat rencana tanggap darurat medis (MERP) yang telah disosialisasikan kepada  50% stakeholder";
			}else{
				$j4 = "Terdapat rencana tanggap darurat medis (MERP) namun belum dikomunikasikan kepada seluruh stakeholder";
			}
	
	
			$tl4 = generate_file_links($data['202006X100X2747'],$data['202006X100X2746']);
	
			if($data['202006X100X2865'] != null){
				$pic4 = $data['202006X100X2865'];
			}else{
				$pic4 = "-";
			}
			if($data['202006X100X2891'] != null){
				$rcn4 = date('d/m/Y',strtotime($data['202006X100X2891']));
			}else{
				$rcn4 =  "-";
			}
	
			//-------Soal 5-----------
			$tl5 = "";
			if($data['202006X101X2748'] != null){
				if($data['202006X101X2748'] == 4){
					$j5 = "Simulasi tanggap darurat medis (MERP) telah dilakukan sesuai dengan jumlah skenario";
				}
				elseif($data['202006X101X2748'] == 3){
					$j5 = "Simulasi tanggap darurat medis (MERP) telah dilakukan 50-75% dari  jumlah skenario";
				}
				elseif($data['202006X101X2748'] == 2){
					$j5 = "Simulasi tanggap darurat medis (MERP) telah dilakukan >25-50% dari  jumlah skenario";
				}
				elseif($data['202006X101X2748'] == 1){
					$j5 = "Simulasi tanggap darurat medis (MERP) telah dilakukan >0-25% dari  jumlah skenario";
				}else{
					$j5 = "Simulasi tanggap darurat medis (MERP)  tidak dilakukan";
				}
				
				$tl5 = generate_file_links($data['202006X101X2750'],$data['202006X101X2749']);
			
				if($data['202006X101X2866'] != null){
					$pic5 = $data['202006X101X2866'];
				}else{
					$pic5 = "-";
				}
				if($data['202006X101X2892'] != null){
					$rcn5 = date('d/m/Y',strtotime($data['202006X101X2892']));
				}else{
					$rcn5 =  "-";
				}
			}else{
				if($data['202006X123X2845'] == 4){
					$j5 = "Simulasi tanggap darurat medis (MERP) telah dilakukan sesuai dengan jumlah skenario";
				}
				elseif($data['202006X123X2845'] == 3){
					$j5 = "Simulasi tanggap darurat medis (MERP) telah dilakukan 50-75% dari  jumlah skenario";
				}
				elseif($data['202006X123X2845'] == 2){
					$j5 = "Simulasi tanggap darurat medis (MERP) telah dilakukan >25-50% dari  jumlah skenario";
				}
				elseif($data['202006X123X2845'] == 1){
					$j5 = "Simulasi tanggap darurat medis (MERP) telah dilakukan >0-25% dari  jumlah skenario";
				}else{
					$j5 = "Simulasi tanggap darurat medis (MERP)  tidak dilakukan";
				}
	
				$tl5 = generate_file_links($data['202006X123X2847'],$data['202006X123X2846']);
	
				if($data['202006X123X2867'] != null){
					$pic5 = $data['202006X123X2867'];
				}else{
					$pic5 = "-";
				}
				if($data['202006X123X2893'] != null){
					$rcn5 = date('d/m/Y',strtotime($data['202006X123X2893']));
				}else{
					$rcn5 =  "-";
				}
			}
	
			//-------Soal 6-----------
			if($data['202006X102X2751'] == 4){
				$j6 = "Seluruh temuan dari hasil evaluasi telah ditindaklanjuti";
			}
			elseif($data['202006X102X2751'] == 3){
				$j6 = "75% temuan dari hasil evaluasi telah ditindaklanjuti";
			}
			elseif($data['202006X102X2751'] == 2){
				$j6 = "50% temuan dari hasil evaluasi telah ditindaklanjuti";
			}
			elseif($data['202006X102X2751'] == 1){
				$j6 = "25% temuan dari hasil evaluasi telah ditindaklanjuti";
			}else{
				$j6 = "Tidak terdapat proses untuk memastikan bahwa pelajaran (lesson learned) ditindaklanjuti";
			}
				
			$tl6 = generate_file_links($data['202006X102X2753'],$data['202006X102X2752']);
	
			if($data['202006X102X2868'] != null){
				$pic6 = $data['202006X102X2868'];
			}else{
				$pic6 = "-";
			}
			if($data['202006X102X2894'] != null){
				$rcn6 = date('d/m/Y',strtotime($data['202006X102X2894']));
			}else{
				$rcn6 =  "-";
			}
	
			//-------Soal 7-----------
			if($data['202006X103X2754'] == 2){
				$j7 = "Seluruh waktu respon yang diperlukan telah ditetapkan baik untuk MERP1, MERP2 dan MERP3";
			}
			elseif($data['202006X103X2754'] == 1){
				$j7 = "Belum seluruh waktu respon yang diperlukan telah ditetapkan baik untuk MERP1, MERP2 dan MERP3";
			}else{
				$j7 = "Waktu respon yang diperlukan tidak ditetapkan baik untuk MERP1, MERP2 dan MERP3";
			}
	
			$tl7 = generate_file_links($data['202006X124X2856'],$data['202006X124X2855']);
	
			if($data['202006X103X2869'] != null){
				$pic7 = $data['202006X103X2869'];
			}else{
				$pic7 = "-";
			}
			if($data['202006X103X2895'] != null){
				$rcn7 = date('d/m/Y',strtotime($data['202006X103X2895']));
			}else{
				$rcn7 =  "-";
			}
	
			//-------Soal 8-----------
			if($data['202006X104X2757'] == 2){
				$j8 = "Prosedur telah menilai seluruh kecukupan klinik yang meliputi tenaga medis dan paramedis yang kompeten, obat-obatan emergensi, tandu, AED dan ketersediaan ambulan";
			}
			elseif($data['202006X104X2757'] == 1){
				$j8 = "Prosedur telah menilai sebagian kecukupan klinik yang meliputi tenaga medis dan paramedis yang kompeten, obat-obatan emergensi, tandu, AED dan ketersediaan ambulan";
			}else{
				$j8 = "Tidak terdapat prosedur";
			}
	
			$tl8 = generate_file_links($data['202006X104X2759'],$data['202006X104X2758']);
	
			if($data['202006X104X2870'] != null){
				$pic8 = $data['202006X104X2870'];
			}else{
				$pic8 = "-";
			}
			if($data['202006X104X2896'] != null){
				$rcn8 = date('d/m/Y',strtotime($data['202006X104X2896']));
			}else{
				$rcn8 =  "-";
			}
	
			//-------Soal 9-----------
			if($data['202006X105X2760'] == 2){
				$j9 = "Nomor kontak darurat terdapat pada lokasi yang mudah diakses, seperti area public, kendaraan perusahaan, ataupun dokumen hse pass";
			}
			elseif($data['202006X105X2760'] == 1){
				$j9 = "Nomor kontak darurat tidak terdapat pada lokasi yang mudah diakses, seperti area public, kendaraan perusahaan, ataupun dokumen hse pass";
			}else{
				$j9 = "Tidak terdapat nomor kontak darurat ";
			}
	
			$tl9 = generate_file_links($data['202006X105X2762'],$data['202006X105X2761']);
	
			if($data['202006X105X2871'] != null){
				$pic9 = $data['202006X105X2871'];
			}else{
				$pic9 = "-";
			}
			if($data['202006X105X2897'] != null){
				$rcn9 = date('d/m/Y',strtotime($data['202006X105X2897']));
			}else{
				$rcn9 =  "-";
			}
	
			//-------Soal 10-----------
			if($data['202006X106X2763'] == 1){
				$j10 = "Terdapat prosedur pelatihan Pertolongan Pertama Pada Kecelakaan/P3K dengan pelatihan dilaksanakan secara berkala";
			}else{
				$j10 = "Tidak terdapat prosedur pelatihan Pertolongan Pertama Pada Kecelakaan/P3K dengan pelatihan dilaksanakan secara berkalamemenuhi standar";
			}
	
			$tl10 = generate_file_links($data['202006X106X2765'],$data['202006X106X2764']);
	
			if($data['202006X106X2872'] != null){
				$pic10 = $data['202006X106X2872'];
			}else{
				$pic10 = "-";
			}
			if($data['202006X106X2898'] != null){
				$rcn10 = date('d/m/Y',strtotime($data['202006X106X2898']));
			}else{
				$rcn10 =  "-";
			}
	
			//-------Soal 11-----------
			if($data['202006X107X2766'] == 1){
				$j11 = "Terdapat prosedur untuk memastikan klinik, sarana, ambulan, isi dari kotak P3K tersebut telah sesuai dengan standar yang berlaku dan terpelihara dengan baik";
			}else{
				$j11 = "Tidak terdapat prosedur untuk memastikan klinik, sarana, ambulan, isi dari kotak P3K tersebut telah sesuai dengan standar yang berlaku dan terpelihara dengan baik";
			}
	
			$tl11 = generate_file_links($data['202006X107X2768'],$data['202006X107X2767']);
	
			if($data['202006X107X2873'] != null){
				$pic11 = $data['202006X107X2873'];
			}else{
				$pic11 = "-";
			}
			if($data['202006X107X2899'] != null){
				$rcn11 = date('d/m/Y',strtotime($data['202006X107X2899']));
			}else{
				$rcn11 =  "-";
			}
	
			//-------Soal 12-----------
			if($data['202006X108X2769'] == 1){
				$j12 = "Terdapat prosedur untuk memastikan sarana dan peralatan tanggap darurat medis diperiksa dan dipelihara secara berkala";
			}else{
				$j12 = "Tidak tterdapat prosedur untuk memastikan sarana dan peralatan tanggap darurat medis diperiksa dan dipelihara secara berkala";
			}
	
			$tl12 = generate_file_links($data['202006X108X2771'],$data['202006X108X2770']);
	
			if($data['202006X108X2874'] != null){
				$pic12 = $data['202006X108X2874'];
			}else{
				$pic12 = "-";
			}
			if($data['202006X108X2900'] != null){
				$rcn12 = date('d/m/Y',strtotime($data['202006X108X2900']));
			}else{
				$rcn12 =  "-";
			}
	
			//-------Soal 13-----------
			if($data['202006X109X2772'] != null){
				if($data['202006X109X2772'] == 1){
					$j13 = "Terdapat prosedur untuk meminta bantuan organisasi eksternal dalam menangani keadaan daruratjika memenuhi standar";
				}else{
					$j13 = "Tidak terdapat prosedur untuk meminta bantuan organisasi eksternal dalam menangani keadaan darurat";
				}
	
				$tl13 = generate_file_links($data['202006X109X2774'],$data['202006X109X2773']);
	
				if($data['202006X109X2875'] != null){
					$pic13 = $data['202006X109X2875'];
				}else{
					$pic13 = "-";
				}
				if($data['202006X109X2901'] != null){
					$rcn13 = date('d/m/Y',strtotime($data['202006X109X2901']));
				}else{
					$rcn13 =  "-";
				}
			}else{
				if($data['202006X109X2849'] == 1){
					$j13 = "Terdapat prosedur untuk meminta bantuan organisasi eksternal dalam menangani keadaan daruratjika memenuhi standar";
				}else{
					$j13 = "Tidak terdapat prosedur untuk meminta bantuan organisasi eksternal dalam menangani keadaan darurat";
				}
	
				$tl13 = generate_file_links($data['202006X109X2774'],$data['202006X109X2773']);
	
				if($data['202006X109X2875'] != null){
					$pic13 = $data['202006X109X2875'];
				}else{
					$pic13 = "-";
				}
				if($data['202006X109X2901'] != null){
					$rcn13 = date('d/m/Y',strtotime($data['202006X109X2901']));
				}else{
					$rcn13 =  "-";
				}
			}
	
			//-------Soal 14-----------
			if($data['202006X110X2775'] == 1){
				$j14 = "Terdapat perjanjian kerjasama dengan organisasi lain/eksternal untuk memberikan bantuan personil dan peralatan jika terjadi keadaan darurat";
			}else{
				$j14 = "Tidak terdapat perjanjian kerjasama dengan organisasi lain/eksternal untuk memberikan bantuan personil dan peralatan jika terjadi keadaan darurat";
			}
	
			$tl14 = generate_file_links($data['202006X110X2777'],$data['202006X110X2776']);
	
			if($data['202006X110X2876'] != null){
				$pic14 = $data['202006X110X2876'];
			}else{
				$pic14 = "-";
			}
			if($data['202006X110X2902'] != null){
				$rcn14 = date('d/m/Y',strtotime($data['202006X110X2902']));
			}else{
				$rcn14 =  "-";
			}
	
			//-------Soal 15-----------
			if($data['202006X111X2778'] == 4){
				$j15 = "Simulasi/drill  MERP dilakukan sesuai dengan jumlah skenario";
			}elseif($data['202006X111X2778'] == 3){
				$j15 = "Simulasi/dril  MERP dilakukan 75% dari  jumlah skenario";
			}elseif($data['202006X111X2778'] == 2){
				$j15 = "Simulasi/drill MERP telah dilakukan >25-50% dari  jumlah skenario";
			}elseif($data['202006X111X2778'] == 1){
				$j15 = "Simulasi/drill MERP telah dilakukan >0-25% dari jumlah skenario";
			}else{
				$j15 = "Simulasi/drill MERP tidak dilakukan";
			}
	
			$tl15 = generate_file_links($data['202006X111X2780'],$data['202006X111X2779']);
	
			if($data['202006X111X2877'] != null){
				$pic15 = $data['202006X111X2877'];
			}else{
				$pic15 = "-";
			}
			if($data['202006X111X2903'] != null){
				$rcn15 = date('d/m/Y',strtotime($data['202006X111X2903']));
			}else{
				$rcn15 =  "-";
			}
	
			//-------Soal 16-----------
			if($data['202006X112X2781'] != null){
				if($data['202006X112X2781'] == 4){
					$j16 = "Terdapat First Aider (FA) tersertifikasi untuk memenuhi waktu respon yg tekah ditentukan";
				}elseif($data['202006X112X2781'] == 3){
					$j16 = "Terdapat First Aider (FA) tersertifikasi namun belum dapat memenuhi waktu respon yg telah ditentukan";
				}elseif($data['202006X112X2781'] == 2){
					$j16 = "Tidak terdapat First Aider (FA) tersertifikasi, namun tersedia FA yg dilatih mandiri";
				}elseif($data['202006X112X2781'] == 1){
					$j16 = "Tidak terdapat First Aider (FA)";
				}else{
					$j16 = "Simulasi/drill MERP tidak dilakukan";
				}
	
				$tl16 = generate_file_links($data['202006X112X2783'],$data['202006X112X2782']);
	
				if($data['202006X112X2878'] != null){
					$pic16 = $data['202006X112X2878'];
				}else{
					$pic16 = "-";
				}
				if($data['202006X112X2904'] != null){
					$rcn16 = date('d/m/Y',strtotime($data['202006X112X2904']));
				}else{
					$rcn16 =  "-";
				}
			}else{
				if($data['202006X112X2851'] == 4){
					$j16 = "Terdapat First Aider (FA) tersertifikasi untuk memenuhi waktu respon yg tekah ditentukan";
				}elseif($data['202006X112X2851'] == 3){
					$j16 = "Terdapat First Aider (FA) tersertifikasi namun belum dapat memenuhi waktu respon yg telah ditentukan";
				}elseif($data['202006X112X2851'] == 2){
					$j16 = "Tidak terdapat First Aider (FA) tersertifikasi, namun tersedia FA yg dilatih mandiri";
				}elseif($data['202006X112X2851'] == 1){
					$j16 = "Tidak terdapat First Aider (FA)";
				}else{
					$j16 = "Simulasi/drill MERP tidak dilakukan";
				}
	
				$tl16 = generate_file_links($data['202006X112X2783'],$data['202006X112X2782']);
	
				if($data['202006X112X2878'] != null){
					$pic16 = $data['202006X112X2878'];
				}else{
					$pic16 = "-";
				}
				if($data['202006X112X2904'] != null){
					$rcn16 = date('d/m/Y',strtotime($data['202006X112X2904']));
				}else{
					$rcn16 =  "-";
				}
			}
	
			//-------Soal 17-----------
			if($data['202006X113X2784'] == 3){
				$j17 = "Terdapat FA tersertifikasi untuk memenuhi waktu respon yg tekah ditentukan";
			}elseif($data['202006X113X2784'] == 2){
				$j17 = "Terdapat FA tersertifikasi namun belum dapat memenuhi waktu respon yg telah ditentukan";
			}elseif($data['202006X113X2784'] == 1){
				$j17 = "Tidak terdapat FA tersertifikasi, namun tersedia FA yg dilatih mandiri";
			}else{
				$j17 = "Tidak terdapat FA";
			} 
	
			$tl17 = generate_file_links($data['202006X113X2786'],$data['202006X113X2785']);
	
			if($data['202006X113X2879'] != null){
				$pic17 = $data['202006X113X2879'];
			}else{
				$pic17 = "-";
			}
			if($data['202006X113X2905'] != null){
				$rcn17 = date('d/m/Y',strtotime($data['202006X113X2905']));
			}else{
				$rcn17 =  "-";
			}
	
			//-------Soal 18-----------
			if($data['202006X114X2787'] == 1){
				$j18 = "Terdapat dokter/paramedis untuk melakukan perawatan medis darurat";
			}else{
				$j18 = "Tidak terdapat dokter dan paramedis untuk melakukan perawatan medis darurat";
			}
	
			$tl18 = generate_file_links($data['202006X114X2789'],$data['202006X114X2788']);
			if($data['202006X114X2880'] != null){
				$pic18 = $data['202006X114X2880'];
			}else{
				$pic18 = "-";
			}
			if($data['202006X114X2906'] != null){
				$rcn18 = date('d/m/Y',strtotime($data['202006X114X2906']));
			}else{
				$rcn18 =  "-";
			}
	
			//-------Soal 19-----------
			if($data['202006X115X2790'] == 2){
				$j19 = "Terdapat dokter dan paramedis dg sertifikasi lengkap";
			}
			elseif($data['202006X115X2790'] == 1){
				$j19 = "Sertifikat dokter dan paramedis tidak lengkap";
			}else{
				$j19 = "Hanya terdapat FA";
			}
	
			$tl19 = generate_file_links($data['202006X115X2792'],$data['202006X115X2791']);
	
			if($data['202006X115X2881'] != null){
				$pic19 = $data['202006X115X2881'];
			}else{
				$pic19 = "-";
			}
			if($data['202006X115X2907'] != null){
				$rcn19 = date('d/m/Y',strtotime($data['202006X115X2907']));
			}else{
				$rcn19 =  "-";
			}
	
			//-------Soal 20-----------
			if($data['202006X116X2793'] == 1){
				$j20 = "Terdapat pekerja yang ditunjuk untuk memelihara dan memastikan semua sarana (termasuk AED), isi kotak P3K terpelihara sepanjang waktu";
			}else{
				$j20 = "Tidak terdapat pekerja yang ditunjuk untuk memelihara dan memastikan semua sarana (termasuk AED), isi kotak P3K terpelihara sepanjang waktu";
			}
	
			
			$tl20 = generate_file_links($data['202006X116X2795'],$data['202006X116X2794']);
	
			if($data['202006X116X2882'] != null){
				$pic20 = $data['202006X116X2882'];
			}else{
				$pic20 = "-";
			}
			if($data['202006X116X2908'] != null){
				$rcn20 = date('d/m/Y',strtotime($data['202006X116X2908']));
			}else{
				$rcn20 =  "-";
			}
	
			//-------Soal 21-----------
			if($data['202006X117X2796'] == 3){
				$j21 = "Terdapat Klinik dan seluruh sarananya sesuai dg standar";
			}
			elseif($data['202006X117X2796'] == 2){
				$j21 = "Terdapat klinik dan sebagian besar sarananya sesuai dg standar";
			}
			elseif($data['202006X117X2796'] == 1){
				$j21 = "Terdapat klinik namun hanya sebagian kecil sarananya yang tersedia";
			}else{
				$j21 = "Tidak terdapat klinik dan sarananya";
			} 
	
			$tl21 = generate_file_links($data['202006X117X2798'],$data['202006X117X2797']);
	
			if($data['202006X117X2883'] != null){
				$pic21 = $data['202006X117X2883'];
			}else{
				$pic21 = "-";
			}
			if($data['202006X117X2909'] != null){
				$rcn21 = date('d/m/Y',strtotime($data['202006X117X2909']));
			}else{
				$rcn21 =  "-";
			}
	
			//-------Soal 22-----------
			if($data['202006X118X2799'] == 3){
				$j22 = "Tersedia alat transportasi evakuasi sesuai dg standar dan risiko yg diidentifikasi";
			}
			elseif($data['202006X118X2799'] == 2){
				$j22 = "Tersedia alat transportasi evakuasi dengan persyaratan yang hampir sebagian besar memenuhi standar";
			}
			elseif($data['202006X118X2799'] == 1){
				$j22 = "Tersedia alat transportasi evakuasi dengan persyaratan yang hampir sebagain besar memenuhi standar";
			}else{
				$j22 = "Tidak terdapat alat transportasi";
			} 
	
			$tl22 = generate_file_links($data['202006X118X2801'],$data['202006X118X2800']);
	
			if($data['202006X118X2884'] != null){
				$pic22 = $data['202006X118X2884'];
			}else{
				$pic22 = "-";
			}
			if($data['202006X118X2910'] != null){
				$rcn22 = date('d/m/Y',strtotime($data['202006X118X2910']));
			}else{
				$rcn22 =  "-";
			}
	
			//-------Soal 23-----------
			if($data['202006X119X2802'] == 1){
				$j23 = "Distribusi AED dan kotak P3K sudah sesuai dengan risiko di tempat kerja";
			}else{
				$j23 = "Distribusi AED dan kotak P3K belum sesuai dengan risiko di tempat kerja";
			}
	
			$tl23 = generate_file_links($data['202006X119X2804'],$data['202006X119X2803']);
	
			if($data['202006X119X2885'] != null){
				$pic23 = $data['202006X119X2885'];
			}else{
				$pic23 = "-";
			}
			if($data['202006X119X2911'] != null){
				$rcn23 = date('d/m/Y',strtotime($data['202006X119X2911']));
			}else{
				$rcn23 =  "-";
			}
	
			//-------Soal 24-----------
			if($data['202006X120X2805'] == 1){
				$j24 = "AED dan Kotak P3K terlihat dengan baik dan mudah diakses";
			}else{
				$j24 = "AED dan Kotak P3K sulit untuk diakses atau tidak tersedia";
			}
	
			$tl24 = generate_file_links($data['202006X120X2807'],$data['202006X120X2806']);
	
			if($data['202006X120X2886'] != null){
				$pic24 = $data['202006X120X2886'];
			}else{
				$pic24 = "-";
			}
			if($data['202006X120X2912'] != null){
				$rcn24 = date('d/m/Y',strtotime($data['202006X120X2912']));
			}else{
				$rcn24 =  "-";
			}
	
			//-------Soal 25-----------
			if($data['202006X121X2808'] == 1){
				$j25 = "Isi kotak P3K tersebut telah sesuai dengan standar yang berlaku dan terpelihara dengan baik";
			}else{
				$j25 = "Isi kotak P3K tersebut tidak sesuai dengan standar yang berlaku dan terpelihara dengan baik";
			}
	
			$tl25 = generate_file_links($data['202006X121X2810'],$data['202006X121X2809']);
	
			if($data['202006X121X2887'] != null){
				$pic25 = $data['202006X121X2887'];
			}else{
				$pic25 = "-";
			}
			if($data['202006X121X2913'] != null){
				$rcn25 = date('d/m/Y',strtotime($data['202006X121X2913']));
			}else{
				$rcn25 =  "-";
			}
	
			//-------Soal 26-----------
			if($data['202006X124X2854'] == 1){
				$j26 = "RS jejaring dapat dijangkau dalam waktu 4 jam/sesuia dengan identifikasi risiko";
			}else{
				$j26 = "RS jejaring tidak dapat dijangkau dalam waktuyg telah diidentifikasi";
			}
	
			$tl26 = generate_file_links($data['202006X124X2856'],$data['202006X124X2855']);
	
			if($data['202006X124X2888'] != null){
				$pic26 = $data['202006X124X2888'];
			}else{
				$pic26 = "-";
			}
			if($data['202006X124X2914'] != null){
				$rcn26 = date('d/m/Y',strtotime($data['202006X124X2914']));
			}else{
				$rcn26 =  "-";
			}

			$jawaban = [
				[$j1,$tl1,$rcn1,$pic1],
				[$j2,$tl2,$rcn2,$pic2],
				[$j3,$tl3,$rcn3,$pic3],
				[$j4,$tl4,$rcn4,$pic4],
				[$j5,$tl5,$rcn5,$pic5],
				[$j6,$tl6,$rcn6,$pic6],
				[$j7,$tl7,$rcn7,$pic7],
				[$j8,$tl8,$rcn8,$pic8],
				[$j9,$tl9,$rcn9,$pic9],
				[$j10,$tl10,$rcn10,$pic10],
				[$j11,$tl11,$rcn11,$pic11],
				[$j12,$tl12,$rcn12,$pic12],
				[$j13,$tl13,$rcn13,$pic13],
				[$j14,$tl14,$rcn14,$pic14],
				[$j15,$tl15,$rcn15,$pic15],
				[$j16,$tl16,$rcn16,$pic16],
				[$j17,$tl17,$rcn17,$pic17],
				[$j18,$tl18,$rcn18,$pic18],
				[$j19,$tl19,$rcn19,$pic19],
				[$j20,$tl20,$rcn20,$pic20],
				[$j21,$tl21,$rcn21,$pic21],
				[$j22,$tl22,$rcn22,$pic22],
				[$j23,$tl23,$rcn23,$pic23],
				[$j24,$tl24,$rcn24,$pic24],
				[$j25,$tl25,$rcn25,$pic25],
				[$j26,$tl26,$rcn26,$pic26]
			];
			return $jawaban;
		
		}else{
			return false;
		}
	}
	
	public function show_file($filename, $ext){
		$file_location = '';
		switch($ext){
			case 'pdf':
			  $file_location = 'files'; // store as constant maybe inside index.php - PDF = 'uploads/pdf/';
 
			  //must have PDF viewer installed in browser !
		   $this->output
			->set_content_type('application/pdf')
			->set_output(file_get_contents($file_location . '/' . $id . '.pdf'))
			->set_header('Cache-Control: no-store, no-cache, must-revalidate');
 
			break;
			//jpg gif etc here...
		}
 
	 }

	 public function openFile(){
		$this->load->helper('file');

		$realfilename = $this->uri->segment(3);
		$filename = $this->uri->segment(5).".".$this->uri->segment(4);
		
		

		$fileRealPath = FCPATH.'files/'.$realfilename;
		
		if (file_exists($fileRealPath)) {
			$mimeType = get_mime_by_extension($filename);
			if (is_null($mimeType)) {
				$mimeType = "application/octet-stream";
			}
			@ob_clean();
			if($mimeType == "application/pdf" || $mimeType == "image/jpeg" || $mimeType == "image/png"){
				header('Content-Disposition: inline;filename="'.$filename.'"');
				header('Content-Type: '.$mimeType);
				header('Expires: 0');
				header("Cache-Control: must-revalidate, no-store, no-cache");
				header('Content-Length: '.filesize($fileRealPath));
				readfile($fileRealPath);
				exit;

			}else{
				header('Content-Disposition: attachment; filename="'.$filename.'"');
				header('Content-Type: '.$mimeType);
				header('Expires: 0');
				header("Cache-Control: must-revalidate, no-store, no-cache");
				header('Content-Length: '.filesize($fileRealPath));
				readfile($fileRealPath);
				exit;
			}
			
		}
	 }
	

}