<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Send_mail extends CI_Controller {

    /**
     * Kirim email dengan SMTP Gmail.
     *
     */
    public function index()
    {
        // Konfigurasi email
        $config = [
            'mailtype'  => 'html',
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
    
        $this->email->from('no-reply@pertamina.com', 'Online Survey MERP 113');
        $this->email->to('sabichul145@gmail.com'); // Ganti dengan email tujuan
        // $this->email->attach('https://masrud.com/content/images/20181215150137-codeigniter-smtp-gmail.png');
        $this->email->subject('Notifikasi Online Survey MERP');
        $this->email->message("Ini adalah contoh email yang dikirim menggunakan SMTP Gmail pada CodeIgniter.<br><br> Klik <strong><a href='https://masrud.com/post/kirim-email-dengan-smtp-gmail' target='_blank' rel='noopener'>disini</a></strong> untuk melihat tutorialnya.");
    
        if ($this->email->send()) {
            echo 'Sukses! email berhasil dikirim.';
            echo $this->email->print_debugger();
        } else {
            echo 'Error! email tidak dapat dikirim.';
            echo $this->email->print_debugger();
        }
    }
}