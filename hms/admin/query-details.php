<?php
session_start();
error_reporting(0);
include('include/config.php');
if(strlen($_SESSION['id']==0)) {
 header('location:logout.php');
  } else{

//updating Admin Remark
if(isset($_POST['update']))
		  {
$qid=intval($_GET['id']);
$adminremark=$_POST['adminremark'];
$isread=1;
$query=mysqli_query($con,"update tblcontactus set  AdminRemark='$adminremark',IsRead='$isread' where id='$qid'");
if($query){
echo "<script>alert('Catatan admin berhasil diperbarui.');</script>";
echo "<script>window.location.href ='read-query.php'</script>";
}
		  }
?>
<!DOCTYPE html>
<html lang="id">
	<head>
		<title>Admin | Detail Pertanyaan</title>
		
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
		<style>
			/* Styling Tabel Detail Clean & Polos */
			.table {
				width: 100%;
				border-collapse: collapse;
				margin-bottom: 20px;
				background-color: #ffffff;
				border: 1px solid #ddd;
			}
			
			.table tbody th {
				background-color: #f9f9f9;
				color: #333;
				font-weight: 600;
				border: 1px solid #ddd;
				padding: 12px 15px;
				text-align: left;
				font-size: 13px;
				width: 30%;
			}
			
			.table tbody td {
				padding: 12px 15px;
				border: 1px solid #ddd;
				color: #555;
				font-size: 13px;
				vertical-align: middle;
			}
			
			.table tbody tr {
				background-color: #ffffff;
				transition: background-color 0.2s ease;
			}
			
			.table tbody tr:hover {
				background-color: #f5f5f5;
			}
			
			/* Styling Form */
			.form-control {
				border: 1px solid #ddd;
				border-radius: 4px;
				padding: 8px 12px;
				font-size: 13px;
				transition: border-color 0.2s ease;
			}
			
			.form-control:focus {
				border-color: #337ab7;
				outline: none;
				box-shadow: 0 0 0 2px rgba(51, 122, 183, 0.1);
			}
			
			/* Styling Button */
			.btn-primary {
				background-color: #337ab7;
				border: 1px solid #2e6da4;
				color: #ffffff;
				padding: 8px 16px;
				font-size: 13px;
				border-radius: 4px;
				cursor: pointer;
				transition: all 0.2s ease;
			}
			
			.btn-primary:hover {
				background-color: #286090;
				border-color: #204d74;
			}
			
			.btn-primary i {
				margin-left: 5px;
			}
			
			/* Container styling */
			.over-title {
				color: #333;
				font-size: 16px;
				margin-bottom: 20px;
			}
			
			hr {
				border: 0;
				border-top: 1px solid #ddd;
				margin: 20px 0;
			}
		</style>
	</head>
	<body>
		<div id="app">		
<?php include('include/sidebar.php');?>
			<div class="app-content">
				
						<?php include('include/header.php');?>
					
				<!-- end: TOP NAVBAR -->
				<div class="main-content" >
					<div class="wrap-content container" id="container">
						<!-- start: PAGE TITLE -->
						<section id="page-title">
							<div class="row">
								<div class="col-sm-8">
									<h1 class="mainTitle">Admin | Detail Pertanyaan</h1>
								</div>

								<ol class="breadcrumb">
									<li>
										<span>Admin</span>
									</li>
									<li class="active">
										<span>Detail Pertanyaan</span>
									</li>
								</ol>
							</div>
						</section>
						<!-- end: PAGE TITLE -->
						<!-- start: BASIC EXAMPLE -->
						<div class="container-fluid container-fullw bg-white">
						

									<div class="row">
								<div class="col-md-12">
									<h5 class="over-title margin-bottom-15">Kelola <span class="text-bold">Detail Pertanyaan</span></h5>
												<hr />
									<table class="table table-hover" id="sample-table-1">
		
										<tbody>
<?php
$qid=intval($_GET['id']);
$sql=mysqli_query($con,"select * from tblcontactus where id='$qid'");
$cnt=1;
while($row=mysqli_fetch_array($sql))
{
?>

											<tr>
												<th>Nama Lengkap</th>
												<td><?php echo $row['fullname'];?></td>
											</tr>

											<tr>
												<th>Email</th>
												<td><?php echo $row['email'];?></td>
											</tr>
											<tr>
												<th>Nomor Kontak</th>
												<td><?php echo $row['contactno'];?></td>
											</tr>
											<tr>
												<th>Pesan</th>
												<td><?php echo $row['message'];?></td>
											</tr>

											<tr>
												<th>Tanggal Pertanyaan</th>
												<td><?php echo $row['PostingDate'];?></td>
											</tr>

<?php if($row['AdminRemark']==""){?>	
<form name="query" method="post">
	<tr>
		<th>Catatan Admin</th>
		<td><textarea name="adminremark" class="form-control" rows="4" required="true" placeholder="Masukkan catatan atau tanggapan admin..."></textarea></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>	
			<button type="submit" class="btn btn-primary pull-left" name="update">
				Perbarui <i class="fa fa-arrow-circle-right"></i>
			</button>
		</td>
	</tr>
</form>												
<?php } else {?>										
	
	<tr>
		<th>Catatan Admin</th>
		<td><?php echo $row['AdminRemark'];?></td>
	</tr>

	<tr>
		<th>Tanggal Pembaruan Terakhir</th>
		<td><?php echo $row['LastupdationDate'];?></td>
	</tr>
											
<?php 
 }} ?>
											
											
										</tbody>
									</table>
								</div>
							</div>
								</div>
							</div>
						</div>
						<!-- end: BASIC EXAMPLE -->
						<!-- end: SELECT BOXES -->
						
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