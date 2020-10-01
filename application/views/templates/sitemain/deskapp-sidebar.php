<div class="left-side-bar">
		<div class="brand-logo">
			<a href="index.php">
				<img src="<?= base_url(); ?>assets/deskapp/src/images/pertamina.png" alt="" class="dark-logo">
				<img src="<?= base_url(); ?>assets/deskapp/src/images/pertamina-w.png" alt="" class="light-logo">
			</a>
			<div class="close-sidebar" data-toggle="left-sidebar-close">
				<i class="ion-close-round"></i>
			</div>
		</div>
		<div class="menu-block customscroll">
			<div class="sidebar-menu">
				<ul id="accordion-menu">
                
                    <li>
						<div class="dropdown-divider"></div>
					</li>
                    <?php 
                        $role_id = $user['role_id'];
                        $queryMenu = "
                                        SELECT `user_menu`.`id`, `menu`
                                        FROM `user_menu` JOIN `user_access_menu`
                                            ON `user_menu` . `id` = `user_access_menu` . `menu_id` 
                                        WHERE `user_access_menu` . `role_id` = $role_id
                                        ORDER BY `user_access_menu` . `menu_id` ASC
                        ";
                        $menu = $this->db->query($queryMenu)->result_array();
                    ?>
                    
                <!-- looping menu -->
                <?php foreach($menu as $m): ?>
                    <!-- Heading -->
					<li>
						<div class="sidebar-small-cap"><?= $m['menu']; ?></div>
					</li>
					<li>
						<div class="dropdown-divider"></div>
					</li>
                        
                <!-- menyiapkan sub-sub menu-->
                    <?php 
                        $menuId = $m['id'];
                        $querySubMenu = "
                                    SELECT *
                                    FROM `user_sub_menu` JOIN `user_menu`
                                        ON `user_sub_menu` . `menu_id` = `user_menu` . `id` 
                                    WHERE `user_sub_menu` . `menu_id` = $menuId
                                    AND `user_sub_menu` . `is_active` = 1
                        ";
                        $subMenu = $this->db->query($querySubMenu)->result_array();
                    ?>
                    <?php foreach($subMenu as $sm): ?>
                        <?php if($title_page == $sm['title']): ?>
                        <li class="dropdown show">
                        <?php else: ?>
                        <li>
                        <?php endif; ?>
                            <a href="<?= base_url($sm['url']); ?>" class="dropdown-toggle no-arrow">
                                <span class="<?= $sm['icon']; ?>"></span><span class="mtext"><?= $sm['title']; ?></span>
                            </a>
                        </li>
                    <?php endforeach; ?>

                    <!-- Divider -->
                    <li>
						<div class="dropdown-divider"></div>
					</li>
                <?php endforeach;?>
                    <li>
                        <a href="#"  data-toggle="modal" data-target="#logoutModal" class="dropdown-toggle no-arrow">
                            <span class="micon dw dw-logout"></span><span class="mtext">Logout</span>
                        </a>
                    </li>
                

				</ul>
			</div>
		</div>
	</div>
	<div class="mobile-menu-overlay"></div>