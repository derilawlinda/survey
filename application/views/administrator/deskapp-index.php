
		<div class="xs-pd-20-10 pd-ltr-20">
			<div class="page-header">
				<div class="row">
					<div class="col-md-6 col-sm-12">
						<div class="title">
							<h4><?php echo $title_page; ?></h4>
						</div>
						<!-- <nav aria-label="breadcrumb" role="navigation">
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="index.php">Home</a></li>
								<li class="breadcrumb-item active" aria-current="page">Dashboard</li>
							</ol>
						</nav> -->
					</div>
					<div class="col-md-6 col-sm-12 text-right">
						<!-- <h4></h4> -->
					</div>
				</div>
			</div>
			<div class="row clearfix progress-box">
                <div class="card-box col-lg-9 pd-20 height-100-p mb-30">
                    <div class="row align-items-center">
                        <div class="col-md-4">
                            <img src="<?= base_url(); ?>assets/deskapp/vendors/images/banner-img.png" alt="">
                        </div>
                        <div class="col-md-8">
                            <h4 class="font-20 weight-500 mb-10 text-capitalize">
                                Welcome back <div class="weight-600 font-30 text-blue"><?= $user['name']; ?>!</div>
                            </h4>
                            <p class="font-18 max-width-600">Kode warna berbasis resiko</p>
                        </div>
                    </div>
                </div>
				<div class="col-lg-3 col-md-6 col-sm-12 mb-30">
					<div class="card-box pd-30 height-100-p">
						<div class="progress-box text-center">
							 <input type="text" class="knob dial1" value="<?php echo $merah; ?>" data-width="120" data-height="120" data-linecap="round" data-thickness="0.12" data-bgColor="#fff" data-fgColor="#ff0000" data-angleOffset="180" readonly>
							<h5 class="text-danger padding-top-10 h5">NOT ACCEPTABLE</h5>
							<span class="d-block">HIGH RISK MERP</span>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-6 col-sm-12 mb-30">
					<div class="card-box pd-30 height-100-p">
						<div class="progress-box text-center">
							 <input type="text" class="knob dial2" value="<?php echo $oren; ?>" data-width="120" data-height="120" data-linecap="round" data-thickness="0.12" data-bgColor="#fff" data-fgColor="#fd7500" data-angleOffset="180" readonly>
							<h5 class="text-orange padding-top-10 h5">NOT TOLERABLE</h5>
							<span class="d-block">MEDIUM RISK MERP</span>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-6 col-sm-12 mb-30">
					<div class="card-box pd-30 height-100-p">
						<div class="progress-box text-center">
							 <input type="text" class="knob dial3" value="<?php echo $kuning; ?>" data-width="120" data-height="120" data-linecap="round" data-thickness="0.12" data-bgColor="#fff" data-fgColor="#fdf500" data-angleOffset="180" readonly>
							<h5 class="text-yellow padding-top-10 h5">TOLERABLE / ADEQUATE</h5>
							<span class="d-block">LOW RISK MERP</span>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-6 col-sm-12 mb-30">
					<div class="card-box pd-30 height-100-p">
						<div class="progress-box text-center">
							 <input type="text" class="knob dial4" value="<?php echo $ijomuda; ?>" data-width="120" data-height="120" data-linecap="round" data-thickness="0.12" data-bgColor="#fff" data-fgColor="#00e091" data-angleOffset="180" readonly>
							<h5 class="text-light-green padding-top-10 h5">ACCEPTABLE</h5>
							<span class="d-block">FULLY ADEQUATE MERP</span>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-6 col-sm-12 mb-30">
					<div class="card-box pd-30 height-100-p">
						<div class="progress-box text-center">
							 <input type="text" class="knob dial5" value="<?php echo $ijo; ?>" data-width="120" data-height="120" data-linecap="round" data-thickness="0.12" data-bgColor="#fff" data-fgColor="#2c8f64" data-angleOffset="180" readonly>
							<h5 class="text-green padding-top-10 h5">EXCELLENCE</h5>
							<span class="d-block">GOOD MERP</span>
						</div>
					</div>
				</div>
			</div>
			
