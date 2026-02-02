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

// Proses Update
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    
    // Validasi input
    $id = intval($_POST['id'] ?? 0);
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
    } elseif($id <= 0) {
        $error_msg = 'ID berita tidak valid!';
    }
    
    if(empty($error_msg)) {
        // Escape string untuk keamanan
        $judul = mysqli_real_escape_string($con, $judul);
        $kategori = mysqli_real_escape_string($con, $kategori);
        $konten = mysqli_real_escape_string($con, $konten);
        $penulis = mysqli_real_escape_string($con, $penulis);
        $status = mysqli_real_escape_string($con, $status);
        
        // Proses upload gambar baru jika ada
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
        
        // Jika tidak ada error, lakukan update
        if(empty($error_msg)) {
            if(!empty($gambar)) {
                // Update dengan gambar baru
                $sql = "UPDATE tblberita SET Judul='$judul', Kategori='$kategori', Konten='$konten', 
                        Gambar='$gambar', Penulis='$penulis', Status='$status' WHERE id='$id'";
            } else {
                // Update tanpa gambar
                $sql = "UPDATE tblberita SET Judul='$judul', Kategori='$kategori', Konten='$konten', 
                        Penulis='$penulis', Status='$status' WHERE id='$id'";
            }
            
            if(mysqli_query($con, $sql)) {
                $success_msg = 'Berita berhasil diperbarui!';
                echo "<script>
                    setTimeout(function() {
                        window.location.href='manage-berita.php';
                    }, 1500);
                </script>";
            } else {
                $error_msg = 'Terjadi kesalahan: ' . mysqli_error($con);
            }
        }
    }
}

