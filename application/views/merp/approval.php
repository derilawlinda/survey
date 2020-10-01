
<!-- DataTales Example -->
<div class="container mt-3">
				<!-- Simple Datatable start -->
				<div class="card-box mb-30">
            		<div class="card-header py-3 d-flex justify-content-between pd-20">
            		  	<h6 class="m-0 font-weight-bold text-primary"><?= $title_page; ?></h6>
            		  	<!-- <a href="https://survey.pertamina-pdc.network/index.php/202006?lang=id" target="_blank" class="btn-sm btn-primary">Jawab Survey</a> -->
            		</div>
					<div class="card-body pb-20">
						<table class=" <?php if($user['role_id'] == 1 || $user['role_id'] == 10){echo 'dataTableExport';}else{echo 'data-table';} ?> table stripe hover text-center">
							<thead>
								<tr>
            						<th class="table-plus datatable-nosort">No</th>
            						<th>UO/AP</th>
            			      		<?php //if($user['role_id'] != 1 && $user['role_id'] != 10){ ?>
            						<th>Status</th>
            						<?php //} ?>
            						<th>Approve Date</th>
            						<th>Approver</th>
                                    <?php if($user['role_id'] == 1 || $user['role_id'] == 10){ ?>
            						<th>Total Nilai</th>
            						<th>Persentase</th>
            						<?php if($user['role_id'] == 10){ ?>
            						<th>Action</th>
                                    <?php }} ?>
								</tr>
							</thead>
							<tbody>
							    <?php 
            			      	$number = 0;
            			      	foreach($merp as $r): ?>
                                <?php if($user['role_id'] != 1 && $user['unit'] == $r['unit_id'] || $user['role_id'] == 10 && $user['unit'] == $r['unit_id'] || $user['role_id'] == 1){ ?>
            			      	<tr>
            			      		<td><?= ++$number; ?></td>
            			      		<td><a href="https://survey.pertamina-pdc.network/dashboard/print/jawaban.php?id=<?= $r['survey_id']; ?>" target="_blank"><i class="dw dw-eye"></i> <?= $r['unit']; ?></a></td>
            			      		<?php //if($user['role_id'] != 1 && $user['role_id'] != 10){ ?>
            			      		<td><a href="#" class="btn-sm btn-<?php if($r['status'] == "Terima"){echo "success";}elseif($r['status'] == "Tolak"){echo "danger";}else{echo "warning";} ?> tampilModalStatus" href="#" data-id="<?= $r['id']; ?>" data-url="<?= base_url(); ?>" data-toggle="modal" data-target="#statusModal"><?php if($r['status'] == "Terima"){echo "Diterima";}elseif($r['status'] == "Tolak"){echo "Ditolak";}else{echo "Persetujuan";} ?></a></td>
            			      		<?php //} ?>
            			      		<td><?= date('d F Y h:i:s',strtotime($r['updated_at'])); ?></td>
            			      		<td><?= $r['updated_by']; ?></td>
                                    <?php if($user['role_id'] == 1 || $user['role_id'] == 10){ ?>
            			      		<td><?= $r['nilai']; ?></td>
            			      		<td style="background-color:
                                        <?php
                                            $persen = $r['persen'];
											if($persen >= 90){echo "#00b630";}
											elseif($persen >= 80 && $persen < 90){echo "#7cff04";}
											elseif($persen >= 70 && $persen < 80){echo "#ffec04";}
											elseif($persen >= 60 && $persen < 70){echo "#ff8f04";}
											else{echo "#ff0000";}
										?>
									"><?= $persen."%"; ?></td>
									<?php if($user['role_id'] == 10){ ?>
                                    <td>
										<div class="dropdown">
											<a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="BUTTON" data-toggle="dropdown">
												<i class="dw dw-more"></i>
											</a>
											<div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                                <!--<a class="dropdown-item tampilModalJawaban" href="#" data-id="<?= $r['survey_id']; ?>" data-url="<?= base_url(); ?>" data-toggle="modal" data-target="#jawabanModal"><i class="dw dw-eye"></i> Lihat Jawaban</a>-->
												<a class="dropdown-item tampilModalUbah" href="#" data-id="<?= $r['id']; ?>" data-url="<?= base_url(); ?>" data-toggle="modal" data-target="#formModal"><i class="dw dw-edit"></i> Tindakan</a>
												<!--<a class="dropdown-item" href="#"><i class="dw dw-edit2"></i> Edit</a>-->
												<a class="dropdown-item tampilModalAlert" href="#" data-id="<?= $r['id']; ?>" data-url="<?= base_url(); ?>" data-toggle="modal" data-target="#alertModal"><i class="dw dw-delete-3"></i> Hapus</a>
											</div>
										</div>
									</td>
                                    <?php }} ?>
								</tr>
                                <?php } ?>
            				    <?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
				<!-- Simple Datatable End -->    
