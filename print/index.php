<?php
include_once("connextion.php"); //buat koneksi ke database
$kode   = $_GET['id']; //kode berita yang akan dikonvert
$sql = "SELECT * FROM srvy_survey_202006 WHERE id=$kode";
$query = $conn->query($sql);
$data   = mysqli_fetch_array($query);
function json_decode_multi($txt, $assoc = false, $depth = 512, $options = 0) {
    if(substr($txt, -1) == ',')
        $txt = substr($s, 0, -1);
    return json_decode("[$txt]", $assoc, $depth, $options);
}

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
            $file_links .= ($x+1)."."." <a target='_blank' href='https://survey.pertamina-pdc.network/dashboard/files/".$arr[0][$x]->filename."'>".$arr[0][$x]->title.".".$arr[0][$x]->ext."</a><br>";
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
//-------Soal 1-----------
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
?>

<style>
table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
}
th, td {
  padding: 15px;
}
</style>

<?php
//Isi HTML Ada disini
echo "<img src='./assets/pertamina.png' style='max-height:50px;float:right'>
<h2>Medical Emergency Response Readiness Assesment Tool</h2>";

echo '<table style="margin:auto;margin-top:50px;">
<thead>
    <tr>
        <th>No</th>
        <th>Jawaban</th>
        <th>Tindak Lanjut / Evidence</th>
        <th>Rencana Pelaksanaan</th>
        <th>PIC</th>
    </tr>