// Proses Hapus
if(isset($_GET['del'])) {
    $id = intval($_GET['del'] ?? 0);
    
    if($id > 0) {
        // Ambil data gambar untuk dihapus
        $result = mysqli_query($con, "SELECT Gambar FROM tblberita WHERE id = '$id'");
        if($result && $row = mysqli_fetch_array($result)) {
            // Hapus file gambar jika ada
            if(!empty($row['Gambar']) && file_exists('berita_images/' . $row['Gambar'])) {
                unlink('berita_images/' . $row['Gambar']);
            }
        }
        
        // Hapus dari database
        if(mysqli_query($con, "DELETE FROM tblberita WHERE id = '$id'")) {
            echo "<script>alert('Berita berhasil dihapus!'); window.location.href='manage-berita.php';</script>";
        } else {
            echo "<script>alert('Gagal menghapus berita!'); window.location.href='manage-berita.php';</script>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Admin | Kelola Berita</title>
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
        .table-container {
            background-color: #ffffff;
            padding: 25px;
            border-radius: 4px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        
        .table > thead > tr > th {
            background-color: #f8f9fa;
            font-weight: 600;
            color: #333;
            border-bottom: 2px solid #dee2e6;
            vertical-align: middle;
        }
        
        .table > tbody > tr > td {
            vertical-align: middle;
            padding: 12px 8px;
        }
        
        .table-hover tbody tr:hover {
            background-color: #f5f8fa;
        }
        
        .table-image {
            width: 80px;
            height: 60px;
            object-fit: cover;
            border-radius: 4px;
            border: 1px solid #ddd;
        }
        
        .kategori-badge {
            display: inline-block;
            padding: 5px 10px;
            background-color: #3498db;
            color: white;
            border-radius: 3px;
            font-size: 11px;
            font-weight: 600;
        }
        
        .no-data {
            text-align: center;
            padding: 60px 20px;
            color: #999;
        }
        
        .no-data i {
            color: #ddd;
            margin-bottom: 15px;
        }
        
        .no-data h4 {
            color: #666;
            margin: 15px 0 10px 0;
        }
        
        .alert {
            border-radius: 4px;
            margin-bottom: 20px;
            border-left: 4px solid;
        }
        
        .alert-danger {
            border-left-color: #e74c3c;
        }
        
        .alert-success {
            border-left-color: #27ae60;
        }
        
        .btn-add {
            margin-bottom: 20px;
            padding: 10px 20px;
            font-weight: 600;
        }
        
        .btn-action {
            margin: 2px;
            padding: 5px 10px;
            font-size: 12px;
        }
        
        .modal-header {
            background-color: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
        }
        
        .modal-title {
            font-weight: 600;
            color: #333;
        }
        
        .modal-body .form-group {
            margin-bottom: 18px;
        }
        
        .modal-body label {
            font-weight: 600;
            margin-bottom: 8px;
            display: block;
            color: #555;
        }
        
        .modal-body .form-control {
            border-radius: 4px;
            border: 1px solid #ddd;
        }
        
        .modal-body .form-control:focus {
            border-color: #3498db;
            box-shadow: 0 0 5px rgba(52, 152, 219, 0.3);
        }
        
        .required {
            color: #e74c3c;
        }
        
        .image-preview {
            background-color: #f0f7ff;
            padding: 12px;
            border-radius: 4px;
            margin-top: 10px;
            border-left: 3px solid #3498db;
        }
        
        .image-preview img {
            max-width: 200px;
            border: 2px solid #ddd;
            padding: 5px;
            border-radius: 4px;
            margin-top: 5px;
        }
        
        .text-muted {
            color: #999 !important;
            font-size: 12px;
        }
        
        .judul-cell {
            max-width: 250px;
        }
        
        .judul-cell strong {
            color: #2c3e50;
            font-size: 13px;
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
                                <h1 class="mainTitle">Admin | Kelola Berita</h1>
                            </div>
                            <ol class="breadcrumb">
                                <li><span>Admin</span></li>
                                <li class="active"><span>Kelola Berita</span></li>
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
                    
                    <!-- TABEL -->
                    <div class="table-container">
                        <div class="row">
                            <div class="col-md-12">
                                
                                <a href="add-berita.php" class="btn btn-primary btn-add">
                                    <i class="fa fa-plus"></i> Tambah Berita Baru
                                </a>
                                
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th width="50" class="text-center">#</th>
                                                <th>Judul</th>
                                                <th width="120" class="text-center">Kategori</th>
                                                <th width="100" class="text-center">Gambar</th>
                                                <th width="120" class="text-center">Penulis</th>
                                                <th width="100" class="text-center">Tanggal</th>
                                                <th width="80" class="text-center">Status</th>
                                                <th width="120" class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
<?php
$sql = mysqli_query($con, "SELECT * FROM tblberita ORDER BY TanggalPosting DESC");
$cnt = 1;

if(mysqli_num_rows($sql) == 0) {
?>
                                            <tr>
                                                <td colspan="8" class="no-data">
                                                    <i class="fa fa-inbox fa-4x"></i>
                                                    <h4>Belum ada berita</h4>
                                                    <p>Klik tombol "Tambah Berita Baru" untuk menambahkan data</p>
                                                </td>
                                            </tr>
<?php
} else {
    while($row = mysqli_fetch_array($sql)) {
        $id = htmlentities($row['id']);
        $judul = htmlentities($row['Judul']);
        $kategori = htmlentities($row['Kategori']);
        $penulis = htmlentities($row['Penulis']);
        $konten = htmlentities($row['Konten']);
        $status = htmlentities($row['Status']);
        $gambar = htmlentities($row['Gambar']);
        $tanggal = date('d/m/Y', strtotime($row['TanggalPosting']));
?>
                                            <tr>
                                                <td class="text-center"><?php echo $cnt; ?></td>
                                                <td class="judul-cell">
                                                    <strong><?php echo strlen($judul) > 40 ? substr($judul, 0, 40) . '...' : $judul; ?></strong>
                                                </td>
                                                <td class="text-center">
                                                    <span class="kategori-badge"><?php echo $kategori; ?></span>
                                                </td>
                                                <td class="text-center">
                                                    <?php if($gambar): ?>
                                                        <img src="berita_images/<?php echo $gambar; ?>" class="table-image" alt="Gambar berita">
                                                    <?php else: ?>
                                                        <span class="text-muted"><i class="fa fa-image"></i></span>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-center">
                                                    <small><?php echo $penulis; ?></small>
                                                </td>
                                                <td class="text-center">
                                                    <small><?php echo $tanggal; ?></small>
                                                </td>
                                                <td class="text-center">
                                                    <?php if($status == 'Aktif'): ?>
                                                        <span class="label label-success">Aktif</span>
                                                    <?php else: ?>
                                                        <span class="label label-danger">Non Aktif</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-center">
                                                    <button class="btn btn-info btn-xs btn-action" data-toggle="modal" data-target="#editModal<?php echo $id; ?>" title="Edit">
                                                        <i class="fa fa-edit"></i>
                                                    </button>
                                                    <a href="?del=<?php echo $id; ?>" onclick="return confirm('Yakin ingin menghapus berita ini?');" class="btn btn-danger btn-xs btn-action" title="Hapus">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>

<!-- Modal Edit -->
<div class="modal fade" id="editModal<?php echo $id; ?>" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title"><i class="fa fa-edit"></i> Edit Berita</h4>
            </div>
            <form method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    
                    <div class="form-group">
                        <label>Judul Berita <span class="required">*</span></label>
                        <input type="text" name="judul" class="form-control" value="<?php echo $judul; ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Kategori <span class="required">*</span></label>
                        <select name="kategori" class="form-control" required>
                            <option value="">-- Pilih Kategori --</option>
                            <option value="Kesehatan" <?php echo ($kategori == 'Kesehatan') ? 'selected' : ''; ?>>Kesehatan</option>
                            <option value="Layanan" <?php echo ($kategori == 'Layanan') ? 'selected' : ''; ?>>Layanan</option>
                            <option value="Fasilitas" <?php echo ($kategori == 'Fasilitas') ? 'selected' : ''; ?>>Fasilitas</option>
                            <option value="Event" <?php echo ($kategori == 'Event') ? 'selected' : ''; ?>>Event</option>
                            <option value="Pengumuman" <?php echo ($kategori == 'Pengumuman') ? 'selected' : ''; ?>>Pengumuman</option>
                            <option value="Lainnya" <?php echo ($kategori == 'Lainnya') ? 'selected' : ''; ?>>Lainnya</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Konten Berita <span class="required">*</span></label>
                        <textarea name="konten" class="form-control" rows="8" required><?php echo $konten; ?></textarea>
                        <small class="text-muted">Isi konten berita secara lengkap</small>
                    </div>

                    <div class="form-group">
                        <label>Gambar Berita</label>
                        <input type="file" name="gambar" class="form-control" accept="image/jpeg,image/png,image/gif">
                        <small class="text-muted">Maksimal 5MB - Kosongkan jika tidak ingin mengubah gambar</small>
                        <?php if($gambar): ?>
                            <div class="image-preview">
                                <i class="fa fa-image"></i> <strong>Gambar saat ini:</strong>
                                <br>
                                <img src="berita_images/<?php echo $gambar; ?>" alt="Preview">
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label>Penulis <span class="required">*</span></label>
                        <input type="text" name="penulis" class="form-control" value="<?php echo $penulis; ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Status <span class="required">*</span></label>
                        <select name="status" class="form-control" required>
                            <option value="">-- Pilih Status --</option>
                            <option value="Aktif" <?php echo ($status == 'Aktif') ? 'selected' : ''; ?>>Aktif</option>
                            <option value="Tidak Aktif" <?php echo ($status == 'Tidak Aktif') ? 'selected' : ''; ?>>Tidak Aktif</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        <i class="fa fa-times"></i> Batal
                    </button>
                    <button type="submit" name="update" class="btn btn-primary">
                        <i class="fa fa-save"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php 
        $cnt++;
    }
}
?>
                                        </tbody>
                                    </table>
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
            
            // Validasi file upload di modal
            $(document).on('change', 'input[name="gambar"]', function() {
                var file = this.files[0];
                if(file) {
                    var maxSize = 5 * 1024 * 1024; // 5MB
                    
                    if(file.size > maxSize) {
                        alert('Ukuran file terlalu besar! Maksimal 5MB.');
                        $(this).val('');
                        return false;
                    }
                    
                    var allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                    if(!allowedTypes.includes(file.type)) {
                        alert('Tipe file tidak diperbolehkan! Gunakan JPG, PNG, atau GIF.');
                        $(this).val('');
                        return false;
                    }
                }
            });
        });
    </script>
</body>
</html>