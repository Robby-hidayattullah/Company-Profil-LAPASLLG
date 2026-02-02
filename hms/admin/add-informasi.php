<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('include/config.php');

// Cek session
if(empty($_SESSION['id'])) {
    header('location:logout.php');
    exit();
}

$error_msg = '';
$success_msg = '';
$username = isset($_SESSION['username']) ? htmlentities($_SESSION['username']) : 'Admin';

// Proses Insert
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    
    // Validasi input
    $judul = trim($_POST['judul'] ?? '');
    $deskripsi = trim($_POST['deskripsi'] ?? '');
    $kategori = trim($_POST['kategori'] ?? '');
    $status = trim($_POST['status'] ?? '');
    
    // Cek field required
    if(empty($judul)) {
        $error_msg = 'Judul informasi tidak boleh kosong!';
    } elseif(empty($deskripsi)) {
        $error_msg = 'Deskripsi tidak boleh kosong!';
    } elseif(empty($kategori)) {
        $error_msg = 'Kategori harus dipilih!';
    } elseif(empty($status)) {
        $error_msg = 'Status harus dipilih!';
    } elseif(!isset($_FILES["dokumen"]) || $_FILES["dokumen"]["error"] != UPLOAD_ERR_OK) {
        $error_msg = 'File dokumen harus diupload!';
    }
    
    if(empty($error_msg)) {
        // Proses upload file
        $target_dir = "informasi_files/";
        
        // Buat folder jika belum ada
        if(!is_dir($target_dir)){
            mkdir($target_dir, 0755, true);
        }
        
        $fileType = strtolower(pathinfo($_FILES["dokumen"]["name"], PATHINFO_EXTENSION));
        $allowed_types = array('pdf');
        $file_size = $_FILES["dokumen"]["size"];
        $max_size = 10 * 1024 * 1024; // 10MB
        
        // Validasi tipe file
        if(!in_array($fileType, $allowed_types)) {
            $error_msg = 'Tipe file tidak diperbolehkan! Hanya file PDF yang diizinkan.';
        } 
        // Validasi ukuran file
        elseif($file_size > $max_size) {
            $error_msg = 'Ukuran file terlalu besar! Maksimal 10MB.';
        } 
        else {
            // Generate nama file yang aman
            $new_filename = time() . '_' . bin2hex(random_bytes(8)) . '.pdf';
            $target_file = $target_dir . $new_filename;
            
            // Validasi file MIME type
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime_type = finfo_file($finfo, $_FILES["dokumen"]["tmp_name"]);
            finfo_close($finfo);
            
            if($mime_type !== 'application/pdf') {
                $error_msg = 'File bukan merupakan PDF yang valid!';
            } 
            elseif(move_uploaded_file($_FILES["dokumen"]["tmp_name"], $target_file)) {
                // Escape string untuk keamanan
                $judul = mysqli_real_escape_string($con, $judul);
                $deskripsi = mysqli_real_escape_string($con, $deskripsi);
                $kategori = mysqli_real_escape_string($con, $kategori);
                $status = mysqli_real_escape_string($con, $status);
                
                // Insert ke database
                $sql = "INSERT INTO tblinformasipublik (JudulInformasi, Deskripsi, Kategori, NamaFile, Status, UplodedBy) 
                        VALUES ('$judul', '$deskripsi', '$kategori', '$new_filename', '$status', '$username')";
                
                if(mysqli_query($con, $sql)) {
                    $success_msg = 'Informasi publik berhasil ditambahkan!';
                    echo "<script>
                        setTimeout(function() {
                            window.location.href='manage-informasi.php';
                        }, 1500);
                    </script>";
                } else {
                    $error_msg = 'Terjadi kesalahan saat menyimpan data: ' . mysqli_error($con);
                    // Hapus file jika insert gagal
                    if(file_exists($target_file)) {
                        unlink($target_file);
                    }
                }
            } 
            else {
                $error_msg = 'Gagal mengupload file!';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Admin | Tambah Informasi Publik</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="http://fonts.googleapis.com/css?family=Lato:300,400,400italic,600,700|Raleway:300,400,500,600,700|Crete+Round:400italic" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="vendor/themify-icons/themify-icons.min.css">
    <link href="vendor/animate.css/animate.min.css" rel="stylesheet" media="screen">
    <link href="vendor/perfect-scrollbar/perfect-scrollbar.min.css" rel="stylesheet" media="screen">
    <link href="vendor/switchery/switchery.min.css" rel="stylesheet" media="screen">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/plugins.css">
    <link rel="stylesheet" href="assets/css/themes/theme-1.css" id="skin_color" />
    <style>
        .form-section {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 4px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            font-weight: 600;
            margin-bottom: 8px;
            display: block;
            color: #333;
        }
        .form-group .form-control {
            border-radius: 4px;
            border: 1px solid #ddd;
            padding: 10px 12px;
            font-size: 13px;
        }
        .form-group .form-control:focus {
            border-color: #337ab7;
            box-shadow: 0 0 5px rgba(51, 122, 183, 0.3);
        }
        .required {
            color: #ff6b6b;
        }
        .alert {
            border-radius: 4px;
            margin-bottom: 20px;
        }
        .file-upload-box {
            border: 2px dashed #3498db;
            border-radius: 4px;
            padding: 20px;
            text-align: center;
            background-color: #f0f7ff;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .file-upload-box:hover {
            border-color: #2980b9;
            background-color: #e8f4fb;
        }
        .file-upload-box i {
            font-size: 32px;
            color: #3498db;
            margin-bottom: 10px;
        }
        .file-info {
            background-color: #ecf0f1;
            padding: 10px;
            border-radius: 4px;
            margin-top: 10px;
            font-size: 12px;
            display: none;
        }
        .file-info.show {
            display: block;
        }
        .btn-group-custom {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }
        .btn-group-custom .btn {
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <div id="app">
        <?php include('include/sidebar.php');?>
        <div class="app-content">
            <?php include('include/header.php');?>
            
            <div class="main-content">
                <div class="wrap-content container" id="container">
                    
                    <!-- PAGE TITLE -->
                    <section id="page-title">
                        <div class="row">
                            <div class="col-sm-8">
                                <h1 class="mainTitle">Admin | Tambah Informasi Publik</h1>
                            </div>
                            <ol class="breadcrumb">
                                <li><span>Admin</span></li>
                                <li><span><a href="manage-informasi.php">Kelola Informasi Publik</a></span></li>
                                <li class="active"><span>Tambah Informasi</span></li>
                            </ol>
                        </div>
                    </section>
                    
                    <!-- Alert Messages -->
                    <?php if(!empty($error_msg)): ?>
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <i class="fa fa-exclamation-circle"></i> <?php echo htmlentities($error_msg); ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if(!empty($success_msg)): ?>
                        <div class="alert alert-success alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <i class="fa fa-check-circle"></i> <?php echo htmlentities($success_msg); ?>
                        </div>
                    <?php endif; ?>
                    
                    <!-- FORM -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-section">
                                <h3 style="margin-top: 0; margin-bottom: 25px;">
                                    <i class="fa fa-plus-circle"></i> Form Tambah Informasi Publik
                                </h3>
                                
                                <form method="post" enctype="multipart/form-data" id="addForm" novalidate>
                                    
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label>Judul Informasi <span class="required">*</span></label>
                                                <input type="text" name="judul" class="form-control" placeholder="Masukkan judul informasi publik" required>
                                                <small class="form-text text-muted">Contoh: Laporan Tahunan 2024, Bukti Pencapaian Program Kesehatan</small>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label>Deskripsi <span class="required">*</span></label>
                                                <textarea name="deskripsi" class="form-control" rows="6" placeholder="Masukkan penjelasan singkat tentang informasi publik ini" required></textarea>
                                                <small class="form-text text-muted">Penjelasan detail akan membantu pengguna memahami konten dokumen</small>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Kategori <span class="required">*</span></label>
                                                <select name="kategori" class="form-control" required>
                                                    <option value="">-- Pilih Kategori --</option>
                                                    <option value="Laporan">Laporan</option>
                                                    <option value="Bukti Pencapaian">Bukti Pencapaian</option>
                                                    <option value="Regulasi">Regulasi</option>
                                                    <option value="SOP">SOP (Standar Operasional Prosedur)</option>
                                                    <option value="Lainnya">Lainnya</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Status <span class="required">*</span></label>
                                                <select name="status" class="form-control" required>
                                                    <option value="">-- Pilih Status --</option>
                                                    <option value="Aktif">Aktif</option>
                                                    <option value="Tidak Aktif">Tidak Aktif</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>File Dokumen (PDF) <span class="required">*</span></label>
                                                <div class="file-upload-box" id="fileUploadBox">
                                                    <i class="fa fa-file-pdf-o"></i>
                                                    <p><strong>Klik atau drag file PDF di sini</strong></p>
                                                    <small>Format: PDF | Ukuran Maksimal: 10MB</small>
                                                    <input type="file" name="dokumen" id="fileInput" class="form-control" accept="application/pdf" style="display: none;" required>
                                                </div>
                                                <div class="file-info" id="fileInfo">
                                                    <i class="fa fa-check-circle" style="color: #27ae60;"></i>
                                                    <strong>File dipilih:</strong> <span id="fileName"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="btn-group-custom">
                                        <button type="submit" name="submit" class="btn btn-primary">
                                            <i class="fa fa-save"></i> Simpan
                                        </button>
                                        <a href="manage-informasi.php" class="btn btn-secondary">
                                            <i class="fa fa-arrow-left"></i> Kembali
                                        </a>
                                    </div>
                                    
                                </form>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
        
        <?php include('include/footer.php');?>
        <?php include('include/setting.php');?>
    </div>

    <!-- JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="vendor/modernizr/modernizr.js"></script>
    <script src="vendor/jquery-cookie/jquery.cookie.js"></script>
    <script src="vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="vendor/switchery/switchery.min.js"></script>
    <script src="assets/js/main.js"></script>
    <script>
        jQuery(document).ready(function() {
            if(typeof Main !== 'undefined') {
                Main.init();
            }
            
            // File upload handler
            var fileInput = document.getElementById('fileInput');
            var fileUploadBox = document.getElementById('fileUploadBox');
            var fileInfo = document.getElementById('fileInfo');
            var fileName = document.getElementById('fileName');
            
            // Click to open file dialog
            fileUploadBox.addEventListener('click', function() {
                fileInput.click();
            });
            
            // Drag and drop
            fileUploadBox.addEventListener('dragover', function(e) {
                e.preventDefault();
                fileUploadBox.style.borderColor = '#2980b9';
                fileUploadBox.style.backgroundColor = '#e8f4fb';
            });
            
            fileUploadBox.addEventListener('dragleave', function(e) {
                e.preventDefault();
                fileUploadBox.style.borderColor = '#3498db';
                fileUploadBox.style.backgroundColor = '#f0f7ff';
            });
            
            fileUploadBox.addEventListener('drop', function(e) {
                e.preventDefault();
                fileUploadBox.style.borderColor = '#3498db';
                fileUploadBox.style.backgroundColor = '#f0f7ff';
                
                var files = e.dataTransfer.files;
                if(files.length > 0) {
                    fileInput.files = files;
                    handleFileSelect();
                }
            });
            
            // File input change handler
            fileInput.addEventListener('change', handleFileSelect);
            
            function handleFileSelect() {
                var file = fileInput.files[0];
                if(file) {
                    var maxSize = 10 * 1024 * 1024; // 10MB
                    
                    if(file.size > maxSize) {
                        alert('Ukuran file terlalu besar! Maksimal 10MB.');
                        fileInput.value = '';
                        fileInfo.classList.remove('show');
                        return false;
                    }
                    
                    if(file.type !== 'application/pdf') {
                        alert('Tipe file harus PDF!');
                        fileInput.value = '';
                        fileInfo.classList.remove('show');
                        return false;
                    }
                    
                    // Tampilkan nama file
                    var fileSizeInMB = (file.size / 1024 / 1024).toFixed(2);
                    fileName.textContent = file.name + ' (' + fileSizeInMB + ' MB)';
                    fileInfo.classList.add('show');
                }
            }
            
            // Form validation
            document.getElementById('addForm').addEventListener('submit', function(e) {
                var fileInput = document.getElementById('fileInput');
                if(!fileInput.files || fileInput.files.length === 0) {
                    e.preventDefault();
                    alert('Silakan pilih file PDF terlebih dahulu!');
                    return false;
                }
            });
        });
    </script>
</body>
</html>