</thead>
<tbody>
    <tr><td colspan="5" align="center"><b>PROCEDURE</b></td></tr>
    <tr>
        <td>1</td>
        <td style="width:200px">'.$j1.'</td>
        <td style="width:300px">'.$tl1.'</td>
        <td>'.$rcn1.'</td>
        <td style="width:100px">'.$pic1.'</td>
    </tr>
    <tr>
        <td>2</td>
        <td style="width:200px">'.$j2.'</td>
        <td style="width:300px">'.$tl2.'</td>
        <td>'.$rcn2.'</td>
        <td style="width:100px">'.$pic2.'</td>
    </tr>
    <tr>
        <td>3</td>
        <td style="width:200px">'.$j3.'</td>
        <td style="width:300px">'.$tl3.'</td>
        <td>'.$rcn3.'</td>
        <td style="width:100px">'.$pic3.'</td>
    </tr>
    <tr>
        <td>4</td>
        <td style="width:200px">'.$j4.'</td>
        <td style="width:300px">'.$tl4.'</td>
        <td>'.$rcn4.'</td>
        <td style="width:100px">'.$pic4.'</td>
    </tr>
    <tr>
        <td>5</td>
        <td style="width:200px">'.$j5.'</td>
        <td style="width:300px">'.$tl5.'</td>
        <td>'.$rcn5.'</td>
        <td style="width:100px">'.$pic5.'</td>
    </tr>
    <tr>
        <td>6</td>
        <td style="width:200px">'.$j6.'</td>
        <td style="width:300px">'.$tl6.'</td>
        <td>'.$rcn6.'</td>
        <td style="width:100px">'.$pic6.'</td>
    </tr>
    <tr>
        <td>7</td>
        <td style="width:200px">'.$j7.'</td>
        <td style="width:300px">'.$tl7.'</td>
        <td>'.$rcn7.'</td>
        <td style="width:100px">'.$pic7.'</td>
    </tr>
    <tr>
        <td>8</td>
        <td style="width:200px">'.$j8.'</td>
        <td style="width:300px">'.$tl8.'</td>
        <td>'.$rcn8.'</td>
        <td style="width:100px">'.$pic8.'</td>
    </tr>
    <tr>
        <td>9</td>
        <td style="width:200px">'.$j9.'</td>
        <td style="width:300px">'.$tl9.'</td>
        <td>'.$rcn9.'</td>
        <td style="width:100px">'.$pic9.'</td>
    </tr>
    <tr>
        <td>10</td>
        <td style="width:200px">'.$j10.'</td>
        <td style="width:300px">'.$tl10.'</td>
        <td>'.$rcn10.'</td>
        <td style="width:100px">'.$pic10.'</td>
    </tr>
    <tr>
        <td>11</td>
        <td style="width:200px">'.$j11.'</td>
        <td style="width:300px">'.$tl11.'</td>
        <td>'.$rcn11.'</td>
        <td style="width:100px">'.$pic11.'</td>
    </tr>
    <tr>
        <td>11a</td>
        <td style="width:200px">'.$j12.'</td>
        <td style="width:300px">'.$tl12.'</td>
        <td>'.$rcn12.'</td>
        <td style="width:100px">'.$pic12.'</td>
    </tr>
    <tr>
        <td>13</td>
        <td style="width:200px">'.$j13.'</td>
        <td style="width:300px">'.$tl13.'</td>
        <td>'.$rcn13.'</td>
        <td style="width:100px">'.$pic13.'</td>
    </tr>
    <tr>
        <td>14</td>
        <td style="width:200px">'.$j14.'</td>
        <td style="width:300px">'.$tl14.'</td>
        <td>'.$rcn14.'</td>
        <td style="width:100px">'.$pic14.'</td>
    </tr>
    <tr>
        <td>15</td>
        <td style="width:200px">'.$j15.'</td>
        <td style="width:300px">'.$tl15.'</td>
        <td>'.$rcn15.'</td>
        <td style="width:100px">'.$pic15.'</td>
    </tr>
    <tr><td colspan="5" align="center"><b>PEOPLE</b></td></tr>
    <tr>
        <td>1</td>
        <td style="width:200px">'.$j16.'</td>
        <td style="width:300px">'.$tl16.'</td>
        <td>'.$rcn16.'</td>
        <td style="width:100px">'.$pic16.'</td>
    </tr>
    <tr>
        <td>2</td>
        <td style="width:200px">'.$j17.'</td>
        <td style="width:300px">'.$tl17.'</td>
        <td>'.$rcn17.'</td>
        <td style="width:100px">'.$pic17.'</td>
    </tr>
    <tr>
        <td>3</td>
        <td style="width:200px">'.$j18.'</td>
        <td style="width:300px">'.$tl18.'</td>
        <td>'.$rcn18.'</td>
        <td style="width:100px">'.$pic18.'</td>
    </tr>
    <tr>
        <td>4</td>
        <td style="width:200px">'.$j19.'</td>
        <td style="width:300px">'.$tl19.'</td>
        <td>'.$rcn19.'</td>
        <td style="width:100px">'.$pic19.'</td>
    </tr>
    <tr>
        <td>5</td>
        <td style="width:200px">'.$j20.'</td>
        <td style="width:300px">'.$tl20.'</td>
        <td>'.$rcn20.'</td>
        <td style="width:100px">'.$pic20.'</td>
    </tr>
    <tr><td colspan="5" align="center"><b>PLANT</b></td></tr>
    <tr>
        <td>1</td>
        <td style="width:200px">'.$j21.'</td>
        <td style="width:300px">'.$tl21.'</td>
        <td>'.$rcn21.'</td>
        <td style="width:100px">'.$pic21.'</td>
    </tr>
    <tr>
        <td>2</td>
        <td style="width:200px">'.$j22.'</td>
        <td style="width:300px">'.$tl22.'</td>
        <td>'.$rcn22.'</td>
        <td style="width:100px">'.$pic22.'</td>
    </tr>
    <tr>
        <td>3</td>
        <td style="width:200px">'.$j23.'</td>
        <td style="width:300px">'.$tl23.'</td>
        <td>'.$rcn23.'</td>
        <td style="width:100px">'.$pic23.'</td>
    </tr>
    <tr>
        <td>4</td>
        <td style="width:200px">'.$j24.'</td>
        <td style="width:300px">'.$tl24.'</td>
        <td>'.$rcn24.'</td>
        <td style="width:100px">'.$pic24.'</td>
    </tr>
    <tr>
        <td>5</td>
        <td style="width:200px">'.$j25.'</td>
        <td style="width:300px">'.$tl25.'</td>
        <td>'.$rcn25.'</td>
        <td style="width:100px">'.$pic25.'</td>
    </tr>
    <tr>
        <td>6</td>
        <td style="width:200px">'.$j26.'</td>
        <td style="width:300px">'.$tl26.'</td>
        <td>'.$rcn26.'</td>
        <td style="width:100px">'.$pic26.'</td>
    </tr>
</tbody>
</table>';

?>