<?php
session_start();
ob_start();
include_once("connextion.php"); //buat koneksi ke database
$kode   = $_GET['id']; //kode berita yang akan dikonvert
$sql = "SELECT * FROM srvy_survey_202006 WHERE id=$kode";
$query = $conn->query($sql);
$data   = mysqli_fetch_array($query);
require_once dirname(__FILE__).'/html2pdf/vendor/autoload.php';

use Spipu\Html2Pdf\Html2Pdf;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Exception\ExceptionFormatter;

try {
    $html2pdf = new Html2Pdf('L', 'A4', 'fr', true, 'UTF-8', array(15, 10, 15, 10));
    $html2pdf->pdf->SetDisplayMode('fullpage');

    ob_start();
    include dirname(__FILE__).'/index.php';
    $content = ob_get_clean();

    $html2pdf->writeHTML($content);
    // $html2pdf->output("MERP2020_".$kode.".pdf","D");
    $html2pdf->output();
} catch (Html2PdfException $e) {
    $html2pdf->clean();

    $formatter = new ExceptionFormatter($e);
    echo $formatter->getHtmlMessage();
}
?>