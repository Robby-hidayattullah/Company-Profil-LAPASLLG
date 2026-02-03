 <!-- INFORMASI PUBLIK SECTION -->
    <section id="informasi_publik" class="informasi-publik-section">
        <div class="container">
            <div class="section-title text-center">
                <h2>Informasi Publik</h2>
                <p>Akses dokumen dan informasi publik yang tersedia</p>
                <div class="title-line"></div>
            </div>

            <div class="row">
                <?php
                // Pagination settings
                $docsPerPage = 6;

                // Get total dokumen
                $totalQuery = mysqli_query($con, "SELECT COUNT(*) as total FROM tblinformasipublik WHERE Status='Aktif'");
                $totalRow = mysqli_fetch_assoc($totalQuery);
                $totalDocs = $totalRow['total'];
                $totalPages = ceil($totalDocs / $docsPerPage);

                // Get current page
                $currentPage = isset($_GET['info_page']) ? max(1, intval($_GET['info_page'])) : 1;
                $currentPage = min($currentPage, max(1, $totalPages));

                // Calculate offset
                $offset = ($currentPage - 1) * $docsPerPage;

                // Get dokumen for current page
                $query_info = mysqli_query($con, "SELECT * FROM tblinformasipublik WHERE Status='Aktif' ORDER BY TanggalUnggah DESC LIMIT {$offset}, {$docsPerPage}");

                if (mysqli_num_rows($query_info) > 0) {
                    while ($info = mysqli_fetch_array($query_info)) {
                        $deskripsi_pendek = substr(strip_tags($info['Deskripsi']), 0, 150);
                        if (strlen(strip_tags($info['Deskripsi'])) > 150) {
                            $deskripsi_pendek .= '...';
                        }

                        $tanggal = date('d M Y', strtotime($info['TanggalUnggah']));
                ?>

                        <div class="col-lg-4 col-md-6 col-12 mb-4">
                            <div class="info-card">
                                <div class="info-header">
                                    <div class="info-kategori">
                                        <span class="badge badge-<?php
                                                                    if ($info['Kategori'] == 'Laporan') echo 'primary';
                                                                    elseif ($info['Kategori'] == 'Bukti Pencapaian') echo 'success';
                                                                    elseif ($info['Kategori'] == 'Regulasi') echo 'warning';
                                                                    elseif ($info['Kategori'] == 'SOP') echo 'info';
                                                                    else echo 'default';
                                                                    ?>">
                                            <i class="fa fa-folder-o"></i> <?php echo $info['Kategori']; ?>
                                        </span>
                                    </div>
                                    <div class="file-badge">
                                        <i class="fa fa-file-pdf-o"></i> PDF
                                    </div>
                                </div>

                                <div class="info-content">
                                    <div class="info-meta">
                                        <span><i class="fa fa-calendar"></i> <?php echo $tanggal; ?></span>
                                        <span><i class="fa fa-user"></i> <?php echo htmlentities($info['UplodedBy']); ?></span>
                                    </div>
                                    <h3 class="info-title cursor-pointer" data-toggle="modal" data-target="#infoModal<?php echo $info['id']; ?>" title="Klik untuk melihat detail">
                                        <?php echo htmlentities($info['JudulInformasi']); ?>
                                    </h3>
                                    <p class="info-excerpt"><?php echo $deskripsi_pendek; ?></p>

                                    <div class="info-actions">
                                        <a href="hms/admin/informasi_files/<?php echo htmlentities($info['NamaFile']); ?>"
                                            target="_blank" class="btn-info-action btn-download">
                                            <i class="fa fa-download"></i> Unduh
                                        </a>
                                        <button class="btn-info-action btn-preview"
                                            data-toggle="modal" data-target="#infoModal<?php echo $info['id']; ?>">
                                            <i class="fa fa-eye"></i> Lihat Detail
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Detail Informasi -->
                        <div class="modal fade" id="infoModal<?php echo $info['id']; ?>" tabindex="-1" role="dialog">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title"><?php echo htmlentities($info['JudulInformasi']); ?></h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="info-meta mb-3">
                                            <span class="badge badge-<?php
                                                                        if ($info['Kategori'] == 'Laporan') echo 'primary';
                                                                        elseif ($info['Kategori'] == 'Bukti Pencapaian') echo 'success';
                                                                        elseif ($info['Kategori'] == 'Regulasi') echo 'warning';
                                                                        elseif ($info['Kategori'] == 'SOP') echo 'info';
                                                                        else echo 'default';
                                                                        ?>">
                                                <i class="fa fa-folder-o"></i> <?php echo $info['Kategori']; ?>
                                            </span>
                                            <span style="margin-left: 10px;"><i class="fa fa-calendar"></i> <?php echo $tanggal; ?></span>
                                            <span style="margin-left: 10px;"><i class="fa fa-user"></i> <?php echo htmlentities($info['UplodedBy']); ?></span>
                                            <span style="margin-left: 10px;"><i class="fa fa-file-pdf-o"></i> PDF</span>
                                        </div>
                                        <hr>
                                        <div class="info-content-full">
                                            <h5>Deskripsi:</h5>
                                            <p><?php echo nl2br(htmlentities($info['Deskripsi'])); ?></p>
                                        </div>
                                        <hr>
                                        <div class="info-preview">
                                            <h5>Preview Dokumen:</h5>
                                            <iframe src="hms/admin/informasi_files/<?php echo htmlentities($info['NamaFile']); ?>"
                                                style="width: 100%; height: 500px; border: 1px solid #ddd; border-radius: 8px;">
                                            </iframe>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <a href="hms/admin/informasi_files/<?php echo htmlentities($info['NamaFile']); ?>"
                                            target="_blank" class="btn btn-primary">
                                            <i class="fa fa-download"></i> Unduh Dokumen
                                        </a>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php
                    }
                } else {
                    ?>
                    <div class="col-12">
                        <div class="no-info">
                            <i class="fa fa-file-text-o fa-5x text-muted"></i>
                            <h4>Belum Ada Informasi Publik</h4>
                            <p>Dokumen informasi publik akan ditampilkan di sini</p>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>

            <!-- Informasi Pagination -->
            <?php if ($totalDocs > $docsPerPage): ?>
                <div class="info-pagination text-center mt-5">
                    <?php if ($currentPage > 1): ?>
                        <a href="?info_page=<?php echo $currentPage - 1; ?>#informasi_publik" class="btn btn-pagination btn-prev">
                            <i class="fas fa-chevron-left"></i> Dokumen Sebelumnya
                        </a>
                    <?php else: ?>
                        <button class="btn btn-pagination btn-prev" disabled>
                            <i class="fas fa-chevron-left"></i> Dokumen Sebelumnya
                        </button>
                    <?php endif; ?>

                    <span class="info-page-info">
                        Halaman <?php echo $currentPage; ?> dari <?php echo $totalPages; ?>
                    </span>

                    <?php if ($currentPage < $totalPages): ?>
                        <a href="?info_page=<?php echo $currentPage + 1; ?>#informasi_publik" class="btn btn-pagination btn-next">
                            Dokumen Berikutnya <i class="fas fa-chevron-right"></i>
                        </a>
                    <?php else: ?>
                        <button class="btn btn-pagination btn-next" disabled>
                            Dokumen Berikutnya <i class="fas fa-chevron-right"></i>
                        </button>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- CSS untuk Informasi Publik - Letakkan di bagian style atau file CSS -->
    <style>
        /* ==================== INFORMASI PUBLIK SECTION ==================== */
        .informasi-publik-section {
            padding: 80px 0;
            background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
        }

        .info-card {
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            transition: all 0.4s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
            border: 1px solid var(--border-gray);
        }

        .info-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.15);
            border-color: var(--accent-blue);
        }

        .info-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .info-kategori .badge {
            padding: 6px 14px;
            font-size: 11px;
            font-weight: 700;
            border-radius: 20px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            background: rgba(255, 255, 255, 0.25);
            color: white;
        }

        .file-badge {
            background: rgba(231, 76, 60, 0.9);
            color: #ffffff;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .info-content {
            padding: 25px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .info-meta {
            font-size: 12px;
            color: #999;
            margin-bottom: 12px;
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        .info-meta i {
            margin-right: 4px;
            color: var(--accent-blue);
        }

        .info-title {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--primary-navy);
            margin-bottom: 12px;
            line-height: 1.4;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .info-title.cursor-pointer {
            cursor: pointer;
            transition: color 0.3s;
        }

        .info-title.cursor-pointer:hover {
            color: var(--accent-blue);
        }

        .info-excerpt {
            color: #666;
            font-size: 0.95rem;
            line-height: 1.6;
            margin-bottom: 15px;
            flex: 1;
        }

        .info-actions {
            display: flex;
            gap: 10px;
            margin-top: auto;
        }

        .btn-info-action {
            flex: 1;
            padding: 10px 15px;
            border: none;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
            text-decoration: none;
            display: inline-block;
        }

        .btn-download {
            background: linear-gradient(135deg, var(--primary-navy), var(--secondary-navy));
            color: #ffffff;
        }

        .btn-download:hover {
            background: linear-gradient(135deg, var(--secondary-navy), var(--primary-navy));
            color: #ffffff;
            text-decoration: none;
            transform: scale(1.02);
        }

        .btn-preview {
            background: #ffffff;
            color: var(--accent-blue);
            border: 2px solid var(--accent-blue);
        }

        .btn-preview:hover {
            background: var(--accent-blue);
            color: #ffffff;
            transform: scale(1.02);
        }

        .no-info {
            padding: 80px 20px;
            text-align: center;
        }

        .no-info i {
            margin-bottom: 20px;
            color: #bbb;
        }

        .no-info h4 {
            color: #666;
            margin-bottom: 10px;
        }

        .no-info p {
            color: #999;
        }

        /* Info Pagination */
        .info-pagination {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 50px;
            flex-wrap: wrap;
            align-items: center;
        }

        .info-page-info {
            display: inline-block;
            padding: 12px 20px;
            color: var(--primary-navy);
            font-weight: 600;
            font-size: 0.95rem;
            background: var(--light-blue);
            border-radius: 8px;
            min-width: 180px;
            letter-spacing: 0.3px;
        }

        .info-content-full {
            font-size: 0.95rem;
            line-height: 1.8;
            color: #444;
        }

        .info-preview h5,
        .info-content-full h5 {
            color: var(--primary-navy);
            font-weight: 600;
            margin-bottom: 15px;
        }

        @media (max-width: 768px) {
            .info-actions {
                flex-direction: column;
            }

            .btn-info-action {
                width: 100%;
            }
        }

        @media (max-width: 576px) {
            .info-pagination {
                gap: 10px;
                margin-top: 40px;
            }
        }
    </style>