</div>
<!-- Jawaban Modal -->
<div class="modal fade" id="jawabanModal" tabindex="-1" role="dialog" aria-labelledby="jawabanModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<form id="jawabanModalAction" action="" method="post">
                <!--<input type="text" name="id" id="id" class="form-control" value="" hidden="hidden">-->
                <div class="modal-header">
                    <h5 class="modal-title" id="jawabanModalLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                        <div class="form-group">
                            <input type="number" name="id" hidden="hidden">
                            <input type="number" name="survey_id" hidden="hidden">
                            <input type="text" name="unit_id" class="form-control" hidden="hidden">
                            <input type="text" name="nilai" class="form-control" hidden="hidden">
                            <input type="text" name="updated_by" class="form-control" hidden="hidden" value="<?= $user['email']; ?>">
                        </div>
                        <div class="form-group">
							<span id="submitDate"></span>
							<table class="table stripe hover"><thead><tr><th class="table-plus datatable-nosort">No.</th><th width="50%">Jawaban</th><th>Tindak Lanjut / Evidence</th></tr></thead>
								<?php for ($i=1; $i < 27; $i++) { ?>
									<tbody id="soal<?= $i; ?>"></tbody>
								<?php } ?>
							</table>
                        </div>
                </div>
                <div class="modal-footer">
                    <a href="<?= base_url(); ?>merp/approval" type="button" class="btn btn-secondary" required="">Close</a>
                    <!--<button type="submit" class="btn btn-primary" id="jawabanModalBtn">Add</button>-->
                </div>
            </form>
		</div>
	</div>
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
                            <input type="text" name="unit_id" class="form-control" hidden="hidden">
                            <input type="text" name="nilai" class="form-control" hidden="hidden">
                            <input type="text" name="updated_by" class="form-control" hidden="hidden" value="<?= $user['email']; ?>">
                            <?php foreach($merp as $r): ?>
                            <?php if($user['role_id'] != 1 && $user['unit'] == $r['unit_id'] || $user['role_id'] == 10 && $user['unit'] == $r['unit_id'] || $user['role_id'] == 1){ ?>
                            <input type="text" name="approver" class="form-control" hidden="hidden" value="<?= $r['approver']; ?>">
                            <input type="text" name="created_by" class="form-control" hidden="hidden" value="<?= $r['created_by']; ?>">
                            <?php } ?>
        				    <?php endforeach; ?>
                            
                            <input type="text" name="lokasi" class="form-control" hidden="hidden" value="<?= $unit['unit']; ?>">
                        </div>
                        <div class="form-group">
                            <select name="status" id="menuSubMenu" class="form-control">
                                <option>Pilih Salah Satu</option>
                                <option value="Terima">Terima</option>
                                <option value="Tolak">Tolak</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <textarea name="reason" class="form-control" placeholder="Berikan alasan jika menolak"></textarea>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" required="">Close</button>
                    <button type="submit" class="btn btn-primary" id="formModalBtn">Add</button>
                </div>
            </form>
		</div>
	</div>
