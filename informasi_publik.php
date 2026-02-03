<?php
include_once('hms/include/config.php');
if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($con, $_POST['fullname']);
    $email = mysqli_real_escape_string($con, $_POST['emailid']);
    $mobileno = mysqli_real_escape_string($con, $_POST['mobileno']);
    $dscrption = mysqli_real_escape_string($con, $_POST['description']);

    $query = mysqli_query($con, "INSERT INTO tblcontactus(fullname,email,contactno,message) VALUES('$name','$email','$mobileno','$dscrption')");

    if ($query) {
        echo "<script>alert('Informasi Anda berhasil dikirim. Terima kasih!');</script>";
        echo "<script>window.location.href='index.php'</script>";
    }
}
?>
<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Lembaga Pemasyarakatan Kelas IIA Lubuk Linggau</title>

    <link rel="shortcut icon" href="assets/images/fav.jpg">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/fontawsom-all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="assets/css/animate.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-navy: #1a3a52;
            --secondary-navy: #2c5f7f;
            --accent-blue: #4a90c0;
            --light-blue: #e8f1f8;
            --dark-navy: #0f2537;
            --gold-accent: #d4af37;
            --danger-red: #e74c3c;
            --success-green: #27ae60;
            --warning-yellow: #f39c12;
            --light-gray: #f8f9fa;
            --border-gray: #e0e0e0;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
            overflow-x: hidden;
            line-height: 1.6;
        }

        /* ==================== HEADER & NAVIGATION ==================== */
        #menu-jk {
            background: rgba(26, 58, 82, 0.95) !important;
            backdrop-filter: blur(10px) !important;
            -webkit-backdrop-filter: blur(10px) !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1) !important;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.15) !important;
            position: fixed !important;
            width: 100% !important;
            top: 0 !important;
            z-index: 1000 !important;
            transition: all 0.3s ease !important;
            padding: 1px 0 !important;
            height: auto !important;
        }

        .header-nav {
            padding: 1px 0;
            background: transparent !important;
        }

        #nav-head {
            background: transparent !important;
        }

        .container {
            background: transparent !important;
        }

        .row {
            background: transparent !important;
            margin: 0 !important;
        }

        .logo-container {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 0px;
        }

        .company-logo {
            max-height: 40px;
            width: auto;
            filter: brightness(1.05);
            transition: transform 0.3s ease;
        }

        .company-logo:hover {
            transform: scale(1.05);
        }

        .logo-text {
            color: #FFFFFF;
            font-size: 11px;
            font-weight: 700;
            line-height: 1.25;
            letter-spacing: 0.2px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);
            margin-left: 8px;
            font-family: 'Montserrat', sans-serif;
            text-transform: uppercase;
        }

        .navbar-toggler {
            background: transparent;
            border: 2px solid #ffffff;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .navbar-toggler:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .small-menu {
            color: #ffffff;
            font-size: 1.8rem;
        }

        .nav-item {
            padding: 0 !important;
        }

        .nav-item ul {
            list-style: none;
            display: flex;
            justify-content: flex-start;
            align-items: center;
            gap: 3px;
            margin: 0 !important;
            padding: 0 !important;
        }

        .nav-item ul li {
            position: relative;
        }

        .nav-item ul li a {
            color: #FFFFFF !important;
            text-decoration: none;
            padding: 5px 8px;
            display: block;
            font-weight: 500;
            font-size: 13px;
            transition: all 0.3s ease;
            border-radius: 5px;
            position: relative;
            letter-spacing: 0px;
            background: transparent;
            white-space: nowrap;
        }

        .nav-item ul li .dropdown-menu {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            background: rgba(26, 58, 82, 0.98);
            backdrop-filter: blur(10px);
            min-width: 220px;
            border-radius: 8px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
            padding: 10px 0;
            z-index: 1000;
            margin-top: 5px;
        }

        .nav-item ul li:hover .dropdown-menu {
            display: block;
            animation: fadeInDown 0.3s ease-out;
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .dropdown-menu li {
            width: 100%;
        }

        .dropdown-menu li a {
            padding: 10px 15px;
            font-size: 13px;
            border-radius: 0;
            display: block;
            white-space: nowrap;
            transition: all 0.3s ease;
        }

        .dropdown-menu li a:hover {
            background: rgba(74, 144, 192, 0.3);
            padding-left: 20px;
        }

        .dropdown-menu li a::after {
            display: none;
        }

        .nav-item ul li.has-dropdown>a::after {
            content: '\f107';
            font-family: 'FontAwesome';
            margin-left: 5px;
            font-size: 11px;
        }

        .nav-item ul li a:hover {
            background: rgba(74, 144, 192, 0.25);
            color: #FFFFFF !important;
            transform: translateY(-1px);
        }

        .nav-item ul li a::before {
            content: '';
            position: absolute;
            bottom: 2px;
            left: 50%;
            transform: translateX(-50%) scaleX(0);
            width: 60%;
            height: 2px;
            background: linear-gradient(90deg, transparent, #4a90c0, transparent);
            transition: transform 0.3s ease;
        }

        .nav-item ul li a:hover::before {
            transform: translateX(-50%) scaleX(1);
        }

        .appoint .btn {
            background: linear-gradient(135deg, #4a90c0, #3d7ba8) !important;
            border: none !important;
            color: #FFFFFF !important;
            padding: 9px 18px;
            font-weight: 600;
            font-size: 13px;
            border-radius: 5px;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(74, 144, 192, 0.3);
            text-decoration: none;
            display: inline-block;
            white-space: nowrap;
        }

        .appoint .btn:hover {
            background: linear-gradient(135deg, #3d7ba8, #2d5a7f) !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(74, 144, 192, 0.4);
        }

        #menu-jk.scrolled {
            background: rgba(26, 58, 82, 0.98) !important;
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            box-shadow: 0 3px 20px rgba(0, 0, 0, 0.2);
            padding: 5px 0 !important;
        }

        /* ==================== SLIDER SECTION ==================== */
        .slider-detail {
            margin-top: 70px;
            position: relative;
        }

        .carousel-item img {
            height: 600px;
            object-fit: cover;
            filter: brightness(0.7);
        }

        .carousel-cover {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(26, 58, 82, 0.7) 0%, rgba(44, 95, 127, 0.5) 100%);
        }

        /* Carousel Controls - Professional Style */
        .carousel-control-prev,
        .carousel-control-next {
            width: auto;
            height: auto;
            top: 50%;
            transform: translateY(-50%);
            background: transparent !important;
            border-radius: 0;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .carousel-control-prev:hover,
        .carousel-control-next:hover {
            background: transparent !important;
            transform: translateY(-50%) scale(1.15);
        }

        .carousel-control-prev:active,
        .carousel-control-next:active {
            transform: translateY(-50%) scale(0.95);
        }

        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            width: 30px;
            height: 30px;
            background-size: 100%, 100%;
            background-image: none;
        }

        .carousel-control-prev-icon::before {
            content: '‹';
            color: #ffffff;
            font-size: 36px;
            font-weight: bold;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .carousel-control-next-icon::before {
            content: '›';
            color: #ffffff;
            font-size: 36px;
            font-weight: bold;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .carousel-control-prev {
            left: 20px;
        }

        .carousel-control-next {
            right: 20px;
        }

        /* Carousel Indicators */
        .carousel-indicators li {
            background-color: rgba(255, 255, 255, 0.5);
            border-radius: 50%;
            width: 12px;
            height: 12px;
            transition: all 0.3s ease;
        }

        .carousel-indicators .active {
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
        }

        .carousel-caption {
            z-index: 10;
        }

        .welcome-container {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 50px;
            margin: 0 auto;
        }

        .welcome-container .sipadek-left {
            max-height: 320px;
            width: auto;
            animation: float 3s ease-in-out infinite;
            filter: drop-shadow(0 10px 25px rgba(0, 0, 0, 0.5));
            flex-shrink: 0;
        }

        .welcome-container h5 {
            font-size: 3rem !important;
            line-height: 1.3;
            text-align: left;
            margin: 0;
            max-width: 750px;
            font-weight: 800;
            letter-spacing: 0.5px;
        }

        .welcome-greeting {
            display: block;
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: 10px;
            opacity: 0.95;
        }

        .welcome-title {
            display: block;
            background: linear-gradient(135deg, #ffffff, #e8f1f8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        /* ==================== BERITA SECTION ==================== */
        .berita-section {
            padding: 80px 0;
            background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
        }

        .section-title {
            margin-bottom: 50px;
        }

        .section-title h2 {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--primary-navy);
            margin-bottom: 10px;
            letter-spacing: 1px;
        }

        .section-title p {
            color: #666;
            font-size: 1rem;
            margin-bottom: 20px;
        }

        .title-line {
            width: 80px;
            height: 4px;
            background: linear-gradient(90deg, var(--accent-blue), var(--gold-accent));
            margin: 0 auto;
            border-radius: 2px;
        }

        .berita-card {
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

        .berita-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.15);
            border-color: var(--accent-blue);
        }

        .berita-image {
            position: relative;
            height: 220px;
            overflow: hidden;
        }

        .berita-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
        }

        .berita-card:hover .berita-image img {
            transform: scale(1.08);
        }

        .berita-kategori {
            position: absolute;
            top: 12px;
            left: 12px;
        }

        .berita-kategori .badge {
            padding: 6px 14px;
            font-size: 11px;
            font-weight: 700;
            border-radius: 20px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }

        .badge-success {
            background: linear-gradient(135deg, #27ae60, #229954);
            color: white;
        }

        .badge-primary {
            background: linear-gradient(135deg, #3498db, #2980b9);
            color: white;
        }

        .badge-warning {
            background: linear-gradient(135deg, #f39c12, #e67e22);
            color: white;
        }

        .badge-info {
            background: linear-gradient(135deg, #1abc9c, #16a085);
            color: white;
        }

        .berita-content {
            padding: 25px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .berita-meta {
            font-size: 12px;
            color: #999;
            margin-bottom: 12px;
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        .berita-meta i {
            margin-right: 4px;
            color: var(--accent-blue);
        }

        .berita-title {
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

        .berita-title.cursor-pointer {
            cursor: pointer;
            transition: color 0.3s;
        }

        .berita-title.cursor-pointer:hover {
            color: var(--accent-blue);
        }

        .berita-excerpt {
            color: #666;
            font-size: 0.95rem;
            line-height: 1.6;
            margin-bottom: 15px;
            flex: 1;
        }

        /* Berita Pagination */
        .berita-pagination {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 50px;
            flex-wrap: wrap;
            align-items: center;
        }

        .btn-pagination {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 12px 30px;
            font-weight: 600;
            font-size: 0.95rem;
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.3s ease;
            border: 2px solid var(--accent-blue);
            color: var(--accent-blue);
            background: transparent;
            cursor: pointer;
            letter-spacing: 0.5px;
        }

        .btn-pagination:hover {
            background: var(--accent-blue);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(74, 144, 192, 0.3);
            text-decoration: none;
        }

        .btn-pagination i {
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .btn-pagination.btn-prev:hover i {
            transform: translateX(-5px);
        }

        .btn-pagination.btn-next:hover i {
            transform: translateX(5px);
        }

        .btn-pagination:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            border-color: #bbb;
            color: #bbb;
        }

        .btn-pagination:disabled:hover {
            background: transparent;
            transform: none;
            box-shadow: none;
        }

        .berita-page-info {
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

        @media (max-width: 576px) {
            .berita-pagination {
                gap: 10px;
                margin-top: 40px;
            }

            .btn-pagination {
                padding: 10px 20px;
                font-size: 0.9rem;
            }
        }

        .no-berita {
            padding: 80px 20px;
            text-align: center;
        }

        .no-berita i {
            margin-bottom: 20px;
            color: #bbb;
        }

        .no-berita h4 {
            color: #666;
            margin-bottom: 10px;
        }

        .no-berita p {
            color: #999;
        }

        /* Modal Styles */
        .modal-content {
            border: none;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
        }

        .modal-header {
            background: linear-gradient(135deg, var(--primary-navy), var(--secondary-navy));
            color: white;
            border-bottom: none;
            border-radius: 12px 12px 0 0;
            padding: 25px;
        }

        .modal-title {
            font-size: 1.5rem;
            font-weight: 700;
        }

        .modal-header .close {
            color: white;
            opacity: 0.8;
            transition: all 0.3s;
        }

        .modal-header .close:hover {
            opacity: 1;
        }

        .berita-content-full {
            font-size: 0.95rem;
            line-height: 1.8;
            color: #444;
        }

        /* ==================== VISI MISI SECTION ==================== */
        .visi-misi-section {
            padding: 80px 0;
            background: linear-gradient(135deg, #ffffff 0%, var(--light-blue) 100%);
            position: relative;
            overflow: hidden;
        }

        .visi-misi-section::before {
            content: '';
            position: absolute;
            top: -150px;
            right: -150px;
            width: 700px;
            height: 700px;
            background: radial-gradient(circle, rgba(74, 144, 192, 0.05) 0%, transparent 70%);
            border-radius: 50%;
        }

        .visi-misi-section::after {
            content: '';
            position: absolute;
            bottom: -150px;
            left: -150px;
            width: 800px;
            height: 800px;
            background: radial-gradient(circle, rgba(74, 144, 192, 0.04) 0%, transparent 70%);
            border-radius: 50%;
        }

        .visi-misi-container {
            position: relative;
            z-index: 1;
        }

        .inner-title {
            text-align: center;
            margin-bottom: 50px;
            position: relative;
        }

        .inner-title h2 {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--primary-navy);
            position: relative;
            display: inline-block;
            padding-bottom: 15px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
        }

        .inner-title h2::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 4px;
            background: linear-gradient(90deg, var(--accent-blue), var(--gold-accent), var(--accent-blue));
            border-radius: 2px;
        }

        .inner-title p {
            color: #666;
            font-size: 1rem;
            margin-top: 12px;
            line-height: 1.6;
        }

        .visi-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 40px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
            transition: all 0.4s ease;
            border: 1px solid rgba(74, 144, 192, 0.1);
        }

        .visi-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 45px rgba(0, 0, 0, 0.15);
        }

        .visi-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 5px;
            height: 100%;
            background: linear-gradient(180deg, var(--accent-blue) 0%, var(--gold-accent) 100%);
        }

        .visi-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
            position: relative;
            z-index: 1;
        }

        .visi-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, var(--accent-blue) 0%, var(--primary-navy) 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 20px rgba(74, 144, 192, 0.3);
            flex-shrink: 0;
        }

        .visi-icon i {
            font-size: 1.8rem;
            color: #ffffff;
        }

        .visi-title {
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--primary-navy);
            margin: 0;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .visi-text {
            font-size: 1rem;
            line-height: 1.8;
            color: #2c3e50;
            text-align: center;
            font-weight: 500;
            position: relative;
            z-index: 1;
            padding: 0 15px;
        }

        .misi-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
            transition: all 0.4s ease;
            border: 1px solid rgba(212, 175, 55, 0.1);
        }

        .misi-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 45px rgba(0, 0, 0, 0.15);
        }

        .misi-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 5px;
            height: 100%;
            background: linear-gradient(180deg, var(--gold-accent) 0%, var(--accent-blue) 100%);
        }

        .misi-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 25px;
            position: relative;
            z-index: 1;
        }

        .misi-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, var(--gold-accent) 0%, #b8941f 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 20px rgba(212, 175, 55, 0.3);
            flex-shrink: 0;
        }

        .misi-icon i {
            font-size: 1.8rem;
            color: #ffffff;
        }

        .misi-title {
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--primary-navy);
            margin: 0;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .misi-list {
            margin: 0;
            padding: 0;
            list-style: none;
            counter-reset: misi-counter;
            position: relative;
            z-index: 1;
        }

        .misi-list li {
            font-size: 0.95rem;
            line-height: 1.8;
            color: #2c3e50;
            text-align: justify;
            margin-bottom: 18px;
            padding: 18px 18px 18px 70px;
            position: relative;
            counter-increment: misi-counter;
            background: linear-gradient(135deg, rgba(74, 144, 192, 0.03), rgba(74, 144, 192, 0.01));
            border-radius: 10px;
            transition: all 0.3s ease;
            border-left: 3px solid var(--accent-blue);
        }

        .misi-list li:hover {
            background: linear-gradient(135deg, rgba(74, 144, 192, 0.08), rgba(74, 144, 192, 0.04));
            transform: translateX(8px);
            border-left-color: var(--gold-accent);
        }

        .misi-list li:last-child {
            margin-bottom: 0;
        }

        .misi-list li::before {
            content: counter(misi-counter);
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, var(--accent-blue) 0%, var(--primary-navy) 100%);
            color: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1.1rem;
            box-shadow: 0 3px 10px rgba(74, 144, 192, 0.2);
        }

        /* ==================== STRUKTUR ORGANISASI ==================== */
        #struktur {
            padding: 80px 0;
            background: linear-gradient(135deg, var(--light-blue) 0%, #ffffff 100%);
        }

        .struktur-container {
            background: #fff;
            border-radius: 15px;
            padding: 50px;
            box-shadow: 0 15px 50px rgba(26, 58, 82, 0.1);
            text-align: center;
        }

        .struktur-image {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 35px rgba(0, 0, 0, 0.12);
            transition: transform 0.3s ease;
        }

        .struktur-image:hover {
            transform: scale(1.02);
        }

        .struktur-image img {
            width: 100%;
            height: auto;
            display: block;
        }

        .download-btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: linear-gradient(135deg, var(--primary-navy) 0%, var(--accent-blue) 100%);
            color: #fff;
            padding: 13px 35px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 600;
            margin-top: 30px;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(26, 58, 82, 0.3);
            border: none;
            cursor: pointer;
            font-size: 0.95rem;
        }

        .download-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(26, 58, 82, 0.4);
            color: #fff;
            text-decoration: none;
        }

        /* ==================== SERVICES SECTION ==================== */
        #services {
            padding: 80px 0;
            background: #fff;
        }

        .single-key {
            background: linear-gradient(135deg, var(--light-blue) 0%, #ffffff 100%);
            padding: 45px 30px;
            border-radius: 12px;
            text-align: center;
            margin-bottom: 30px;
            transition: all 0.4s ease;
            border: 1px solid var(--border-gray);
            height: 100%;
        }

        .single-key:hover {
            background: linear-gradient(135deg, var(--primary-navy) 0%, var(--secondary-navy) 100%);
            color: #fff;
            transform: translateY(-8px);
            border-color: var(--accent-blue);
            box-shadow: 0 12px 35px rgba(26, 58, 82, 0.2);
        }

        .single-key i {
            font-size: 3.8rem;
            color: var(--accent-blue);
            margin-bottom: 20px;
            transition: all 0.4s ease;
        }

        .single-key:hover i {
            color: var(--gold-accent);
            transform: scale(1.1);
        }

        .single-key h5 {
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--primary-navy);
            transition: color 0.4s ease;
            letter-spacing: 0.5px;
        }

        .single-key:hover h5 {
            color: #fff;
        }

        /* ==================== ABOUT US SECTION ==================== */
        #about_us {
            padding: 80px 0;
            background: linear-gradient(135deg, #ffffff 0%, var(--light-blue) 100%);
        }

        .about-us .row {
            max-width: 1200px;
            margin: 0 auto;
            align-items: center;
        }

        .about-image-wrapper {
            position: relative;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 15px 50px rgba(26, 58, 82, 0.15);
            transition: transform 0.4s ease;
            margin-bottom: 30px;
        }

        .about-image-wrapper:hover {
            transform: translateY(-5px);
        }

        .about-image-wrapper img {
            width: 100%;
            height: 400px;
            object-fit: cover;
            display: block;
        }

        .about-content {
            padding: 0 30px;
        }

        .about-content p {
            font-size: 0.95rem;
            line-height: 1.8;
            color: #555;
            text-align: justify;
            margin-bottom: 15px;
        }

        /* ==================== GALLERY SECTION ==================== */
        #gallery {
            padding: 80px 0;
            background: #fff;
        }

        .gallery-filter {
            text-align: center;
            margin-bottom: 50px;
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 10px;
        }

        .filter-button {
            background: #fff;
            border: 2px solid var(--primary-navy);
            color: var(--primary-navy);
            padding: 10px 25px;
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s ease;
            cursor: pointer;
            font-size: 0.95rem;
        }

        .filter-button:hover,
        .filter-button.active {
            background: linear-gradient(135deg, var(--primary-navy), var(--accent-blue));
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(26, 58, 82, 0.2);
        }

        .gallery_product {
            margin-bottom: 25px;
            overflow: hidden;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .gallery_product:hover {
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .gallery_product img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            transition: transform 0.5s ease;
            border-radius: 12px;
        }

        .gallery_product:hover img {
            transform: scale(1.12);
        }

        /* ==================== CONTACT FORM SECTION ==================== */
        #contact_us {
            padding: 80px 0;
            background: linear-gradient(135deg, var(--light-blue) 0%, #ffffff 100%);
        }

        .cop-ck {
            background: #fff;
            padding: 45px 50px;
            border-radius: 15px;
            box-shadow: 0 12px 40px rgba(26, 58, 82, 0.12);
            border: 1px solid var(--border-gray);
        }

        .cop-ck h2 {
            color: var(--primary-navy);
            font-weight: 800;
            font-size: 1.8rem;
            margin-bottom: 8px;
            letter-spacing: 0.5px;
        }

        .form-control {
            border: 1px solid var(--border-gray);
            border-radius: 8px;
            padding: 12px 15px;
            transition: all 0.3s ease;
            font-size: 0.9rem;
            font-family: 'Poppins', sans-serif;
        }

        .form-control:focus {
            border-color: var(--accent-blue);
            box-shadow: 0 0 0 0.2rem rgba(74, 144, 192, 0.15);
            outline: none;
        }

        .form-control::placeholder {
            color: #bbb;
        }

        .cf-ro {
            margin-bottom: 20px;
        }

        .col-form-label {
            font-weight: 700;
            color: var(--primary-navy);
            font-size: 0.9rem;
            padding-top: 8px;
            letter-spacing: 0.3px;
        }

        #contact_us .btn {
            background: linear-gradient(135deg, var(--primary-navy) 0%, var(--accent-blue) 100%);
            border: none;
            padding: 12px 35px;
            font-weight: 700;
            border-radius: 8px;
            transition: all 0.3s ease;
            font-size: 0.95rem;
            cursor: pointer;
            color: white;
            letter-spacing: 0.5px;
        }

        #contact_us .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(26, 58, 82, 0.3);
        }

        /* ==================== FOOTER ==================== */
        .footer {
            background: linear-gradient(135deg, #0f2537 0%, #1a3a52 100%);
            color: #fff;
            padding: 60px 0 20px;
        }

        .footer h2 {
            color: #fff;
            font-size: 1.3rem;
            font-weight: 800;
            margin-bottom: 25px;
            position: relative;
            padding-bottom: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .footer h2::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 3px;
            background: var(--accent-blue);
            border-radius: 2px;
        }

        .contact-info-wrapper {
            display: flex;
            flex-direction: column;
            gap: 0;
            margin-top: 20px;
        }

        .contact-item {
            display: flex;
            align-items: flex-start;
            gap: 15px;
            padding: 15px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            transition: all 0.3s ease;
        }

        .contact-item:last-child {
            border-bottom: none;
        }

        .contact-item:hover {
            padding-left: 10px;
        }

        .contact-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, rgba(74, 144, 192, 0.2), rgba(74, 144, 192, 0.1));
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            transition: all 0.3s ease;
            color: var(--accent-blue);
        }

        .contact-item:hover .contact-icon {
            background: rgba(74, 144, 192, 0.3);
            transform: scale(1.1);
        }

        .contact-text {
            flex: 1;
        }

        .contact-text span:first-child {
            color: rgba(255, 255, 255, 0.6);
            font-size: 11px;
            display: block;
            margin-bottom: 5px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 700;
        }

        .contact-text a {
            color: var(--accent-blue);
            font-size: 0.95rem;
            line-height: 1.6;
            text-decoration: none;
            transition: color 0.3s ease;
            display: inline-block;
            word-break: break-word;
        }

        .contact-text a:hover {
            color: var(--gold-accent);
            text-decoration: underline;
        }

        .copy {
            background: #0a1929;
            color: rgba(255, 255, 255, 0.7);
            padding: 20px 0;
            text-align: center;
            font-size: 0.9rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* ==================== RESPONSIVE ==================== */
        @media (max-width: 768px) {
            .logo-text {
                display: none;
            }

            .welcome-container {
                flex-direction: column;
                gap: 20px;
            }

            .welcome-container .sipadek-left {
                max-height: 200px;
            }

            .welcome-container h5 {
                font-size: 1.8rem;
                text-align: center;
            }

            .carousel-item img {
                height: 400px;
            }

            .inner-title h2 {
                font-size: 2rem;
            }

            .cop-ck {
                padding: 30px 20px;
            }

            .about-image-wrapper {
                margin-bottom: 30px;
            }

            .slider-detail {
                margin-top: 65px;
            }

            .footer {
                padding: 40px 0 20px;
            }

            .berita-card {
                margin-bottom: 20px;
            }
        }

        @media (max-width: 991px) {
            .nav-item ul {
                flex-direction: column;
                gap: 0;
                padding: 10px 0;
            }

            .nav-item ul li {
                width: 100%;
            }

            .nav-item ul li a {
                padding: 12px 20px;
                border-radius: 0;
                border-bottom: 1px solid rgba(255, 255, 255, 0.08);
                font-size: 13px;
            }

            .nav-item ul li:last-child a {
                border-bottom: none;
            }

            .nav-item ul li .dropdown-menu {
                position: static;
                display: none;
                background: rgba(15, 37, 55, 0.95);
                box-shadow: none;
                margin: 0;
                padding: 0;
                border-radius: 0;
            }

            .nav-item ul li.has-dropdown.active .dropdown-menu {
                display: block;
            }

            .dropdown-menu li a {
                padding: 10px 20px 10px 40px;
                font-size: 13px;
                border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            }

            .navbar-collapse {
                background: rgba(26, 58, 82, 0.95) !important;
                backdrop-filter: blur(10px);
                -webkit-backdrop-filter: blur(10px);
                margin-top: 10px;
                border-radius: 8px;
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.25);
            }
        }

        .animate-on-scroll {
            animation: fadeInUp 0.8s ease-out forwards;
            opacity: 0;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .navbar-collapse {
            transition: all 0.3s ease;
        }

        .navbar-collapse.show,
        .navbar-collapse.collapsing {
            display: block !important;
        }

        @media (min-width: 992px) {
            .navbar-collapse {
                display: flex !important;
            }
        }
    </style>
</head>

<body>

    <!-- HEADER & NAVIGATION -->
    <header id="menu-jk">
        <div id="nav-head" class="header-nav">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                        <div class="logo-container">
                            <img src="assets/images/imipas.png" alt="Logo Pemasyarakatan" class="company-logo">
                            <img src="assets/images/pemasyarakatann.png" alt="Logo IMIPAS" class="company-logo">
                            <span class="logo-text d-none d-lg-inline">LEMBAGA<br>PEMASYARAKATAN<br>KELAS IIA LUBUK LINGGAU</span>
                        </div>
                    </div>

                    <div class="col-6 d-md-none text-right">
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#menu">
                            <i class="fas fa-bars small-menu"></i>
                        </button>
                    </div>

                    <div id="menu" class="col-lg-9 col-md-8 col-12 collapse navbar-collapse nav-item">
                        <ul>
                            <li><a href="#home">Beranda</a></li>
                            <li class="has-dropdown">
                                <a href="#profil">Profil</a>
                                <ul class="dropdown-menu">
                                    <li><a href="#visi_misi">Visi & Misi</a></li>
                                    <li><a href="#struktur">Struktur Organisasi</a></li>
                                    <li><a href="#about_us">Tentang Kami</a></li>
                                    <li><a href="#contact_us">Kontak</a></li>
                                </ul>
                            </li>
                            <li><a href="#berita">Berita</a></li>
                            <li><a href="#services">Layanan</a></li>
                            <li><a href="#gallery">Galeri</a></li>
                            <li><a href="informasi_publik.php">Informasi Publik</a></li>
                            <li><a href="hms/admin">Login</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </header>
