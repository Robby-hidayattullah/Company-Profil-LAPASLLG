<?php
session_start();
//error_reporting(0);
include('include/config.php');
if(strlen($_SESSION['id']==0)) {
 header('location:logout.php');
  } else{

date_default_timezone_set('Asia/Kolkata');// change according timezone
$currentTime = date( 'd-m-Y h:i:s A', time () );

if(isset($_POST['submit']))
{
    $cpass = md5($_POST['cpass']);  // PERBAIKAN: Hash password lama dengan md5
    $uname = $_SESSION['login'];
    
    // PERBAIKAN: Cek password lama dengan md5
    $sql = mysqli_query($con, "SELECT password FROM admin WHERE password='$cpass' AND username='$uname'");
    $num = mysqli_num_rows($sql);
    
    if($num > 0)
    {
        $npass = md5($_POST['npass']);  // PERBAIKAN: Hash password baru dengan md5
        $updateQuery = mysqli_query($con, "UPDATE admin SET password='$npass', updationDate='$currentTime' WHERE username='$uname'");
        
        if($updateQuery) {
            $_SESSION['msg1'] = "Password Berhasil Diubah!";
        } else {
            $_SESSION['msg1'] = "Gagal mengubah password. Error: " . mysqli_error($con);
        }
    }
    else
    {
        $_SESSION['msg1'] = "Password Lama Tidak Sesuai!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Admin | Change Password</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta content="" name="description" />
		<meta content="" name="author" />
		<link href="http://fonts.googleapis.com/css?family=Lato:300,400,400italic,600,700|Raleway:300,400,500,600,700|Crete+Round:400italic" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="vendor/themify-icons/themify-icons.min.css">
		<link href="vendor/animate.css/animate.min.css" rel="stylesheet" media="screen">
		<link href="vendor/perfect-scrollbar/perfect-scrollbar.min.css" rel="stylesheet" media="screen">
		<link href="vendor/switchery/switchery.min.css" rel="stylesheet" media="screen">
		<link href="vendor/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet" media="screen">
		<link href="vendor/select2/select2.min.css" rel="stylesheet" media="screen">
		<link href="vendor/bootstrap-datepicker/bootstrap-datepicker3.standalone.min.css" rel="stylesheet" media="screen">
		<link href="vendor/bootstrap-timepicker/bootstrap-timepicker.min.css" rel="stylesheet" media="screen">
		<link rel="stylesheet" href="assets/css/styles.css">
		<link rel="stylesheet" href="assets/css/plugins.css">
		<link rel="stylesheet" href="assets/css/themes/theme-1.css" id="skin_color" />

<script type="text/javascript">
function valid()
{
    if(document.chngpwd.cpass.value=="")
    {
        alert("Password Saat Ini Tidak Boleh Kosong!!");
        document.chngpwd.cpass.focus();
        return false;
    }
    else if(document.chngpwd.npass.value=="")
    {
        alert("Password Baru Tidak Boleh Kosong!!");
        document.chngpwd.npass.focus();
        return false;
    }
    else if(document.chngpwd.npass.value.length < 6)
    {
        alert("Password Baru Minimal 6 Karakter!!");
        document.chngpwd.npass.focus();
        return false;
    }
    else if(document.chngpwd.cfpass.value=="")
    {
        alert("Konfirmasi Password Tidak Boleh Kosong!!");
        document.chngpwd.cfpass.focus();
        return false;
    }
    else if(document.chngpwd.npass.value != document.chngpwd.cfpass.value)
    {
        alert("Password Baru dan Konfirmasi Password Tidak Sama!!");
        document.chngpwd.cfpass.focus();
        return false;
    }
    return true;
}
</script>

	</head>
	<body>
		<div id="app">		
<?php include('include/sidebar.php');?>
			<div class="app-content">
				
						<?php include('include/header.php');?>
		
				</header>
				<!-- end: TOP NAVBAR -->
				<div class="main-content" >
					<div class="wrap-content container" id="container">
						<!-- start: PAGE TITLE -->
						<section id="page-title">
							<div class="row">
								<div class="col-sm-8">
									<h1 class="mainTitle">Admin | Change Password</h1>
								</div>
								<ol class="breadcrumb">
									<li>
										<span>Admin</span>
									</li>
									<li class="active">
										<span>Change Password</span>
									</li>
								</ol>
							</div>
						</section>
						<!-- end: PAGE TITLE -->
						<!-- start: BASIC EXAMPLE -->
						<div class="container-fluid container-fullw bg-white">
							<div class="row">
								<div class="col-md-12">
									
									<div class="row margin-top-30">
										<div class="col-lg-8 col-md-12">
											<div class="panel panel-white">
												<div class="panel-heading">
													<h5 class="panel-title">Ubah Password</h5>
												</div>
												<div class="panel-body">
													<p style="color:red;">
														<?php 
														if(isset($_SESSION['msg1']) && $_SESSION['msg1'] != "") {
															echo htmlentities($_SESSION['msg1']);
															$_SESSION['msg1'] = "";
														}
														?>
													</p>	
													<form role="form" name="chngpwd" method="post" onSubmit="return valid();">
														<div class="form-group">
															<label for="cpass">
																Password Saat Ini
															</label>
															<input type="password" name="cpass" id="cpass" class="form-control" placeholder="Masukkan Password Saat Ini" required>
														</div>

														<div class="form-group">
															<label for="npass">
																Password Baru
															</label>
															<input type="password" name="npass" id="npass" class="form-control" placeholder="Masukkan Password Baru" required>
														</div>
														
														<div class="form-group">
															<label for="cfpass">
																Konfirmasi Password
															</label>
															<input type="password" name="cfpass" id="cfpass" class="form-control" placeholder="Konfirmasi Password Baru" required>
														</div>
														
														<button type="submit" name="submit" class="btn btn-o btn-primary">
															<i class="fa fa-save"></i> Simpan Perubahan
														</button>
													</form>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- end: BASIC EXAMPLE -->
					</div>
				</div>
			</div>
			<!-- start: FOOTER -->
	<?php include('include/footer.php');?>
			<!-- end: FOOTER -->
		
			<!-- start: SETTINGS -->
	<?php include('include/setting.php');?>
		
			<!-- end: SETTINGS -->
		</div>
		<!-- start: MAIN JAVASCRIPTS -->
		<script src="vendor/jquery/jquery.min.js"></script>
		<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
		<script src="vendor/modernizr/modernizr.js"></script>
		<script src="vendor/jquery-cookie/jquery.cookie.js"></script>
		<script src="vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
		<script src="vendor/switchery/switchery.min.js"></script>
		<!-- end: MAIN JAVASCRIPTS -->
		<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
		<script src="vendor/maskedinput/jquery.maskedinput.min.js"></script>
		<script src="vendor/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js"></script>
		<script src="vendor/autosize/autosize.min.js"></script>
		<script src="vendor/selectFx/classie.js"></script>
		<script src="vendor/selectFx/selectFx.js"></script>
		<script src="vendor/select2/select2.min.js"></script>
		<script src="vendor/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
		<script src="vendor/bootstrap-timepicker/bootstrap-timepicker.min.js"></script>
		<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
		<!-- start: CLIP-TWO JAVASCRIPTS -->
		<script src="assets/js/main.js"></script>
		<!-- start: JavaScript Event Handlers for this page -->
		<script src="assets/js/form-elements.js"></script>
		<script>
			jQuery(document).ready(function() {
				Main.init();
				FormElements.init();
			});
		</script>
		<!-- end: JavaScript Event Handlers for this page -->
		<!-- end: CLIP-TWO JAVASCRIPTS -->
	</body>
</html>
<?php } ?>