</div>
<!-- status Modal -->
<div class="modal fade" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="statusModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<!-- <form id="statusModalAction" action="" method="post"> -->
                <input type="text" name="id" id="id" class="form-control" value="" hidden="hidden">
                <div class="modal-header">
                    <h5 class="modal-title" id="statusModalLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                        <div class="form-group">
                            <input type="number" name="id" hidden="hidden">
                            <input type="text" name="unit_id" class="form-control" hidden="hidden">
                            <input type="text" name="nilai" class="form-control" hidden="hidden">
                            <input type="text" name="updated_by" class="form-control" hidden="hidden" value="<?= $user['email']; ?>">
                        </div>
                        <div class="form-group">
                            <select name="status" id="menuSubMenu" class="form-control" disabled>
                                <option>Status</option>
                                <option value="Terima">Terima</option>
                                <option value="Tolak">Tolak</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <textarea name="reason" class="form-control" placeholder="Berikan alasan jika menolak" readonly></textarea>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" required="">Close</button>
                    <!-- <button type="submit" class="btn btn-primary" id="formModalBtn">Add</button> -->
                </div>
            <!-- </form> -->
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
        $('.dataTableExport').DataTable({
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
            dom: 'Bfrtp',
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'pdfHtml5',
                'print'
            ]
        });
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
			$('#alertModalLabel').html('Hapus Pengajuan Survey');
			$('#anchorAlertModal').attr('class', 'btn btn-danger');
			$('#anchorAlertModal').html('Hapus');
			$('#paragrafBodyModal').html('Apakah anda yakin..?');
			$('#anchorAlertModal').attr('href', url + 'merp/approvedelete/' + id);
		});
        // modal status data
		$('.tampilModalStatus').on('click', function(){
			const id = $(this).data('id');
			const url = $(this).data('url');
			$('#statusModalLabel').html('Status Survey');
			$('#formModalBtn').html('Simpan');
			// $('#formModalAction').attr('action', url + 'merp/approval');
			$.ajax({
				url: url + 'merp/approvedetail',
				data: {id: id},
				method: 'post',
				dataType: 'json',
				success: function(data){
					$('input[name=id]').val(data['id']);
					$('input[name=unit_id]').val(data['unit_id']);
					$('input[name=nilai]').val(data['nilai']);
					// $('input[name=updated_by]').val(data['updated_by']);
					$('option[value='+ data.status +']').attr('selected','');
					$('textarea[name=reason]').val(data['reason']);
				}
			});
        });
		// modal edit data
		$('.tampilModalUbah').on('click', function(){
			const id = $(this).data('id');
			const url = $(this).data('url');
			$('#formModalLabel').html('Tindakan Approval Survey');
			$('#formModalBtn').html('Simpan');
			$('#formModalAction').attr('action', url + 'merp/approval');
			$.ajax({
				url: url + 'merp/approvedetail',
				data: {id: id},
				method: 'post',
				dataType: 'json',
				success: function(data){
					$('input[name=id]').val(data['id']);
					$('input[name=unit_id]').val(data['unit_id']);
					$('input[name=nilai]').val(data['nilai']);
					// $('input[name=updated_by]').val(data['updated_by']);
					$('option[value='+ data.status +']').attr('selected','');
					$('textarea[name=reason]').val(data['reason']);
				}
			});
        });
        // modal jawaban data
		$('.tampilModalJawaban').on('click', function(){
			const id = $(this).data('id');
			const url = $(this).data('url');
			$('#jawabanModalLabel').html('Approval Survey');
			$('#jawabanModalBtn').html('Simpan');
			$('#jawabanModalAction').attr('action', url + 'merp/approval');
			$.ajax({
				url: url + 'merp/surveydetail',
				data: {id: id},
				method: 'post',
				dataType: 'json',
				success: function(data){
					//Insert/////////
					$('input[name=id]').val(data['id']);
					$('input[name=survey_id]').val(data['survey_id']);
					$('input[name=unit_id]').val(data['202006X125X2916']);
					$('input[name=nilai]').val(data['202006X122X2859']);
					$('option[value='+ data.status +']').attr('selected','');
					$('textarea[name=reason]').val(data['reason']);
					//View
					$( "#submitDate" ).html( "<tr class='btn btn-sm btn-warning' style='margin-bottom:5%'><td>Survey Completion</td><td>: "+data['submitdate']+"</td></tr>" );


					
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
						if(data['202006X97X2736'] != null){//File
							$( "#soal1" ).html( //ID Soal
								"<tr><td colspan='3' class='text-center'><b>PROCEDURE</b></td></tr><tr><td ><b>1. </b></td><td>"+
								jawaban
								+"</td><td ><a href='<?= base_url(); ?>files/"+obj.filename+"' target='_blank' class='btn btn-sm btn-success'><i class='fa fa-download'></i> "+obj.name+"</a></td></tr>"
							);
						}else{
							$( "#soal1" ).html( 						//Soal Berapa
								"<tr><td colspan='3' class='text-center'><b>PROCEDURE</b></td></tr><tr><td ><b>1. </b></td><td>"+
								jawaban
								+"</td><td>"+data['202006X97X2737']+"</td></tr>"
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
						if(data['202006X98X2740'] != null){//File
							$( "#soal2" ).html( //ID Soal
								"<tr><td ><b>2. </b></td><td>"+
								jawaban
								+"</td><td ><a href='<?= base_url(); ?>files/"+obj.filename+"' target='_blank' class='btn btn-sm btn-success'><i class='fa fa-download'></i> "+obj.name+"</a></td></tr>"
							);
						}else{
							$( "#soal2" ).html( 						//Soal Berapa
								"<tr><td ><b>2. </b></td><td>"+
								jawaban
								+"</td><td>"+data['202006X98X2741']+"</td></tr>"
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
						if(data['202006X99X2744'] != null){//File
							$( "#soal3" ).html( //ID Soal
								"<tr><td ><b>3. </b></td><td>"+
								jawaban
								+"</td><td ><a href='<?= base_url(); ?>files/"+obj.filename+"' target='_blank' class='btn btn-sm btn-success'><i class='fa fa-download'></i> "+obj.name+"</a></td></tr>"
							);
						}else{
							$( "#soal3" ).html( 						//Soal Berapa
								"<tr><td ><b>3. </b></td><td>"+
								jawaban
								+"</td><td>"+data['202006X99X2743']+"</td></tr>"
							);							//Teks
						}
					}else{
						$( "#soal3" ).html(
							"<tr><td ><b>3. </b></td><td>"+
							"Distribusi AED dan kotak P3K belum sesuai dengan risiko di tempat kerja"
							+"</td><td> - </td></tr>"
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
						if(data['202006X100X2747'] != null){//File
							$( "#soal4" ).html( //ID Soal
								"<tr><td ><b>4. </b></td><td>"+
								jawaban
								+"</td><td ><a href='<?= base_url(); ?>files/"+obj.filename+"' target='_blank' class='btn btn-sm btn-success'><i class='fa fa-download'></i> "+obj.name+"</a></td></tr>"
							);
						}else{
							$( "#soal4" ).html( 						//Soal Berapa
								"<tr><td ><b>4. </b></td><td>"+
								jawaban
								+"</td><td>"+data['202006X100X2746']+"</td></tr>"
							);							//Teks
						}
					}else{
						$( "#soal4" ).html(
							"<tr><td ><b>4. </b></td><td>"+
							"Terdapat rencana tanggap darurat medis (MERP) yang namun belum dikomunikasikan kepada seluruh stakeholder"
							+"</td><td> - </td></tr>"
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
						if(data['202006X101X2750'] != null){//File
							$( "#soal5" ).html( //ID Soal
								"<tr><td ><b>5. </b></td><td>"+
								jawaban
								+"</td><td ><a href='<?= base_url(); ?>files/"+obj.filename+"' target='_blank' class='btn btn-sm btn-success'><i class='fa fa-download'></i> "+obj.name+"</a></td></tr>"
							);
						}else{
							$( "#soal5" ).html( 						//Soal Berapa
								"<tr><td ><b>5. </b></td><td>"+
								jawaban
								+"</td><td>"+data['202006X101X2749']+"</td></tr>"
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
						if(data['202006X123X2847'] != null){//File
							$( "#soal5" ).html( //ID Soal
								"<tr><td ><b>5. </b></td><td>"+
								jawaban
								+"</td><td ><a href='<?= base_url(); ?>files/"+obj.filename+"' target='_blank' class='btn btn-sm btn-success'><i class='fa fa-download'></i> "+obj.name+"</a></td></tr>"
							);
						}else{
							$( "#soal5" ).html( 						//Soal Berapa
								"<tr><td ><b>5. </b></td><td>"+
								jawaban
								+"</td><td>"+data['202006X123X2846']+"</td></tr>"
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
						if(data['202006X102X2753'] != null){//File
							$( "#soal6" ).html( //ID Soal
								"<tr><td ><b>6. </b></td><td>"+
								jawaban
								+"</td><td ><a href='<?= base_url(); ?>files/"+obj.filename+"' target='_blank' class='btn btn-sm btn-success'><i class='fa fa-download'></i> "+obj.name+"</a></td></tr>"
							);
						}else{
							$( "#soal6" ).html( 						//Soal Berapa
								"<tr><td ><b>6. </b></td><td>"+
								jawaban
								+"</td><td>"+data['202006X102X2752']+"</td></tr>"
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
						if(data['202006X103X2756'] != null){//File
							$( "#soal7" ).html( //ID Soal
								"<tr><td ><b>7. </b></td><td>"+
								jawaban
								+"</td><td ><a href='<?= base_url(); ?>files/"+obj.filename+"' target='_blank' class='btn btn-sm btn-success'><i class='fa fa-download'></i> "+obj.name+"</a></td></tr>"
							);
						}else{
							$( "#soal7" ).html( //ID Soal
								"<tr><td ><b>7. </b></td><td>"+
								jawaban
								+"</td><td>"+data['202006X103X2755']+"</td></tr>"
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
						if(data['202006X104X2759'] != null){//File
							$( "#soal8" ).html( //ID Soal
								"<tr><td ><b>8. </b></td><td>"+
								jawaban
								+"</td><td ><a href='<?= base_url(); ?>files/"+obj.filename+"' target='_blank' class='btn btn-sm btn-success'><i class='fa fa-download'></i> "+obj.name+"</a></td></tr>"
							);
						}else{
							$( "#soal8" ).html( //ID Soal
								"<tr><td ><b>8. </b></td><td>"+
								jawaban
								+"</td><td>"+data['202006X104X2758']+"</td></tr>"
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
						if(data['202006X105X2762'] != null){//File
							$( "#soal9" ).html( //ID Soal
								"<tr><td ><b>9. </b></td><td>"+
								jawaban
								+"</td><td ><a href='<?= base_url(); ?>files/"+obj.filename+"' target='_blank' class='btn btn-sm btn-success'><i class='fa fa-download'></i> "+obj.name+"</a></td></tr>"
							);
						}else{
							$( "#soal9" ).html( 						//Soal Berapa
								"<tr><td ><b>9. </b></td><td>"+
								jawaban
								+"</td><td>"+data['202006X105X2761']+"</td></tr>"
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
						if(data['202006X106X2765'] != null){//File
							$( "#soal10" ).html( //ID Soal
								"<tr><td ><b>10. </b></td><td>"+
								jawaban
								+"</td><td ><a href='<?= base_url(); ?>files/"+obj.filename+"' target='_blank' class='btn btn-sm btn-success'><i class='fa fa-download'></i> "+obj.name+"</a></td></tr>"
							);
						}else{
							$( "#soal10" ).html( 						//Soal Berapa
								"<tr><td ><b>10. </b></td><td>"+
								jawaban
								+"</td><td>"+data['202006X106X2764']+"</td></tr>"
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
						if(data['202006X107X2768'] != null){//File
							$( "#soal11" ).html( //ID Soal
								"<tr><td ><b>11. </b></td><td>"+
								jawaban
								+"</td><td ><a href='<?= base_url(); ?>files/"+obj.filename+"' target='_blank' class='btn btn-sm btn-success'><i class='fa fa-download'></i> "+obj.name+"</a></td></tr>"
							);
						}else{
							$( "#soal11" ).html( 						//Soal Berapa
								"<tr><td ><b>11. </b></td><td>"+
								jawaban
								+"</td><td>"+data['202006X107X2767']+"</td></tr>"
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
						if(data['202006X108X2771'] != null){//File
							$( "#soal12" ).html( 						//Soal Berapa
								"<tr><td ><b>11a. </b></td><td>"+
								jawaban
								+"</td><td ><a href='<?= base_url(); ?>files/"+obj.filename+"' target='_blank' class='btn btn-sm btn-success'><i class='fa fa-download'></i> "+obj.name+"</a></td></tr>"
							);
						}else{
							$( "#soal12" ).html( 						//Soal Berapa
								"<tr><td ><b>11a. </b></td><td>"+
								jawaban
								+"</td><td>"+data['202006X108X2770']+"</td></tr>"
							);							//Teks
						}
					}else{
						$( "#soal12" ).html(
							"<tr><td ><b>11a. </b></td><td>"+
							"Tidak tterdapat prosedur untuk memastikan sarana dan peralatan tanggap darurat medis diperiksa dan dipelihara secara berkala"
							+"</td><td> - </td></tr>"
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
						if(data['202006X109X2774'] != null){//File
							$( "#soal13" ).html( 						//Soal Berapa
								"<tr><td ><b>13. </b></td><td>"+
								jawaban
								+"</td><td ><a href='<?= base_url(); ?>files/"+obj.filename+"' target='_blank' class='btn btn-sm btn-success'><i class='fa fa-download'></i> "+obj.name+"</a></td></tr>"
							);
						}else{
							$( "#soal13" ).html( 						//Soal Berapa
								"<tr><td ><b>13. </b></td><td>"+
								jawaban
								+"</td><td>"+data['202006X109X2773']+"</td></tr>"
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
						if(data['202006X109X2774'] != null){//File
							$( "#soal13" ).html( 						//Soal Berapa
								"<tr><td ><b>13. </b></td><td>"+
								jawaban
								+"</td><td ><a href='<?= base_url(); ?>files/"+obj.filename+"' target='_blank' class='btn btn-sm btn-success'><i class='fa fa-download'></i> "+obj.name+"</a></td></tr>"
							);
						}else{
							$( "#soal13" ).html( 						//Soal Berapa
								"<tr><td ><b>13. </b></td><td>"+
								jawaban
								+"</td><td>"+data['202006X109X2773']+"</td></tr>"
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
						if(data['202006X110X2777'] != null){//File
							$( "#soal14" ).html( 						//Soal Berapa
								"<tr><td ><b>14. </b></td><td>"+
								jawaban
								+"</td><td ><a href='<?= base_url(); ?>files/"+obj.filename+"' target='_blank' class='btn btn-sm btn-success'><i class='fa fa-download'></i> "+obj.name+"</a></td></tr>"
							);
						}else{
							$( "#soal14" ).html( 						//Soal Berapa
								"<tr><td ><b>14. </b></td><td>"+
								jawaban
								+"</td><td>"+data['202006X110X2776']+"</td></tr>"
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
						if(data['202006X111X2780'] != null){//File
							$( "#soal15" ).html( 						//Soal Berapa
								"<tr><td ><b>15. </b></td><td>"+
								jawaban
								+"</td><td ><a href='<?= base_url(); ?>files/"+obj.filename+"' target='_blank' class='btn btn-sm btn-success'><i class='fa fa-download'></i> "+obj.name+"</a></td></tr>"
							);
						}else{
							$( "#soal15" ).html( 						//Soal Berapa
								"<tr><td ><b>15. </b></td><td>"+
								jawaban
								+"</td><td>"+data['202006X111X2779']+"</td></tr>"
							);							//Teks
						}
					}else{
						$( "#soal15" ).html(
							"<tr><td ><b>15. </b></td><td>"+
							"Simulasi/drill MERP tidak dilakukan"
							+"</td><td> - </td></tr>"
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
						if(data['202006X112X2783'] != null){//File
							$( "#soal16" ).html( 						//Soal Berapa
								"<tr><td colspan='3' class='text-center'><b>PEOPLE</b></td></tr><tr><td ><b>1. </b></td><td>"+
								jawaban
								+"</td><td ><a href='<?= base_url(); ?>files/"+obj.filename+"' target='_blank' class='btn btn-sm btn-success'><i class='fa fa-download'></i> "+obj.name+"</a></td></tr>"
							);
						}else{
							$( "#soal16" ).html( 						//Soal Berapa
								"<tr><td colspan='3' class='text-center'><b>PEOPLE</b></td></tr><tr><td ><b>1. </b></td><td>"+
								jawaban
								+"</td><td>"+data['202006X112X2782']+"</td></tr>"
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
						if(data['202006X112X2783'] != null){//File
							$( "#soal16" ).html( 						//Soal Berapa
								"<tr><td colspan='3' class='text-center'><b>PEOPLE</b></td></tr><tr><td ><b>1. </b></td><td>"+
								jawaban
								+"</td><td ><a href='<?= base_url(); ?>files/"+obj.filename+"' target='_blank' class='btn btn-sm btn-success'><i class='fa fa-download'></i> "+obj.name+"</a></td></tr>"
							);
						}else{
							$( "#soal16" ).html( 						//Soal Berapa
								"<tr><td colspan='3' class='text-center'><b>PEOPLE</b></td></tr><tr><td ><b>1. </b></td><td>"+
								jawaban
								+"</td><td>"+data['202006X112X2782']+"</td></tr>"
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
						if(data['202006X113X2786'] != null){//File
							$( "#soal17" ).html( 						//Soal Berapa
								"<tr><td ><b>2. </b></td><td>"+
								jawaban
								+"</td><td ><a href='<?= base_url(); ?>files/"+obj.filename+"' target='_blank' class='btn btn-sm btn-success'><i class='fa fa-download'></i> "+obj.name+"</a></td></tr>"
							);
						}else{
							$( "#soal17" ).html( 						//Soal Berapa
								"<tr><td ><b>2. </b></td><td>"+
								jawaban
								+"</td><td>"+data['202006X113X2785']+"</td></tr>"
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
						if(data['202006X114X2789'] != null){//File
							$( "#soal18" ).html( 						//Soal Berapa
								"<tr><td ><b>3. </b></td><td>"+
								jawaban
								+"</td><td ><a href='<?= base_url(); ?>files/"+obj.filename+"' target='_blank' class='btn btn-sm btn-success'><i class='fa fa-download'></i> "+obj.name+"</a></td></tr>"
							);
						}else{
							$( "#soal18" ).html( 						//Soal Berapa
								"<tr><td ><b>3. </b></td><td>"+
								jawaban
								+"</td><td>"+data['202006X114X2788']+"</td></tr>"
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
						if(data['202006X115X2792'] != null){//File
							$( "#soal19" ).html( //Soal ke Berapa
								"<tr><td ><b>4. </b></td><td>"+
								jawaban
								+"</td><td ><a href='<?= base_url(); ?>files/"+obj.filename+"' target='_blank' class='btn btn-sm btn-success'><i class='fa fa-download'></i> "+obj.name+"</a></td></tr>"
							);
						}else{
							$( "#soal19" ).html( //Soal ke Berapa
								"<tr><td ><b>4. </b></td><td>"+
								jawaban
								+"</td><td>"+data['202006X115X2791']+"</td></tr>"
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
						if(data['202006X116X2795'] != null){//File
							$( "#soal20" ).html( //Soal ke Berapa
								"<tr><td ><b>5. </b></td><td>"+
								jawaban
								+"</td><td ><a href='<?= base_url(); ?>files/"+obj.filename+"' target='_blank' class='btn btn-sm btn-success'><i class='fa fa-download'></i> "+obj.name+"</a></td></tr>"
							);
						}else{
							$( "#soal20" ).html( //Soal ke Berapa
								"<tr><td ><b>5. </b></td><td>"+
								jawaban
								+"</td><td>"+data['202006X116X2794']+"</td></tr>"
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
						if(data['202006X117X2798'] != null){//File
							$( "#soal21" ).html( //Soal ke Berapa
								"<tr><td colspan='3' class='text-center'><b>PLANT</b></td></tr><tr><td ><b>1. </b></td><td>"+
								jawaban
								+"</td><td ><a href='<?= base_url(); ?>files/"+obj.filename+"' target='_blank' class='btn btn-sm btn-success'><i class='fa fa-download'></i> "+obj.name+"</a></td></tr>"
							);
						}else{
							$( "#soal21" ).html( //Soal ke Berapa
								"<tr><td colspan='3' class='text-center'><b>PLANT</b></td></tr><tr><td ><b>1. </b></td><td>"+
								jawaban
								+"</td><td>"+data['202006X117X2797']+"</td></tr>"
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
						if(data['202006X118X2801'] != null){//File
							$( "#soal22" ).html( //Soal ke Berapa
								"<tr><td ><b>2. </b></td><td>"+
								jawaban
								+"</td><td ><a href='<?= base_url(); ?>files/"+obj.filename+"' target='_blank' class='btn btn-sm btn-success'><i class='fa fa-download'></i> "+obj.name+"</a></td></tr>"
							);
						}else{
							$( "#soal22" ).html( //Soal ke Berapa
								"<tr><td ><b>2. </b></td><td>"+
								jawaban
								+"</td><td>"+data['202006X118X2800']+"</td></tr>"
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
						if(data['202006X119X2804'] != null){//File
							$( "#soal23" ).html( //Soal ke Berapa
								"<tr><td ><b>3. </b></td><td>"+
								jawaban
								+"</td><td ><a href='<?= base_url(); ?>files/"+obj.filename+"' target='_blank' class='btn btn-sm btn-success'><i class='fa fa-download'></i> "+obj.name+"</a></td></tr>"
							);
						}else{
							$( "#soal23" ).html( //Soal ke Berapa
								"<tr><td ><b>3. </b></td><td>"+
								jawaban
								+"</td><td>"+data['202006X119X2803']+"</td></tr>"
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
						if(data['202006X120X2807'] != null){//File
							$( "#soal24" ).html( //Soal ke Berapa
								"<tr><td ><b>4. </b></td><td>"+
								jawaban
								+"</td><td ><a href='<?= base_url(); ?>files/"+obj.filename+"' target='_blank' class='btn btn-sm btn-success'><i class='fa fa-download'></i> "+obj.name+"</a></td></tr>"
							);
						}else{
							$( "#soal24" ).html( //Soal ke Berapa
								"<tr><td ><b>4. </b></td><td>"+
								jawaban
								+"</td><td>"+data['202006X120X2806']+"</td></tr>"
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
						if(data['202006X121X2810'] != null){//File
							$( "#soal25" ).html( //Soal ke Berapa
								"<tr><td ><b>5. </b></td><td>"+
								jawaban
								+"</td><td ><a href='<?= base_url(); ?>files/"+obj.filename+"' target='_blank' class='btn btn-sm btn-success'><i class='fa fa-download'></i> "+obj.name+"</a></td></tr>"
							);
						}else{
							$( "#soal25" ).html( //Soal ke Berapa
								"<tr><td ><b>5. </b></td><td>"+
								jawaban
								+"</td><td>"+data['202006X121X2809']+"</td></tr>"
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
						if(data['202006X124X2856'] != null){//File
							$( "#soal26" ).html( //Soal ke Berapa
								"<tr><td ><b>6. </b></td><td>"+
								jawaban
								+"</td><td ><a href='<?= base_url(); ?>files/"+obj.filename+"' target='_blank' class='btn btn-sm btn-success'><i class='fa fa-download'></i> "+obj.name+"</a></td></tr>"
							);
						}else{
							$( "#soal26" ).html( //Soal ke Berapa
								"<tr><td ><b>6. </b></td><td>"+
								jawaban
								+"</td><td>"+data['202006X124X2855']+"</td></tr>"
							);							//Teks
						}
					}
					//------ End Soal 26 ----------
				}
			});
		});
	});
</script>

    