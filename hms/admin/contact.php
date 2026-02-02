<?php
session_start();
error_reporting(0);
include('include/config.php');
if(strlen($_SESSION['id']==0)) {
 header('location:logout.php');
  } else{
//Code for Update the Content

if(isset($_POST['submit']))
  {
   
     // Sanitasi input data
     $pagetitle = isset($_POST['pagetitle']) ? trim($_POST['pagetitle']) : '';
     $pagedes = isset($_POST['pagedes']) ? trim($_POST['pagedes']) : '';
     $email = isset($_POST['email']) ? trim($_POST['email']) : '';
     $mobnum = isset($_POST['mobnum']) ? trim($_POST['mobnum']) : '';
     $address = isset($_POST['address']) ? trim($_POST['address']) : '';
     $whatsapp = isset($_POST['whatsapp']) ? trim($_POST['whatsapp']) : '';
     $facebook = isset($_POST['facebook']) ? trim($_POST['facebook']) : '';
     $instagram = isset($_POST['instagram']) ? trim($_POST['instagram']) : '';
     $tiktok = isset($_POST['tiktok']) ? trim($_POST['tiktok']) : '';
     
     // Validasi input
     $errors = array();
     
     if(empty($pagetitle)) {
         $errors[] = "Page Title tidak boleh kosong";
     }
     if(empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
         $errors[] = "Email tidak valid";
     }
     if(empty($mobnum)) {
         $errors[] = "Mobile Number tidak boleh kosong";
     }
     if(empty($address)) {
         $errors[] = "Alamat tidak boleh kosong";
     }
     
     // Jika ada error, tampilkan pesan
     if(count($errors) > 0) {
         echo '<script>alert("Validasi Error:\n' . implode('\n', $errors) . '");</script>';
     } else {
         // Gunakan Prepared Statement untuk keamanan
         $query = "UPDATE tblpage SET 
                   PageTitle=?, 
                   PageDescription=?, 
                   Email=?, 
                   MobileNumber=?, 
                   Address=?, 
                   WhatsApp=?, 
                   Facebook=?, 
                   Instagram=?, 
                   TikTok=? 
                   WHERE PageType='contactus'";
         
         $stmt = $con->prepare($query);
         
         if($stmt) {
             // Bind parameters (9 string parameters)
             $stmt->bind_param('sssssssss', 
                 $pagetitle, 
                 $pagedes, 
                 $email, 
                 $mobnum, 
                 $address, 
                 $whatsapp, 
                 $facebook, 
                 $instagram, 
                 $tiktok
             );
             
             // Execute query
             if($stmt->execute()) {
                 echo '<script>alert("Contact Us berhasil diupdate!");</script>';
             } else {
                 echo '<script>alert("Error: ' . $stmt->error . '");</script>';
             }
             
             $stmt->close();
         } else {
             echo '<script>alert("Prepare Error: ' . $con->error . '");</script>';
         }
     }
  }

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Admin | Contact Us </title>
		
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
		  <script src="http://js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
<script type="text/javascript">bkLib.onDomLoaded(nicEditors.allTextAreas);</script>
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
									<h1 class="mainTitle">Admin | Update Contact Us Content</h1>
																	</div>
								<ol class="breadcrumb">
									<li>
										<span>Admin </span>
									</li>
									<li class="active">
										<span>Update Contact Us Content</span>
									</li>
								</ol>
							</div>
						</section>
						<!-- end: PAGE TITLE -->
						<!-- start: BASIC EXAMPLE -->
						<div class="container-fluid container-fullw bg-white">
						

									<div class="row">
								<div class="col-md-12">
									
									
          <form class="forms-sample" method="post" onsubmit="return validateForm();">
                    <?php
                
$ret=mysqli_query($con,"select * from tblpage where PageType='contactus'");
$cnt=1;
while ($row=mysqli_fetch_array($ret)) {

?>
                    <div class="form-group">
                       <label for="pagetitle">Page Title <span style="color:red;">*</span></label>
                      <input id="pagetitle" name="pagetitle" type="text" class="form-control" required="true" value="<?php echo isset($row['PageTitle']) ? htmlspecialchars($row['PageTitle']) : '';?>">
                    </div>
                    
                    <div class="form-group">
                      <label for="pagedes">Page Description</label>
                      <textarea class="form-control" name="pagedes" id="pagedes" rows="5"><?php echo isset($row['PageDescription']) ? htmlspecialchars($row['PageDescription']) : '';?></textarea>
                    </div>
                    
                    <div class="form-group">
                      <label for="address">Alamat <span style="color:red;">*</span></label>
                     <input type="text" class="form-control" name="address" id="address" value="<?php echo isset($row['Address']) ? htmlspecialchars($row['Address']) : '';?>" required='true' placeholder="Contoh: Ulak Lebar, Kecamatan Lubuk Linggau Barat II...">
                    </div>
                    
                    <div class="form-group">
                      <label for="email">Email Address <span style="color:red;">*</span></label>
                     <input type="email" class="form-control" name="email" id="email" value="<?php echo isset($row['Email']) ? htmlspecialchars($row['Email']) : '';?>" required='true'>
                    </div>
                    
                    <div class="form-group">
                      <label for="mobnum">Mobile Number / Telepon <span style="color:red;">*</span></label>
                     <input type="text" class="form-control" name="mobnum" id="mobnum" value="<?php echo isset($row['MobileNumber']) ? htmlspecialchars($row['MobileNumber']) : '';?>" required='true' maxlength="15" pattern='[0-9\+]+' placeholder="Contoh: 085609468687">
                    </div>
                    
                    <div class="form-group">
                      <label for="whatsapp">WhatsApp</label>
                     <input type="text" class="form-control" name="whatsapp" id="whatsapp" value="<?php echo isset($row['WhatsApp']) ? htmlspecialchars($row['WhatsApp']) : '';?>" maxlength="15" pattern='[0-9\+]*' placeholder="Contoh: 085609468687">
                    </div>
                    
                    <div class="form-group">
                      <label for="facebook">Facebook</label>
                     <input type="text" class="form-control" name="facebook" id="facebook" value="<?php echo isset($row['Facebook']) ? htmlspecialchars($row['Facebook']) : '';?>" placeholder="Contoh: Lplubuklinggau">
                    </div>
                    
                    <div class="form-group">
                      <label for="instagram">Instagram</label>
                     <input type="text" class="form-control" name="instagram" id="instagram" value="<?php echo isset($row['Instagram']) ? htmlspecialchars($row['Instagram']) : '';?>" placeholder="Contoh: @lplubuklinggau">
                    </div>
                    
                    <div class="form-group">
                      <label for="tiktok">TikTok</label>
                     <input type="text" class="form-control" name="tiktok" id="tiktok" value="<?php echo isset($row['TikTok']) ? htmlspecialchars($row['TikTok']) : '';?>" placeholder="Contoh: @lapas_llg">
                    </div>
                    
                    <?php } ?>
                    <button type="submit" class="btn btn-primary mr-2" name="submit">Update</button>
                    <button type="reset" class="btn btn-secondary">Reset</button>
                  </form>
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
			
			// Client-side validation
			function validateForm() {
				var pagetitle = document.getElementById('pagetitle').value.trim();
				var email = document.getElementById('email').value.trim();
				var mobnum = document.getElementById('mobnum').value.trim();
				var address = document.getElementById('address').value.trim();
				
				if(pagetitle == '') {
					alert('Page Title tidak boleh kosong!');
					return false;
				}
				if(email == '') {
					alert('Email tidak boleh kosong!');
					return false;
				}
				if(mobnum == '') {
					alert('Mobile Number tidak boleh kosong!');
					return false;
				}
				if(address == '') {
					alert('Alamat tidak boleh kosong!');
					return false;
				}
				return true;
			}
		</script>
		<!-- end: JavaScript Event Handlers for this page -->
		<!-- end: CLIP-TWO JAVASCRIPTS -->
	</body>
</html>
<?php } ?>