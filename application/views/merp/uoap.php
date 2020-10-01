
<!-- DataTales Example -->
<div class="container mt-3">
				<!-- Simple Datatable start -->
				<div class="card-box mb-30">
            		<div class="card-header py-3 d-flex justify-content-between pd-20">
            		  	<h6 class="m-0 font-weight-bold text-primary"><?= $title_page; ?></h6>
            		  	<a href="https://survey.pertamina-pdc.network/index.php/202006?lang=id" target="_blank" class="btn-sm btn-primary">Jawab Survey</a>
            		</div>
					<div class="card-body pb-20">
						<table class="data-table table stripe hover nowrap">
							<thead>
								<tr>
            						<th class="table-plus datatable-nosort">No</th>
            						<th>UO/AP</th>
            						<!--<th>Total Nilai</th>-->
            						<!--<th>Persentase</th>-->
            						<th>Tanggal Pengisian</th>
            						<th>Action</th>
								</tr>
							</thead>
							<tbody>
							    <?php 
            			      	$number = 0;
            			      	foreach($merp as $r): ?>
            			      	<?php $persen = intval(($r['202006X122X2859']/450)*100); ?>
            			      	<?php if($user['role_id'] != 1 && $user['unit'] == $r['202006X125X2916']){ ?>
            			      	<tr>
            			      		<td><?= ++$number; ?></td>
            			      		<td><?= $r['unit']; ?></td>
            			      		<!--<td><?= $r['202006X122X2859']; ?></td>-->
            			      		<!--<td style="background-color:<?php if($persen == 100){echo "#2c8f64";} ?>"><?= $persen; ?></td>-->
            			      		<td><?= date('d F Y h:i:s',strtotime($r['startdate'])); ?></td>
            			    <!--  		<td>	-->
            			    <!--  			<a href="#" class="btn-sm btn-warning p-2 tampilModalUbah" data-id="<?= $r['id']; ?>" data-url="<?= base_url(); ?>" data-toggle="modal" data-target="#formModal">Edit</a>		-->
            							<!--<a href="#" class="btn-sm btn-danger p-2 tampilModalAlert" data-id="<?= $r['id']; ?>" data-url="<?= base_url(); ?>" data-toggle="modal" data-target="#alertModal">Delete</a>		-->
            			    <!--  		</td>-->
									<td>
										<div class="dropdown">
											<a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
												<i class="dw dw-more"></i>
											</a>
											<div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
												<a class="dropdown-item tampilModalUbah" href="#" data-id="<?= $r['id']; ?>" data-url="<?= base_url(); ?>" data-toggle="modal" data-target="#formModal"><i class="dw dw-edit"></i> Submit</a>
												<!--<a class="dropdown-item" href="#"><i class="dw dw-edit2"></i> Edit</a>-->
												<!--<a class="dropdown-item" href="#"><i class="dw dw-delete-3"></i> Delete</a>-->
											</div>
										</div>
									</td>
								</tr>
            			      	<?php } ?>
            				    <?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
				<!-- Simple Datatable End -->    
</div>

<!-- form Modal -->
<div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<form id="formModalAction" action="" method="post">
                <input type="text" name="id" id="id" class="form-control" value="" hidden="hidden">
                <div class="modal-header">
                    <h5 class="modal-title" id="formModalLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                        <div class="form-group">
                            <input type="number" name="id" hidden="hidden">
                            <input type="number" name="survey_id" hidden="hidden">
                            <input type="text" hidden="hidden" name="unit_id" class="form-control" required="">
                            <input type="text" hidden="hidden" name="nilai" class="form-control" required="">
                            <input type="text" name="created_by" class="form-control" hidden="hidden" value="<?= $user['email']; ?>">
                            <input type="text" name="approver" class="form-control" hidden="hidden" value="<?= $userapp['email']; ?>">
                            <input type="text" name="lokasi" class="form-control" hidden="hidden" value="<?= $unit['unit']; ?>">
                        </div>
                        <div class="form-group">
							<span id="submitDate"></span>
							<!--<table class="table stripe hover"><thead><tr><th class="table-plus datatable-nosort">No.</th><th width="50%">Jawaban</th><th>Tindak Lanjut / Evidence</th><th>Rencana Pelaksanaan</th><th>PIC</th></tr></thead>-->
							<!--	<?php for ($i=1; $i < 27; $i++) { ?>-->
							<!--		<tbody id="soal<?= $i; ?>"></tbody>-->
							<!--	<?php } ?>-->
							<!--</table>-->
                        </div>
                </div>
                <div class="modal-footer">
                    <a href="<?= base_url(); ?>merp/uoap" type="button" class="btn btn-secondary" required="">Close</a>
                    <button type="submit" class="btn btn-primary" id="formModalBtn">Add</button>
                </div>
            </form>
		</div>
	</div>
</div>
<!-- Alert Modal -->
<div class="modal fade" id="alertModal" tabindex="-1" role="dialog" aria-labelledby="alertModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="alertModalLabel"></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
			<p id="paragrafBodyModal"></p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<a href="" id="anchorAlertModal"></a>
			</div>
		</div>
	</div>
</div>

