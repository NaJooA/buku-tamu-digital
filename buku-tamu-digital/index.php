<?php
require_once 'koneksi.php';

$pesan = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $instansi = mysqli_real_escape_string($koneksi, $_POST['instansi']);
    $tujuan = mysqli_real_escape_string($koneksi, $_POST['tujuan']);
    
    $tanggal = date("Y-m-d");
    $waktu = date("H:i:s");

    $sql = "INSERT INTO buku_tamu (nama, instansi, tujuan, tanggal, waktu) 
            VALUES ('$nama', '$instansi', '$tujuan', '$tanggal', '$waktu')";
    
    if (mysqli_query($koneksi, $sql)) {
        $pesan = "<div class='alert-success'>Data tamu berhasil disimpan!</div>";
    } else {
        $pesan = "<div class='alert-danger'>Error: " . mysqli_error($koneksi) . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buku Tamu Digital - Form Tamu</title>
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
            max-width: 1000px;
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
        
        .form-title {
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
        
        .form-label {
            font-weight: 500;
            color: var(--text-color);
            margin-bottom: 8px;
        }
        
        .form-control {
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 12px 15px;
            font-size: 15px;
            transition: all 0.3s;
            margin-bottom: 15px;
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
        
        .alert-success {
            background-color: #DCFCE7;
            color: #166534;
            padding: 15px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-weight: 500;
            display: flex;
            align-items: center;
        }
        
        .alert-success::before {
            content: '\f058';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            margin-right: 10px;
            font-size: 18px;
        }
        
        .alert-danger {
            background-color: #FEE2E2;
            color: #B91C1C;
            padding: 15px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-weight: 500;
            display: flex;
            align-items: center;
        }
        
        .alert-danger::before {
            content: '\f057';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            margin-right: 10px;
            font-size: 18px;
        }
        
        .form-text {
            color: var(--light-text);
            font-size: 13px;
            margin-top: 5px;
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
    </style>
</head>
<body>
    <div class="decoration-circle-1"></div>
    <div class="decoration-circle-2"></div>
    
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow">
                    <h1 class="form-title">Buku Tamu Digital</h1>
                    
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" href="index.php">
                                <i class="fas fa-edit me-2"></i>Form Tamu
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="daftar_tamu.php">
                                <i class="fas fa-list me-2"></i>Daftar Tamu
                            </a>
                        </li>
                    </ul>
                    
                    <?php echo $pesan; ?>
                    
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <div class="mb-4">
                            <label for="nama" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan nama lengkap" required>
                        </div>
                        
                        <div class="mb-4">
                            <label for="instansi" class="form-label">Instansi</label>
                            <input type="text" class="form-control" id="instansi" name="instansi" placeholder="Masukkan nama instansi" required>
                        </div>
                        
                        <div class="mb-4">
                            <label for="tujuan" class="form-label">Tujuan Kedatangan</label>
                            <textarea class="form-control" id="tujuan" name="tujuan" rows="3" placeholder="Jelaskan tujuan kedatangan Anda" required></textarea>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label">Tanggal & Waktu Kedatangan</label>
                            <div class="input-group">
                                <span class="input-group-text" style="border-radius: 12px 0 0 12px; background-color: #f8fafc; border: 2px solid #e2e8f0; border-right: none;">
                                    <i class="far fa-calendar-alt"></i>
                                </span>
                                <input type="text" class="form-control" style="border-radius: 0 12px 12px 0; border-left: none;" value="<?php echo date('d-m-Y H:i:s'); ?>" disabled>
                            </div>
                            <div class="form-text">
                                <i class="fas fa-info-circle me-1"></i>Tanggal dan waktu diisi otomatis oleh sistem
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-paper-plane me-2"></i>Simpan Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>