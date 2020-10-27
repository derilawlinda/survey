<?php
defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH."/libraries/koolreport/core/autoload.php";
use JsonRPC\CLient;



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
	
	public function chart(){

		$query = $this->db->select('pertamin_survey.srvy_survey_202006.202006X122X2812, pertamin_survey.srvy_survey_202006.202006X122X2813, pertamin_survey.srvy_survey_202006.202006X122X2815, pertamin_survey.srvy_survey_202006.202006X122X2816, pertamin_survey.srvy_survey_202006.202006X122X2817, pertamin_survey.srvy_survey_202006.202006X122X2819, pertamin_survey.srvy_survey_202006.202006X122X2820, pertamin_survey.srvy_survey_202006.202006X122X2822, pertamin_survey.srvy_survey_202006.202006X122X2823, pertamin_survey.srvy_survey_202006.202006X122X2828, pertamin_survey.srvy_survey_202006.202006X122X2829, pertamin_survey.srvy_survey_202006.202006X122X2830, pertamin_survey.srvy_survey_202006.202006X122X2831, pertamin_survey.srvy_survey_202006.202006X122X2832, pertamin_survey.srvy_survey_202006.202006X122X2833, pertamin_survey.srvy_survey_202006.202006X122X2834, pertamin_survey.srvy_survey_202006.202006X122X2835, pertamin_survey.srvy_survey_202006.202006X122X2836, pertamin_survey.srvy_survey_202006.202006X122X2837, pertamin_survey.srvy_survey_202006.202006X122X2838, pertamin_survey.srvy_survey_202006.202006X122X2839, pertamin_survey.srvy_survey_202006.202006X122X2840, pertamin_survey.srvy_survey_202006.202006X122X2841, pertamin_survey.srvy_survey_202006.202006X122X2842, pertamin_survey.srvy_survey_202006.202006X122X2843, pertamin_survey.srvy_survey_202006.202006X122X2857, '.
								   '(pertamin_survey.srvy_survey_202006.202006X122X2812 + pertamin_survey.srvy_survey_202006.202006X122X2813 + pertamin_survey.srvy_survey_202006.202006X122X2815 + pertamin_survey.srvy_survey_202006.202006X122X2816 + pertamin_survey.srvy_survey_202006.202006X122X2817 + pertamin_survey.srvy_survey_202006.202006X122X2819 + pertamin_survey.srvy_survey_202006.202006X122X2820 + pertamin_survey.srvy_survey_202006.202006X122X2822 + pertamin_survey.srvy_survey_202006.202006X122X2823 + pertamin_survey.srvy_survey_202006.202006X122X2828 + pertamin_survey.srvy_survey_202006.202006X122X2829 + pertamin_survey.srvy_survey_202006.202006X122X2830 + pertamin_survey.srvy_survey_202006.202006X122X2831 + pertamin_survey.srvy_survey_202006.202006X122X2832 + pertamin_survey.srvy_survey_202006.202006X122X2833) AS score_procedure,'.
								   '(pertamin_survey.srvy_survey_202006.202006X122X2834 + pertamin_survey.srvy_survey_202006.202006X122X2835 + pertamin_survey.srvy_survey_202006.202006X122X2836 + pertamin_survey.srvy_survey_202006.202006X122X2837 + pertamin_survey.srvy_survey_202006.202006X122X2838) AS score_people,'.
								   '(pertamin_survey.srvy_survey_202006.202006X122X2839 + pertamin_survey.srvy_survey_202006.202006X122X2840 + pertamin_survey.srvy_survey_202006.202006X122X2841 + pertamin_survey.srvy_survey_202006.202006X122X2842 + pertamin_survey.srvy_survey_202006.202006X122X2843 + pertamin_survey.srvy_survey_202006.202006X122X2857) AS score_plant')
					->from('pertamin_survey.srvy_survey_202006')
					->where('pertamin_survey.srvy_survey_202006.202006X125X2916',$this->session->userdata('unit'))
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
		$questions_procedure = 
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
			["15","Apakah dilakukan pengujian dan drill secara periodik sesuai dengan perjanjian kerjasama tersebut dan juga sistem tanggap darurat dari eksternal?"]
		];

		$questions_people = 
		[
			["1","Apakah terdapat First Aider/FA (tersertifikasi Kemenaker) yang ditunjuk perusahaan untuk memenuhi waktu respon yang telah ditetapkan untuk pertolongan pertama (4 menit)?"],
			["2","Apakah distribusi pekerja yang terlatih First Aid sudah sesuai dengan risiko di lokasi kerja?"],
			["3","Apakah tersedia dokter/paramedis untuk melakukan perawatan medis darurat dan evakuasi?"],
			["4","Apakah Dokter dan paramedis telah memiliki sertifikat ACLS/ATLS (bagi dokter) dan BCLS/BTLS (bagi paramedic) yang masih valid?"],
			["5","Apakah terdapat pekerja yang ditunjuk untuk memelihara dan memastikan semua sarana (termasuk AED), isi kotak P3K terpelihara sepanjang waktu?"]
		];
		
		$questions_plant = 
		[
			["1","Apakah tersedia klinik/pos P3K, dan sarana (termasuk AED), yang sesuai dengan standar (risk based) dan terpelihara dengan baik. (Pedoman No. A-002/S00000/2017-S9 Rev.0 tentang Tanggap Darurat Medis, Corporate HSSE)?"],
			["2","Apakah tersedia alat transportasi untuk evakuasi medis (ambulan/kapal/helicopter) yang sesuai standard dan terpelihara dengan baik (Kepmenkes No. 143/Menkes-kesos/SK/II/2001, tentang Standarisasi Kendaraan Pelayanan Medik?"],
			["3","Apakah distribusi AED dan kotak P3K sudah sesuai dengan risiko di tempat kerja?"],
			["4","Apakah AED dan Kotak P3K terlihat dengan baik dan mudah diakses?"],
			["5","Apakah isi kotak P3K tersebut telah sesuai dengan standar yang berlaku dan terpelihara dengan baik.(Permenaker No 15 tahun 2008)?"],
			["6","Apakah RS Jejaring untuk Medevac dapat dijangkau dalam waktu 4 jam?"]
		];
		
		
		$this->db->select('merp.*,user_unit.unit');    
		$this->db->from('merp');
		$this->db->join('user_unit', 'merp.unit_id = user_unit.id');
		
		$data['merp'] = $this->db->group_by('unit_id')->get()->result_array();
		$data['approve'] = $this->db->get_where('merp', ['id' => $this->input->post('id')])->row_array();
		$data['unit'] = $this->db->get_where('user_unit', ['id' => $this->session->userdata('unit')])->row_array();
		
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['userapp'] = $this->db->get_where('user', ['unit' => $this->session->userdata('unit')])->row_array();
		$data['title_page'] = "MERP Chart";
		$this->load->view('templates/sitemain/deskapp-header', $data);
		$this->load->view('templates/sitemain/deskapp-sidebar', $data);
		$this->load->view('templates/sitemain/deskapp-topbar', $data);
		$this->load->view('merp/chart');
		$this->load->view('templates/sitemain/deskapp-footer');

	}

}