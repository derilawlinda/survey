<?php
    use \koolreport\chartjs\BarChart;
    use \koolreport\chartjs\ColumnChart;
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

<link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>

<div class="container mt-3">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary"><?= $title_page; ?></h6>
        </div>
        <div class="card-body">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Rangkuman</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="procedure-tab" data-toggle="tab" href="#procedure" role="tab" aria-controls="profile" aria-selected="false">Procedure</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="people-tab" data-toggle="tab" href="#people" role="tab" aria-controls="contact" aria-selected="false">People</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="plant-tab" data-toggle="tab" href="#plant" role="tab" aria-controls="contact" aria-selected="false">Plant</a>
                </li>
            </ul>

            <?php if (isset($merp_scores)) { ?>

                <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <div style="margin-bottom:50px;">
                        <?php
                        BarChart::create(array(
                            "title"=>"MERP Chart unit ". $unit["unit"],
                            "dataSource"=>$merp_scores,
                            "columns"=>array(
                                "category",
                                "score"=>array(
                                    "label"=>"Score",
                                    "type"=>"number",
                                    "prefix"=>"",
                                    "config"=>array(
                                        "yAxisID"=>"bar-y-sale",
                                    )
                                ),
                                "max_score"=>array(
                                    "label"=>"Max Score",
                                    "type"=>"number",
                                    "prefix"=>"",
                                    "config"=>array(
                                        "yAxisID"=>"bar-y-cost"
                                    )
                                ),
                            ),
                            "options"=>array(
                                "scales"=>array(
                                    "yAxes"=>array(
                                        array(
                                            "stacked"=>true,
                                            "id"=>"bar-y-sale",
                                            "barThickness"=> 40,
                                            "scaleLabel"=>[
                                                "display"=>true,
                                                "labelString"=>"Kategori"
                                            ]
                                        ),
                                        array(
                                            "stacked"=>true,
                                            "id"=>"bar-y-cost",
                                            "display"=>false,
                                            "type"=>"category",
                                            "barThickness"=> 20,
                                            "categoryPercentage"=> 0.8,
                                            "barPercentage"=> 0.9,
                                            "offset"=>true,
                                            
                                        ),
                                    ),
                                    "xAxes"=>array(
                                        array(
                                            "stacked"=>false,
                                            "scaleLabel"=>[
                                                "display"=>true,
                                                "labelString"=>"Score"
                                            ]
                                        )
                                    )
                                )
                            )
                        ));
                        ?>
                    </div>
                </div>
         
                <div class="tab-pane fade" id="procedure" role="tabpanel" aria-labelledby="people-tab">
                    <div style="margin-bottom:50px;">
                        <?php
                        ColumnChart::create(array(
                            "title"=>"Procedure score unit ". $unit["unit"],
                            "dataSource"=>$procedure_scores,
                            "columns"=>array(
                                "category",
                                "score"=>array(
                                    "label"=>"Score",
                                    "type"=>"number",
                                    "prefix"=>"",
                                    "config"=>array(
                                        "xAxisID"=>"bar-x-sale",
                                    )
                                ),
                                "max_score"=>array(
                                    "label"=>"Max Score",
                                    "type"=>"number",
                                    "prefix"=>"",
                                    "config"=>array(
                                        "xAxisID"=>"bar-x-cost"
                                    )
                                ),
                            ),
                            "options"=>array(
                                "scales"=>array(
                                    "yAxes"=>array(
                                        array(
                                            "stacked"=>false,
                                            "scaleLabel"=>[
                                                "display"=>true,
                                                "labelString"=>"Score"
                                            ]
                                        )
                                    ),
                                    "xAxes"=>array(
                                        array(
                                            "id"=>"bar-x-sale",
                                            "stacked"=>true,
                                            "barThickness"=> 30,
                                            "scaleLabel"=>[
                                                "display"=>true,
                                                "labelString"=>"Pertanyaan Procedure"
                                            ]
                                        ),
                                        array(
                                            "id"=>"bar-x-cost",
                                            "stacked"=>true,
                                            "display"=>false,
                                            "barThickness"=> 10,
                                            "type"=>"category",
                                            "categoryPercentage"=> 0.8,
                                            "barPercentage"=> 0.9,
                                            "offset"=>true,
                                            "gridLines"=> array(
                                            "offsetGridLines"=> true
                                            ),
                                        ),
                                    )
                                )
                            )
                        ));
                        ?>
                    </div>

                    <div>
                        <table style="margin:auto;margin-top:50px;" id="procedureTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Pertanyaan</th>
                                    <th>Jawaban</th>
                                    <th>Tindak Lanjut / Evidence</th>
                                    <th>Rencana Pelaksanaan</th>
                                    <th>PIC</th>
                                </tr>
                            </thead>
                            <tbody>

                            <?php 
                            $counter = 0;
                            for ($i = 0; $i < 15; $i++) { 
                            ?>
                                <tr>
                                    <td><?php echo $counter+1; ?></td>
                                    <td style="width:200px"><?php echo $questions[$counter][1]; ?></td>
                                    <td style="width:200px"><?php echo $jawaban[$counter][0];?></td>
                                    <td style="width:300px"><?php echo $jawaban[$counter][1];?></td>
                                    <td><?php echo $jawaban[$counter][2]; ?></td>
                                    <td style="width:100px"><?php echo $jawaban[$counter][3]; ?></td>
                                </tr>
                            <?php 
                                $counter += 1;
                            }; ?>
                                
                            </tbody>
                        </table>
                    </div>
                </div>


                <div class="tab-pane fade" id="people" role="tabpanel" aria-labelledby="people-tab">
                    <div style="margin-bottom:50px;">
                        <?php
                        ColumnChart::create(array(
                            "title"=>"People score unit ". $unit["unit"],
                            "dataSource"=>$people_scores,
                            "columns"=>array(
                                "category",
                                "score"=>array(
                                    "label"=>"Score",
                                    "type"=>"number",
                                    "prefix"=>"",
                                    "config"=>array(
                                        "xAxisID"=>"bar-x-sale",
                                    )
                                ),
                                "max_score"=>array(
                                    "label"=>"Max Score",
                                    "type"=>"number",
                                    "prefix"=>"",
                                    "config"=>array(
                                        "xAxisID"=>"bar-x-cost"
                                    )
                                ),
                            ),
                            "options"=>array(
                                "scales"=>array(
                                    "yAxes"=>array(
                                        array(
                                            "stacked"=>false,
                                            "scaleLabel"=>[
                                                "display"=>true,
                                                "labelString"=>"Score"
                                            ]
                                        )
                                    ),
                                    "xAxes"=>array(
                                        array(
                                            "id"=>"bar-x-sale",
                                            "stacked"=>true,
                                            "barThickness"=> 30,
                                            "scaleLabel"=>[
                                                "display"=>true,
                                                "labelString"=>"Pertanyaan People"
                                            ]
                                        ),
                                        array(
                                            "id"=>"bar-x-cost",
                                            "stacked"=>true,
                                            "display"=>false,
                                            "barThickness"=> 10,
                                            "type"=>"category",
                                            "categoryPercentage"=> 0.8,
                                            "barPercentage"=> 0.9,
                                            "offset"=>true,
                                            "gridLines"=> array(
                                            "offsetGridLines"=> true
                                            ),
                                        ),
                                    )
                                )
                            )
                        ));
                        ?>
                    </div>

                    <div>
                        <table style="margin:auto;margin-top:50px;" id="peopleTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Pertanyaan</th>
                                    <th>Jawaban</th>
                                    <th>Tindak Lanjut / Evidence</th>
                                    <th>Rencana Pelaksanaan</th>
                                    <th>PIC</th>
                                </tr>
                            </thead>
                            <tbody>

                            <?php 
                            for ($i = 0; $i < 5; $i++) { 
                            ?>
                                <tr>
                                    <td><?php echo $counter+1; ?></td>
                                    <td style="width:200px"><?php echo $questions[$counter][1]; ?></td>
                                    <td style="width:200px"><?php echo $jawaban[$counter][0];?></td>
                                    <td style="width:300px"><?php echo $jawaban[$counter][1];?></td>
                                    <td><?php echo $jawaban[$counter][2]; ?></td>
                                    <td style="width:100px"><?php echo $jawaban[$counter][3]; ?></td>
                                </tr>
                            <?php 
                                $counter += 1;
                            }; ?>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
       

                <div class="tab-pane fade" id="plant" role="tabpanel" aria-labelledby="plant-tab">
                    <div style="margin-bottom:50px;">
                        <?php
                        ColumnChart::create(array(
                            "title"=>"People score unit ". $unit["unit"],
                            "dataSource"=>$plant_scores,
                            "columns"=>array(
                                "category",
                                "score"=>array(
                                    "label"=>"Score",
                                    "type"=>"number",
                                    "prefix"=>"",
                                    "config"=>array(
                                        "xAxisID"=>"bar-x-sale",
                                    )
                                ),
                                "max_score"=>array(
                                    "label"=>"Max Score",
                                    "type"=>"number",
                                    "prefix"=>"",
                                    "config"=>array(
                                        "xAxisID"=>"bar-x-cost"
                                    )
                                ),
                            ),
                            "options"=>array(
                                "scales"=>array(
                                    "yAxes"=>array(
                                        array(
                                            "stacked"=>false,
                                            "scaleLabel"=>[
                                                "display"=>true,
                                                "labelString"=>"Score"
                                            ],
                                            "ticks"=>array(
                                                "suggestedMin"=>0
                                            )
                                        )
                                    ),
                                    "xAxes"=>array(
                                        array(
                                            "id"=>"bar-x-sale",
                                            "stacked"=>true,
                                            "barThickness"=> 30,
                                            "scaleLabel"=>[
                                                "display"=>true,
                                                "labelString"=>"Pertanyaan Plant"
                                            ]
                                        ),
                                        array(
                                            "id"=>"bar-x-cost",
                                            "stacked"=>true,
                                            "display"=>false,
                                            "barThickness"=> 10,
                                            "type"=>"category",
                                            "categoryPercentage"=> 0.8,
                                            "barPercentage"=> 0.9,
                                            "offset"=>true,
                                            "gridLines"=> array(
                                            "offsetGridLines"=> true
                                            ),
                                        ),
                                    )
                                )
                            )
                        ));
                        ?>
                    </div>

                    <div>
                        <table style="margin:auto;margin-top:50px;" id="plantTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Pertanyaan</th>
                                    <th>Jawaban</th>
                                    <th>Tindak Lanjut / Evidence</th>
                                    <th>Rencana Pelaksanaan</th>
                                    <th>PIC</th>
                                </tr>
                            </thead>
                            <tbody>

                            <?php 
                            for ($i = 0; $i < 6; $i++) { 
                            ?>
                                <tr>
                                    <td><?php echo $counter+1; ?></td>
                                    <td style="width:200px"><?php echo $questions[$counter][1]; ?></td>
                                    <td style="width:200px"><?php echo $jawaban[$counter][0];?></td>
                                    <td style="width:300px"><?php echo $jawaban[$counter][1];?></td>
                                    <td><?php echo $jawaban[$counter][2]; ?></td>
                                    <td style="width:100px"><?php echo $jawaban[$counter][3]; ?></td>
                                </tr>
                            <?php 
                                $counter += 1;
                            }; ?>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> <!-- tab content -->

            <?php }
            else{ 
                 echo "<p style='margin-top:50px;' class='font-18 max-width-600'> Tidak ada data </p>";
            }
                ?>
                
            
      
        </div>

       
    </div>
