    <!-- <div class="pre-loader">
		<div class="pre-loader-box">
			<div class="loader-logo"><img src="<?= base_url(); ?>assets/deskapp/src/images/pertamina.png" alt=""></div>
			<div class='loader-progress' id="progress_div">
				<div class='bar' id='bar1'></div>
			</div>
			<div class='percent' id='percent1'>0%</div>
			<div class="loading-text">
				Mohon menunggu...
			</div>
		</div>
	</div> -->

	<div class="header">
		<div class="header-left">
			<div class="menu-icon dw dw-menu"></div>
		</div>
		<div class="header-right">
			<div class="user-info-dropdown">
				<div class="dropdown">
					<a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown">
						<span class="user-icon">
							<img src="<?= base_url('assets/img/profile/') . $user['image']; ?>" alt="">
						</span>
						<span class="user-name"><?= $user['name']; ?></span>
					</a>
					<div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                            <?php
                                if ($user['role_id'] == 1) {
                                    $role_id = 'administrator';
                                }elseif ($user['role_id'] == 2) {
                                    $role_id = 'user';
                                }
                            ?>
						<a class="dropdown-item" href="<?= base_url('user'); ?>"><i class="dw dw-user1"></i> Profile</a>
						<!-- <a class="dropdown-item" href="profile.php"><i class="dw dw-settings2"></i> Setting</a> -->
						<!-- <a class="dropdown-item" href="faq.php"><i class="dw dw-help"></i> Help</a> -->
						<a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal"><i class="dw dw-logout"></i> Log Out</a>
					</div>
				</div>
			</div>
		</div>
	</div>
                    
							<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
								<div class="modal-dialog modal-sm modal-dialog-centered">
									<div class="modal-content">
										<div class="modal-header">
											<h4 class="modal-title" id="myLargeModalLabel">Ready to leave?</h4>
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
										</div>
										<div class="modal-body">
											<p>Select "Logout" below if you are ready to end your current session.</p>
										</div>
										<div class="modal-footer">
                                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                            <a class="btn btn-primary" href="<?= base_url(); ?>auth/logout">Logout</a>
										</div>
									</div>
								</div>
							</div>

            <?php if($this->session->flashdata('titleFlash')): ?>
                <div class="alert alert-<?= $this->session->flashdata('colorFlash'); ?> alert-dismissible fade show m-3" role="alert">
                    <strong><?= $this->session->flashdata('titleFlash'); ?>!</strong> <?= $this->session->flashdata('captionFlash'); ?>.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif ?>