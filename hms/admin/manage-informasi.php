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

// Proses Update
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    
    // Validasi input
    $id = intval($_POST['id'] ?? 0);
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
    } elseif($id <= 0) {
        $error_msg = 'ID informasi tidak valid!';
    }
    
    if(empty($error_msg)) {
        // Escape string untuk keamanan
        $judul = mysqli_real_escape_string($con, $judul);
        $deskripsi = mysqli_real_escape_string($con, $deskripsi);
        $kategori = mysqli_real_escape_string($con, $kategori);
        $status = mysqli_real_escape_string($con, $status);
        
        // Proses upload file baru jika ada
        $namafile = '';
        if(isset($_FILES["dokumen"]) && $_FILES["dokumen"]["error"] == UPLOAD_ERR_OK) {
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
                    $namafile = $new_filename;
                } 
                else {
                    $error_msg = 'Gagal mengupload file!';
                }
            }
        }
        
        // Jika tidak ada error, lakukan update
        if(empty($error_msg)) {
            if(!empty($namafile)) {
                // Update dengan file baru
                $sql = "UPDATE tblinformasipublik SET JudulInformasi='$judul', Deskripsi='$deskripsi', 
                        Kategori='$kategori', NamaFile='$namafile', Status='$status' WHERE id='$id'";
            } else {
                // Update tanpa file
                $sql = "UPDATE tblinformasipublik SET JudulInformasi='$judul', Deskripsi='$deskripsi', 
                        Kategori='$kategori', Status='$status' WHERE id='$id'";
            }
            
            if(mysqli_query($con, $sql)) {
                $success_msg = 'Informasi publik berhasil diperbarui!';
                echo "<script>
                    setTimeout(function() {
                        window.location.href='manage-informasi.php';
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
        // Ambil data file untuk dihapus
        $result = mysqli_query($con, "SELECT NamaFile FROM tblinformasipublik WHERE id = '$id'");
        if($result && $row = mysqli_fetch_array($result)) {
            // Hapus file jika ada
            if(!empty($row['NamaFile']) && file_exists('informasi_files/' . $row['NamaFile'])) {
                unlink('informasi_files/' . $row['NamaFile']);
            }
        }
        
        // Hapus dari database
        if(mysqli_query($con, "DELETE FROM tblinformasipublik WHERE id = '$id'")) {
            echo "<script>alert('Informasi publik berhasil dihapus!'); window.location.href='manage-informasi.php';</script>";
        } else {
            echo "<script>alert('Gagal menghapus informasi publik!'); window.location.href='manage-informasi.php';</script>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Admin | Kelola Informasi Publik</title>
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
        
        .file-badge {
            display: inline-block;
            padding: 6px 12px;
            background-color: #e74c3c;
            color: white;
            border-radius: 3px;
            font-size: 11px;
            font-weight: 600;
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
        
        .file-info {
            background-color: #f0f7ff;
            padding: 12px;
            border-radius: 4px;
            margin-top: 10px;
            font-size: 12px;
            border-left: 3px solid #3498db;
        }
        
        .text-muted {
            color: #999 !important;
            font-size: 12px;
        }
        
        .judul-cell {
            max-width: 300px;
        }
        
        .judul-cell strong {
            color: #2c3e50;
            font-size: 13px;
        }
        
        .judul-cell small {
            display: block;
            margin-top: 4px;
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
                                <h1 class="mainTitle">Admin | Kelola Informasi Publik</h1>
                            </div>
                            <ol class="breadcrumb">
                                <li><span>Admin</span></li>
                                <li class="active"><span>Kelola Informasi Publik</span></li>
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
                                
                                <a href="add-informasi.php" class="btn btn-primary btn-add">
                                    <i class="fa fa-plus"></i> Tambah Informasi Baru
                                </a>
                                
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th width="50" class="text-center">#</th>
                                                <th>Judul Informasi</th>
                                                <th width="120" class="text-center">Kategori</th>
                                                <th width="80" class="text-center">File</th>
                                                <th width="130" class="text-center">Tanggal Unggah</th>
                                                <th width="80" class="text-center">Status</th>
                                                <th width="150" class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
<?php
$sql = mysqli_query($con, "SELECT * FROM tblinformasipublik ORDER BY TanggalUnggah DESC");
$cnt = 1;

if(mysqli_num_rows($sql) == 0) {
?>
                                            <tr>
                                                <td colspan="7" class="no-data">
                                                    <i class="fa fa-inbox fa-4x"></i>
                                                    <h4>Belum ada informasi publik</h4>
                                                    <p>Klik tombol "Tambah Informasi Baru" untuk menambahkan data</p>
                                                </td>
                                            </tr>
<?php
} else {
    while($row = mysqli_fetch_array($sql)) {
        $id = htmlentities($row['id']);
        $judul = htmlentities($row['JudulInformasi']);
        $deskripsi = htmlentities($row['Deskripsi']);
        $kategori = htmlentities($row['Kategori']);
        $status = htmlentities($row['Status']);
        $namafile = htmlentities($row['NamaFile']);
        $tanggal = date('d/m/Y H:i', strtotime($row['TanggalUnggah']));
        $uploadedby = htmlentities($row['UplodedBy']);
?>
                                            <tr>
                                                <td class="text-center"><?php echo $cnt; ?></td>
                                                <td class="judul-cell">
                                                    <strong><?php echo strlen($judul) > 50 ? substr($judul, 0, 50) . '...' : $judul; ?></strong>
                                                    <small class="text-muted"><i class="fa fa-user"></i> Oleh: <?php echo $uploadedby; ?></small>
                                                </td>
                                                <td class="text-center">
                                                    <span class="kategori-badge"><?php echo $kategori; ?></span>
                                                </td>
                                                <td class="text-center">
                                                    <span class="file-badge">
                                                        <i class="fa fa-file-pdf-o"></i> PDF
                                                    </span>
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
                                                    <a href="informasi_files/<?php echo $namafile; ?>" target="_blank" class="btn btn-success btn-xs btn-action" title="Download">
                                                        <i class="fa fa-download"></i>
                                                    </a>
                                                    <a href="?del=<?php echo $id; ?>" onclick="return confirm('Yakin ingin menghapus informasi ini?');" class="btn btn-danger btn-xs btn-action" title="Hapus">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>

<!-- Modal Edit -->
<div class="modal fade" id="editModal<?php echo $id; ?>" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title"><i class="fa fa-edit"></i> Edit Informasi Publik</h4>
            </div>
            <form method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    
                    <div class="form-group">
                        <label>Judul Informasi <span class="required">*</span></label>
                        <input type="text" name="judul" class="form-control" value="<?php echo $judul; ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Deskripsi <span class="required">*</span></label>
                        <textarea name="deskripsi" class="form-control" rows="4" required><?php echo $deskripsi; ?></textarea>
                        <small class="text-muted">Penjelasan singkat tentang informasi publik</small>
                    </div>

                    <div class="form-group">
                        <label>Kategori <span class="required">*</span></label>
                        <select name="kategori" class="form-control" required>
                            <option value="">-- Pilih Kategori --</option>
                            <option value="Laporan" <?php echo ($kategori == 'Laporan') ? 'selected' : ''; ?>>Laporan</option>
                            <option value="Bukti Pencapaian" <?php echo ($kategori == 'Bukti Pencapaian') ? 'selected' : ''; ?>>Bukti Pencapaian</option>
                            <option value="Regulasi" <?php echo ($kategori == 'Regulasi') ? 'selected' : ''; ?>>Regulasi</option>
                            <option value="SOP" <?php echo ($kategori == 'SOP') ? 'selected' : ''; ?>>SOP</option>
                            <option value="Lainnya" <?php echo ($kategori == 'Lainnya') ? 'selected' : ''; ?>>Lainnya</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>File Dokumen (PDF)</label>
                        <input type="file" name="dokumen" class="form-control" accept="application/pdf">
                        <small class="text-muted">Maksimal 10MB - Kosongkan jika tidak ingin mengubah file</small>
                        <div class="file-info">
                            <i class="fa fa-file-pdf-o"></i> File saat ini: <strong><?php echo $namafile; ?></strong>
                        </div>
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
            $(document).on('change', 'input[name="dokumen"]', function() {
                var file = this.files[0];
                if(file) {
                    var maxSize = 10 * 1024 * 1024; // 10MB
                    
                    if(file.size > maxSize) {
                        alert('Ukuran file terlalu besar! Maksimal 10MB.');
                        $(this).val('');
                        return false;
                    }
                    
                    if(file.type !== 'application/pdf') {
                        alert('Tipe file harus PDF!');
                        $(this).val('');
                        return false;
                    }
                }
            });
        });
    </script>
</body>
</html>