<script>
	// Scrip hidden and unhidden button
	$(document).ready(function(){
		$('.reportSurvey').DataTable({
            scrollCollapse: true,
            autoWidth: false,
            responsive: true,
            columnDefs: [{
                targets: "datatable-nosort",
                orderable: false,
            }],
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "language": {
                "info": "_START_-_END_ of _TOTAL_ entries",
                searchPlaceholder: "Search",
                paginate: {
                    next: '<i class="ion-chevron-right"></i>',
                    previous: '<i class="ion-chevron-left"></i>'  
                }
            },
            dom: 'Bfrtip',
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'pdfHtml5',
                'print'
            ]
        });
		// menampilkan alert konfirmasi hapus data
		$('.tampilModalAlert').on('click', function(){
			const id = $(this).data('id');
			const url = $(this).data('url');
			$('#alertModalLabel').html('Delete Menu');
			$('#anchorAlertModal').attr('class', 'btn btn-danger');
			$('#anchorAlertModal').html('Delete');
			$('#paragrafBodyModal').html('Are You Sure..?');
			$('#anchorAlertModal').attr('href', url + 'administrator/userdelete/' + id);
		});
		// modal edit data
		$('.tampilModalUbah').on('click', function(){
			const id = $(this).data('id');
			const url = $(this).data('url');
			$('#formModalLabel').html('Submit Survey');
			$('#formModalBtn').html('Submit');
			$('#formModalAction').attr('action', url + 'merp/uoap');
			$.ajax({
				url: url + 'merp/surveydetail',
				data: {id: id},
				method: 'post',
				dataType: 'json',
				success: function(data){
					//Insert/////////
					$('input[name=id]').val(data['id']);
					$('input[name=survey_id]').val(data['id']);
					$('input[name=unit_id]').val(data['202006X125X2916']);
					$('input[name=nilai]').val(data['202006X122X2859']);
					//View
					$( "#submitDate" ).html( "<tr><td><button class='btn btn-sm btn-warning' style='margin-bottom:5%'>Survey Completion : "+data['submitdate']+"</button></td><td><a href=<?= base_url(); ?>print/report.php?id="+data['id']+" target='_blank' class='btn btn-sm btn-info' style='margin-bottom:11%'>Print Jawaban</a></td></tr>" );


					
					//------ Soal 1 -----------
					if(data['202006X97X2735'] != null){//Soal Berapa
						var txt = data['202006X97X2736'];//File
						if(txt == null){
							var tks = new String('{ "name":"","filename":"" }');
						}else{
							var tks = txt.replace("[",'').replace("]",'');
						}
						var obj = JSON.parse(tks);
						if(data['202006X97X2735'] == 1){
							var jawaban = new String("Tersedia manajemen tanggap darurat medis");
						}else{
							var jawaban = new String("Belum tersedia manajemen tanggap darurat medis");
						}
						if(data['202006X97X2861'] != null){
                            var d = new Date(data['202006X97X2861']);
                            var curr_date = d.getDate();
                            var curr_month = d.getMonth() + 1; //Months are zero based
                            var curr_year = d.getFullYear();
                            var rcn1 = curr_date + "/" + curr_month + "/" + curr_year;
                        }else{
                            var rcn1 =  new String("-");
                        }
                        if(data['202006X97X2860'] != null){
                            var pic1 = data['202006X97X2860'];
                        }else{
                            var pic1 = new String("-");
                        }
						if(data['202006X97X2736'] != null){//File
							$( "#soal1" ).html( //ID Soal
								"<tr><td colspan='5' class='text-center'><b>PROCEDURE</b></td></tr><tr><td ><b>1. </b></td><td>"+
								jawaban
								+"</td><td ><a href='<?= base_url(); ?>files/"+obj.filename+"' target='_blank' class='btn btn-sm btn-success'><i class='fa fa-download'></i> "+obj.name+"</a></td><td>"+rcn1+"</td><td>"+pic1+"</td></tr>"
							);
						}else{
							$( "#soal1" ).html( 						//Soal Berapa
								"<tr><td colspan='5' class='text-center'><b>PROCEDURE</b></td></tr><tr><td ><b>1. </b></td><td>"+
								jawaban
								+"</td><td>"+data['202006X97X2737']+"</td><td>"+rcn1+"</td><td>"+pic1+"</td></tr>"
							);														//Teks
						}
					}
					//------ End Soal 1 ----------

					//------ Soal 2 -----------
					if(data['202006X98X2738'] != null){//Soal Berapa
						var txt = data['202006X98X2740'];//File
						if(txt == null){
							var tks = new String('{ "name":"","filename":"" }');
						}else{
							var tks = txt.replace("[",'').replace("]",'');
						}
						var obj = JSON.parse(tks);
						if(data['202006X98X2738'] == 3){
							var jawaban = new String("Prosedur tanggap darurat medis tersedia dan sesuai dengan tingkat risiko serta sesuai dengan regulasi");
						}else if(data['202006X98X2738'] == 2){
							var jawaban = new String("Prosedur tanggap darurat medis tersedia, sesuai dengan regulasi minimal");
						}else if(data['202006X98X2738'] == 1){
							var jawaban = new String("Prosedur tanggap darurat medis tersedia namun belum mengacu pada ketentuan regulasi");
						}else{
							var jawaban = new String("Prosedur tanggap darurat medis belum tersedia");
						}
						if(data['202006X98X2889'] != null){
                            var d = new Date(data['202006X98X2889']);
                            var curr_date = d.getDate();
                            var curr_month = d.getMonth() + 1; //Months are zero based
                            var curr_year = d.getFullYear();
                            var rcn2 = curr_date + "/" + curr_month + "/" + curr_year;
                        }else{
                            var rcn2 =  new String("-");
                        }
                        if(data['202006X98X2862'] != null){
                            var pic2 = data['202006X98X2862'];
                        }else{
                            var pic2 = new String("-");
                        }
						if(data['202006X98X2740'] != null){//File
							$( "#soal2" ).html( //ID Soal
								"<tr><td ><b>2. </b></td><td>"+
								jawaban
								+"</td><td ><a href='<?= base_url(); ?>files/"+obj.filename+"' target='_blank' class='btn btn-sm btn-success'><i class='fa fa-download'></i> "+obj.name+"</a></td><td>"+rcn2+"</td><td>"+pic2+"</td></tr>"
							);
						}else{
							$( "#soal2" ).html( 						//Soal Berapa
								"<tr><td ><b>2. </b></td><td>"+
								jawaban
								+"</td><td>"+data['202006X98X2741']+"</td><td>"+rcn2+"</td><td>"+pic2+"</td></tr>"
							);							//Teks
						}
					}
					//------ End Soal 2 ----------

					//------ Soal 3 -----------
					if(data['202006X99X2742'] != null){//Soal Berapa
						var txt = data['202006X99X2744'];//File
						if(txt == null){
							var tks = new String('{ "name":"","filename":"" }');
						}else{
							var tks = txt.replace("[",'').replace("]",'');
						}
						var obj = JSON.parse(tks);
						if(data['202006X99X2742'] == 1){
							var jawaban = new String("Tersedia rencana tanggap darurat medis yang terintegrasi ke dalam prosedur tanggap darurat (Emergency Respon/ERP)");
						}else{
							var jawaban = new String("Belum tersedia manajemen tanggap darurat medis yang terintegrasi ke dalam prosedur tanggap darurat (Emergency Respon/ERP)");
						}
						//RENCANA DISINI
						if(data['202006X99X2890'] != null){
                            var d = new Date(data['202006X99X2890']);
                            var curr_date = d.getDate();
                            var curr_month = d.getMonth() + 1; //Months are zero based
                            var curr_year = d.getFullYear();
                            var rcn3 = curr_date + "/" + curr_month + "/" + curr_year;
                        }else{
                            var rcn3 =  new String("-");
                        }
                        //PIC DISINI
                        if(data['202006X99X2863'] != null){
                            var pic3 = data['202006X99X2863'];
                        }else{
                            var pic3 = new String("-");
                        }
						if(data['202006X99X2744'] != null){//File
							$( "#soal3" ).html( //ID Soal
								"<tr><td ><b>3. </b></td><td>"+
								jawaban
								+"</td><td ><a href='<?= base_url(); ?>files/"+obj.filename+"' target='_blank' class='btn btn-sm btn-success'><i class='fa fa-download'></i> "+obj.name+"</a></td><td>"+rcn3+"</td><td>"+pic3+"</td></tr>"
							);
						}else{
							$( "#soal3" ).html( 						//Soal Berapa
								"<tr><td ><b>3. </b></td><td>"+
								jawaban
								+"</td><td>"+data['202006X99X2743']+"</td><td>"+rcn3+"</td><td>"+pic3+"</td></tr>"
							);							//Teks
						}
					}else{
						$( "#soal3" ).html(
							"<tr><td ><b>3. </b></td><td>"+
							"Distribusi AED dan kotak P3K belum sesuai dengan risiko di tempat kerja"
							+"</td><td> - </td><td> - </td><td> - </td></tr>"
						);	
					}
					//------ End Soal 3 ----------

					//------ Soal 4 -----------
					if(data['202006X100X2745'] != null){//Soal Berapa
						var txt = data['202006X100X2747'];//File
						if(txt == null){
							var tks = new String('{ "name":"","filename":"" }');
						}else{
							var tks = txt.replace("[",'').replace("]",'');
						}
						var obj = JSON.parse(tks);
						if(data['202006X100X2745'] == 3){
							var jawaban = new String("Terdapat rencana tanggap darurat medis (MERP) yang telah disosialisasikan kepada seluruh stakeholder menggunakan media yg ada dan dilakukan pemantauan efektivitasnya");
						}else if(data['202006X100X2745'] == 2){
							var jawaban = new String("Terdapat rencana tanggap darurat medis (MERP) yang telah disosialisasikan kepada stakeholder menggunakan media yg ada namun belum dilakukan pemantauan efektivitasnya");
						}else if(data['202006X100X2745'] == 1){
							var jawaban = new String("Terdapat rencana tanggap darurat medis (MERP) yang telah disosialisasikan kepada  50% stakeholder");
						}else{
							var jawaban = new String("Terdapat rencana tanggap darurat medis (MERP) yang namun belum dikomunikasikan kepada seluruh stakeholder");
						}
						//RENCANA DISINI
						if(data['202006X100X2891'] != null){
                            var d = new Date(data['202006X100X2891']);
                            var curr_date = d.getDate();
                            var curr_month = d.getMonth() + 1; //Months are zero based
                            var curr_year = d.getFullYear();
                            var rcn4 = curr_date + "/" + curr_month + "/" + curr_year;
                        }else{
                            var rcn4 =  new String("-");
                        }
                        //PIC DISINI
                        if(data['202006X100X2865'] != null){
                            var pic4 = data['202006X100X2865'];
                        }else{
                            var pic4 = new String("-");
                        }
						if(data['202006X100X2747'] != null){//File
							$( "#soal4" ).html( //ID Soal
								"<tr><td ><b>4. </b></td><td>"+
								jawaban
								+"</td><td ><a href='<?= base_url(); ?>files/"+obj.filename+"' target='_blank' class='btn btn-sm btn-success'><i class='fa fa-download'></i> "+obj.name+"</a></td><td>"+rcn4+"</td><td>"+pic4+"</td></tr>"
							);
						}else{
							$( "#soal4" ).html( 						//Soal Berapa
								"<tr><td ><b>4. </b></td><td>"+
								jawaban
								+"</td><td>"+data['202006X100X2746']+"</td><td>"+rcn4+"</td><td>"+pic4+"</td></tr>"
							);							//Teks
						}
					}else{
						$( "#soal4" ).html(
							"<tr><td ><b>4. </b></td><td>"+
							"Terdapat rencana tanggap darurat medis (MERP) yang namun belum dikomunikasikan kepada seluruh stakeholder"
							+"</td><td> - </td><td> - </td><td> - </td></tr>"
						);	
					}
					//------ End Soal 4 ----------

					//------ Soal 5 -----------
					if(data['202006X101X2748'] != null){//Soal Berapa
						var txt = data['202006X101X2750'];//File
						if(txt == null){
							var tks = new String('{ "name":"","filename":"" }');
						}else{
							var tks = txt.replace("[",'').replace("]",'');
						}
						var obj = JSON.parse(tks);
						if(data['202006X101X2748'] == 4){
							var jawaban = new String("Simulasi tanggap darurat medis (MERP) telah dilakukan sesuai dengan jumlah skenario");
						}else if(data['202006X101X2748'] == 3){
							var jawaban = new String("Simulasi tanggap darurat medis (MERP) telah dilakukan 50-75% dari  jumlah skenario");
						}else if(data['202006X101X2748'] == 2){
							var jawaban = new String("Simulasi tanggap darurat medis (MERP) telah dilakukan >25-50% dari  jumlah skenario");
						}else if(data['202006X101X2748'] == 1){
							var jawaban = new String("Simulasi tanggap darurat medis (MERP) telah dilakukan >0-25% dari  jumlah skenario");
						}else{
							var jawaban = new String("Simulasi tanggap darurat medis (MERP)  tidak dilakukan");
						}
						//RENCANA DISINI
						if(data['202006X101X2892'] != null){
                            var d = new Date(data['202006X101X2892']);
                            var curr_date = d.getDate();
                            var curr_month = d.getMonth() + 1; //Months are zero based
                            var curr_year = d.getFullYear();
                            var rcn5 = curr_date + "/" + curr_month + "/" + curr_year;
                        }else{
                            var rcn5 =  new String("-");
                        }
                        //PIC DISINI
                        if(data['202006X101X2866'] != null){
                            var pic5 = data['202006X101X2866'];
                        }else{
                            var pic5 = new String("-");
                        }
                        //<td>"+rcn5+"</td><td>"+pic5+"</td>
						if(data['202006X101X2750'] != null){//File
							$( "#soal5" ).html( //ID Soal
								"<tr><td ><b>5. </b></td><td>"+
								jawaban
								+"</td><td ><a href='<?= base_url(); ?>files/"+obj.filename+"' target='_blank' class='btn btn-sm btn-success'><i class='fa fa-download'></i> "+obj.name+"</a></td><td>"+rcn5+"</td><td>"+pic5+"</td></tr>"
							);
						}else{
							$( "#soal5" ).html( 						//Soal Berapa
								"<tr><td ><b>5. </b></td><td>"+
								jawaban
								+"</td><td>"+data['202006X101X2749']+"</td><td>"+rcn5+"</td><td>"+pic5+"</td></tr>"
							);							//Teks
						}
					}else{
						var txt = data['202006X123X2847'];//File
						if(txt == null){
							var tks = new String('{ "name":"","filename":"" }');
						}else{
							var tks = txt.replace("[",'').replace("]",'');
						}
						var obj = JSON.parse(tks);
						if(data['202006X101X2748'] == 4){
							var jawaban = new String("Simulasi tanggap darurat medis (MERP) telah dilakukan sesuai dengan jumlah skenario");
						}else if(data['202006X101X2748'] == 3){
							var jawaban = new String("Simulasi tanggap darurat medis (MERP) telah dilakukan 50-75% dari  jumlah skenario");
						}else if(data['202006X101X2748'] == 2){
							var jawaban = new String("Simulasi tanggap darurat medis (MERP) telah dilakukan >25-50% dari  jumlah skenario");
						}else if(data['202006X101X2748'] == 1){
							var jawaban = new String("Simulasi tanggap darurat medis (MERP) telah dilakukan >0-25% dari  jumlah skenario");
						}else{
							var jawaban = new String("Simulasi tanggap darurat medis (MERP)  tidak dilakukan");
						}
						//RENCANA DISINI
						if(data['202006X123X2893'] != null){
                            var d = new Date(data['202006X123X2893']);
                            var curr_date = d.getDate();
                            var curr_month = d.getMonth() + 1; //Months are zero based
                            var curr_year = d.getFullYear();
                            var rcn5 = curr_date + "/" + curr_month + "/" + curr_year;
                        }else{
                            var rcn5 =  new String("-");
                        }
                        //PIC DISINI
                        if(data['202006X123X2867'] != null){
                            var pic5 = data['202006X123X2867'];
                        }else{
                            var pic5 = new String("-");
                        }
                        //<td>"+rcn5+"</td><td>"+pic5+"</td>
						if(data['202006X123X2847'] != null){//File
							$( "#soal5" ).html( //ID Soal
								"<tr><td ><b>5. </b></td><td>"+
								jawaban
								+"</td><td ><a href='<?= base_url(); ?>files/"+obj.filename+"' target='_blank' class='btn btn-sm btn-success'><i class='fa fa-download'></i> "+obj.name+"</a></td><td>"+rcn5+"</td><td>"+pic5+"</td></tr>"
							);
						}else{
							$( "#soal5" ).html( 						//Soal Berapa
								"<tr><td ><b>5. </b></td><td>"+
								jawaban
								+"</td><td>"+data['202006X123X2846']+"</td><td>"+rcn5+"</td><td>"+pic5+"</td></tr>"
							);							//Teks
						}
					}
					//------ End Soal 5 ----------

					//------ Soal 6 -----------
					if(data['202006X102X2751'] != null){//Soal Berapa
						var txt = data['202006X102X2753'];//File
						if(txt == null){
							var tks = new String('{ "name":"","filename":"" }');
						}else{
							var tks = txt.replace("[",'').replace("]",'');
						}
						var obj = JSON.parse(tks);
						if(data['202006X102X2751'] == 4){
							var jawaban = new String("Simulasi tanggap darurat medis (MERP) telah dilakukan sesuai dengan jumlah skenario");
						}else if(data['202006X102X2751'] == 3){
							var jawaban = new String("Simulasi tanggap darurat medis (MERP) telah dilakukan 50-75% dari  jumlah skenario");
						}else if(data['202006X102X2751'] == 2){
							var jawaban = new String("Simulasi tanggap darurat medis (MERP) telah dilakukan >25-50% dari  jumlah skenario");
						}else if(data['202006X102X2751'] == 1){
							var jawaban = new String("Simulasi tanggap darurat medis (MERP) telah dilakukan >0-25% dari  jumlah skenario");
						}else{
							var jawaban = new String("Simulasi tanggap darurat medis (MERP)  tidak dilakukan");
						}
						//RENCANA DISINI
						if(data['202006X102X2894'] != null){
                            var d = new Date(data['202006X102X2894']);
                            var curr_date = d.getDate();
                            var curr_month = d.getMonth() + 1; //Months are zero based
                            var curr_year = d.getFullYear();
                            var rcn6 = curr_date + "/" + curr_month + "/" + curr_year;
                        }else{
                            var rcn6 =  new String("-");
                        }
                        //PIC DISINI
                        if(data['202006X102X2868'] != null){
                            var pic6 = data['202006X102X2868'];
                        }else{
                            var pic6 = new String("-");
                        }
                        //<td>"+rcn6+"</td><td>"+pic6+"</td>
						if(data['202006X102X2753'] != null){//File
							$( "#soal6" ).html( //ID Soal
								"<tr><td ><b>6. </b></td><td>"+
								jawaban
								+"</td><td ><a href='<?= base_url(); ?>files/"+obj.filename+"' target='_blank' class='btn btn-sm btn-success'><i class='fa fa-download'></i> "+obj.name+"</a></td><td>"+rcn6+"</td><td>"+pic6+"</td></tr>"
							);
						}else{
							$( "#soal6" ).html( 						//Soal Berapa
								"<tr><td ><b>6. </b></td><td>"+
								jawaban
								+"</td><td>"+data['202006X102X2752']+"</td><td>"+rcn6+"</td><td>"+pic6+"</td></tr>"
							);							//Teks
						}
					}
					//------ End Soal 6 ----------

					//------ Soal 7 -----------
					if(data['202006X103X2754'] != null){//Soal Berapa
						var txt = data['202006X103X2756'];//File
						if(txt == null){
							var tks = new String('{ "name":"","filename":"" }');
						}else{
							var tks = txt.replace("[",'').replace("]",'');
						}
						var obj = JSON.parse(tks);
						if(data['202006X103X2754'] == 2){
							var jawaban = new String("Seluruh waktu respon yang diperlukan telah ditetapkan baik untuk MERP1, MERP2 dan MERP3");
						}else if(data['202006X103X2754'] == 1){
							var jawaban = new String("Belum seluruh waktu respon yang diperlukan telah ditetapkan baik untuk MERP1, MERP2 dan MERP3");
						}else{
							var jawaban = new String("Waktu respon yang diperlukan tidak ditetapkan baik untuk MERP1, MERP2 dan MERP3");
						}
						//RENCANA DISINI
						if(data['202006X103X2895'] != null){
                            var d = new Date(data['202006X103X2895']);
                            var curr_date = d.getDate();
                            var curr_month = d.getMonth() + 1; //Months are zero based
                            var curr_year = d.getFullYear();
                            var rcn7 = curr_date + "/" + curr_month + "/" + curr_year;
                        }else{
                            var rcn7 =  new String("-");
                        }
                        //PIC DISINI
                        if(data['202006X103X2869'] != null){
                            var pic7 = data['202006X103X2869'];
                        }else{
                            var pic7 = new String("-");
                        }
                        //<td>"+rcn7+"</td><td>"+pic7+"</td>
						if(data['202006X103X2756'] != null){//File
							$( "#soal7" ).html( //ID Soal
								"<tr><td ><b>7. </b></td><td>"+
								jawaban
								+"</td><td ><a href='<?= base_url(); ?>files/"+obj.filename+"' target='_blank' class='btn btn-sm btn-success'><i class='fa fa-download'></i> "+obj.name+"</a></td><td>"+rcn7+"</td><td>"+pic7+"</td></tr>"
							);
						}else{
							$( "#soal7" ).html( //ID Soal
								"<tr><td ><b>7. </b></td><td>"+
								jawaban
								+"</td><td>"+data['202006X103X2755']+"</td><td>"+rcn7+"</td><td>"+pic7+"</td></tr>"
							);							//Teks
						}
					}
					//------ End Soal 7 ----------

					//------ Soal 8 -----------
					if(data['202006X104X2757'] != null){//Soal Berapa
						var txt = data['202006X104X2759'];//File
						if(txt == null){
							var tks = new String('{ "name":"","filename":"" }');
						}else{
							var tks = txt.replace("[",'').replace("]",'');
						}
						var obj = JSON.parse(tks);
						if(data['202006X104X2757'] == 2){
							var jawaban = new String("Prosedur telah menilai seluruh kecukupan klinik yang meliputi tenaga medis dan paramedis yang kompeten, obat-obatan emergensi, tandu, AED dan ketersediaan ambulan");
						}else if(data['202006X104X2757'] == 1){
							var jawaban = new String("Prosedur telah menilai sebagian kecukupan klinik yang meliputi tenaga medis dan paramedis yang kompeten, obat-obatan emergensi, tandu, AED dan ketersediaan ambulan");
						}else{
							var jawaban = new String("Tidak terdapat prosedur");
						}
						//RENCANA DISINI
						if(data['202006X104X2896'] != null){
                            var d = new Date(data['202006X104X2896']);
                            var curr_date = d.getDate();
                            var curr_month = d.getMonth() + 1; //Months are zero based
                            var curr_year = d.getFullYear();
                            var rcn8 = curr_date + "/" + curr_month + "/" + curr_year;
                        }else{
                            var rcn8 =  new String("-");
                        }
                        //PIC DISINI
                        if(data['202006X104X2870'] != null){
                            var pic8 = data['202006X104X2870'];
                        }else{
                            var pic8 = new String("-");
                        }
                        //<td>"+rcn8+"</td><td>"+pic8+"</td>
						if(data['202006X104X2759'] != null){//File
							$( "#soal8" ).html( //ID Soal
								"<tr><td ><b>8. </b></td><td>"+
								jawaban
								+"</td><td ><a href='<?= base_url(); ?>files/"+obj.filename+"' target='_blank' class='btn btn-sm btn-success'><i class='fa fa-download'></i> "+obj.name+"</a></td><td>"+rcn8+"</td><td>"+pic8+"</td></tr>"
							);
						}else{
							$( "#soal8" ).html( //ID Soal
								"<tr><td ><b>8. </b></td><td>"+
								jawaban
								+"</td><td>"+data['202006X104X2758']+"</td><td>"+rcn8+"</td><td>"+pic8+"</td></tr>"
							);							//Teks
						}
					}
					//------ End Soal 8 ----------

					//------ Soal 9 -----------
					if(data['202006X105X2760'] != null){//Soal Berapa
						var txt = data['202006X105X2762'];//File
						if(txt == null){
							var tks = new String('{ "name":"","filename":"" }');
						}else{
							var tks = txt.replace("[",'').replace("]",'');
						}
						var obj = JSON.parse(tks);
						if(data['202006X105X2760'] == 2){
							var jawaban = new String("Nomor kontak darurat terdapat pada lokasi yang mudah diakses, seperti area public, kendaraan perusahaan, ataupun dokumen hse pass");
						}else if(data['202006X105X2760'] == 1){
							var jawaban = new String("Nomor kontak darurat tidak terdapat pada lokasi yang mudah diakses, seperti area public, kendaraan perusahaan, ataupun dokumen hse pass");
						}else{
							var jawaban = new String("Tidak terdapat nomor kontak darurat");
						}
						//RENCANA DISINI
						if(data['202006X105X2897'] != null){
                            var d = new Date(data['202006X105X2897']);
                            var curr_date = d.getDate();
                            var curr_month = d.getMonth() + 1; //Months are zero based
                            var curr_year = d.getFullYear();
                            var rcn9 = curr_date + "/" + curr_month + "/" + curr_year;
                        }else{
                            var rcn9 =  new String("-");
                        }
                        //PIC DISINI
                        if(data['202006X105X2871'] != null){
                            var pic9 = data['202006X105X2871'];
                        }else{
                            var pic9 = new String("-");
                        }
                        //<td>"+rcn9+"</td><td>"+pic9+"</td>
						if(data['202006X105X2762'] != null){//File
							$( "#soal9" ).html( //ID Soal
								"<tr><td ><b>9. </b></td><td>"+
								jawaban
								+"</td><td ><a href='<?= base_url(); ?>files/"+obj.filename+"' target='_blank' class='btn btn-sm btn-success'><i class='fa fa-download'></i> "+obj.name+"</a></td><td>"+rcn9+"</td><td>"+pic9+"</td></tr>"
							);
						}else{
							$( "#soal9" ).html( 						//Soal Berapa
								"<tr><td ><b>9. </b></td><td>"+
								jawaban
								+"</td><td>"+data['202006X105X2761']+"</td><td>"+rcn9+"</td><td>"+pic9+"</td></tr>"
							);							//Teks
						}
					}
					//------ End Soal 9 ----------

					//------ Soal 10 -----------
					if(data['202006X106X2763'] != null){//Soal Berapa
						var txt = data['202006X106X2765'];//File
						if(txt == null){
							var tks = new String('{ "name":"","filename":"" }');
						}else{
							var tks = txt.replace("[",'').replace("]",'');
						}
						var obj = JSON.parse(tks);
						if(data['202006X106X2763'] == 1){
							var jawaban = new String("Terdapat prosedur pelatihan Pertolongan Pertama Pada Kecelakaan/P3K dengan pelatihan dilaksanakan secara berkala");
						}else{
							var jawaban = new String("Tidak terdapat prosedur pelatihan Pertolongan Pertama Pada Kecelakaan/P3K dengan pelatihan dilaksanakan secara berkalamemenuhi standar");
						}
						//RENCANA DISINI
						if(data['202006X106X2898'] != null){
                            var d = new Date(data['202006X106X2898']);
                            var curr_date = d.getDate();
                            var curr_month = d.getMonth() + 1; //Months are zero based
                            var curr_year = d.getFullYear();
                            var rcn10 = curr_date + "/" + curr_month + "/" + curr_year;
                        }else{
                            var rcn10 =  new String("-");
                        }
                        //PIC DISINI
                        if(data['202006X106X2872'] != null){
                            var pic10 = data['202006X106X2872'];
                        }else{
                            var pic10 = new String("-");
                        }
                        //<td>"+rcn10+"</td><td>"+pic10+"</td>
						if(data['202006X106X2765'] != null){//File
							$( "#soal10" ).html( //ID Soal
								"<tr><td ><b>10. </b></td><td>"+
								jawaban
								+"</td><td ><a href='<?= base_url(); ?>files/"+obj.filename+"' target='_blank' class='btn btn-sm btn-success'><i class='fa fa-download'></i> "+obj.name+"</a></td><td>"+rcn10+"</td><td>"+pic10+"</td></tr>"
							);
						}else{
							$( "#soal10" ).html( 						//Soal Berapa
								"<tr><td ><b>10. </b></td><td>"+
								jawaban
								+"</td><td>"+data['202006X106X2764']+"</td><td>"+rcn10+"</td><td>"+pic10+"</td></tr>"
							);							//Teks
						}
					}
					//------ End Soal 10 ----------
					
					//------ Soal 11 -----------
					if(data['202006X107X2766'] != null){//Soal Berapa
						var txt = data['202006X107X2768'];//File
						if(txt == null){
							var tks = new String('{ "name":"","filename":"" }');
						}else{
							var tks = txt.replace("[",'').replace("]",'');
						}
						var obj = JSON.parse(tks);
						if(data['202006X107X2766'] == 1){
							var jawaban = new String("Terdapat prosedur untuk memastikan klinik, sarana, ambulan, isi dari kotak P3K tersebut telah sesuai dengan standar yang berlaku dan terpelihara dengan baik");
						}else{
							var jawaban = new String("Tidak terdapat prosedur untuk memastikan klinik, sarana, ambulan, isi dari kotak P3K tersebut telah sesuai dengan standar yang berlaku dan terpelihara dengan baik");
						}
						//RENCANA DISINI
						if(data['202006X107X2899'] != null){
                            var d = new Date(data['202006X107X2899']);
                            var curr_date = d.getDate();
                            var curr_month = d.getMonth() + 1; //Months are zero based
                            var curr_year = d.getFullYear();
                            var rcn11 = curr_date + "/" + curr_month + "/" + curr_year;
                        }else{
                            var rcn11 =  new String("-");
                        }
                        //PIC DISINI
                        if(data['202006X107X2873'] != null){
                            var pic11 = data['202006X107X2873'];
                        }else{
                            var pic11 = new String("-");
                        }
                        //<td>"+rcn11+"</td><td>"+pic11+"</td>
						if(data['202006X107X2768'] != null){//File
							$( "#soal11" ).html( //ID Soal
								"<tr><td ><b>11. </b></td><td>"+
								jawaban
								+"</td><td ><a href='<?= base_url(); ?>files/"+obj.filename+"' target='_blank' class='btn btn-sm btn-success'><i class='fa fa-download'></i> "+obj.name+"</a></td><td>"+rcn11+"</td><td>"+pic11+"</td></tr>"
							);
						}else{
							$( "#soal11" ).html( 						//Soal Berapa
								"<tr><td ><b>11. </b></td><td>"+
								jawaban
								+"</td><td>"+data['202006X107X2767']+"</td><td>"+rcn11+"</td><td>"+pic11+"</td></tr>"
							);							//Teks
						}
					}
					//------ End Soal 11 ----------

					//------ Soal 12 -----------
					if(data['202006X108X2769'] != null){//Soal Berapa
						var txt = data['202006X108X2771'];//File
						if(txt == null){
							var tks = new String('{ "name":"","filename":"" }');
						}else{
							var tks = txt.replace("[",'').replace("]",'');
						}
						var obj = JSON.parse(tks);
						if(data['202006X108X2769'] == 1){
							var jawaban = new String("Terdapat prosedur untuk memastikan sarana dan peralatan tanggap darurat medis diperiksa dan dipelihara secara berkala");
						}else{
							var jawaban = new String("Tidak tterdapat prosedur untuk memastikan sarana dan peralatan tanggap darurat medis diperiksa dan dipelihara secara berkala");
						}
						//RENCANA DISINI
						if(data['202006X108X2900'] != null){
                            var d = new Date(data['202006X108X2900']);
                            var curr_date = d.getDate();
                            var curr_month = d.getMonth() + 1; //Months are zero based
                            var curr_year = d.getFullYear();
                            var rcn12 = curr_date + "/" + curr_month + "/" + curr_year;
                        }else{
                            var rcn12 =  new String("-");
                        }
                        //PIC DISINI
                        if(data['202006X108X2874'] != null){
                            var pic12 = data['202006X108X2874'];
                        }else{
                            var pic12 = new String("-");
                        }
                        //<td>"+rcn12+"</td><td>"+pic12+"</td>
						if(data['202006X108X2771'] != null){//File
							$( "#soal12" ).html( 						//Soal Berapa
								"<tr><td ><b>11a. </b></td><td>"+
								jawaban
								+"</td><td ><a href='<?= base_url(); ?>files/"+obj.filename+"' target='_blank' class='btn btn-sm btn-success'><i class='fa fa-download'></i> "+obj.name+"</a></td><td>"+rcn12+"</td><td>"+pic12+"</td></tr>"
							);
						}else{
							$( "#soal12" ).html( 						//Soal Berapa
								"<tr><td ><b>11a. </b></td><td>"+
								jawaban
								+"</td><td>"+data['202006X108X2770']+"</td><td>"+rcn12+"</td><td>"+pic12+"</td></tr>"
							);							//Teks
						}
					}else{
						$( "#soal12" ).html(
							"<tr><td ><b>11a. </b></td><td>"+
							"Tidak tterdapat prosedur untuk memastikan sarana dan peralatan tanggap darurat medis diperiksa dan dipelihara secara berkala"
							+"</td><td> - </td><td> - </td><td> - </td></tr>"
						);	
					}
					//------ End Soal 12 ----------

					//------ Soal 13 -----------
					if(data['202006X109X2772'] != null){//Soal Berapa
						var txt = data['202006X109X2774'];//File
						if(txt == null){
							var tks = new String('{ "name":"","filename":"" }');
						}else{
							var tks = txt.replace("[",'').replace("]",'');
						}
						var obj = JSON.parse(tks);
						if(data['202006X109X2772'] == 1){
							var jawaban = new String("Terdapat prosedur untuk meminta bantuan organisasi eksternal dalam menangani keadaan daruratjika memenuhi standar");
						}else{
							var jawaban = new String("Tidak terdapat prosedur untuk meminta bantuan organisasi eksternal dalam menangani keadaan darurat");
						}
						//RENCANA DISINI
						if(data['202006X109X2901'] != null){
                            var d = new Date(data['202006X109X2901']);
                            var curr_date = d.getDate();
                            var curr_month = d.getMonth() + 1; //Months are zero based
                            var curr_year = d.getFullYear();
                            var rcn13 = curr_date + "/" + curr_month + "/" + curr_year;
                        }else{
                            var rcn13 =  new String("-");
                        }
                        //PIC DISINI
                        if(data['202006X109X2875'] != null){
                            var pic13 = data['202006X109X2875'];
                        }else{
                            var pic13 = new String("-");
                        }
                        //<td>"+rcn13+"</td><td>"+pic13+"</td>
						if(data['202006X109X2774'] != null){//File
							$( "#soal13" ).html( 						//Soal Berapa
								"<tr><td ><b>13. </b></td><td>"+
								jawaban
								+"</td><td ><a href='<?= base_url(); ?>files/"+obj.filename+"' target='_blank' class='btn btn-sm btn-success'><i class='fa fa-download'></i> "+obj.name+"</a></td><td>"+rcn13+"</td><td>"+pic13+"</td></tr>"
							);
						}else{
							$( "#soal13" ).html( 						//Soal Berapa
								"<tr><td ><b>13. </b></td><td>"+
								jawaban
								+"</td><td>"+data['202006X109X2773']+"</td><td>"+rcn13+"</td><td>"+pic13+"</td></tr>"
							);							//Teks
						}
					}else{
						var txt = data['202006X109X2774'];//File
						if(txt == null){
							var tks = new String('{ "name":"","filename":"" }');
						}else{
							var tks = txt.replace("[",'').replace("]",'');
						}
						var obj = JSON.parse(tks);
						if(data['202006X109X2849'] == 1){
							var jawaban = new String("Terdapat prosedur untuk meminta bantuan organisasi eksternal dalam menangani keadaan daruratjika memenuhi standar");
						}else{
							var jawaban = new String("Tidak terdapat prosedur untuk meminta bantuan organisasi eksternal dalam menangani keadaan darurat");
						}
						//RENCANA DISINI
						if(data['202006X109X2901'] != null){
                            var d = new Date(data['202006X109X2901']);
                            var curr_date = d.getDate();
                            var curr_month = d.getMonth() + 1; //Months are zero based
                            var curr_year = d.getFullYear();
                            var rcn13 = curr_date + "/" + curr_month + "/" + curr_year;
                        }else{
                            var rcn13 =  new String("-");
                        }
                        //PIC DISINI
                        if(data['202006X109X2875'] != null){
                            var pic13 = data['202006X109X2875'];
                        }else{
                            var pic13 = new String("-");
                        }
                        //<td>"+rcn13+"</td><td>"+pic13+"</td>
						if(data['202006X109X2774'] != null){//File
							$( "#soal13" ).html( 						//Soal Berapa
								"<tr><td ><b>13. </b></td><td>"+
								jawaban
								+"</td><td ><a href='<?= base_url(); ?>files/"+obj.filename+"' target='_blank' class='btn btn-sm btn-success'><i class='fa fa-download'></i> "+obj.name+"</a></td><td>"+rcn13+"</td><td>"+pic13+"</td></tr>"
							);
						}else{
							$( "#soal13" ).html( 						//Soal Berapa
								"<tr><td ><b>13. </b></td><td>"+
								jawaban
								+"</td><td>"+data['202006X109X2773']+"</td><td>"+rcn13+"</td><td>"+pic13+"</td></tr>"
							);							//Teks
						}
					}
					//------ End Soal 13 ----------

					//------ Soal 14 -----------
					if(data['202006X110X2775'] != null){//Soal Berapa
						var txt = data['202006X110X2777'];//File
						if(txt == null){
							var tks = new String('{ "name":"","filename":"" }');
						}else{
							var tks = txt.replace("[",'').replace("]",'');
						}
						var obj = JSON.parse(tks);
						if(data['202006X110X2775'] == 1){
							var jawaban = new String("Terdapat perjanjian kerjasama dengan organisasi lain/eksternal untuk memberikan bantuan personil dan peralatan jika terjadi keadaan darurat");
						}else{
							var jawaban = new String("Tidak terdapat perjanjian kerjasama dengan organisasi lain/eksternal untuk memberikan bantuan personil dan peralatan jika terjadi keadaan darurat");
						}
						//RENCANA DISINI
						if(data['202006X110X2902'] != null){
                            var d = new Date(data['202006X110X2902']);
                            var curr_date = d.getDate();
                            var curr_month = d.getMonth() + 1; //Months are zero based
                            var curr_year = d.getFullYear();
                            var rcn14 = curr_date + "/" + curr_month + "/" + curr_year;
                        }else{
                            var rcn14 =  new String("-");
                        }
                        //PIC DISINI
                        if(data['202006X110X2876'] != null){
                            var pic14 = data['202006X110X2876'];
                        }else{
                            var pic14 = new String("-");
                        }
                        //<td>"+rcn14+"</td><td>"+pic14+"</td>
						if(data['202006X110X2777'] != null){//File
							$( "#soal14" ).html( 						//Soal Berapa
								"<tr><td ><b>14. </b></td><td>"+
								jawaban
								+"</td><td ><a href='<?= base_url(); ?>files/"+obj.filename+"' target='_blank' class='btn btn-sm btn-success'><i class='fa fa-download'></i> "+obj.name+"</a></td><td>"+rcn14+"</td><td>"+pic14+"</td></tr>"
							);
						}else{
							$( "#soal14" ).html( 						//Soal Berapa
								"<tr><td ><b>14. </b></td><td>"+
								jawaban
								+"</td><td>"+data['202006X110X2776']+"</td><td>"+rcn14+"</td><td>"+pic14+"</td></tr>"
							);							//Teks
						}
					}
					//------ End Soal 14 ----------

					//------ Soal 15 -----------
					if(data['202006X111X2778'] != null){//Soal Berapa
						var txt = data['202006X111X2780'];//File
						if(txt == null){
							var tks = new String('{ "name":"","filename":"" }');
						}else{
							var tks = txt.replace("[",'').replace("]",'');
						}
						var obj = JSON.parse(tks);
						if(data['202006X111X2778'] == 4){
							var jawaban = new String("Simulasi/drill  MERP dilakukan sesuai dengan jumlah skenario");
						}else if(data['202006X111X2778'] == 3){
							var jawaban = new String("Simulasi/dril  MERP dilakukan 75% dari  jumlah skenario");
						}else if(data['202006X111X2778'] == 2){
							var jawaban = new String("Simulasi/drill MERP telah dilakukan >25-50% dari  jumlah skenario");
						}else if(data['202006X111X2778'] == 1){
							var jawaban = new String("Simulasi/drill MERP telah dilakukan >0-25% dari jumlah skenario");
						}else{
							var jawaban = new String("Simulasi/drill MERP tidak dilakukan");
						}
						//RENCANA DISINI
						if(data['202006X111X2903'] != null){
                            var d = new Date(data['202006X111X2903']);
                            var curr_date = d.getDate();
                            var curr_month = d.getMonth() + 1; //Months are zero based
                            var curr_year = d.getFullYear();
                            var rcn15 = curr_date + "/" + curr_month + "/" + curr_year;
                        }else{
                            var rcn15 =  new String("-");
                        }
                        //PIC DISINI
                        if(data['202006X111X2877'] != null){
                            var pic15 = data['202006X111X2877'];
                        }else{
                            var pic15 = new String("-");
                        }
                        //<td>"+rcn15+"</td><td>"+pic15+"</td>
						if(data['202006X111X2780'] != null){//File
							$( "#soal15" ).html( 						//Soal Berapa
								"<tr><td ><b>15. </b></td><td>"+
								jawaban
								+"</td><td ><a href='<?= base_url(); ?>files/"+obj.filename+"' target='_blank' class='btn btn-sm btn-success'><i class='fa fa-download'></i> "+obj.name+"</a></td><td>"+rcn15+"</td><td>"+pic15+"</td></tr>"
							);
						}else{
							$( "#soal15" ).html( 						//Soal Berapa
								"<tr><td ><b>15. </b></td><td>"+
								jawaban
								+"</td><td>"+data['202006X111X2779']+"</td><td>"+rcn15+"</td><td>"+pic15+"</td></tr>"
							);							//Teks
						}
					}else{
						$( "#soal15" ).html(
							"<tr><td ><b>15. </b></td><td>"+
							"Simulasi/drill MERP tidak dilakukan"
							+"</td><td> - </td><td> - </td><td> - </td></tr>"
						);	
					}
					//------ End Soal 15 ----------

					//------ Soal 16 -----------
					if(data['202006X112X2781'] != null){//Soal Berapa
						var txt = data['202006X112X2783'];//File
						if(txt == null){
							var tks = new String('{ "name":"","filename":"" }');
						}else{
							var tks = txt.replace("[",'').replace("]",'');
						}
						var obj = JSON.parse(tks);
						if(data['202006X112X2781'] == 3){//Jawabannya Apa?
							var jawaban = new String("Terdapat First Aider (FA) tersertifikasi untuk memenuhi waktu respon yg tekah ditentukan");
						}else if(data['202006X112X2781'] == 2){
							var jawaban = new String("Terdapat First Aider (FA) tersertifikasi namun belum dapat memenuhi waktu respon yg telah ditentukan");
						}else if(data['202006X112X2781'] == 1){
							var jawaban = new String("Tidak terdapat First Aider (FA) tersertifikasi, namun tersedia FA yg dilatih mandiri");
						}else{
							var jawaban = new String("Tidak terdapat First Aider (FA)");
						}
						//RENCANA DISINI
						if(data['202006X112X2904'] != null){
                            var d = new Date(data['202006X112X2904']);
                            var curr_date = d.getDate();
                            var curr_month = d.getMonth() + 1; //Months are zero based
                            var curr_year = d.getFullYear();
                            var rcn16 = curr_date + "/" + curr_month + "/" + curr_year;
                        }else{
                            var rcn16 =  new String("-");
                        }
                        //PIC DISINI
                        if(data['202006X112X2878'] != null){
                            var pic16 = data['202006X112X2878'];
                        }else{
                            var pic16 = new String("-");
                        }
                        //<td>"+rcn16+"</td><td>"+pic16+"</td>
						if(data['202006X112X2783'] != null){//File
							$( "#soal16" ).html( 						//Soal Berapa
								"<tr><td colspan='5' class='text-center'><b>PEOPLE</b></td></tr><tr><td ><b>1. </b></td><td>"+
								jawaban
								+"</td><td ><a href='<?= base_url(); ?>files/"+obj.filename+"' target='_blank' class='btn btn-sm btn-success'><i class='fa fa-download'></i> "+obj.name+"</a></td><td>"+rcn16+"</td><td>"+pic16+"</td></tr>"
							);
						}else{
							$( "#soal16" ).html( 						//Soal Berapa
								"<tr><td colspan='5' class='text-center'><b>PEOPLE</b></td></tr><tr><td ><b>1. </b></td><td>"+
								jawaban
								+"</td><td>"+data['202006X112X2782']+"</td><td>"+rcn16+"</td><td>"+pic16+"</td></tr>"
							);							//Teks
						}
					}else{
						var txt = data['202006X112X2783'];//File
						if(txt == null){
							var tks = new String('{ "name":"","filename":"" }');
						}else{
							var tks = txt.replace("[",'').replace("]",'');
						}
						var obj = JSON.parse(tks);
						if(data['202006X112X2851'] == 3){//Jawabannya Apa?
							var jawaban = new String("Terdapat First Aider (FA) tersertifikasi untuk memenuhi waktu respon yg tekah ditentukan");
						}else if(data['202006X112X2851'] == 2){
							var jawaban = new String("Terdapat First Aider (FA) tersertifikasi namun belum dapat memenuhi waktu respon yg telah ditentukan");
						}else if(data['202006X112X2851'] == 1){
							var jawaban = new String("Tidak terdapat First Aider (FA) tersertifikasi, namun tersedia FA yg dilatih mandiri");
						}else{
							var jawaban = new String("Tidak terdapat First Aider (FA)");
						}
						//RENCANA DISINI
						if(data['202006X112X2904'] != null){
                            var d = new Date(data['202006X112X2904']);
                            var curr_date = d.getDate();
                            var curr_month = d.getMonth() + 1; //Months are zero based
                            var curr_year = d.getFullYear();
                            var rcn16 = curr_date + "/" + curr_month + "/" + curr_year;
                        }else{
                            var rcn16 =  new String("-");
                        }
                        //PIC DISINI
                        if(data['202006X112X2878'] != null){
                            var pic16 = data['202006X112X2878'];
                        }else{
                            var pic16 = new String("-");
                        }
                        //<td>"+rcn16+"</td><td>"+pic16+"</td>
						if(data['202006X112X2783'] != null){//File
							$( "#soal16" ).html( 						//Soal Berapa
								"<tr><td colspan='5' class='text-center'><b>PEOPLE</b></td></tr><tr><td ><b>1. </b></td><td>"+
								jawaban
								+"</td><td ><a href='<?= base_url(); ?>files/"+obj.filename+"' target='_blank' class='btn btn-sm btn-success'><i class='fa fa-download'></i> "+obj.name+"</a></td><td>"+rcn16+"</td><td>"+pic16+"</td></tr>"
							);
						}else{
							$( "#soal16" ).html( 						//Soal Berapa
								"<tr><td colspan='5' class='text-center'><b>PEOPLE</b></td></tr><tr><td ><b>1. </b></td><td>"+
								jawaban
								+"</td><td>"+data['202006X112X2782']+"</td><td>"+rcn16+"</td><td>"+pic16+"</td></tr>"
							);							//Teks
						}
					}
					//------ End Soal 16 ----------

					//------ Soal 17 -----------
					if(data['202006X113X2784'] != null){//Soal Berapa
						var txt = data['202006X113X2786'];//File
						if(txt == null){
							var tks = new String('{ "name":"","filename":"" }');
						}else{
							var tks = txt.replace("[",'').replace("]",'');
						}
						var obj = JSON.parse(tks);
						if(data['202006X113X2784'] == 3){
							var jawaban = new String("Terdapat FA tersertifikasi untuk memenuhi waktu respon yg tekah ditentukan");
						}else if(data['202006X113X2784'] == 2){
							var jawaban = new String("Terdapat FA tersertifikasi namun belum dapat memenuhi waktu respon yg telah ditentukan");
						}else if(data['202006X113X2784'] == 1){
							var jawaban = new String("Tidak terdapat FA tersertifikasi, namun tersedia FA yg dilatih mandiri");
						}else{
							var jawaban = new String("Tidak terdapat FA");
						}
						//RENCANA DISINI
						if(data['202006X113X2905'] != null){
                            var d = new Date(data['202006X113X2905']);
                            var curr_date = d.getDate();
                            var curr_month = d.getMonth() + 1; //Months are zero based
                            var curr_year = d.getFullYear();
                            var rcn17 = curr_date + "/" + curr_month + "/" + curr_year;
                        }else{
                            var rcn17 =  new String("-");
                        }
                        //PIC DISINI
                        if(data['202006X113X2879'] != null){
                            var pic17 = data['202006X113X2879'];
                        }else{
                            var pic17 = new String("-");
                        }
                        //<td>"+rcn17+"</td><td>"+pic17+"</td>
						if(data['202006X113X2786'] != null){//File
							$( "#soal17" ).html( 						//Soal Berapa
								"<tr><td ><b>2. </b></td><td>"+
								jawaban
								+"</td><td ><a href='<?= base_url(); ?>files/"+obj.filename+"' target='_blank' class='btn btn-sm btn-success'><i class='fa fa-download'></i> "+obj.name+"</a></td><td>"+rcn17+"</td><td>"+pic17+"</td></tr>"
							);
						}else{
							$( "#soal17" ).html( 						//Soal Berapa
								"<tr><td ><b>2. </b></td><td>"+
								jawaban
								+"</td><td>"+data['202006X113X2785']+"</td><td>"+rcn17+"</td><td>"+pic17+"</td></tr>"
							);							//Teks
						}
					}
					//------ End Soal 17 ----------

					//------ Soal 18 -----------
					if(data['202006X114X2787'] != null){//Soal Berapa
						var txt = data['202006X114X2789'];//File
						if(txt == null){
							var tks = new String('{ "name":"","filename":"" }');
						}else{
							var tks = txt.replace("[",'').replace("]",'');
						}
						var obj = JSON.parse(tks);
						if(data['202006X114X2787'] == 1){
							var jawaban = new String("Terdapat dokter/paramedis untuk melakukan perawatan medis darurat");
						}else{
							var jawaban = new String("Tidak terdapat dokter dan paramedis untuk melakukan perawatan medis darurat");
						}
						//RENCANA DISINI
						if(data['202006X114X2906'] != null){
                            var d = new Date(data['202006X114X2906']);
                            var curr_date = d.getDate();
                            var curr_month = d.getMonth() + 1; //Months are zero based
                            var curr_year = d.getFullYear();
                            var rcn18 = curr_date + "/" + curr_month + "/" + curr_year;
                        }else{
                            var rcn18 =  new String("-");
                        }
                        //PIC DISINI
                        if(data['202006X114X2880'] != null){
                            var pic18 = data['202006X114X2880'];
                        }else{
                            var pic18 = new String("-");
                        }
                        //<td>"+rcn18+"</td><td>"+pic18+"</td>
						if(data['202006X114X2789'] != null){//File
							$( "#soal18" ).html( 						//Soal Berapa
								"<tr><td ><b>3. </b></td><td>"+
								jawaban
								+"</td><td ><a href='<?= base_url(); ?>files/"+obj.filename+"' target='_blank' class='btn btn-sm btn-success'><i class='fa fa-download'></i> "+obj.name+"</a></td><td>"+rcn18+"</td><td>"+pic18+"</td></tr>"
							);
						}else{
							$( "#soal18" ).html( 						//Soal Berapa
								"<tr><td ><b>3. </b></td><td>"+
								jawaban
								+"</td><td>"+data['202006X114X2788']+"</td><td>"+rcn18+"</td><td>"+pic18+"</td></tr>"
							);							//Teks
						}
					}
					//------ End Soal 18 ----------

					//------ Soal 19 -----------
					if(data['202006X115X2790'] != null){//Soal Berapa
						var txt = data['202006X115X2792'];//File
						if(txt == null){
							var tks = new String('{ "name":"","filename":"" }');
						}else{
							var tks = txt.replace("[",'').replace("]",'');
						}
						var obj = JSON.parse(tks);
						if(data['202006X115X2790'] == 2){
							var jawaban = new String("Terdapat dokter dan paramedis dg sertifikasi lengkap");
						}else if(data['202006X115X2790'] == 1){
							var jawaban = new String("Sertifikat dokter dan paramedis tidak lengkap");
						}else{
							var jawaban = new String("Hanya terdapat FA");
						}
						//RENCANA DISINI
						if(data['202006X115X2907'] != null){
                            var d = new Date(data['202006X115X2907']);
                            var curr_date = d.getDate();
                            var curr_month = d.getMonth() + 1; //Months are zero based
                            var curr_year = d.getFullYear();
                            var rcn19 = curr_date + "/" + curr_month + "/" + curr_year;
                        }else{
                            var rcn19 =  new String("-");
                        }
                        //PIC DISINI
                        if(data['202006X115X2881'] != null){
                            var pic19 = data['202006X115X2881'];
                        }else{
                            var pic19 = new String("-");
                        }
                        //<td>"+rcn19+"</td><td>"+pic19+"</td>
						if(data['202006X115X2792'] != null){//File
							$( "#soal19" ).html( //Soal ke Berapa
								"<tr><td ><b>4. </b></td><td>"+
								jawaban
								+"</td><td ><a href='<?= base_url(); ?>files/"+obj.filename+"' target='_blank' class='btn btn-sm btn-success'><i class='fa fa-download'></i> "+obj.name+"</a></td><td>"+rcn19+"</td><td>"+pic19+"</td></tr>"
							);
						}else{
							$( "#soal19" ).html( //Soal ke Berapa
								"<tr><td ><b>4. </b></td><td>"+
								jawaban
								+"</td><td>"+data['202006X115X2791']+"</td><td>"+rcn19+"</td><td>"+pic19+"</td></tr>"
							);							//Teks
						}
					}
					//------ End Soal 19 ----------

					//------ Soal 20 -----------
					if(data['202006X116X2793'] != null){//Soal Berapa
						var txt = data['202006X116X2795'];//File
						if(txt == null){
							var tks = new String('{ "name":"","filename":"" }');
						}else{
							var tks = txt.replace("[",'').replace("]",'');
						}
						var obj = JSON.parse(tks);
						if(data['202006X116X2793'] == 1){
							var jawaban = new String("Terdapat pekerja yang ditunjuk untuk memelihara dan memastikan semua sarana (termasuk AED), isi kotak P3K terpelihara sepanjang waktu");
						}else{
							var jawaban = new String("Tidak terdapat pekerja yang ditunjuk untuk memelihara dan memastikan semua sarana (termasuk AED), isi kotak P3K terpelihara sepanjang waktu");
						}
						//RENCANA DISINI
						if(data['202006X116X2908'] != null){
                            var d = new Date(data['202006X116X2908']);
                            var curr_date = d.getDate();
                            var curr_month = d.getMonth() + 1; //Months are zero based
                            var curr_year = d.getFullYear();
                            var rcn20 = curr_date + "/" + curr_month + "/" + curr_year;
                        }else{
                            var rcn20 =  new String("-");
                        }
                        //PIC DISINI
                        if(data['202006X116X2882'] != null){
                            var pic20 = data['202006X116X2882'];
                        }else{
                            var pic20 = new String("-");
                        }
                        //<td>"+rcn20+"</td><td>"+pic20+"</td>
						if(data['202006X116X2795'] != null){//File
							$( "#soal20" ).html( //Soal ke Berapa
								"<tr><td ><b>5. </b></td><td>"+
								jawaban
								+"</td><td ><a href='<?= base_url(); ?>files/"+obj.filename+"' target='_blank' class='btn btn-sm btn-success'><i class='fa fa-download'></i> "+obj.name+"</a></td><td>"+rcn20+"</td><td>"+pic20+"</td></tr>"
							);
						}else{
							$( "#soal20" ).html( //Soal ke Berapa
								"<tr><td ><b>5. </b></td><td>"+
								jawaban
								+"</td><td>"+data['202006X116X2794']+"</td><td>"+rcn20+"</td><td>"+pic20+"</td></tr>"
							);							//Teks
						}
					}
					//------ End Soal 20 ----------

					//------ Soal 21 -----------
					if(data['202006X117X2796'] != null){//Soal Berapa
						var txt = data['202006X117X2798'];//File
						if(txt == null){
							var tks = new String('{ "name":"","filename":"" }');
						}else{
							var tks = txt.replace("[",'').replace("]",'');
						}
						var obj = JSON.parse(tks);
						if(data['202006X117X2796'] == 3){
							var jawaban = new String("Terdapat Klinik dan seluruh sarananya sesuai dg standar");
						}else if(data['202006X117X2796'] == 2){
							var jawaban = new String("Terdapat klinik dan sebagian besar sarananya sesuai dg standar");
						}else if(data['202006X117X2796'] == 1){
							var jawaban = new String("Terdapat klinik namun hanya sebagian kecil sarananya yang tersedia");
						}else{
							var jawaban = new String("Tidak terdapat klinik dan sarananya");
						}
						//RENCANA DISINI
						if(data['202006X117X2909'] != null){
                            var d = new Date(data['202006X117X2909']);
                            var curr_date = d.getDate();
                            var curr_month = d.getMonth() + 1; //Months are zero based
                            var curr_year = d.getFullYear();
                            var rcn21 = curr_date + "/" + curr_month + "/" + curr_year;
                        }else{
                            var rcn21 =  new String("-");
                        }
                        //PIC DISINI
                        if(data['202006X117X2883'] != null){
                            var pic21 = data['202006X117X2883'];
                        }else{
                            var pic21 = new String("-");
                        }
                        //<td>"+rcn21+"</td><td>"+pic21+"</td>
						if(data['202006X117X2798'] != null){//File
							$( "#soal21" ).html( //Soal ke Berapa
								"<tr><td colspan='5' class='text-center'><b>PLANT</b></td></tr><tr><td ><b>1. </b></td><td>"+
								jawaban
								+"</td><td ><a href='<?= base_url(); ?>files/"+obj.filename+"' target='_blank' class='btn btn-sm btn-success'><i class='fa fa-download'></i> "+obj.name+"</a></td><td>"+rcn21+"</td><td>"+pic21+"</td></tr>"
							);
						}else{
							$( "#soal21" ).html( //Soal ke Berapa
								"<tr><td colspan='5' class='text-center'><b>PLANT</b></td></tr><tr><td ><b>1. </b></td><td>"+
								jawaban
								+"</td><td>"+data['202006X117X2797']+"</td><td>"+rcn21+"</td><td>"+pic21+"</td></tr>"
							);							//Teks
						}
					}
					//------ End Soal 21 ----------

					//------ Soal 22 -----------
					if(data['202006X118X2799'] != null){//Soal Berapa
						var txt = data['202006X118X2801'];//File
						if(txt == null){
							var tks = new String('{ "name":"","filename":"" }');
						}else{
							var tks = txt.replace("[",'').replace("]",'');
						}
						var obj = JSON.parse(tks);
						if(data['202006X118X2799'] == 3){
							var jawaban = new String("Tersedia alat transportasi evakuasi sesuai dg standar dan risiko yg diidentifikasi");
						}else if(data['202006X118X2799'] == 2){
							var jawaban = new String("Tersedia alat transportasi evakuasi dengan persyaratan yang hampir sebagian besar memenuhi standar");
						}else if(data['202006X118X2799'] == 1){
							var jawaban = new String("Tersedia alat transportasi evakuasi dengan persyaratan yang hampir sebagain besar memenuhi standar");
						}else{
							var jawaban = new String("Tidak terdapat alat transportasi");
						}
						//RENCANA DISINI
						if(data['202006X118X2910'] != null){
                            var d = new Date(data['202006X118X2910']);
                            var curr_date = d.getDate();
                            var curr_month = d.getMonth() + 1; //Months are zero based
                            var curr_year = d.getFullYear();
                            var rcn22 = curr_date + "/" + curr_month + "/" + curr_year;
                        }else{
                            var rcn22 =  new String("-");
                        }
                        //PIC DISINI
                        if(data['202006X118X2884'] != null){
                            var pic22 = data['202006X118X2884'];
                        }else{
                            var pic22 = new String("-");
                        }
                        //<td>"+rcn22+"</td><td>"+pic22+"</td>
						if(data['202006X118X2801'] != null){//File
							$( "#soal22" ).html( //Soal ke Berapa
								"<tr><td ><b>2. </b></td><td>"+
								jawaban
								+"</td><td ><a href='<?= base_url(); ?>files/"+obj.filename+"' target='_blank' class='btn btn-sm btn-success'><i class='fa fa-download'></i> "+obj.name+"</a></td><td>"+rcn22+"</td><td>"+pic22+"</td></tr>"
							);
						}else{
							$( "#soal22" ).html( //Soal ke Berapa
								"<tr><td ><b>2. </b></td><td>"+
								jawaban
								+"</td><td>"+data['202006X118X2800']+"</td><td>"+rcn22+"</td><td>"+pic22+"</td></tr>"
							);							//Teks
						}
					}
					//------ End Soal 22 ----------

					//------ Soal 23 -----------
					if(data['202006X119X2802'] != null){//Soal Berapa
						var txt = data['202006X119X2804'];//File
						if(txt == null){
							var tks = new String('{ "name":"","filename":"" }');
						}else{
							var tks = txt.replace("[",'').replace("]",'');
						}
						var obj = JSON.parse(tks);
						if(data['202006X119X2802'] == 1){
							var jawaban = new String("Distribusi AED dan kotak P3K sudah sesuai dengan risiko di tempat kerja");
						}else{
							var jawaban = new String("Distribusi AED dan kotak P3K belum sesuai dengan risiko di tempat kerja");
						}
						//RENCANA DISINI
						if(data['202006X119X2911'] != null){
                            var d = new Date(data['202006X119X2911']);
                            var curr_date = d.getDate();
                            var curr_month = d.getMonth() + 1; //Months are zero based
                            var curr_year = d.getFullYear();
                            var rcn23 = curr_date + "/" + curr_month + "/" + curr_year;
                        }else{
                            var rcn23 =  new String("-");
                        }
                        //PIC DISINI
                        if(data['202006X119X2885'] != null){
                            var pic23 = data['202006X119X2885'];
                        }else{
                            var pic23 = new String("-");
                        }
                        //<td>"+rcn23+"</td><td>"+pic23+"</td>
						if(data['202006X119X2804'] != null){//File
							$( "#soal23" ).html( //Soal ke Berapa
								"<tr><td ><b>3. </b></td><td>"+
								jawaban
								+"</td><td ><a href='<?= base_url(); ?>files/"+obj.filename+"' target='_blank' class='btn btn-sm btn-success'><i class='fa fa-download'></i> "+obj.name+"</a></td><td>"+rcn23+"</td><td>"+pic23+"</td></tr>"
							);
						}else{
							$( "#soal23" ).html( //Soal ke Berapa
								"<tr><td ><b>3. </b></td><td>"+
								jawaban
								+"</td><td>"+data['202006X119X2803']+"</td><td>"+rcn23+"</td><td>"+pic23+"</td></tr>"
							);							//Teks
						}
					}
					//------ End Soal 23 ----------

					//------ Soal 24 -----------
					if(data['202006X120X2805'] != null){//Soal Berapa
						var txt = data['202006X120X2807'];//File
						if(txt == null){
							var tks = new String('{ "name":"","filename":"" }');
						}else{
							var tks = txt.replace("[",'').replace("]",'');
						}
						var obj = JSON.parse(tks);
						if(data['202006X120X2805'] == 1){
							var jawaban = new String("AED dan Kotak P3K terlihat dengan baik dan mudah diakses");
						}else{
							var jawaban = new String("AED dan Kotak P3K sulit untuk diakses atau tidak tersedia");
						}
						//RENCANA DISINI
						if(data['202006X120X2912'] != null){
                            var d = new Date(data['202006X120X2912']);
                            var curr_date = d.getDate();
                            var curr_month = d.getMonth() + 1; //Months are zero based
                            var curr_year = d.getFullYear();
                            var rcn24 = curr_date + "/" + curr_month + "/" + curr_year;
                        }else{
                            var rcn24 =  new String("-");
                        }
                        //PIC DISINI
                        if(data['202006X120X2886'] != null){
                            var pic24 = data['202006X120X2886'];
                        }else{
                            var pic24 = new String("-");
                        }
                        //<td>"+rcn24+"</td><td>"+pic24+"</td>
						if(data['202006X120X2807'] != null){//File
							$( "#soal24" ).html( //Soal ke Berapa
								"<tr><td ><b>4. </b></td><td>"+
								jawaban
								+"</td><td ><a href='<?= base_url(); ?>files/"+obj.filename+"' target='_blank' class='btn btn-sm btn-success'><i class='fa fa-download'></i> "+obj.name+"</a></td><td>"+rcn24+"</td><td>"+pic24+"</td></tr>"
							);
						}else{
							$( "#soal24" ).html( //Soal ke Berapa
								"<tr><td ><b>4. </b></td><td>"+
								jawaban
								+"</td><td>"+data['202006X120X2806']+"</td><td>"+rcn24+"</td><td>"+pic24+"</td></tr>"
							);							//Teks
						}
					}
					//------ End Soal 24 ----------

					//------ Soal 25 -----------
					if(data['202006X121X2808'] != null){//Soal Berapa
						var txt = data['202006X121X2810'];//File
						if(txt == null){
							var tks = new String('{ "name":"","filename":"" }');
						}else{
							var tks = txt.replace("[",'').replace("]",'');
						}
						var obj = JSON.parse(tks);
						if(data['202006X121X2808'] == 1){
							var jawaban = new String("Isi kotak P3K tersebut telah sesuai dengan standar yang berlaku dan terpelihara dengan baik");
						}else{
							var jawaban = new String("Isi kotak P3K tersebut tidak sesuai dengan standar yang berlaku dan terpelihara dengan baik");
						}
						//RENCANA DISINI
						if(data['202006X121X2913'] != null){
                            var d = new Date(data['202006X121X2913']);
                            var curr_date = d.getDate();
                            var curr_month = d.getMonth() + 1; //Months are zero based
                            var curr_year = d.getFullYear();
                            var rcn25 = curr_date + "/" + curr_month + "/" + curr_year;
                        }else{
                            var rcn25 =  new String("-");
                        }
                        //PIC DISINI
                        if(data['202006X121X2887'] != null){
                            var pic25 = data['202006X121X2887'];
                        }else{
                            var pic25 = new String("-");
                        }
                        //<td>"+rcn25+"</td><td>"+pic25+"</td>
						if(data['202006X121X2810'] != null){//File
							$( "#soal25" ).html( //Soal ke Berapa
								"<tr><td ><b>5. </b></td><td>"+
								jawaban
								+"</td><td ><a href='<?= base_url(); ?>files/"+obj.filename+"' target='_blank' class='btn btn-sm btn-success'><i class='fa fa-download'></i> "+obj.name+"</a></td><td>"+rcn25+"</td><td>"+pic25+"</td></tr>"
							);
						}else{
							$( "#soal25" ).html( //Soal ke Berapa
								"<tr><td ><b>5. </b></td><td>"+
								jawaban
								+"</td><td>"+data['202006X121X2809']+"</td><td>"+rcn25+"</td><td>"+pic25+"</td></tr>"
							);							//Teks
						}
					}
					//------ End Soal 25 ----------

					//------ Soal 26 -----------
					if(data['202006X124X2854'] != null){//Soal Berapa
						var txt = data['202006X124X2856'];//File
						if(txt == null){
							var tks = new String('{ "name":"","filename":"" }');
						}else{
							var tks = txt.replace("[",'').replace("]",'');
						}
						var obj = JSON.parse(tks);
						if(data['202006X124X2854'] == 1){
							var jawaban = new String("RS jejaring dapat dijangkau dalam waktu 4 jam/sesuia dengan identifikasi risiko");
						}else{
							var jawaban = new String("RS jejaring tidak dapat dijangkau dalam waktuyg telah diidentifikasi");
						}
						//RENCANA DISINI
						if(data['202006X124X2914'] != null){
                            var d = new Date(data['202006X124X2914']);
                            var curr_date = d.getDate();
                            var curr_month = d.getMonth() + 1; //Months are zero based
                            var curr_year = d.getFullYear();
                            var rcn26 = curr_date + "/" + curr_month + "/" + curr_year;
                        }else{
                            var rcn26 =  new String("-");
                        }
                        //PIC DISINI
                        if(data['202006X124X2888'] != null){
                            var pic26 = data['202006X124X2888'];
                        }else{
                            var pic26 = new String("-");
                        }
                        //<td>"+rcn26+"</td><td>"+pic26+"</td>
						if(data['202006X124X2856'] != null){//File
							$( "#soal26" ).html( //Soal ke Berapa
								"<tr><td ><b>6. </b></td><td>"+
								jawaban
								+"</td><td ><a href='<?= base_url(); ?>files/"+obj.filename+"' target='_blank' class='btn btn-sm btn-success'><i class='fa fa-download'></i> "+obj.name+"</a></td><td>"+rcn26+"</td><td>"+pic26+"</td></tr>"
							);
						}else{
							$( "#soal26" ).html( //Soal ke Berapa
								"<tr><td ><b>6. </b></td><td>"+
								jawaban
								+"</td><td>"+data['202006X124X2855']+"</td><td>"+rcn26+"</td><td>"+pic26+"</td></tr>"
							);							//Teks
						}
					}
					//------ End Soal 26 ----------
				}
			});
		});
	});
</script>