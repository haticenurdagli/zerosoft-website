<?php
// Bu kısım, PHP kodunuzun başlangıcıdır.

// URL'den 'page' parametresini alıyoruz. Eğer yoksa, varsayılan olarak 'home' (ana sayfa) kabul ediyoruz.
// Bu basit bir yönlendirme (routing) mekanizmasıdır.
$page = isset($_GET['page']) ? $_GET['page'] : 'home';

// İletişim formu gönderildiğinde çalışacak PHP kodu
$form_status_message = ''; // Kullanıcıya gösterilecek mesajı saklar
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $page === 'contact') {
    // Form verilerini alıyoruz ve güvenlik için temizliyoruz (XSS saldırılarına karşı)
    $name = htmlspecialchars($_POST['name'] ?? '');
    $email = htmlspecialchars($_POST['email'] ?? '');
    $message = htmlspecialchars($_POST['message'] ?? '');

    // Zorunlu alanların doldurulup doldurulmadığını kontrol ediyoruz
    if (!empty($name) && !empty($email) && !empty($message)) {
        // Gerçek bir uygulamada burada e-posta gönderme (örn: mail() fonksiyonu ile) veya
        // veritabanına kaydetme işlemleri yapılır.
        // Şimdilik sadece bir başarı mesajı gösteriyoruz.
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
    <!-- Tailwind CSS CDN (İnternet bağlantısı gerektirir) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts - 'Inter' fontunu kullanıyoruz, ZeroSoft sitesine benzer modern bir görünüm için -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    xintegrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Lucide Icons CDN -->
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

    <!-- Header (Site Navigasyon Çubuğu) -->
    <header class="bg-white shadow-lg py-4 sticky top-0 z-50">
        <div class="container flex justify-between items-center">
            <!-- Logo veya Site Adı -->
            <a href="index.php?page=home" class="reveal-item reveal-item-1">
                <img src="assets/images/logo.jpg" alt="ZeroSoft Logo" class="h-16 w-auto">
            </a>
            <!-- Navigasyon Menüsü -->
            <nav class="flex items-center space-x-8">
                <ul class="flex space-x-8">
                    <li><a href="index.php?page=home" class="text-gray-700 hover:text-indigo-600 font-medium transition duration-300 px-3 py-2 rounded-md reveal-item reveal-item-2">Ana Sayfa</a></li>
                    <li><a href="index.php?page=services" class="text-gray-700 hover:text-indigo-600 font-medium transition duration-300 px-3 py-2 rounded-md reveal-item reveal-item-3">Hizmetler</a></li>
                    <li><a href="index.php?page=portfolio" class="text-gray-700 hover:text-indigo-600 font-medium transition duration-300 px-3 py-2 rounded-md reveal-item reveal-item-4">Portföy</a></li>
                    <li><a href="index.php?page=about" class="text-gray-700 hover:text-indigo-600 font-medium transition duration-300 px-3 py-2 rounded-md reveal-item reveal-item-5">Hakkımızda</a></li>
                    <li><a href="index.php?page=blog" class="text-gray-700 hover:text-indigo-600 font-medium transition duration-300 px-3 py-2 rounded-md reveal-item reveal-item-6">Blog</a></li>
                    <li><a href="index.php?page=faq" class="text-gray-700 hover:text-indigo-600 font-medium transition duration-300 px-3 py-2 rounded-md reveal-item reveal-item-7">SSS</a></li>
                    <!-- Kariyer linki kaldırıldı -->
                    <li><a href="index.php?page=contact" class="text-gray-700 hover:text-indigo-600 font-medium transition duration-300 px-3 py-2 rounded-md reveal-item reveal-item-9">İletişim</a></li>
                </ul>
                <!-- Arama Çubuğu ve Dil Seçeneği -->
                <div class="flex items-center space-x-4 ml-8 reveal-item reveal-item-10">
                    <div class="relative">
                        <input type="text" placeholder="Ara..." class="pl-10 pr-4 py-2 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-gray-700">
                        <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
            </nav>
        </div>
    </header>

    <!-- Ana İçerik Alanı -->
    <main class="flex-grow">
        <?php
        // PHP ile hangi sayfanın gösterileceğine karar veriyoruz
        if ($page === 'home') {
        ?>
            <!-- Ana Sayfa İçeriği -->
            <section class="hero-section rounded-b-3xl shadow-xl">
                <div class="container">
                    <h1 class="text-5xl md:text-6xl font-extrabold mb-6 leading-tight reveal-item reveal-item-1">
                        Dijital Geleceğinizi Şekillendirin
                    </h1>
                    <p class="text-xl md:text-2xl mb-10 opacity-90 max-w-3xl mx-auto reveal-item reveal-item-2">
                        Web mobil tüm çözümleriniz için zerosoft.
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
                        <!-- Kart 1: Uzmanlık ve Deneyim -->
                        <div class="bg-purple-50 rounded-xl p-8 shadow-md hover:shadow-lg hover:-translate-y-3 transition duration-300 group">
                            <div class="flex items-center justify-center w-20 h-20 rounded-full bg-indigo-500 text-white mx-auto mb-6 transition duration-300 group-hover:scale-110">
                                <script>
                                    document.write('<i data-lucide="award" class="w-10 h-10"></i>');
                                </script>
                            </div>
                            <h3 class="text-2xl font-bold mb-4 text-gray-800 text-center">Uzmanlık ve Deneyim</h3>
                            <p class="text-gray-700 text-center">Yılların verdiği tecrübe ve sektördeki en iyi uzmanlarla projelerinizi hayata geçiriyoruz.</p>
                        </div>
                        <!-- Kart 2: İnovasyon ve Teknoloji -->
                        <div class="bg-purple-50 rounded-xl p-8 shadow-md hover:shadow-lg hover:-translate-y-3 transition duration-300 group">
                            <div class="flex items-center justify-center w-20 h-20 rounded-full bg-green-500 text-white mx-auto mb-6 transition duration-300 group-hover:scale-110">
                                <script>
                                    document.write('<i data-lucide="lightbulb" class="w-10 h-10"></i>');
                                </script>
                            </div>
                            <h3 class="text-2xl font-bold mb-4 text-gray-800 text-center">İnovasyon ve Teknoloji</h3>
                            <p class="text-gray-700 text-center">En yeni teknolojileri ve yenilikçi yaklaşımları kullanarak çözümler üretiyoruz.</p>
                        </div>
                        <!-- Kart 3: Müşteri Odaklı Yaklaşım -->
                        <div class="bg-purple-50 rounded-xl p-8 shadow-md hover:shadow-lg hover:-translate-y-3 transition duration-300 group">
                            <div class="flex items-center justify-center w-20 h-20 rounded-full bg-red-500 text-white mx-auto mb-6 transition duration-300 group-hover:scale-110">
                                <script>
                                    document.write('<i data-lucide="heart" class="w-10 h-10"></i>');
                                </script>
                            </div>
                            <h3 class="text-2xl font-bold mb-4 text-gray-800 text-center">Müşteri Odaklı Yaklaşım</h3>
                            <p class="text-gray-700 text-center">Müşteri memnuniyetini en üst düzeyde tutarak, projelerimizi sizin ihtiyaçlarınıza göre şekillendiriyoruz.</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Yeni Blog Yazıları Bölümü -->
            <section class="py-20 bg-white">
                <div class="container text-center">
                    <h2 class="section-title reveal-item reveal-item-1">Son Blog Yazılarımız</h2>
                    <p class="text-lg text-gray-700 mb-12 max-w-3xl mx-auto reveal-item reveal-item-2">
                        Teknoloji ve yazılım dünyasındaki en güncel gelişmeleri takip edin.
                    </p>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        <!-- Blog Yazısı Kartı 1 -->
                        <div class="bg-purple-50 rounded-xl p-6 shadow-md hover:shadow-lg hover:-translate-y-2 transition duration-300 group reveal-item reveal-item-3">
                            <img src="assets/images/yapay_zeka.jpg" alt="Yapay Zeka ve Geleceğin Yazılımı" class="rounded-lg mb-6 w-full h-40 object-cover">
                            <h3 class="text-xl font-bold mb-2 text-gray-800 text-left">Yapay Zeka ve Geleceğin Yazılımı</h3>
                            <p class="text-gray-600 text-left text-sm mb-4">Yapay zekanın yazılım dünyasını nasıl dönüştürdüğünü ve gelecekte bizi nelerin beklediğini keşfedin.</p>
                            <a href="index.php?page=blog_ai" class="text-indigo-600 hover:underline font-medium text-left block">Devamını Oku <i class="fas fa-arrow-right text-xs ml-1"></i></a>
                            <p class="text-gray-500 text-xs mt-2 text-left">10 Temmuz 2024</p>
                        </div>
                        <!-- Blog Yazısı Kartı 2 -->
                        <div class="bg-purple-50 rounded-xl p-6 shadow-md hover:shadow-lg hover:-translate-y-2 transition duration-300 group reveal-item reveal-item-4">
                            <img src="assets/images/cloud-teknolojisi.jpg" alt="Bulut Bilişimin İşletmelere Faydaları" class="rounded-lg mb-6 w-full h-40 object-cover">
                            <h3 class="text-xl font-bold mb-2 text-gray-800 text-left">Bulut Bilişimin İşletmelere Faydaları</h3>
                            <p class="text-gray-600 text-left text-sm mb-4">Bulut teknolojilerinin işletmeler için sunduğu avantajları ve nasıl adapte olabileceğinizi öğrenin.</p>
                            <a href="index.php?page=blog_cloud" class="text-indigo-600 hover:underline font-medium text-left block">Devamını Oku <i class="fas fa-arrow-right text-xs ml-1"></i></a>
                            <p class="text-gray-500 text-xs mt-2 text-left">05 Temmuz 2024</p>
                        </div>
                        <!-- Blog Yazısı Kartı 3 -->
                        <div class="bg-purple-50 rounded-xl p-6 shadow-md hover:shadow-lg hover:-translate-y-2 transition duration-300 group reveal-item reveal-item-5">
                            <img src="assets/images/mobil.png" alt="Mobil Uygulama Geliştirmede UX Önemi" class="rounded-lg mb-6 w-full h-40 object-cover">
                            <h3 class="text-xl font-bold mb-2 text-gray-800 text-left">Mobil Uygulama Geliştirmede UX Önemi</h3>
                            <p class="text-gray-600 text-left text-sm mb-4">Kullanıcı deneyiminin mobil uygulama başarısındaki kritik rolünü ve en iyi uygulamaları inceleyin.</p>
                            <a href="index.php?page=blog_ux" class="text-indigo-600 hover:underline font-medium text-left block">Devamını Oku <i class="fas fa-arrow-right text-xs ml-1"></i></a>
                            <p class="text-gray-500 text-xs mt-2 text-left">01 Temmuz 2024</p>
                        </div>
                    </div>
                    <a href="index.php?page=blog" class="btn-primary inline-block text-lg shadow-lg hover:shadow-xl transform hover:scale-105 duration-300 mt-12 reveal-item reveal-item-6">
                        Tüm Blog Yazılarını Görüntüle
                    </a>
                </div>
            </section>

        <?php
        } elseif ($page === 'services') {
        ?>
            <!-- Hizmetler Sayfası İçeriği -->
            <section class="py-20 bg-gray-50">
                <div class="container mx-auto px-4">
                    <h2 class="section-title reveal-item text-center items-center reveal-item-1">Sunulan Hizmetlerimiz</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-10 reveal-item reveal-item-2">
                        <!-- Hizmet Kartı 1: Web Geliştirme -->
                        <div class="bg-purple-50 rounded-xl p-8 shadow-md hover:shadow-lg hover:brightness-105 transition duration-300 group flex flex-col items-center text-center">
                            <div class="flex items-center justify-center w-16 h-16 rounded-full bg-blue-600 text-white mx-auto mb-6 transition duration-300 group-hover:scale-110">
                                <script>
                                    document.write('<i data-lucide="monitor" class="w-8 h-8"></i>');
                                </script>
                            </div>
                            <h3 class="text-2xl font-bold mb-4 text-gray-800 font-inter">Web Geliştirme</h3>
                            <p class="text-gray-700 mb-4 font-inter">Modern, duyarlı ve performans odaklı web siteleri ve web tabanlı uygulamalar tasarlıyor ve geliştiriyoruz.</p>
                            <ul class="list-disc list-inside text-gray-700 space-y-2 text-left w-full font-inter">
                                <li>Responsive Tasarım</li>
                                <li>SEO Optimizasyonu</li>
                                <li>Hızlı performans</li>
                            </ul>
                        </div>
                        <!-- Hizmet Kartı 2: Mobil Uygulama Geliştirme -->
                        <div class="bg-purple-50 rounded-xl p-8 shadow-md hover:shadow-lg hover:brightness-105 transition duration-300 group flex flex-col items-center text-center">
                            <div class="flex items-center justify-center w-16 h-16 rounded-full bg-green-600 text-white mx-auto mb-6 transition duration-300 group-hover:scale-110">
                                <script>
                                    document.write('<i data-lucide="app-window" class="w-8 h-8"></i>');
                                </script>
                            </div>
                            <h3 class="text-2xl font-bold mb-4 text-gray-800 font-inter">Mobil Uygulama Geliştirme</h3>
                            <p class="text-gray-700 mb-4 font-inter">iOS ve Android platformları için kullanıcı dostu ve yenilikçi mobil uygulamalar geliştiriyoruz.</p>
                            <ul class="list-disc list-inside text-gray-700 space-y-2 text-left w-full font-inter">
                                <li>Native Mobil Uygulamalar</li>
                                <li>Cross-Platform Uygulamalar</li>
                                <li>App Store Optimizasyonu</li>
                            </ul>
                        </div>
                        <!-- Hizmet Kartı 3: Bulut Çözümleri -->
                        <div class="bg-purple-50 rounded-xl p-8 shadow-md hover:shadow-lg hover:brightness-105 transition duration-300 group flex flex-col items-center text-center">
                            <div class="flex items-center justify-center w-16 h-16 rounded-full bg-purple-600 text-white mx-auto mb-6 transition duration-300 group-hover:scale-110">
                                <script>
                                    document.write('<i data-lucide="server" class="w-8 h-8"></i>');
                                </script>
                            </div>
                            <h3 class="text-2xl font-bold mb-4 text-gray-800 font-inter">Bulut Çözümleri</h3>
                            <p class="text-gray-700 mb-4 font-inter">AWS, Azure ve Google Cloud üzerinde güvenli ve ölçeklenebilir bulut çözümleri sunuyoruz.</p>
                            <ul class="list-disc list-inside text-gray-700 space-y-2 text-left w-full font-inter">
                                <li>Cloud Migration</li>
                                <li>DevOps Hizmetleri</li>
                                <li>7/24 Monitoring</li>
                            </ul>
                        </div>
                        <!-- Hizmet Kartı 4: Danışmanlık ve Destek -->
                        <div class="bg-purple-50 rounded-xl p-8 shadow-md hover:shadow-lg hover:brightness-105 transition duration-300 group flex flex-col items-center text-center">
                            <div class="flex items-center justify-center w-16 h-16 rounded-full bg-red-600 text-white mx-auto mb-6 transition duration-300 group-hover:scale-110">
                                <script>
                                    document.write('<i data-lucide="handshake" class="w-8 h-8"></i>');
                                </script>
                            </div>
                            <h3 class="text-2xl font-bold mb-4 text-gray-800 font-inter">Danışmanlık ve Destek</h3>
                            <p class="text-gray-700 mb-4 font-inter">Dijital dönüşüm süreçlerinizde uzman ekibimizle yanınızdayız.</p>
                            <ul class="list-disc list-inside text-gray-700 space-y-2 text-left w-full font-inter">
                                <li>Dijital Strateji</li>
                                <li>Proje Yönetimi</li>
                                <li>Teknoloji Danışmanlığı</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Sürecimiz Bölümü -->
            <section class="py-20 bg-white">
                <div class="container mx-auto px-4 text-center">
                    <h2 class="section-title reveal-item reveal-item-1">Sürecimiz</h2>
                    <p class="text-lg text-gray-700 mb-12 max-w-3xl mx-auto reveal-item reveal-item-2">
                        Projelerinizi hayata geçirirken izlediğimiz adımlar.
                    </p>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 reveal-item reveal-item-3">
                        <!-- Süreç Kartı 1: Keşif ve Analiz -->
                        <div class="bg-purple-50 rounded-xl p-8 shadow-sm hover:shadow-md hover:-translate-y-2 transition duration-300 border-t-4 border-indigo-500 hover:border-t-8 hover:border-indigo-700 group">
                            <div class="flex items-center justify-center w-16 h-16 rounded-full bg-indigo-500 text-white mx-auto mb-6 transition duration-300 group-hover:rotate-6">
                                <script>
                                    document.write('<i data-lucide="search" class="w-8 h-8"></i>');
                                </script>
                            </div>
                            <h3 class="text-xl font-bold mb-2 text-gray-800">Keşif ve Analiz</h3>
                            <p class="text-gray-700">İhtiyaçlarınızı ve hedeflerinizi detaylı bir şekilde anlayarak projenizin temelini atıyoruz.</p>
                        </div>
                        <!-- Süreç Kartı 2: Tasarım ve Planlama -->
                        <div class="bg-purple-50 rounded-xl p-8 shadow-sm hover:shadow-md hover:-translate-y-2 transition duration-300 border-t-4 border-purple-500 hover:border-t-8 hover:border-purple-700 group">
                            <div class="flex items-center justify-center w-16 h-16 rounded-full bg-purple-500 text-white mx-auto mb-6 transition duration-300 group-hover:rotate-6">
                                <script>
                                    document.write('<i data-lucide="pencil-ruler" class="w-8 h-8"></i>');
                                </script>
                            </div>
                            <h3 class="text-xl font-bold mb-2 text-gray-800">Tasarım ve Planlama</h3>
                            <p class="text-gray-700">Kullanıcı deneyimini ön planda tutarak estetik ve işlevsel tasarımlar oluşturuyoruz.</p>
                        </div>
                        <!-- Süreç Kartı 3: Geliştirme ve Uygulama -->
                        <div class="bg-purple-50 rounded-xl p-8 shadow-sm hover:shadow-md hover:-translate-y-2 transition duration-300 border-t-4 border-green-500 hover:border-t-8 hover:border-green-700 group">
                            <div class="flex items-center justify-center w-16 h-16 rounded-full bg-green-500 text-white mx-auto mb-6 transition duration-300 group-hover:rotate-6">
                                <script>
                                    document.write('<i data-lucide="code" class="w-8 h-8"></i>');
                                </script>
                            </div>
                            <h3 class="text-xl font-bold mb-2 text-gray-800">Geliştirme ve Uygulama</h3>
                            <p class="text-gray-700">En son teknolojileri kullanarak projenizi titizlikle geliştiriyor ve hayata geçiriyoruz.</p>
                        </div>
                        <!-- Süreç Kartı 4: Test ve Destek -->
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

            <!-- Bülten Aboneliği Bölümü - Kart Tasarımı -->
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
        ?>
            <!-- Portföy Sayfası İçeriği -->
            <section class="py-20 bg-gray-50">
                <div class="container text-center">
                    <h2 class="section-title reveal-item reveal-item-1">Portföyümüz</h2>
                    <p class="text-lg text-gray-700 mb-12 max-w-3xl mx-auto reveal-item reveal-item-2">
                        Tamamladığımız projelerden bazı örnekleri inceleyebilirsiniz.
                    </p>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        <!-- Demo Kart 1 -->
                        <div class="relative rounded-xl shadow-md overflow-hidden group">
                            <img src="assets/images/eticaret.jpg" alt="Web Demo 1 Website" class="w-full h-48 object-cover rounded-t-xl">
                            <div class="absolute inset-0 bg-purple-700/70 rounded-t-xl flex items-center justify-center opacity-100 group-hover:opacity-0 transition duration-300">
                                <h3 class="text-3xl font-bold text-white">E-Ticaret Sitesi</h3>
                            </div>
                            <div class="p-6 bg-purple-50 rounded-b-xl text-left">
                                
                                <p class="text-gray-700 mb-4">Modern ve kullanıcı dostu bir e-ticaret platformu demosu.</p>
                                <a href="#" class="btn-primary inline-block text-sm">Detayları İncele</a>
                            </div>
                        </div>
                        <!-- Demo Kart 2 -->
                        <div class="relative rounded-xl shadow-md overflow-hidden group">
                            <img src="assets/images/profesyonel-mobil-uygulama.jpg" alt="Mobil Uygulama Demo 1" class="w-full h-48 object-cover rounded-t-xl">
                            <div class="absolute inset-0 bg-purple-700/70 rounded-t-xl flex items-center justify-center opacity-100 group-hover:opacity-0 transition duration-300">
                                <h3 class="text-3xl font-bold text-white">Mobil CRM Uygulaması</h3>
                            </div>
                            <div class="p-6 bg-purple-50 rounded-b-xl text-left">
                                
                                <p class="text-gray-700 mb-4">Müşteri ilişkileri yönetimi için mobil uygulama demosu.</p>
                                <a href="#" class="btn-primary inline-block text-sm">Detayları İncele</a>
                            </div>
                        </div>
                        <!-- Demo Kart 3 -->
                        <div class="relative rounded-xl shadow-md overflow-hidden group">
                            <img src="assets/images/SAAS.jpg" alt="SaaS Demo 1" class="w-full h-48 object-cover rounded-t-xl">
                            <div class="absolute inset-0 bg-purple-700/70 rounded-t-xl flex items-center justify-center opacity-100 group-hover:opacity-0 transition duration-300">
                                <h3 class="text-3xl font-bold text-white">SaaS Yönetim Paneli</h3>
                            </div>
                            <div class="p-6 bg-purple-50 rounded-b-xl text-left">
                                
                                <p class="text-gray-700 mb-4">Kapsamlı bir SaaS ürününün yönetim paneli demosu.</p>
                                <a href="#" class="btn-primary inline-block text-sm">Detayları İncele</a>
                            </div>
                        </div>
                        <!-- Demo Kart 4 -->
                        <div class="relative rounded-xl shadow-md overflow-hidden group">
                            <img src="assets/images/kurumsal-web-sitesi-2.jpg" alt="Web Demo 2" class="w-full h-48 object-cover rounded-t-xl">
                            <div class="absolute inset-0 bg-purple-700/70 rounded-t-xl flex items-center justify-center opacity-100 group-hover:opacity-0 transition duration-300">
                                <h3 class="text-3xl font-bold text-white">Kurumsal Web Sitesi</h3>
                            </div>
                            <div class="p-6 bg-purple-50 rounded-b-xl text-left">
                                
                                <p class="text-gray-700 mb-4">Modern ve profesyonel kurumsal web sitesi demosu.</p>
                                <a href="#" class="btn-primary inline-block text-sm">Detayları İncele</a>
                            </div>
                        </div>
                        

                    <!-- Müşteri Yorumları / Referanslar Bölümü kaldırıldı -->
                </div>
            </section>

        <?php
        } elseif ($page === 'about') {
        ?>
            <!-- Hakkımızda Sayfası İçeriği -->
            <section class="py-20 bg-white">
                <div class="container text-center">
                    <h2 class="section-title reveal-item reveal-item-1">Biz Kimiz?</h2>
                    <p class="text-lg leading-relaxed text-gray-700 mb-8 max-w-4xl mx-auto reveal-item reveal-item-2">
                        ZeroSoft olarak, teknolojinin sunduğu sınırsız imkanlarla onların potansiyellerini açığa çıkarmalarına yardımcı oluyoruz.
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
                        <!-- Hakkımızda Kart 1: Misyonumuz -->
                        <div class="bg-purple-50 rounded-xl p-8 shadow-md hover:shadow-lg hover:-translate-y-3 transition duration-300 group">
                            <div class="flex items-center justify-center w-20 h-20 rounded-full bg-indigo-600 text-white mx-auto mb-6 transition duration-300 group-hover:scale-110">
                                <script>
                                    document.write('<i data-lucide="target" class="w-10 h-10"></i>');
                                </script>
                            </div>
                            <h4 class="text-2xl font-bold mb-4 text-gray-800">Misyonumuz</h4>
                            <p class="text-gray-700">Müşterilerimize özel ve yenilikçi teknoloji çözümleri sunarak, işlerini dijital dünyada büyütmelerine yardımcı olmak ve sürdürülebilir başarı elde etmelerini sağlamak.</p>
                        </div>
                        <!-- Hakkımızda Kart 2: Vizyonumuz -->
                        <div class="bg-purple-50 rounded-xl p-8 shadow-md hover:shadow-lg hover:-translate-y-3 transition duration-300 group">
                            <div class="flex items-center justify-center w-20 h-20 rounded-full bg-purple-600 text-white mx-auto mb-6 transition duration-300 group-hover:scale-110">
                                <script>
                                    document.write('<i data-lucide="eye" class="w-10 h-10"></i>');
                                </script>
                            </div>
                            <h4 class="text-2xl font-bold mb-4 text-gray-800">Vizyonumuz</h4>
                            <p class="text-gray-700">Dijital dünyada öncü çözümler üreterek, işletmelerin teknolojik dönüşümüne liderlik etmek ve müşterilerimizin başarı hikayelerinin bir parçası olmak.</p>
                        </div>
                        <!-- Hakkımızda Kart 3: Değerlerimiz -->
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
        ?>
            <!-- Blog Sayfası İçeriği -->
            <section class="py-20 bg-gray-50">
                <div class="container text-center">
                    <h2 class="section-title reveal-item reveal-item-1">Blogumuzdan Son Yazılar</h2>
                    <p class="text-lg text-gray-700 mb-12 max-w-3xl mx-auto reveal-item reveal-item-2">
                        Teknoloji, yazılım geliştirme ve sektördeki yenilikler hakkında en güncel içerikler.
                    </p>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        <!-- Blog Yazısı 1 -->
                        <div class="bg-purple-50 rounded-xl p-6 shadow-md hover:shadow-lg hover:-translate-y-2 transition duration-300 group reveal-item reveal-item-3">
                            <img src="assets/images/yapay_zeka.jpg" alt="Yapay Zeka ve Geleceğin Yazılımı" class="rounded-lg mb-6 w-full h-40 object-cover">
                            <h3 class="text-xl font-bold mb-2 text-gray-800 text-left">Yapay Zeka ve Geleceğin Yazılımı</h3>
                            <p class="text-gray-600 text-left text-sm mb-4">Yapay zekanın yazılım dünyasını nasıl dönüştürdüğünü ve gelecekte bizi nelerin beklediğini keşfedin.</p>
                            <a href="index.php?page=blog_ai" class="text-indigo-600 hover:underline font-medium text-left block">Devamını Oku <i class="fas fa-arrow-right text-xs ml-1"></i></a>
                            <p class="text-gray-500 text-xs mt-2 text-left">10 Temmuz 2024</p>
                        </div>
                        <!-- Blog Yazısı 2 -->
                        <div class="bg-purple-50 rounded-xl p-6 shadow-md hover:shadow-lg hover:-translate-y-2 transition duration-300 group reveal-item reveal-item-4">
                            <img src="assets/images/cloud-teknolojisi.jpg" alt="Bulut Bilişimin İşletmelere Faydaları" class="rounded-lg mb-6 w-full h-40 object-cover">
                            <h3 class="text-xl font-bold mb-2 text-gray-800 text-left">Bulut Bilişimin İşletmelere Faydaları</h3>
                            <p class="text-gray-600 text-left text-sm mb-4">Bulut teknolojilerinin işletmeler için sunduğu avantajları ve nasıl adapte olabileceğinizi öğrenin.</p>
                            <a href="index.php?page=blog_cloud" class="text-indigo-600 hover:underline font-medium text-left block">Devamını Oku <i class="fas fa-arrow-right text-xs ml-1"></i></a>
                            <p class="text-gray-500 text-xs mt-2 text-left">05 Temmuz 2024</p>
                        </div>
                        <!-- Blog Yazısı 3 -->
                        <div class="bg-purple-50 rounded-xl p-6 shadow-md hover:shadow-lg hover:-translate-y-2 transition duration-300 group reveal-item reveal-item-5">
                            <img src="assets/images/mobil.png" alt="Mobil Uygulama Geliştirmede UX Önemi" class="rounded-lg mb-6 w-full h-40 object-cover">
                            <h3 class="text-xl font-bold mb-2 text-gray-800 text-left">Mobil Uygulama Geliştirmede UX Önemi</h3>
                            <p class="text-gray-600 text-left text-sm mb-4">Kullanıcı deneyiminin mobil uygulama başarısındaki kritik rolünü ve en iyi uygulamaları inceleyin.</p>
                            <a href="index.php?page=blog_ux" class="text-indigo-600 hover:underline font-medium text-left block">Devamını Oku <i class="fas fa-arrow-right text-xs ml-1"></i></a>
                            <p class="text-gray-500 text-xs mt-2 text-left">01 Temmuz 2024</p>
                        </div>
                    </div>
                </div>
            </section>

        <?php
        } elseif ($page === 'faq') {
        ?>
            <!-- SSS Sayfası İçeriği -->
            <section class="py-20 bg-gray-50">
                <div class="container">
                    <h2 class="section-title text-center reveal-item reveal-item-1">Sıkça Sorulan Sorular</h2>
                    <p class="text-lg text-gray-700 mb-12 max-w-3xl mx-auto text-center reveal-item reveal-item-2">
                        Aklınızdaki sorulara hızlı yanıtlar bulabilirsiniz.
                    </p>
                    <div class="max-w-3xl mx-auto bg-purple-50 rounded-xl shadow-lg p-8 reveal-item reveal-item-3">
                        <!-- SSS Öğesi 1 -->
                        <div class="faq-item">
                            <div class="faq-question" onclick="toggleFAQ(this)">
                                <span>ZeroSoft hangi hizmetleri sunuyor?</span>
                                <i class="fas fa-chevron-down faq-icon"></i>
                            </div>
                            <div class="faq-answer">
                                <p>ZeroSoft olarak web geliştirme, mobil uygulama geliştirme, bulut çözümleri ve teknoloji danışmanlığı gibi geniş bir yelpazede hizmetler sunmaktayız.</p>
                            </div>
                        </div>
                        <!-- SSS Öğesi 2 -->
                        <div class="faq-item">
                            <div class="faq-question" onclick="toggleFAQ(this)">
                                <span>Projelerinizde hangi teknolojileri kullanıyorsunuz?</span>
                                <i class="fas fa-chevron-down faq-icon"></i>
                            </div>
                            <div class="faq-answer">
                                <p>Projelerimizde güncel ve sektör lideri teknolojileri tercih ediyoruz. Bunlar arasında React, Vue.js, Node.js, Python, PHP, Laravel, Flutter, React Native, AWS, Azure ve Google Cloud gibi teknolojiler bulunmaktadır.</p>
                            </div>
                        </div>
                        <!-- SSS Öğesi 3 -->
                        <div class="faq-item">
                            <div class="faq-question" onclick="toggleFAQ(this)">
                                <span>Proje süreci nasıl işliyor?</span>
                                <i class="fas fa-chevron-down faq-icon"></i>
                            </div>
                            <div class="faq-answer">
                                <p>Proje sürecimiz keşif ve analiz, tasarım ve planlama, geliştirme ve uygulama, test ve destek olmak üzere dört ana adımdan oluşmaktadır. Her aşamada şeffaf iletişim ve müşteri odaklı yaklaşım benimsiyoruz.</p>
                            </div>
                        </div>
                        <!-- SSS Öğesi 4 -->
                        <div class="faq-item">
                            <div class="faq-question" onclick="toggleFAQ(this)">
                                <span>Destek hizmetleriniz nelerdir?</span>
                                <i class="fas fa-chevron-down faq-icon"></i>
                            </div>
                            <div class="faq-answer">
                                <p>Tamamlanan projeler için sürekli teknik destek, bakım ve güncelleme hizmetleri sunuyoruz. Müşterilerimizin sistemlerinin sorunsuz çalışmasını sağlamak için 7/24 izleme ve müdahale kapasitemiz bulunmaktadır.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        <?php
        } elseif ($page === 'contact') {
        ?>
            <!-- İletişim Sayfası İçeriği -->
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
        // Yeni blog yazısı detay sayfaları
        elseif ($page === 'blog_ai') {
        ?>
            <section class="py-20 bg-gray-50">
                <div class="container mx-auto px-4 max-w-3xl">
                    <h2 class="section-title text-left reveal-item reveal-item-1">Yapay Zeka ve Geleceğin Yazılımı</h2>
                    <p class="text-gray-600 text-left text-sm mb-6 reveal-item reveal-item-2">10 Temmuz 2024</p>
                    <img src="https://placehold.co/800x400/A78BFA/FFFFFF?text=Yapay+Zeka+Detay" alt="Yapay Zeka ve Geleceğin Yazılımı Detay" class="rounded-lg mb-8 w-full object-cover reveal-item reveal-item-3">
                    <p class="text-lg leading-relaxed text-gray-700 mb-6 reveal-item reveal-item-4">
                        Yapay zeka (YZ), günümüz yazılım dünyasını kökten değiştiren ve gelecekteki teknolojik gelişmelere yön veren en önemli alanlardan biridir. Makine öğrenimi, derin öğrenme ve doğal dil işleme gibi alt dallarıyla YZ, yazılımların daha akıllı, adaptif ve özerk hale gelmesini sağlamaktadır.
                    </p>
                    <p class="text-lg leading-relaxed text-gray-700 mb-6 reveal-item reveal-item-5">
                        Gelecekte yazılım geliştirme süreçlerinde YZ'nin rolü daha da artacak. Otomatik kod üretimi, hata tespiti ve optimizasyon gibi alanlarda YZ destekli araçlar yaygınlaşacak. Bu da geliştiricilerin daha karmaşık ve yaratıcı problemlere odaklanmasına olanak tanıyacak. YZ ayrıca, kişiselleştirilmiş kullanıcı deneyimleri sunan, veri analiziyle karar alma süreçlerini optimize eden ve otomasyonu artıran uygulamaların temelini oluşturacak.
                    </p>
                    <p class="text-lg leading-relaxed text-gray-700 reveal-item reveal-item-6">
                        ZeroSoft olarak, yapay zeka entegrasyonu konusunda uzmanlaşmış ekibimizle, işletmelerin YZ'nin sunduğu potansiyeli tam olarak kullanmalarına yardımcı oluyoruz. Akıllı otomasyon sistemlerinden veri odaklı karar destek mekanizmalarına kadar çeşitli YZ çözümleri geliştirerek, müşterilerimizin dijital dönüşüm yolculuklarında yanlarında oluyoruz.
                    </p>
                    <a href="index.php?page=blog" class="btn-primary inline-block text-base mt-8 reveal-item reveal-item-7">
                        <i class="fas fa-arrow-left mr-2"></i> Tüm Yazılara Geri Dön
                    </a>
                </div>
            </section>
        <?php
        } elseif ($page === 'blog_cloud') {
        ?>
            <section class="py-20 bg-gray-50">
                <div class="container mx-auto px-4 max-w-3xl">
                    <h2 class="section-title text-left reveal-item reveal-item-1">Bulut Bilişimin İşletmelere Faydaları</h2>
                    <p class="text-gray-600 text-left text-sm mb-6 reveal-item reveal-item-2">05 Temmuz 2024</p>
                    <img src="https://placehold.co/800x400/A78BFA/FFFFFF?text=Bulut+Bilisim+Detay" alt="Bulut Bilişimin İşletmelere Faydaları Detay" class="rounded-lg mb-8 w-full object-cover reveal-item reveal-item-3">
                    <p class="text-lg leading-relaxed text-gray-700 mb-6 reveal-item reveal-item-4">
                        Bulut bilişim, işletmelerin IT altyapılarını yönetme ve kullanma şekillerini devrim niteliğinde değiştiren bir teknolojidir. Sunucular, depolama, veritabanları, ağ ve yazılım gibi bilişim hizmetlerinin internet üzerinden, yani "bulut" aracılığıyla sunulması anlamına gelir. Bu model, işletmelere esneklik, ölçeklenebilirlik ve maliyet avantajları sunar.
                    </p>
                    <p class="text-lg leading-relaxed text-gray-700 mb-6 reveal-item reveal-item-5">
                        Bulut bilişimin en büyük faydalarından biri, başlangıç maliyetlerini düşürmesidir. Fiziksel donanım satın alma ve bakım maliyetlerinden kurtulan işletmeler, sadece kullandıkları hizmet kadar ödeme yaparlar. Ayrıca, bulut altyapıları sayesinde iş yükleri anlık olarak ölçeklenebilir, bu da ani talep artışlarına veya azalışlarına kolayca adapte olmayı sağlar. Güvenlik, veri yedekleme ve felaket kurtarma gibi konularda da bulut sağlayıcılarının sunduğu gelişmiş çözümler, işletmelerin veri güvenliğini artırır.
                    </p>
                    <p class="text-lg leading-relaxed text-gray-700 reveal-item reveal-item-6">
                        ZeroSoft olarak, AWS, Azure ve Google Cloud gibi önde gelen bulut platformlarında uzmanlaşmış ekibimizle, işletmelerin bulut dönüşüm süreçlerinde stratejik danışmanlık ve uygulama hizmetleri sunuyoruz. Mevcut altyapıların buluta taşınmasından, bulut tabanlı yeni uygulamaların geliştirilmesine kadar her adımda yanınızdayız.
                    </p>
                    <a href="index.php?page=blog" class="btn-primary inline-block text-base mt-8 reveal-item reveal-item-7">
                        <i class="fas fa-arrow-left mr-2"></i> Tüm Yazılara Geri Dön
                    </a>
                </div>
            </section>
        <?php
        } elseif ($page === 'blog_ux') {
        ?>
            <section class="py-20 bg-gray-50">
                <div class="container mx-auto px-4 max-w-3xl">
                    <h2 class="section-title text-left reveal-item reveal-item-1">Mobil Uygulama Geliştirmede UX Önemi</h2>
                    <p class="text-gray-600 text-left text-sm mb-6 reveal-item reveal-item-2">01 Temmuz 2024</p>
                    <img src="https://placehold.co/800x400/A78BFA/FFFFFF?text=Mobil+UX+Detay" alt="Mobil Uygulama Geliştirmede UX Önemi Detay" class="rounded-lg mb-8 w-full object-cover reveal-item reveal-item-3">
                    <p class="text-lg leading-relaxed text-gray-700 mb-6 reveal-item reveal-item-4">
                        Mobil uygulama geliştirme dünyasında kullanıcı deneyimi (UX), uygulamanın başarısını doğrudan etkileyen kritik bir faktördür. Harika bir fikriniz ve güçlü bir teknik altyapınız olsa bile, eğer kullanıcılar uygulamanızı kolayca kullanamıyor, keyif almıyor veya hedeflerine ulaşamıyorsa, uygulamanızın benimsenmesi ve kalıcılığı zorlaşır. UX, kullanıcıların bir ürünle etkileşim kurarken yaşadıkları tüm deneyimi kapsar.
                    </p>
                    <p class="text-lg leading-relaxed text-gray-700 mb-6 reveal-item reveal-item-5">
                        Mobil UX tasarımında hız, basitlik, tutarlılık ve erişilebilirlik temel prensiplerdir. Kullanıcıların sınırlı ekran alanında hızlıca işlem yapabilmesi, karmaşık menülerle boğuşmaması, uygulamanın farklı bölümlerinde aynı dil ve görsel tutarlılığı bulması ve engelli kullanıcılar için de erişilebilir olması büyük önem taşır. İyi bir UX, kullanıcı memnuniyetini artırır, uygulamanın tekrar kullanım oranını yükseltir ve olumlu ağızdan ağıza pazarlamayı teşvik eder.
                    </p>
                    <p class="text-lg leading-relaxed text-gray-700 reveal-item reveal-item-6">
                        ZeroSoft olarak, mobil uygulama geliştirme süreçlerimizde UX'i projenin merkezine koyuyoruz. Detaylı kullanıcı araştırmaları, prototipleme, kullanıcı testleri ve sürekli geri bildirimlerle, sadece işlevsel değil, aynı zamanda kullanıcı dostu ve keyifli mobil deneyimler tasarlıyoruz. Uygulamalarımızın kullanıcılar tarafından sevilerek kullanılmasını sağlamak, bizim için en büyük önceliktir.
                    </p>
                    <a href="index.php?page=blog" class="btn-primary inline-block text-base mt-8 reveal-item reveal-item-7">
                        <i class="fas fa-arrow-left mr-2"></i> Tüm Yazılara Geri Dön
                    </a>
                </div>
            </section>
        <?php
        }
        else {
        ?>
            <!-- Sayfa Bulunamadı İçeriği (404 Sayfası) -->
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

    <!-- Footer (Altbilgi) -->
    <footer class="bg-blue-900 text-white py-10 mt-auto rounded-t-3xl shadow-inner">
        <div class="container text-center">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Telif Hakkı -->
                <div class="reveal-item reveal-item-1">
                    <p class="text-gray-400">&copy; <?php echo date('Y'); ?> ZeroSoft. Tüm Hakları Saklıdır.</p>
                </div>
                
                <!-- Hızlı Bağlantılar -->
                <div class="reveal-item reveal-item-2">
                    <h3 class="text-xl font-semibold mb-4">Hızlı Bağlantılar</h3>
                    <ul class="space-y-2">
                        <li><a href="index.php?page=home" class="text-gray-400 hover:text-white transition duration-300">Ana Sayfa</a></li>
                        <li><a href="index.php?page=services" class="text-gray-400 hover:text-white transition duration-300">Hizmetler</a></li>
                        <li><a href="index.php?page=portfolio" class="text-gray-400 hover:text-white transition duration-300">Portföy</a></li>
                        <li><a href="index.php?page=about" class="text-gray-400 hover:text-white transition duration-300">Hakkımızda</a></li>
                        <li><a href="index.php?page=blog" class="text-gray-400 hover:text-white transition duration-300">Blog</a></li>
                        <li><a href="index.php?page=faq" class="text-gray-400 hover:text-white transition duration-300">SSS</a></li>
                        <!-- Kariyer linki kaldırıldı -->
                        <li><a href="index.php?page=contact" class="text-gray-400 hover:text-white transition duration-300">İletişim</a></li>
                    </ul>
                </div>

                <!-- İletişim Bilgileri -->
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
