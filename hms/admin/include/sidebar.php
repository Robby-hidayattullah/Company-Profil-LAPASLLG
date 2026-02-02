<?php
// sidebar.php - Sidebar Menu Admin Panel
// STYLING AWAL TETAP SAMA - HANYA MENAMBAHKAN MENU INFORMASI PUBLIK
?>
<div class="sidebar app-aside" id="sidebar">
	<div class="sidebar-container perfect-scrollbar">
		<nav>
			<!-- MENU NAVIGASI UTAMA -->
			<div class="navbar-title">
				<span>Menu Navigasi Utama</span>
			</div>
			
			<ul class="main-navigation-menu">
				<!-- Dashboard -->
				<li class="<?php echo (basename($_SERVER['PHP_SELF']) == 'dashboard.php') ? 'active' : ''; ?>">
					<a href="dashboard.php">
						<div class="item-content">
							<div class="item-media">
								<i class="ti-home"></i>
							</div>
							<div class="item-inner">
								<span class="title">Dashboard</span>
							</div>
						</div>
					</a>
				</li>

				<!-- Pertanyaan Hubungi Kami -->
				<?php 
				$queryPages = array('unread-queries.php', 'read-query.php', 'query-details.php');
				$isQueryActive = in_array(basename($_SERVER['PHP_SELF']), $queryPages);
				?>
				<li class="<?php echo $isQueryActive ? 'active open' : ''; ?>">
					<a href="javascript:void(0)" class="menu-toggle">
						<div class="item-content">
							<div class="item-media">
								<i class="ti-email"></i>
							</div>
							<div class="item-inner">
								<span class="title">Pertanyaan Hubungi Kami</span>
								<i class="icon-arrow"></i>
							</div>
						</div>
					</a>
					<ul class="sub-menu" style="<?php echo $isQueryActive ? 'display: block;' : 'display: none;'; ?>">
						<li class="<?php echo (basename($_SERVER['PHP_SELF']) == 'unread-queries.php') ? 'active' : ''; ?>">
							<a href="unread-queries.php">
								<span class="title">Belum Dibaca</span>
							</a>
						</li>
						<li class="<?php echo (basename($_SERVER['PHP_SELF']) == 'read-query.php' || basename($_SERVER['PHP_SELF']) == 'query-details.php') ? 'active' : ''; ?>">
							<a href="read-query.php">
								<span class="title">Sudah Dibaca</span>
							</a>
						</li>
					</ul>
				</li>

				<!-- Struktur Organisasi -->
				<li class="<?php echo (basename($_SERVER['PHP_SELF']) == 'struktur-organisasi.php') ? 'active' : ''; ?>">
					<a href="struktur-organisasi.php">
						<div class="item-content">
							<div class="item-media">
								<i class="ti-layout"></i>
							</div>
							<div class="item-inner">
								<span class="title">Struktur Organisasi</span>
							</div>
						</div>
					</a>
				</li>

				<!-- Berita -->
				<?php 
				$beritaPages = array('add-berita.php', 'manage-berita.php', 'edit-berita.php');
				$isBeritaActive = in_array(basename($_SERVER['PHP_SELF']), $beritaPages);
				?>
				<li class="<?php echo $isBeritaActive ? 'active open' : ''; ?>">
					<a href="javascript:void(0)" class="menu-toggle">
						<div class="item-content">
							<div class="item-media">
								<i class="ti-announcement"></i>
							</div>
							<div class="item-inner">
								<span class="title">Berita</span>
								<i class="icon-arrow"></i>
							</div>
						</div>
					</a>
					<ul class="sub-menu" style="<?php echo $isBeritaActive ? 'display: block;' : 'display: none;'; ?>">
						<li class="<?php echo (basename($_SERVER['PHP_SELF']) == 'add-berita.php') ? 'active' : ''; ?>">
							<a href="add-berita.php">
								<span class="title">Tambah Berita</span>
							</a>
						</li>
						<li class="<?php echo (basename($_SERVER['PHP_SELF']) == 'manage-berita.php' || basename($_SERVER['PHP_SELF']) == 'edit-berita.php') ? 'active' : ''; ?>">
							<a href="manage-berita.php">
								<span class="title">Kelola Berita</span>
							</a>
						</li>
					</ul>
				</li>

				<!-- Informasi Publik ✨ MENU BARU ✨ -->
				<?php 
				$informasiPages = array('add-informasi.php', 'manage-informasi.php');
				$isInformasiActive = in_array(basename($_SERVER['PHP_SELF']), $informasiPages);
				?>
				<li class="<?php echo $isInformasiActive ? 'active open' : ''; ?>">
					<a href="javascript:void(0)" class="menu-toggle">
						<div class="item-content">
							<div class="item-media">
								<i class="ti-files"></i>
							</div>
							<div class="item-inner">
								<span class="title">Informasi Publik</span>
								<i class="icon-arrow"></i>
							</div>
						</div>
					</a>
					<ul class="sub-menu" style="<?php echo $isInformasiActive ? 'display: block;' : 'display: none;'; ?>">
						<li class="<?php echo (basename($_SERVER['PHP_SELF']) == 'add-informasi.php') ? 'active' : ''; ?>">
							<a href="add-informasi.php">
								<span class="title">Tambah Informasi</span>
							</a>
						</li>
						<li class="<?php echo (basename($_SERVER['PHP_SELF']) == 'manage-informasi.php') ? 'active' : ''; ?>">
							<a href="manage-informasi.php">
								<span class="title">Kelola Informasi</span>
							</a>
						</li>
					</ul>
				</li>

				<!-- Halaman -->
				<?php 
				$halamanPages = array('about-us.php', 'contact.php');
				$isHalamanActive = in_array(basename($_SERVER['PHP_SELF']), $halamanPages);
				?>
				<li class="<?php echo $isHalamanActive ? 'active open' : ''; ?>">
					<a href="javascript:void(0)" class="menu-toggle">
						<div class="item-content">
							<div class="item-media">
								<i class="ti-files"></i>
							</div>
							<div class="item-inner">
								<span class="title">Halaman</span>
								<i class="icon-arrow"></i>
							</div>
						</div>
					</a>
					<ul class="sub-menu" style="<?php echo $isHalamanActive ? 'display: block;' : 'display: none;'; ?>">
						<li class="<?php echo (basename($_SERVER['PHP_SELF']) == 'about-us.php') ? 'active' : ''; ?>">
							<a href="about-us.php">
								<span class="title">Tentang Kami</span>
							</a>
						</li>
						<li class="<?php echo (basename($_SERVER['PHP_SELF']) == 'contact.php') ? 'active' : ''; ?>">
							<a href="contact.php">
								<span class="title">Hubungi Kami</span>
							</a>
						</li>
					</ul>
				</li>

			</ul>
		</nav>
	</div>
</div>

<style>
/* Styling Sidebar Sederhana - STYLING AWAL TETAP SAMA */
.sidebar .main-navigation-menu > li.active > a {
	background-color: #337ab7;
	color: #ffffff;
}

.sidebar .sub-menu {
	display: none;
	background-color: #f9f9f9;
}

.sidebar .main-navigation-menu > li.open .sub-menu {
	display: block;
}

.sidebar .sub-menu li.active a {
	color: #337ab7;
	font-weight: 600;
}

.sidebar .main-navigation-menu > li.open > a .icon-arrow {
	transform: rotate(90deg);
}
</style>

<script>
// JavaScript untuk Toggle Menu
document.addEventListener('DOMContentLoaded', function() {
	var menuToggles = document.querySelectorAll('.menu-toggle');
	
	menuToggles.forEach(function(toggle) {
		toggle.addEventListener('click', function(e) {
			e.preventDefault();
			var parentLi = this.parentElement;
			
			if (parentLi.classList.contains('open')) {
				parentLi.classList.remove('open');
			} else {
				parentLi.classList.add('open');
			}
		});
	});
});
</script>