<?php
session_start();
error_reporting(0);
include('include/config.php');

// Cek session login
if(strlen($_SESSION['id']==0)) {
    header('location:logout.php');
    exit;
}

// Ambil filter tanggal dari URL
$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';

// Query berdasarkan filter
if($start_date && $end_date) {
    $sql = mysqli_query($con, "SELECT * FROM tblcontactus WHERE IsRead IS NOT NULL AND DATE(PostingDate) BETWEEN '$start_date' AND '$end_date' ORDER BY PostingDate DESC");
    $periode = date('d-m-Y', strtotime($start_date)) . ' s/d ' . date('d-m-Y', strtotime($end_date));
} else {
    $sql = mysqli_query($con, "SELECT * FROM tblcontactus WHERE IsRead IS NOT NULL ORDER BY PostingDate DESC");
    $periode = 'Semua Data';
}

$total = mysqli_num_rows($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Read Queries</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        @media print {
            .no-print { display: none !important; }
            body { background: white; margin: 0; }
            @page { 
                margin: 20mm;
                size: A4 landscape;
            }
        }

        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background: #fafafa;
        }

        .container {
            max-width: 1100px;
            margin: 0 auto;
            background: white;
            padding: 30px;
        }

        /* Filter */
        .filter {
            background: #f5f5f5;
            padding: 15px;
            margin-bottom: 20px;
            display: flex;
            gap: 10px;
            align-items: end;
        }

        .filter input {
            padding: 8px;
            border: 1px solid #ddd;
            font-size: 14px;
        }

        .filter button {
            padding: 8px 20px;
            background: #333;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 14px;
        }

        .filter a {
            padding: 8px 20px;
            background: #666;
            color: white;
            text-decoration: none;
            font-size: 14px;
        }

        /* Buttons */
        .buttons {
            text-align: right;
            margin-bottom: 20px;
        }

        .buttons button {
            padding: 10px 20px;
            background: #333;
            color: white;
            border: none;
            cursor: pointer;
            margin-left: 10px;
            font-size: 14px;
        }

        /* Header */
        h1 {
            font-size: 24px;
            margin-bottom: 10px;
            text-align: center;
        }

        .info {
            text-align: center;
            font-size: 14px;
            color: #666;
            padding-bottom: 15px;
            margin-bottom: 30px;
            border-bottom: 3px solid #000;
        }

        /* Table */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th {
            background: #333;
            color: white;
            padding: 12px 8px;
            text-align: left;
            font-size: 13px;
        }

        td {
            padding: 10px 8px;
            border-bottom: 1px solid #ddd;
            font-size: 13px;
        }

        tr:nth-child(even) {
            background: #f9f9f9;
        }

        /* Footer */
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 13px;
            padding-top: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        
        <!-- Filter -->
        <div class="filter no-print">
            <form method="GET" style="display: flex; gap: 10px; align-items: end; flex: 1;">
                <div>
                    <label style="font-size: 12px; display: block; margin-bottom: 3px;">Dari:</label>
                    <input type="date" name="start_date" value="<?php echo $start_date; ?>" required>
                </div>
                <div>
                    <label style="font-size: 12px; display: block; margin-bottom: 3px;">Sampai:</label>
                    <input type="date" name="end_date" value="<?php echo $end_date; ?>" required>
                </div>
                <button type="submit">Filter</button>
                <a href="download-read-queries-pdf.php">Reset</a>
            </form>
        </div>

        <!-- Buttons -->
        <div class="buttons no-print">
            <button onclick="window.print()">Print PDF</button>
            <button onclick="window.close()">Tutup</button>
        </div>

        <!-- Header -->
        <h1>LAPORAN READ QUERIES</h1>
        <div class="info">
            Periode: <?php echo $periode; ?> | 
            Total: <?php echo $total; ?> data | 
            Dicetak: <?php echo date('d-m-Y H:i'); ?>
        </div>

        <!-- Table -->
        <table>
            <thead>
                <tr>
                    <th width="4%">No</th>
                    <th width="18%">Nama</th>
                    <th width="20%">Email</th>
                    <th width="12%">No. Telepon</th>
                    <th width="36%">Pesan</th>
                    <th width="10%">Tanggal</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if($total > 0) {
                    $no = 1;
                    while($row = mysqli_fetch_array($sql)) {
                ?>
                <tr>
                    <td style="text-align:center;"><?php echo $no; ?></td>
                    <td><?php echo htmlspecialchars($row['fullname']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo htmlspecialchars($row['contactno']); ?></td>
                    <td><?php echo htmlspecialchars($row['message']); ?></td>
                    <td><?php echo date('d-m-Y', strtotime($row['PostingDate'])); ?></td>
                </tr>
                <?php
                    $no++;
                    }
                } else {
                ?>
                <tr>
                    <td colspan="6" style="text-align:center; padding: 30px; color: #999;">
                        Tidak ada data
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>

        <!-- Footer -->
        <div class="footer">
            <strong>Total: <?php echo $total; ?> Read Queries</strong>
        </div>

    </div>
</body>
</html>