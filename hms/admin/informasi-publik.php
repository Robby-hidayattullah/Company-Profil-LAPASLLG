<?php
// informasi-publik.php - Halaman Informasi Publik User
include('include/config.php');

// Ambil parameter kategori dari URL jika ada
$kategori_filter = isset($_GET['kategori']) ? mysqli_real_escape_string($con, $_GET['kategori']) : '';

// Query dengan filter status aktif dan kategori jika dipilih
if(!empty($kategori_filter)) {
    $sql = "SELECT * FROM tblinformasipublik WHERE Status='Aktif' AND Kategori='$kategori_filter' ORDER BY TanggalUnggah DESC";
} else {
    $sql = "SELECT * FROM tblinformasipublik WHERE Status='Aktif' ORDER BY TanggalUnggah DESC";
}

$result = mysqli_query($con, $sql);
$total_informasi = mysqli_num_rows($result);

// Ambil daftar kategori unik
$kategori_sql = "SELECT DISTINCT Kategori FROM tblinformasipublik WHERE Status='Aktif' ORDER BY Kategori";
$kategori_result = mysqli_query($con, $kategori_sql);
$kategori_list = array();
while($row = mysqli_fetch_array($kategori_result)) {
    $kategori_list[] = $row['Kategori'];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informasi Publik</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .page-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 60px 0;
            margin-bottom: 40px;
        }

        .page-header h1 {
            font-size: 36px;
            font-weight: 700;
            margin: 0;
        }

        .page-header p {
            font-size: 16px;
            margin-top: 10px;
            opacity: 0.9;
        }

        .filter-section {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 4px;
            margin-bottom: 30px;
        }

        .filter-section h5 {
            font-weight: 600;
            margin-bottom: 15px;
            color: #333;
        }

        .filter-btn {
            display: inline-block;
            padding: 8px 15px;
            margin-right: 10px;
            margin-bottom: 10px;
            border: 2px solid #667eea;
            background-color: white;
            color: #667eea;
            border-radius: 20px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 13px;
            font-weight: 500;
        }

        .filter-btn:hover,
        .filter-btn.active {
            background-color: #667eea;
            color: white;
            text-decoration: none;
        }

        .info-card {
            background: white;
            border-left: 5px solid #667eea;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .info-card:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            transform: translateY(-2px);
        }

        .info-card-content {
            flex: 1;
        }

        .info-card-title {
            font-size: 16px;
            font-weight: 600;
            color: #333;
            margin: 0 0 8px 0;
        }

        .info-card-description {
            font-size: 13px;
            color: #666;
            margin: 0 0 12px 0;
            line-height: 1.5;
            max-width: 90%;
        }

        .info-card-meta {
            font-size: 12px;
            color: #999;
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        .info-card-meta span {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .info-card-badge {
            display: inline-block;
            padding: 4px 10px;
            background-color: #667eea;
            color: white;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 600;
            margin-right: 5px;
        }

        .info-card-actions {
            text-align: right;
            flex-shrink: 0;
            margin-left: 20px;
        }

        .btn-download {
            background-color: #27ae60;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 13px;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }

        .btn-download:hover {
            background-color: #229954;
            text-decoration: none;
            color: white;
        }

        .no-data {
            text-align: center;
            padding: 60px 20px;
            color: #999;
        }

        .no-data i {
            font-size: 48px;
            margin-bottom: 15px;
            opacity: 0.5;
        }

        .no-data h3 {
            color: #666;
            margin: 15px 0;
        }

        .stats-box {
            background: white;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.08);
        }

        .stats-box .number {
            font-size: 28px;
            font-weight: 700;
            color: #667eea;
        }

        .stats-box .label {
            font-size: 12px;
            color: #999;
            margin-top: 5px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .breadcrumb {
            background: transparent;
            padding: 0;
            margin-bottom: 20px;
        }

        @media (max-width: 768px) {
            .page-header {
                padding: 40px 0;
            }

            .page-header h1 {
                font-size: 28px;
            }

            .info-card {
                flex-direction: column;
                align-items: flex-start;
            }

            .info-card-actions {
                margin-left: 0;
                margin-top: 15px;
                text-align: left;
            }

            .info-card-description {
                max-width: 100%;
            }
        }
    </style>
</head>
<body>
    <!-- NAVBAR (dari file navbar/header Anda) -->
    <!-- Bagian ini menyesuaikan dengan navbar website Anda -->

    <div class="page-header">
        <div class="container">
            <h1><i class="fa fa-file-pdf-o"></i> Informasi Publik</h1>
            <p>Akses dokumen dan informasi penting yang telah kami publikasikan</p>
        </div>
    </div>

    <div class="container" style="margin-bottom: 60px;">
        
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Beranda</a></li>
                <li class="breadcrumb-item active" aria-current="page">Informasi Publik</li>
            </ol>
        </nav>

        <div class="row">
            <!-- Sidebar Filter -->
            <div class="col-md-3">
                <div class="stats-box">
                    <div class="number"><?php echo $total_informasi; ?></div>
                    <div class="label">Total Dokumen</div>
                </div>

                <div class="filter-section">
                    <h5>Filter Kategori</h5>
                    <div>
                        <a href="informasi-publik.php" class="filter-btn <?php echo empty($kategori_filter) ? 'active' : ''; ?>">
                            <i class="fa fa-th-list"></i> Semua
                        </a>
                        <?php foreach($kategori_list as $kat): ?>
                            <a href="informasi-publik.php?kategori=<?php echo urlencode($kat); ?>" 
                               class="filter-btn <?php echo ($kategori_filter == $kat) ? 'active' : ''; ?>">
                                <i class="fa fa-folder"></i> <?php echo htmlentities($kat); ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-9">
                <?php if($total_informasi > 0): ?>
                    <?php while($row = mysqli_fetch_array($result)): 
                        $id = htmlentities($row['id']);
                        $judul = htmlentities($row['JudulInformasi']);
                        $deskripsi = htmlentities($row['Deskripsi']);
                        $kategori = htmlentities($row['Kategori']);
                        $namafile = htmlentities($row['NamaFile']);
                        $tanggal = date('d/m/Y', strtotime($row['TanggalUnggah']));
                        $uploadedby = htmlentities($row['UplodedBy']);
                    ?>
                        <div class="info-card">
                            <div class="info-card-content">
                                <h5 class="info-card-title">
                                    <i class="fa fa-file-pdf-o" style="color: #e74c3c;"></i>
                                    <?php echo $judul; ?>
                                </h5>
                                <p class="info-card-description"><?php echo $deskripsi; ?></p>
                                <div class="info-card-meta">
                                    <span class="info-card-badge"><?php echo $kategori; ?></span>
                                    <span>
                                        <i class="fa fa-calendar"></i>
                                        <?php echo $tanggal; ?>
                                    </span>
                                    <span>
                                        <i class="fa fa-user"></i>
                                        <?php echo $uploadedby; ?>
                                    </span>
                                </div>
                            </div>
                            <div class="info-card-actions">
                                <a href="informasi_files/<?php echo $namafile; ?>" 
                                   class="btn-download" 
                                   target="_blank" 
                                   download 
                                   title="Download PDF">
                                    <i class="fa fa-download"></i>
                                    Download PDF
                                </a>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="no-data">
                        <i class="fa fa-folder-open"></i>
                        <h3>Tidak ada dokumen</h3>
                        <p>Maaf, tidak ada dokumen yang tersedia pada kategori yang dipilih</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

    </div>

    <!-- FOOTER (dari file footer Anda) -->

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script>
        // Active state untuk filter button
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                if(this.classList.contains('active')) {
                    e.preventDefault();
                }
            });
        });
    </script>
</body>
</html>