</div>

<script type="text/javascript">
$(document).ready(function() {
    // Setup - add a text input to each footer cell
    $('#procedureTable thead tr').clone(true).appendTo( '#procedureTable thead' );
    $('#procedureTable thead tr:eq(1) th').each( function (i) {
        var title = $(this).text();
        $(this).html( '<input type="text" style="width:100%"/>' );
 
        $( 'input', this ).on( 'keyup change', function () {
            if ( table.column(i).search() !== this.value ) {
                table
                    .column(i)
                    .search( this.value )
                    .draw();
            }
        } );
    } );
 
    var table = $('#procedureTable').DataTable( {
        orderCellsTop: true,
        fixedHeader: true
    } );

    $('#peopleTable thead tr').clone(true).appendTo( '#peopleTable thead' );
    $('#peopleTable thead tr:eq(1) th').each( function (i) {
        var title = $(this).text();
        $(this).html( '<input type="text" style="width:100%"/>' );
 
        $( 'input', this ).on( 'keyup change', function () {
            if ( peopleTable.column(i).search() !== this.value ) {
                peopleTable
                    .column(i)
                    .search( this.value )
                    .draw();
            }
        } );
    } );
 
    var peopleTable = $('#peopleTable').DataTable( {
        orderCellsTop: true,
        fixedHeader: true
    } );

    $('#plantTable thead tr').clone(true).appendTo( '#plantTable thead' );
    $('#plantTable thead tr:eq(1) th').each( function (i) {
        var title = $(this).text();
        $(this).html( '<input type="text" style="width:100%"/>' );
 
        $( 'input', this ).on( 'keyup change', function () {
            if ( plantTable.column(i).search() !== this.value ) {
                plantTable
                    .column(i)
                    .search( this.value )
                    .draw();
            }
        } );
    } );
 
    var plantTable = $('#plantTable').DataTable( {
        orderCellsTop: true,
        fixedHeader: true
    } );
} );
</script>
