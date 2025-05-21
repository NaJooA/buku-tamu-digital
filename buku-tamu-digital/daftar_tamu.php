<?php

require_once 'koneksi.php';

$where = "";
if (isset($_GET['cari'])) {
    $kata_kunci = mysqli_real_escape_string($koneksi, $_GET['kata_kunci']);
    $where = "WHERE nama LIKE '%$kata_kunci%' OR instansi LIKE '%$kata_kunci%'";
}

$sql = "SELECT * FROM buku_tamu $where ORDER BY id DESC";
$result = mysqli_query($koneksi, $sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buku Tamu Digital - Daftar Tamu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #6366F1;
            --primary-light: #818CF8;
            --primary-dark: #4F46E5;
            --accent-color: #C4B5FD;
            --text-color: #1E293B;
            --light-text: #64748B;
            --bg-color: #F8FAFC;
            --card-color: #FFFFFF;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            margin: 0;
            color: var(--text-color);
        }
        
        .container {
            max-width: 1200px;
            margin: 40px auto;
        }
        
        .card {
            background-color: var(--card-color);
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            overflow: hidden;
            margin-bottom: 30px;
            border: none;
            padding: 40px;
        }
        
        .table-title {
            color: var(--primary-color);
            text-align: center;
            margin-bottom: 30px;
            font-weight: 600;
            font-size: 28px;
        }
        
        .nav-tabs {
            border-bottom: 2px solid #e2e8f0;
            margin-bottom: 30px;
        }
        
        .nav-tabs .nav-link {
            border: none;
            color: var(--light-text);
            font-weight: 500;
            padding: 10px 20px;
            border-radius: 0;
            margin-right: 20px;
            position: relative;
        }
        
        .nav-tabs .nav-link.active {
            color: var(--primary-color);
            background: transparent;
            font-weight: 600;
        }
        
        .nav-tabs .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 100%;
            height: 3px;
            background-color: var(--primary-color);
            border-top-left-radius: 3px;
            border-top-right-radius: 3px;
        }
        
        .form-control {
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 12px 15px;
            font-size: 15px;
            transition: all 0.3s;
        }
        
        .form-control:focus {
            border-color: var(--primary-light);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            border: none;
            border-radius: 12px;
            padding: 12px 20px;
            font-weight: 500;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 10px rgba(79, 70, 229, 0.2);
            transition: all 0.3s;
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-color) 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(79, 70, 229, 0.3);
        }
        
        .search-container {
            background: #f8fafc;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 30px;
            border: 1px solid #e2e8f0;
        }
        
        table {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            border-collapse: separate;
            border-spacing: 0;
        }
        
        .table-striped > tbody > tr:nth-of-type(odd) > * {
            background-color: #f8fafc;
        }
        
        .table > :not(caption) > * > * {
            padding: 15px 20px;
            vertical-align: middle;
        }
        
        thead {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-color) 100%);
            color: white;
        }
        
        .table-hover tbody tr:hover {
            background-color: rgba(99, 102, 241, 0.05) !important;
        }
        
        .decoration-circle-1 {
            position: fixed;
            width: 300px;
            height: 300px;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            top: -150px;
            right: -150px;
            z-index: -1;
        }
        
        .decoration-circle-2 {
            position: fixed;
            width: 200px;
            height: 200px;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            bottom: -100px;
            left: -100px;
            z-index: -1;
        }
        
        .empty-state {
            text-align: center;
            padding: 30px;
            color: var(--light-text);
        }
        
        .empty-state i {
            font-size: 48px;
            margin-bottom: 20px;
            color: var(--accent-color);
        }
    </style>
</head>
<body>
    <div class="decoration-circle-1"></div>
    <div class="decoration-circle-2"></div>
    
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card shadow">
                    <h1 class="table-title">Daftar Tamu</h1>
                    
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">
                                <i class="fas fa-edit me-2"></i>Form Tamu
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="daftar_tamu.php">
                                <i class="fas fa-list me-2"></i>Daftar Tamu
                            </a>
                        </li>
                    </ul>
                    
                    <div class="search-container">
                        <form action="" method="get">
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="input-group">
                                        <span class="input-group-text" style="border-radius: 12px 0 0 12px; background-color: white; border: 2px solid #e2e8f0; border-right: none;">
                                            <i class="fas fa-search"></i>
                                        </span>
                                        <input type="text" name="kata_kunci" class="form-control" style="border-radius: 0 12px 12px 0; border-left: none;" placeholder="Cari berdasarkan nama atau instansi..." value="<?php echo isset($_GET['kata_kunci']) ? htmlspecialchars($_GET['kata_kunci']) : ''; ?>">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="d-grid">
                                        <button type="submit" name="cari" class="btn btn-primary">
                                            <i class="fas fa-search me-2"></i>Cari
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th width="5%">No.</th>
                                    <th width="20%">Nama Lengkap</th>
                                    <th width="20%">Instansi</th>
                                    <th width="30%">Tujuan</th>
                                    <th width="15%">Tanggal</th>
                                    <th width="10%">Waktu</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (mysqli_num_rows($result) > 0) {
                                    $no = 1;
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<tr>";
                                        echo "<td>" . $no . "</td>";
                                        echo "<td>" . htmlspecialchars($row['nama']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['instansi']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['tujuan']) . "</td>";
                                        echo "<td>" . date('d-m-Y', strtotime($row['tanggal'])) . "</td>";
                                        echo "<td>" . date('H:i', strtotime($row['waktu'])) . "</td>";
                                        echo "</tr>";
                                        $no++;
                                    }
                                } else {
                                    echo '<tr><td colspan="6">
                                        <div class="empty-state">
                                            <i class="fas fa-inbox"></i>
                                            <h4>Tidak ada data tamu</h4>
                                            <p>Belum ada data tamu yang tersimpan atau tidak ditemukan hasil pencarian.</p>
                                        </div>
                                    </td></tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <?php if (isset($_GET['cari']) && mysqli_num_rows($result) > 0): ?>
                    <div class="text-end mt-3">
                        <a href="daftar_tamu.php" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-1"></i> Reset Pencarian
                        </a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>