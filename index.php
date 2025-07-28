<?php

// Bu kısım, PHP kodunuzun başlangıcıdır.
// Veritabanı bağlantısını dahil et
include 'db.php'; // db.php dosyasını dahil ediyoruz

// URL'den 'page' parametresini alıyoruz. Eğer yoksa, varsayılan olarak 'home' (ana sayfa) kabul ediyoruz.
// Bu basit bir yönlendirme (routing) mekanizmasıdır.

$page = isset($_GET['page']) ? $_GET['page'] : 'home';
$slug = isset($_GET['slug']) ? $_GET['slug'] : ''; // Blog yazıları için slug parametresi

// İletişim formu gönderildiğinde çalışacak PHP kodu
$form_status_message = ''; // Kullanıcıya gösterilecek mesajı saklar
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $page === 'contact') {
    // Form verilerini alıyoruz ve güvenlik için temizliyoruz (XSS saldırılarına karşı)
    $name = htmlspecialchars($_POST['name'] ?? '');
    $email = htmlspecialchars($_POST['email'] ?? '');
    $subject = htmlspecialchars($_POST['subject'] ?? ''); // Konu alanı eklendi
    $message = htmlspecialchars($_POST['message'] ?? '');

    // Zorunlu alanların doldurulup doldurulmadığını kontrol ediyoruz
    if (!empty($name) && !empty($email) && !empty($subject) && !empty($message)) { // Konu alanı da kontrol edildi
        // Gerçek bir uygulamada burada e-posta gönderme (örn: mail() fonksiyonu ile) veya
        // veritabanına kaydetme işlemleri yapılır.
        // Şimdilik sadece bir başarı mesajı gösteriyoruz.

        // Örnek: Form verilerini bir log dosyasına kaydetme
        $log_file = 'form_submissions.log';
        $submission_data = date('Y-m-d H:i:s') . " - Name: $name, Email: $email, Subject: $subject, Message: $message\n";
        file_put_contents($log_file, $submission_data, FILE_APPEND);

        $form_status_message = '<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                                    <strong class="font-bold">Başarılı!</strong>
                                    <span class="block sm:inline">Mesajınız başarıyla gönderildi. Teşekkür ederiz!</span>
                                </div>';
    } else {
        $form_status_message = '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                                    <strong class="font-bold">Hata!</strong>
                                    <span class="block sm:inline">Lütfen tüm alanları doldurun.</span>
                                </div>';
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZeroSoft Web Sitesi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    xintegrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        /* Genel stil ayarları */
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f0f4f8; /* Daha açık, modern bir gri tonu */
            color: #2d3748; /* Koyu gri metin */
            cursor: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"><circle cx="10" cy="10" r="4" fill="%23667eea" stroke="%23ffffff" stroke-width="1.5"/></svg>') 10 10, auto;
        }
        /* Etkileşimli öğelerde varsayılan pointer imleci korundu */
        a, button, .custom-card, .faq-question {
            cursor: pointer;
        }

        .container {
            max-width: 1280px; /* Geniş ekranlar için maksimum genişlik */
            margin-left: auto;
            margin-right: auto;
            padding-left: 1.5rem; /* Yan boşluklar */
            padding-right: 1.5rem;
        }
        /* Kahraman (Hero) bölümü için özel stil */
        .hero-section {
            background: linear-gradient(to right bottom, #667eea, #764ba2); /* Canlı mor-mavi gradient */
            color: white;
            padding: 8rem 0;
            text-align: center;
            position: relative;
            overflow: hidden; /* Animasyonlu arka plan için */
        }
        /* Hero section arka plan animasyonu */
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: inherit;
            filter: blur(50px) opacity(0.8); /* Hafif bulanıklık efekti */
            transform: scale(1.1);
            animation: hero-bg-pulse 15s infinite alternate; /* Yeni animasyon */
            z-index: 0;
        }
        .hero-section > * {
            position: relative;
            z-index: 1; /* İçeriğin arka planın önünde olmasını sağlar */
        }

        @keyframes hero-bg-pulse {
            0% { transform: scale(1.1) rotate(0deg); }
            100% { transform: scale(1.2) rotate(5deg); }
        }

        .section-title {
            font-size: 3rem; /* H2 başlık boyutu büyütüldü */
            font-weight: 800; /* Daha kalın */
            margin-bottom: 2.5rem;
            color: #1a202c; /* Koyu metin */
        }
        /* Genel kart stili */
        .custom-card {
            border-radius: 1.25rem; /* Daha yuvarlak köşeler */
            padding: 2.5rem;
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out, background-color 0.3s ease-in-out, border-color 0.3s ease-in-out, filter 0.3s ease-in-out;
            cursor: pointer;
            border: 1px solid rgba(226, 232, 240, 0.6); /* Hafif kenarlık */
        }

        .btn-primary {
            background-color: #667eea; /* Mor buton */
            color: white;
            padding: 0.85rem 2.5rem; /* Buton boyutu büyütüldü */
            border-radius: 0.75rem; /* Daha yuvarlak */
            font-weight: 700; /* Daha kalın */
            transition: background-color 0.3s ease-in-out, transform 0.2s ease-in-out;
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4); /* Buton gölgesi */
        }
        .btn-primary:hover {
            background-color: #5a67d8; /* Butonun hover rengi */
            transform: translateY(-2px); /* Hafif yukarı kalkma */
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.6);
        }
        /* Input ve textarea stilleri */
        input[type="text"], input[type="email"], textarea {
            border: 1px solid #cbd5e1; /* Gri kenarlık */
            padding: 0.75rem 1rem;
            border-radius: 0.5rem; /* Daha yuvarlak */
            width: 100%;
            box-sizing: border-box; /* Padding ve border'ı genişliğe dahil et */
            background-color: #f7fafc; /* Hafif arka plan rengi */
        }
        input[type="text"]:focus, input[type="email"]:focus, textarea:focus {
            outline: none;
            border-color: #667eea; /* Odaklanınca mor kenarlık */
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.3); /* Hafif gölge */
            background-color: white;
        }

        /* Özel animasyonlar */
        @keyframes scale-up-slow {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }
        @keyframes bounce-slow {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        @keyframes pulse-slow {
            0%, 100% { opacity: 1; }
            50% { opacity: .5; }
        }
        @keyframes wiggle-slow {
            0%, 100% { transform: rotate(-3deg); }
            50% { transform: rotate(3deg); }
        }
        @keyframes gradient-shift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* İkon animasyonları için yeni sınıflar */
        .group-hover\:animate-icon-bounce { animation: bounce-slow 1.5s ease-in-out infinite; }
        .group-hover\:animate-icon-pulse { animation: pulse-slow 2s ease-in-out infinite; }
        .group-hover\:animate-icon-wiggle { animation: wiggle-slow 0.5s ease-in-out infinite; }
        .group-hover\:animate-icon-scale { animation: scale-up-slow 1.5s ease-in-out infinite; }


        .animated-background {
            background: linear-gradient(270deg, #e0e7ff, #c7d2fe, #a5b4fc);
            background-size: 600% 600%;
            animation: gradient-shift 10s ease infinite;
        }

        /* Scroll Reveal Animasyonları */
        .reveal-item {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.6s ease-out, transform 0.6s ease-out;
        }
        .reveal-item.is-visible {
            opacity: 1;
            transform: translateY(0);
        }
        /* Gecikmeler korunuyor */
        .reveal-item-1 { transition-delay: 0.1s; }
        .reveal-item-2 { transition-delay: 0.2s; }
        .reveal-item-3 { transition-delay: 0.3s; }
        .reveal-item-4 { transition-delay: 0.4s; }
        .reveal-item-5 { transition-delay: 0.5s; }
        .reveal-item-6 { transition-delay: 0.6s; }
        .reveal-item-7 { transition-delay: 0.7s; }
        .reveal-item-8 { transition-delay: 0.8s; }
        .reveal-item-9 { transition-delay: 0.9s; }
        .reveal-item-10 { transition-delay: 1.0s; }

        /* SSS için özel stil */
        .faq-item {
            border-bottom: 1px solid #e2e8f0;
        }
        .faq-question {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem 0;
            font-weight: 600;
            font-size: 1.25rem;
            color: #4a5568;
            cursor: pointer;
        }
        .faq-answer {
            padding-bottom: 1.5rem;
            color: #718096;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-out;
        }
        .faq-answer.open {
            max-height: 200px; /* Yaklaşık bir değer, içeriğe göre ayarlanmalı */
        }
        .faq-icon {
            transition: transform 0.3s ease-out;
        }
        .faq-icon.rotate {
            transform: rotate(180deg);
        }
    </style>
</head>
<body class="flex flex-col min-h-screen">

    <header class="bg-white shadow-lg py-4 sticky top-0 z-50">
        <div class="container flex justify-between items-center">
            <a href="index.php?page=home" class="reveal-item reveal-item-1">
                <img src="assets/images/logo.jpg" alt="ZeroSoft Logo" class="h-16 w-auto">
            </a>
            <nav class="flex items-center space-x-8">
                <ul class="flex space-x-8">
                    <li><a href="index.php?page=home" class="text-gray-700 hover:text-indigo-600 font-medium transition duration-300 px-3 py-2 rounded-md reveal-item reveal-item-2">Ana Sayfa</a></li>
                    <li><a href="index.php?page=services" class="text-gray-700 hover:text-indigo-600 font-medium transition duration-300 px-3 py-2 rounded-md reveal-item reveal-item-3">Hizmetler</a></li>
                    <li><a href="index.php?page=portfolio" class="text-gray-700 hover:text-indigo-600 font-medium transition duration-300 px-3 py-2 rounded-md reveal-item reveal-item-4">Portföy</a></li>
                    <li><a href="index.php?page=about" class="text-gray-700 hover:text-indigo-600 font-medium transition duration-300 px-3 py-2 rounded-md reveal-item reveal-item-5">Hakkımızda</a></li>
                    <li><a href="index.php?page=blog" class="text-gray-700 hover:text-indigo-600 font-medium transition duration-300 px-3 py-2 rounded-md reveal-item reveal-item-6">Blog</a></li>
                    <li><a href="index.php?page=faq" class="text-gray-700 hover:text-indigo-600 font-medium transition duration-300 px-3 py-2 rounded-md reveal-item reveal-item-7">SSS</a></li>
                    <li><a href="index.php?page=contact" class="text-gray-700 hover:text-indigo-600 font-medium transition duration-300 px-3 py-2 rounded-md reveal-item reveal-item-9">İletişim</a></li>
                </ul>
                <div class="flex items-center space-x-4 ml-8 reveal-item reveal-item-10">
                    <div class="relative">
                        <input type="text" placeholder="Ara..." class="pl-10 pr-4 py-2 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-gray-700">
                        <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
            </nav>
        </div>
    </header>

    <main class="flex-grow">
        <?php
        // PHP ile hangi sayfanın gösterileceğine karar veriyoruz
        if ($page === 'home') {
            $stmt = $conn->prepare("SELECT title, content FROM pages WHERE page_name = 'home'");
            $stmt->execute();
            $result = $stmt->get_result();
            $home_content = $result->fetch_assoc();
            $stmt->close();

            $stmt = $conn->prepare("SELECT title, description, icon_name, bg_color FROM services LIMIT 3"); // İlk 3 hizmeti çek
            $stmt->execute();
            $services_home = $stmt->get_result();
            $stmt->close();

            $stmt = $conn->prepare("SELECT slug, title, summary, image_url, publish_date FROM blog_posts ORDER BY publish_date DESC LIMIT 3");
            $stmt->execute();
            $recent_blog_posts = $stmt->get_result();
            $stmt->close();
        ?>
            <section class="hero-section rounded-b-3xl shadow-xl">
                <div class="container">
                    <h1 class="text-5xl md:text-6xl font-extrabold mb-6 leading-tight reveal-item reveal-item-1">
                        <?php echo $home_content['title']; ?>
                    </h1>
                    <p class="text-xl md:text-2xl mb-10 opacity-90 max-w-3xl mx-auto reveal-item reveal-item-2">
                        <?php echo $home_content['content']; ?>
                    </p>
                    <a href="index.php?page=services" class="btn-primary inline-block text-lg shadow-lg hover:shadow-xl transform hover:scale-105 duration-300 reveal-item reveal-item-3">
                        Hizmetlerimizi Keşfedin
                    </a>
                </div>
            </section>

            <section class="py-20 bg-gray-50">
                <div class="container text-center">
                    <h2 class="section-title reveal-item reveal-item-1">Neden ZeroSoft?</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10 reveal-item reveal-item-2">
                        <?php while ($service = $services_home->fetch_assoc()): ?>
                        <div class="bg-purple-50 rounded-xl p-8 shadow-md hover:shadow-lg hover:-translate-y-3 transition duration-300 group">
                            <div class="flex items-center justify-center w-20 h-20 rounded-full bg-<?php echo $service['bg_color']; ?> text-white mx-auto mb-6 transition duration-300 group-hover:scale-110">
                                <script>
                                    document.write('<i data-lucide="<?php echo $service['icon_name']; ?>" class="w-10 h-10"></i>');
                                </script>
                            </div>
                            <h3 class="text-2xl font-bold mb-4 text-gray-800 text-center"><?php echo $service['title']; ?></h3>
                            <p class="text-gray-700 text-center"><?php echo $service['description']; ?></p>
                        </div>
                        <?php endwhile; ?>
                    </div>
                </div>
            </section>

            <section class="py-20 bg-white">
                <div class="container text-center">
                    <h2 class="section-title reveal-item reveal-item-1">Son Blog Yazılarımız</h2>
                    <p class="text-lg text-gray-700 mb-12 max-w-3xl mx-auto reveal-item reveal-item-2">
                        Teknoloji ve yazılım dünyasındaki en güncel gelişmeleri takip edin.
                    </p>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        <?php while ($post = $recent_blog_posts->fetch_assoc()): ?>
                        <div class="bg-purple-50 rounded-xl p-6 shadow-md hover:shadow-lg hover:-translate-y-2 transition duration-300 group reveal-item reveal-item-3">
                            <img src="<?php echo $post['image_url']; ?>" alt="<?php echo $post['title']; ?>" class="rounded-lg mb-6 w-full h-40 object-cover">
                            <h3 class="text-xl font-bold mb-2 text-gray-800 text-left"><?php echo $post['title']; ?></h3>
                            <p class="text-gray-600 text-left text-sm mb-4"><?php echo $post['summary']; ?></p>
                            <a href="index.php?page=blog_detail&slug=<?php echo $post['slug']; ?>" class="text-indigo-600 hover:underline font-medium text-left block">Devamını Oku <i class="fas fa-arrow-right text-xs ml-1"></i></a>
                            <p class="text-gray-500 text-xs mt-2 text-left"><?php echo date('d F Y', strtotime($post['publish_date'])); ?></p>
                        </div>
                        <?php endwhile; ?>
                    </div>
                    <a href="index.php?page=blog" class="btn-primary inline-block text-lg shadow-lg hover:shadow-xl transform hover:scale-105 duration-300 mt-12 reveal-item reveal-item-6">
                        Tüm Blog Yazılarını Görüntüle
                    </a>
                </div>
            </section>

        <?php
        } elseif ($page === 'services') {
            $stmt = $conn->prepare("SELECT title, description, icon_name, bg_color FROM services");
            $stmt->execute();
            $services = $stmt->get_result();
            $stmt->close();
        ?>
            <section class="py-20 bg-gray-50">
                <div class="container mx-auto px-4">
                    <h2 class="section-title reveal-item text-center items-center reveal-item-1">Sunulan Hizmetlerimiz</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-10 reveal-item reveal-item-2">
                        <?php while ($service = $services->fetch_assoc()): ?>
                        <div class="bg-purple-50 rounded-xl p-8 shadow-md hover:shadow-lg hover:brightness-105 transition duration-300 group flex flex-col items-center text-center">
                            <div class="flex items-center justify-center w-16 h-16 rounded-full bg-<?php echo $service['bg_color']; ?> text-white mx-auto mb-6 transition duration-300 group-hover:scale-110">
                                <script>
                                    document.write('<i data-lucide="<?php echo $service['icon_name']; ?>" class="w-8 h-8"></i>');
                                </script>
                            </div>
                            <h3 class="text-2xl font-bold mb-4 text-gray-800 font-inter"><?php echo $service['title']; ?></h3>
                            <p class="text-gray-700 mb-4 font-inter"><?php echo $service['description']; ?></p>
                            <ul class="list-disc list-inside text-gray-700 space-y-2 text-left w-full font-inter">
                                <li>Responsive Tasarım</li>
                                <li>SEO Optimizasyonu</li>
                                <li>Hızlı performans</li>
                            </ul>
                        </div>
                        <?php endwhile; ?>
                    </div>
                </div>
            </section>

            <section class="py-20 bg-white">
                <div class="container mx-auto px-4 text-center">
                    <h2 class="section-title reveal-item reveal-item-1">Sürecimiz</h2>
                    <p class="text-lg text-gray-700 mb-12 max-w-3xl mx-auto reveal-item reveal-item-2">
                        Projelerinizi hayata geçirirken izlediğimiz adımlar.
                    </p>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 reveal-item reveal-item-3">
                        <div class="bg-purple-50 rounded-xl p-8 shadow-sm hover:shadow-md hover:-translate-y-2 transition duration-300 border-t-4 border-indigo-500 hover:border-t-8 hover:border-indigo-700 group">
                            <div class="flex items-center justify-center w-16 h-16 rounded-full bg-indigo-500 text-white mx-auto mb-6 transition duration-300 group-hover:rotate-6">
                                <script>
                                    document.write('<i data-lucide="search" class="w-8 h-8"></i>');
                                </script>
                            </div>
                            <h3 class="text-xl font-bold mb-2 text-gray-800">Keşif ve Analiz</h3>
                            <p class="text-gray-700">İhtiyaçlarınızı ve hedeflerinizi detaylı bir şekilde anlayarak projenizin temelini atıyoruz.</p>
                        </div>
                        <div class="bg-purple-50 rounded-xl p-8 shadow-sm hover:shadow-md hover:-translate-y-2 transition duration-300 border-t-4 border-purple-500 hover:border-t-8 hover:border-purple-700 group">
                            <div class="flex items-center justify-center w-16 h-16 rounded-full bg-purple-500 text-white mx-auto mb-6 transition duration-300 group-hover:rotate-6">
                                <script>
                                    document.write('<i data-lucide="pencil-ruler" class="w-8 h-8"></i>');
                                </script>
                            </div>
                            <h3 class="text-xl font-bold mb-2 text-gray-800">Tasarım ve Planlama</h3>
                            <p class="text-gray-700">Kullanıcı deneyimini ön planda tutarak estetik ve işlevsel tasarımlar oluşturuyoruz.</p>
                        </div>
                        <div class="bg-purple-50 rounded-xl p-8 shadow-sm hover:shadow-md hover:-translate-y-2 transition duration-300 border-t-4 border-green-500 hover:border-t-8 hover:border-green-700 group">
                            <div class="flex items-center justify-center w-16 h-16 rounded-full bg-green-500 text-white mx-auto mb-6 transition duration-300 group-hover:rotate-6">
                                <script>
                                    document.write('<i data-lucide="code" class="w-8 h-8"></i>');
                                </script>
                            </div>
                            <h3 class="text-xl font-bold mb-2 text-gray-800">Geliştirme ve Uygulama</h3>
                            <p class="text-gray-700">En son teknolojileri kullanarak projenizi titizlikle geliştiriyor ve hayata geçiriyoruz.</p>
                        </div>
                        <div class="bg-purple-50 rounded-xl p-8 shadow-sm hover:shadow-md hover:-translate-y-2 transition duration-300 border-t-4 border-red-500 hover:border-t-8 hover:border-red-700 group">
                            <div class="flex items-center justify-center w-16 h-16 rounded-full bg-red-500 text-white mx-auto mb-6 transition duration-300 group-hover:rotate-6">
                                <script>
                                    document.write('<i data-lucide="life-buoy" class="w-8 h-8"></i>');
                                </script>
                            </div>
                            <h3 class="text-xl font-bold mb-2 text-gray-800">Test ve Destek</h3>
                            <p class="text-gray-700">Projenizi kapsamlı testlerden geçiriyor ve sürekli destek sağlayarak sorunsuz çalışmasını güvence altına alıyoruz.</p>
                        </div>
                    </div>
                </div>
            </section>

            <section class="py-20 bg-gray-100">
                <div class="container mx-auto px-4 text-center">
                    <h2 class="section-title reveal-item reveal-item-1">Bültenimize Abone Olun</h2>
                    <div class="custom-card max-w-2xl mx-auto p-10 bg-gradient-to-br from-indigo-500 to-purple-600 text-white shadow-xl rounded-xl group reveal-item reveal-item-2">
                        <script>
                            document.write('<i data-lucide="mail" class="w-20 h-20 text-white mb-6 mx-auto group-hover:animate-scale-up-slow"></i>');
                        </script>
                        <p class="text-xl mb-8 opacity-90">
                            En son haberler, güncellemeler ve özel teklifler için e-posta bültenimize kaydolun.
                        </p>
                        <form action="#" method="POST" class="flex flex-col sm:flex-row gap-4">
                            <input type="email" placeholder="E-posta adresinizi girin"
                                   class="flex-grow p-3 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-white focus:border-transparent text-gray-800"
                                   required>
                            <button type="submit" class="bg-gradient-to-r from-green-400 to-blue-500 text-white px-6 py-3 rounded-md text-lg font-semibold hover:from-green-500 hover:to-blue-600 transition duration-300 shadow-lg transform hover:scale-105">
                                Abone Ol
                            </button>
                        </form>
                    </div>
                </div>
            </section>

        <?php
        } elseif ($page === 'portfolio') { // Demolar sayfası Portföy olarak güncellendi
            $stmt = $conn->prepare("SELECT title, description, image_url FROM portfolio_items");
            $stmt->execute();
            $portfolio_items = $stmt->get_result();
            $stmt->close();
        ?>
            <section class="py-20 bg-gray-50">
                <div class="container text-center">
                    <h2 class="section-title reveal-item reveal-item-1">Portföyümüz</h2>
                    <p class="text-lg text-gray-700 mb-12 max-w-3xl mx-auto reveal-item reveal-item-2">
                        Tamamladığımız projelerden bazı örnekleri inceleyebilirsiniz.
                    </p>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        <?php while ($item = $portfolio_items->fetch_assoc()): ?>
                        <div class="relative rounded-xl shadow-md overflow-hidden group">
                            <img src="<?php echo $item['image_url']; ?>" alt="<?php echo $item['title']; ?>" class="w-full h-48 object-cover rounded-t-xl">
                            <div class="absolute inset-0 bg-purple-700/70 rounded-t-xl flex items-center justify-center opacity-100 group-hover:opacity-0 transition duration-300">
                                <h3 class="text-3xl font-bold text-white"><?php echo $item['title']; ?></h3>
                            </div>
                            <div class="p-6 bg-purple-50 rounded-b-xl text-left">

                                <p class="text-gray-700 mb-4"><?php echo $item['description']; ?></p>
                                <a href="#" class="btn-primary inline-block text-sm">Detayları İncele</a>
                            </div>
                        </div>
                        <?php endwhile; ?>
                    </div>
                </div>
            </section>

        <?php
        } elseif ($page === 'about') {
            $stmt = $conn->prepare("SELECT title, content FROM pages WHERE page_name = 'about'");
            $stmt->execute();
            $about_content = $stmt->get_result()->fetch_assoc();
            $stmt->close();
        ?>
            <section class="py-20 bg-white">
                <div class="container text-center">
                    <h2 class="section-title reveal-item reveal-item-1"><?php echo $about_content['title']; ?></h2>
                    <p class="text-lg leading-relaxed text-gray-700 mb-8 max-w-4xl mx-auto reveal-item reveal-item-2">
                        <?php echo nl2br($about_content['content']); ?>
                    </p>
                    <p class="text-lg leading-relaxed text-gray-700 max-w-4xl mx-auto reveal-item reveal-item-3">
                        Her projede, müşterilerimizin hedeflerini kendi hedeflerimiz gibi benimseyerek, şeffaf iletişim ve mükemmeliyetçilik ilkesiyle hareket ediyoruz. Deneyimli kadromuz ve dinamik ekibimizle, global standartlarda çözümler üretiyor ve teknolojinin geleceğini şekillendiriyoruz.
                    </p>
                </div>
            </section>

            <section class="py-20 animated-background">
                <div class="container text-center">
                    <h3 class="text-3xl font-bold text-gray-800 mb-10 reveal-item reveal-item-1">Misyonumuz & Vizyonumuz & Değerlerimiz</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10 reveal-item reveal-item-2">
                        <div class="bg-purple-50 rounded-xl p-8 shadow-md hover:shadow-lg hover:-translate-y-3 transition duration-300 group">
                            <div class="flex items-center justify-center w-20 h-20 rounded-full bg-indigo-600 text-white mx-auto mb-6 transition duration-300 group-hover:scale-110">
                                <script>
                                    document.write('<i data-lucide="target" class="w-10 h-10"></i>');
                                </script>
                            </div>
                            <h4 class="text-2xl font-bold mb-4 text-gray-800">Misyonumuz</h4>
                            <p class="text-gray-700">Müşterilerimize özel ve yenilikçi teknoloji çözümleri sunarak, işlerini dijital dünyada büyütmelerine yardımcı olmak ve sürdürülebilir başarı elde etmelerini sağlamak.</p>
                        </div>
                        <div class="bg-purple-50 rounded-xl p-8 shadow-md hover:shadow-lg hover:-translate-y-3 transition duration-300 group">
                            <div class="flex items-center justify-center w-20 h-20 rounded-full bg-purple-600 text-white mx-auto mb-6 transition duration-300 group-hover:scale-110">
                                <script>
                                    document.write('<i data-lucide="eye" class="w-10 h-10"></i>');
                                </script>
                            </div>
                            <h4 class="text-2xl font-bold mb-4 text-gray-800">Vizyonumuz</h4>
                            <p class="text-gray-700">Dijital dünyada öncü çözümler üreterek, işletmelerin teknolojik dönüşümüne liderlik etmek ve müşterilerimizin başarı hikayelerinin bir parçası olmak.</p>
                        </div>
                        <div class="bg-purple-50 rounded-xl p-8 shadow-md hover:shadow-lg hover:-translate-y-3 transition duration-300 group">
                            <div class="flex items-center justify-center w-20 h-20 rounded-full bg-yellow-600 text-white mx-auto mb-6 transition duration-300 group-hover:scale-110">
                                <script>
                                    document.write('<i data-lucide="shield" class="w-10 h-10"></i>');
                                </script>
                            </div>
                            <h4 class="text-2xl font-bold mb-4 text-gray-800">Değerlerimiz</h4>
                            <p class="text-gray-700">Müşterilerimizle uzun vadeli ve güçlü ortaklıklar kurarak, onların başarısını kendi başarımız olarak görüyor ve bu doğrultuda çalışıyoruz.</p>
                        </div>

                    </div>
                </div>
            </section>

        <?php
        } elseif ($page === 'blog') {
            $stmt = $conn->prepare("SELECT slug, title, summary, image_url, publish_date FROM blog_posts ORDER BY publish_date DESC");
            $stmt->execute();
            $blog_posts = $stmt->get_result();
            $stmt->close();
        ?>
            <section class="py-20 bg-gray-50">
                <div class="container text-center">
                    <h2 class="section-title reveal-item reveal-item-1">Blogumuzdan Son Yazılar</h2>
                    <p class="text-lg text-gray-700 mb-12 max-w-3xl mx-auto reveal-item reveal-item-2">
                        Teknoloji, yazılım geliştirme ve sektördeki yenilikler hakkında en güncel içerikler.
                    </p>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        <?php while ($post = $blog_posts->fetch_assoc()): ?>
                        <div class="bg-purple-50 rounded-xl p-6 shadow-md hover:shadow-lg hover:-translate-y-2 transition duration-300 group reveal-item reveal-item-3">
                            <img src="<?php echo $post['image_url']; ?>" alt="<?php echo $post['title']; ?>" class="rounded-lg mb-6 w-full h-40 object-cover">
                            <h3 class="text-xl font-bold mb-2 text-gray-800 text-left"><?php echo $post['title']; ?></h3>
                            <p class="text-gray-600 text-left text-sm mb-4"><?php echo $post['summary']; ?></p>
                            <a href="index.php?page=blog_detail&slug=<?php echo $post['slug']; ?>" class="text-indigo-600 hover:underline font-medium text-left block">Devamını Oku <i class="fas fa-arrow-right text-xs ml-1"></i></a>
                            <p class="text-gray-500 text-xs mt-2 text-left"><?php echo date('d F Y', strtotime($post['publish_date'])); ?></p>
                        </div>
                        <?php endwhile; ?>
                    </div>
                </div>
            </section>

        <?php
        } elseif ($page === 'blog_detail' && !empty($slug)) {
            $stmt = $conn->prepare("SELECT title, content, image_url, publish_date FROM blog_posts WHERE slug = ?");
            $stmt->bind_param("s", $slug);
            $stmt->execute();
            $result = $stmt->get_result();
            $blog_post_detail = $result->fetch_assoc();
            $stmt->close();

            if ($blog_post_detail) {
        ?>
            <section class="py-20 bg-gray-50">
                <div class="container mx-auto px-4 max-w-3xl">
                    <h2 class="section-title text-left reveal-item reveal-item-1"><?php echo $blog_post_detail['title']; ?></h2>
                    <p class="text-gray-600 text-left text-sm mb-6 reveal-item reveal-item-2"><?php echo date('d F Y', strtotime($blog_post_detail['publish_date'])); ?></p>
                    <img src="<?php echo $blog_post_detail['image_url']; ?>" alt="<?php echo $blog_post_detail['title']; ?> Detay" class="rounded-lg mb-8 w-full object-cover reveal-item reveal-item-3">
                    <div class="text-lg leading-relaxed text-gray-700 mb-6 reveal-item reveal-item-4">
                        <?php echo $blog_post_detail['content']; ?>
                    </div>
                    <a href="index.php?page=blog" class="btn-primary inline-block text-base mt-8 reveal-item reveal-item-7">
                        <i class="fas fa-arrow-left mr-2"></i> Tüm Yazılara Geri Dön
                    </a>
                </div>
            </section>
        <?php
            } else {
                // Blog yazısı bulunamazsa 404 sayfasına yönlendir
                header("Location: index.php?page=404");
                exit();
            }
        }
        elseif ($page === 'faq') {
            $stmt = $conn->prepare("SELECT question, answer FROM faqs");
            $stmt->execute();
            $faqs = $stmt->get_result();
            $stmt->close();
        ?>
            <section class="py-20 bg-gray-50">
                <div class="container">
                    <h2 class="section-title text-center reveal-item reveal-item-1">Sıkça Sorulan Sorular</h2>
                    <p class="text-lg text-gray-700 mb-12 max-w-3xl mx-auto text-center reveal-item reveal-item-2">
                        Aklınızdaki sorulara hızlı yanıtlar bulabilirsiniz.
                    </p>
                    <div class="max-w-3xl mx-auto bg-purple-50 rounded-xl shadow-lg p-8 reveal-item reveal-item-3">
                        <?php while ($faq = $faqs->fetch_assoc()): ?>
                        <div class="faq-item">
                            <div class="faq-question" onclick="toggleFAQ(this)">
                                <span><?php echo $faq['question']; ?></span>
                                <i class="fas fa-chevron-down faq-icon"></i>
                            </div>
                            <div class="faq-answer">
                                <p><?php echo $faq['answer']; ?></p>
                            </div>
                        </div>
                        <?php endwhile; ?>
                    </div>
                </div>
            </section>

        <?php
        } elseif ($page === 'contact') {
        ?>
            <section class="py-20 bg-gray-50">
                <div class="container">
                    <h2 class="section-title text-center reveal-item reveal-item-1">Bize Ulaşın</h2>
                    <div class="bg-purple-50 rounded-xl p-10 shadow-lg reveal-item reveal-item-2 max-w-2xl mx-auto">
                        <?php echo $form_status_message; // Form gönderim durum mesajını gösteriyoruz ?>
                        <form action="index.php?page=contact" method="POST" class="space-y-6">
                            <div class="reveal-item reveal-item-3">
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Adınız Soyadınız</label>
                                <input type="text" id="name" name="name" required
                                        class="block w-full">
                            </div>
                            <div class="reveal-item reveal-item-4">
                                <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">Konu Başlığınız</label>
                                <input type="text" id="subject" name="subject" required
                                        class="block w-full">
                            </div>

                            <div class="reveal-item reveal-item-5">
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">E-posta Adresiniz</label>
                                <input type="email" id="email" name="email" required
                                        class="block w-full">
                            </div>
                            <div class="reveal-item reveal-item-6">
                                <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Mesajınız</label>
                                <textarea id="message" name="message" rows="6" required
                                            class="block w-full"></textarea>
                            </div>
                            <div class="reveal-item reveal-item-7">
                                <button type="submit" class="w-full btn-primary font-semibold text-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition duration-300 rounded-lg">
                                    Mesaj Gönder
                                </button>
                            </div>
                        </form>
                        <div class="mt-12 text-center text-gray-600 text-lg space-y-4 reveal-item reveal-item-8">
                            <p>Alternatif iletişim kanalları:</p>
                            <p>
                                <i class="fas fa-envelope"></i> <a href="mailto:info@zerosoft.com.tr" class="text-indigo-600 hover:underline">info@zerosoft.com.tr</a>
                            </p>
                            <p>
                                <i class="fas fa-phone"></i> <a href="tel:+9005349746703" class="text-indigo-600 hover:underline">+90 534 974 67 03</a>
                            </p>
                            <p>
                                <i class="fas fa-map-marker-alt"></i> Bandırma, Türkiye
                            </p>
                        </div>
                    </div>
                </div>
            </section>

        <?php
        }
        else {
        ?>
            <section class="py-20 bg-gray-50 text-center">
                <div class="container">
                    <h2 class="section-title text-red-600 reveal-item reveal-item-1">404 - Sayfa Bulunamadı!</h2>
                    <p class="text-lg text-gray-700 mb-8 reveal-item reveal-item-2">Üzgünüz, aradığınız sayfa mevcut değil veya yanlış bir adrese geldiniz.</p>
                    <a href="index.php?page=home" class="btn-primary inline-block reveal-item reveal-item-3">Ana Sayfaya Dön</a>
                </div>
            </section>
        <?php
        }
        ?>
    </main>

    <footer class="bg-blue-900 text-white py-10 mt-auto rounded-t-3xl shadow-inner">
        <div class="container text-center">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="reveal-item reveal-item-1">
                    <p class="text-gray-400">&copy; <?php echo date('Y'); ?> ZeroSoft. Tüm Hakları Saklıdır.</p>
                </div>

                <div class="reveal-item reveal-item-2">
                    <h3 class="text-xl font-semibold mb-4">Hızlı Bağlantılar</h3>
                    <ul class="space-y-2">
                        <li><a href="index.php?page=home" class="text-gray-400 hover:text-white transition duration-300">Ana Sayfa</a></li>
                        <li><a href="index.php?page=services" class="text-gray-400 hover:text-white transition duration-300">Hizmetler</a></li>
                        <li><a href="index.php?page=portfolio" class="text-gray-400 hover:text-white transition duration-300">Portföy</a></li>
                        <li><a href="index.php?page=about" class="text-gray-400 hover:text-white transition duration-300">Hakkımızda</a></li>
                        <li><a href="index.php?page=blog" class="text-gray-400 hover:text-white transition duration-300">Blog</a></li>
                        <li><a href="index.php?page=faq" class="text-gray-400 hover:text-white transition duration-300">SSS</a></li>
                        <li><a href="index.php?page=contact" class="text-gray-400 hover:text-white transition duration-300">İletişim</a></li>
                    </ul>
                </div>

                <div class="reveal-item reveal-item-3">
                    <h3 class="text-xl font-semibold mb-4">Bize Ulaşın</h3>
                    <ul class="space-y-2">
                        <li>
                            <i class="fas fa-map-marker-alt text-gray-500 mr-2"></i>
                            <span class="text-gray-400">Bandırma, Türkiye</span>
                        </li>
                        <li>
                            <i class="fas fa-phone-alt text-gray-500 mr-2"></i>
                            <a href="tel:+9005349746703" class="text-gray-400 hover:text-white transition duration-300">+90 534 974 67 03</a>
                        </li>
                        <li>
                            <i class="fas fa-envelope text-gray-500 mr-2"></i>
                            <a href="mailto:info@zerosoft.com.tr" class="text-gray-400 hover:text-white transition duration-300">info@zerosoft.com.tr</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Lucide ikonlarını DOM yüklendikten sonra başlat
        document.addEventListener('DOMContentLoaded', function() {
            lucide.createIcons();

            // Scroll Reveal Efekti İçin Intersection Observer
            const revealElements = document.querySelectorAll('.reveal-item');

            const observer = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        observer.unobserve(entry.target); // Animasyon sadece bir kez çalışsın
                    }
                });
            }, {
                threshold: 0.1 // Elementin %10'u göründüğünde tetikle
            });

            revealElements.forEach(element => {
                observer.observe(element);
            });

            // SSS (FAQ) Akordiyon İşlevselliği
            window.toggleFAQ = function(element) {
                const answer = element.nextElementSibling;
                const icon = element.querySelector('.faq-icon');

                if (answer.classList.contains('open')) {
                    answer.classList.remove('open');
                    answer.style.maxHeight = null;
                    icon.classList.remove('rotate');
                } else {
                    // Diğer tüm SSS'leri kapat
                    document.querySelectorAll('.faq-answer.open').forEach(item => {
                        item.style.maxHeight = null;
                        item.classList.remove('open');
                        item.previousElementSibling.querySelector('.faq-icon').classList.remove('rotate');
                    });

                    answer.classList.add('open');
                    answer.style.maxHeight = answer.scrollHeight + "px"; // İçeriğin yüksekliğine göre ayarla
                    icon.classList.add('rotate');
                }
            };
        });
    </script>

</body>
</html>