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

// Proses ketika form di-submit
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    
    // Validasi input
    $judul = trim($_POST['judul'] ?? '');
    $kategori = trim($_POST['kategori'] ?? '');
    $konten = trim($_POST['konten'] ?? '');
    $penulis = trim($_POST['penulis'] ?? '');
    $status = trim($_POST['status'] ?? '');
    
    // Cek field required
    if(empty($judul)) {
        $error_msg = 'Judul berita tidak boleh kosong!';
    } elseif(empty($kategori)) {
        $error_msg = 'Kategori harus dipilih!';
    } elseif(empty($konten)) {
        $error_msg = 'Konten berita tidak boleh kosong!';
    } elseif(empty($penulis)) {
        $error_msg = 'Nama penulis tidak boleh kosong!';
    } elseif(empty($status)) {
        $error_msg = 'Status harus dipilih!';
    }
    
    if(empty($error_msg)) {
        // Escape string untuk keamanan
        $judul = mysqli_real_escape_string($con, $judul);
        $kategori = mysqli_real_escape_string($con, $kategori);
        $konten = mysqli_real_escape_string($con, $konten);
        $penulis = mysqli_real_escape_string($con, $penulis);
        $status = mysqli_real_escape_string($con, $status);
        $tanggal = date('Y-m-d H:i:s');
        
        // Proses upload gambar
        $gambar = '';
        if(isset($_FILES["gambar"]) && $_FILES["gambar"]["error"] == UPLOAD_ERR_OK) {
            $target_dir = "berita_images/";
            
            // Buat folder jika belum ada
            if(!is_dir($target_dir)){
                mkdir($target_dir, 0755, true);
            }
            
            $imageFileType = strtolower(pathinfo($_FILES["gambar"]["name"], PATHINFO_EXTENSION));
            $allowed_types = array('jpg', 'jpeg', 'png', 'gif');
            $file_size = $_FILES["gambar"]["size"];
            $max_size = 5 * 1024 * 1024; // 5MB
            
            // Validasi tipe file
            if(!in_array($imageFileType, $allowed_types)) {
                $error_msg = 'Tipe file tidak diperbolehkan! Gunakan JPG, JPEG, PNG, atau GIF.';
            } 
            // Validasi ukuran file
            elseif($file_size > $max_size) {
                $error_msg = 'Ukuran file terlalu besar! Maksimal 5MB.';
            } 
            else {
                // Generate nama file yang aman
                $new_filename = time() . '_' . bin2hex(random_bytes(8)) . '.' . $imageFileType;
                $target_file = $target_dir . $new_filename;
                
                // Validasi file MIME type
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $mime_type = finfo_file($finfo, $_FILES["gambar"]["tmp_name"]);
                finfo_close($finfo);
                
                $allowed_mimes = array('image/jpeg', 'image/png', 'image/gif');
                if(!in_array($mime_type, $allowed_mimes)) {
                    $error_msg = 'File bukan merupakan gambar yang valid!';
                } 
                elseif(move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
                    $gambar = $new_filename;
                } 
                else {
                    $error_msg = 'Gagal mengupload gambar!';
                }
            }
        }
        
        // Jika tidak ada error, insert ke database
        if(empty($error_msg)) {
            $sql = "INSERT INTO tblberita (Judul, Kategori, Konten, Gambar, Penulis, Status, TanggalPosting) 
                    VALUES ('$judul', '$kategori', '$konten', '$gambar', '$penulis', '$status', '$tanggal')";
            
            if(mysqli_query($con, $sql)) {
                $success_msg = 'Berita berhasil ditambahkan!';
                echo "<script>
                    setTimeout(function() {
                        window.location.href='manage-berita.php';
                    }, 1500);
                </script>";
            } else {
                $error_msg = 'Terjadi kesalahan saat menyimpan data: ' . mysqli_error($con);
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Admin | Tambah Berita</title>
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
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            font-weight: 600;
            margin-bottom: 8px;
            display: block;
            color: #333;
        }
        .required {
            color: #ff6b6b;
        }
        .alert {
            border-radius: 4px;
            margin-bottom: 20px;
        }
        .btn-group-custom {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }
        .btn-group-custom .btn {
            margin-right: 10px;
        }
        textarea.form-control {
            resize: vertical;
            min-height: 250px;
        }
        .text-muted {
            display: block;
            margin-top: 5px;
            font-size: 13px;
        }
        .form-wrapper {
            max-width: 700px;
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
                                <h1 class="mainTitle">Admin | Tambah Berita</h1>
                            </div>
                            <ol class="breadcrumb">
                                <li><span>Admin</span></li>
                                <li><span><a href="manage-berita.php">Kelola Berita</a></span></li>
                                <li class="active"><span>Tambah Berita</span></li>
                            </ol>
                        </div>
                    </section>
                    
                    <!-- FORM -->
                    <div class="container-fluid container-fullw bg-white">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-wrapper">
                                    
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
                                    
                                    <!-- Form -->
                                    <form method="post" enctype="multipart/form-data" novalidate>
                                        
                                        <div class="form-group">
                                            <label>Judul Berita <span class="required">*</span></label>
                                            <input type="text" name="judul" class="form-control" placeholder="Masukkan judul berita" value="<?php echo isset($_POST['judul']) ? htmlentities($_POST['judul']) : ''; ?>" required>
                                            <small class="form-text text-muted">Judul berita yang menarik dan deskriptif</small>
                                        </div>

                                        <div class="form-group">
                                            <label>Kategori <span class="required">*</span></label>
                                            <select name="kategori" class="form-control" required>
                                                <option value="">-- Pilih Kategori --</option>
                                                <option value="Kesehatan" <?php echo (isset($_POST['kategori']) && $_POST['kategori'] == 'Kesehatan') ? 'selected' : ''; ?>>Kesehatan</option>
                                                <option value="Layanan" <?php echo (isset($_POST['kategori']) && $_POST['kategori'] == 'Layanan') ? 'selected' : ''; ?>>Layanan</option>
                                                <option value="Fasilitas" <?php echo (isset($_POST['kategori']) && $_POST['kategori'] == 'Fasilitas') ? 'selected' : ''; ?>>Fasilitas</option>
                                                <option value="Event" <?php echo (isset($_POST['kategori']) && $_POST['kategori'] == 'Event') ? 'selected' : ''; ?>>Event</option>
                                                <option value="Pengumuman" <?php echo (isset($_POST['kategori']) && $_POST['kategori'] == 'Pengumuman') ? 'selected' : ''; ?>>Pengumuman</option>
                                                <option value="Lainnya" <?php echo (isset($_POST['kategori']) && $_POST['kategori'] == 'Lainnya') ? 'selected' : ''; ?>>Lainnya</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label>Konten Berita <span class="required">*</span></label>
                                            <textarea name="konten" class="form-control" rows="12" placeholder="Tulis konten berita di sini..." required><?php echo isset($_POST['konten']) ? htmlentities($_POST['konten']) : ''; ?></textarea>
                                            <small class="form-text text-muted">Jelaskan isi berita secara lengkap dan terstruktur</small>
                                        </div>

                                        <div class="form-group">
                                            <label>Gambar Berita</label>
                                            <input type="file" name="gambar" class="form-control" accept="image/jpeg,image/png,image/gif">
                                            <small class="form-text text-muted">Format: JPG, JPEG, PNG, GIF (Maksimal 5MB) - Opsional</small>
                                        </div>

                                        <div class="form-group">
                                            <label>Penulis <span class="required">*</span></label>
                                            <input type="text" name="penulis" class="form-control" placeholder="Nama penulis" value="<?php echo isset($_POST['penulis']) ? htmlentities($_POST['penulis']) : ''; ?>" required>
                                        </div>

                                        <div class="form-group">
                                            <label>Status <span class="required">*</span></label>
                                            <select name="status" class="form-control" required>
                                                <option value="">-- Pilih Status --</option>
                                                <option value="Aktif" <?php echo (isset($_POST['status']) && $_POST['status'] == 'Aktif') ? 'selected' : ''; ?>>Aktif</option>
                                                <option value="Tidak Aktif" <?php echo (isset($_POST['status']) && $_POST['status'] == 'Tidak Aktif') ? 'selected' : ''; ?>>Tidak Aktif</option>
                                            </select>
                                        </div>

                                        <div class="btn-group-custom">
                                            <button type="submit" name="submit" class="btn btn-primary">
                                                <i class="fa fa-save"></i> Simpan
                                            </button>
                                            <a href="manage-berita.php" class="btn btn-secondary">
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
            
            // Validasi file upload
            document.querySelector('input[name="gambar"]').addEventListener('change', function(e) {
                var file = this.files[0];
                if(file) {
                    var maxSize = 5 * 1024 * 1024; // 5MB
                    if(file.size > maxSize) {
                        alert('Ukuran file terlalu besar! Maksimal 5MB.');
                        this.value = '';
                        return false;
                    }
                    
                    var allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                    if(!allowedTypes.includes(file.type)) {
                        alert('Tipe file tidak diperbolehkan! Gunakan JPG, PNG, atau GIF.');
                        this.value = '';
                        return false;
                    }
                }
            });
        });
    </script>
</body>
</html>