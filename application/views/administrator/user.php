		<!-- <div class="pd-ltr-20 xs-pd-20-10">
			<div class="min-height-200px">
				<div class="page-header">
					<div class="row">
						<div class="col-md-6 col-sm-12">
							<div class="title">
								<h4><?= $title_page; ?></h4>
							</div>
						</div>
						<div class="col-md-6 col-sm-12 text-right">
							<div class="dropdown">
								<a href="#" class="btn-sm btn-primary" data-toggle="modal" data-target="#formModal" data-url="<?= base_url(); ?>" id="addNewMenu">Add New Role</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div> -->
<!-- DataTales Example -->
<div class="container mt-3">
	<div class="card shadow mb-4">
		<div class="card-header py-3 d-flex justify-content-between">
		  	<h6 class="m-0 font-weight-bold text-primary"><?= $title_page; ?></h6>
		  	<a href="<?= base_url(); ?>auth/registrasion" class="btn-sm btn-primary">Add New User</a>
		</div>
		<div class="card-body">
			<div class="table-responsive">
			    <table class="table table-bordered table-striped table-hover" id="postsList" width="100%" cellspacing="0">
			      <thead>
			        <tr>
						<th>No</th>
						<th>Nama</th>
						<th>Email</th>
						<th>Unit Operasi</th>
						<th>Role</th>
						<th>Action</th>
			        </tr>
			      </thead>
			      <tbody>
			      	<?php 
			      	$number = 0;
			      	foreach($users as $r): ?>
			      	<tr>
			      		<td><?= ++$number; ?></td>
			      		<td><?= $r['name']; ?></td>
			      		<td><?= $r['email']; ?></td>
			      		<td><?= $r['unit']; ?></td>
			      		<td><?= $r['role']; ?></td>
			      		<td style="width: 5%; min-width: 150px;">
			      			<a href="#" class="btn-sm btn-warning p-2 tampilModalUbah" data-id="<?= $r['id']; ?>" data-url="<?= base_url(); ?>" data-toggle="modal" data-target="#formModal">Edit</a>		
							<a href="#" class="btn-sm btn-danger p-2 tampilModalAlert" data-id="<?= $r['id']; ?>" data-url="<?= base_url(); ?>" data-toggle="modal" data-target="#alertModal">Delete</a>		
			      		</td>
			      	</tr>
				    <?php endforeach; ?>
			      </tbody>
			    </table>
			</div>
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
                            <input type="text" name="inputName" class="form-control" required="" id="formModalInput" placeholder="Nama Lengkap">
                        </div>
                        <div class="form-group">
                            <input type="email" name="inputEmail" class="form-control" required="" id="formModalInput" placeholder="Email">
                        </div>
                        <div class="form-group">
                            <select name="inputRole" id="inputRole" class="form-control selectpicker">
                                <?php foreach($role as $s): ?>
                                    <option value="<?= $s['id']; ?>"><?= $s['role']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <select name="inputUnit" id="inputUnit" class="form-control selectpicker" data-live-search="true">
                                <?php foreach($unit as $u): ?>
                                    <option value="<?= $u['id']; ?>"><?= $u['unit']; ?></option>
                                <?php endforeach; ?>
                            </select>
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
			$('#formModalLabel').html('Edit Menu');
			$('#formModalBtn').html('Edit');
			$('#formModalAction').attr('action', url + 'administrator/useredit');
			$.ajax({
				url: url + 'administrator/userdetail',
				data: {id: id},
				method: 'post',
				dataType: 'json',
				success: function(data){
					$('input[name=id]').val(data['id']);
					$('input[name=inputName]').val(data['name']);
					$('input[name=inputEmail]').val(data['email']);
					$('option[value='+ data.role_id +']').attr('selected','');
					$('option[value='+ data.unit +']').attr('selected','');
				}
			});
		});
	});
</script>