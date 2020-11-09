<?php
//MyReport.php
require APPPATH."/libraries/koolreport/core/autoload.php";
class MerpReport extends \koolreport\KoolReport
{
    // use \koolreport\clients\Bootstrap;
    // function settings()
    // {
    //     return array(
    //         "assets"=>array(
    //             "path"=>"../../assets",
    //             "url"=>"assets",
    //         ),
    //         "dataSources"=>array(
    //             "survey"=>array(
    //                 "connectionString"=>"mysql:host=localhost;dbname=pertamin_survey",
    //                 "username"=>"root",
    //                 "password"=>"qlue12345",
    //                 "charset"=>"utf8"
    //             )
    //         )
    //     );
    // }
    // function setup()
    // {
    //     $this->src('survey')
    //     ->query("Select * from offices")
    //     ->pipe($this->dataStore("offices"));
    // }
}