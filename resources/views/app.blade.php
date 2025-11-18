<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title inertia>{{ config('app.name', 'Soie Sexy') }}</title>

        <meta name="description" content="Découvrez Soie Sexy, la lingerie qui révèle votre beauté naturelle. Sous-vêtements séduisants, robes sexy, bodys, dentelles et astuces de séduction pour attirer et impressionner sans effort. Restez toujours belle, même dans la cuisine.">

        <meta name="keywords" content="lingerie femme, lingerie sexy, sous-vêtements chic, robe de nuit, body sexy, lingerie Côte d'Ivoire, lingerie Abidjan, soie sexy, astuces de séduction, sous-corps sexy">

        <meta name="author" content="Soie Sexy">
        <meta name="robots" content="index, follow">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- Open Graph (Facebook, WhatsApp, Instagram) -->
        <meta property="og:title" content="Soie Sexy – Lingerie féminine élégante et irrésistible">
        <meta property="og:description" content="Lingerie sexy, dentelle, sous-corps et astuces de séduction pour révéler votre charme naturel. Impressionnez sans parler.">
        <meta property="og:type" content="website">
        <meta property="og:image" content="/assets/img/logo.png">

        <!-- Twitter Card -->
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="Soie Sexy – Lingerie féminine élégante et irrésistible">
        <meta name="twitter:description" content="Découvrez la lingerie qui attire, impressionne et révèle votre vraie beauté.">

        <link rel="icon" href="/assets/img/logo.ico" sizes="32x32">
        <link rel="icon" href="/assets/img/favicon.png" type="image/png" sizes="32x32">
        <link rel="apple-touch-icon" href="/assets/img/logo.ico">
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
              integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
              crossorigin="anonymous" referrerpolicy="no-referrer" />
        <!-- Scripts -->

        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-CWPVTDYT7B"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'G-CWPVTDYT7B');
        </script>

        <!-- Meta Pixel Code -->
        <script>
            !function(f,b,e,v,n,t,s)
            {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
                n.callMethod.apply(n,arguments):n.queue.push(arguments)};
                if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
                n.queue=[];t=b.createElement(e);t.async=!0;
                t.src=v;s=b.getElementsByTagName(e)[0];
                s.parentNode.insertBefore(t,s)}(window, document,'script',
                'https://connect.facebook.net/en_US/fbevents.js');
            fbq('init', '1176485344435462');
            fbq('track', 'PageView');
        </script>
        <noscript><img height="1" width="1" style="display:none"
                       src="https://www.facebook.com/tr?id=1176485344435462&ev=PageView&noscript=1"
            /></noscript>
        <!-- End Meta Pixel Code -->
        @routes
        @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
        @inertiaHead
        @stack('css')
    </head>
    <body class="bg-slate-900">
        @inertia
        <!-- Floating WhatsApp button -->
        <a href="https://wa.me/+2250798690325?&text=Est-ce que je peux discuter avec quelqu'un ?" target="_blank" rel="noopener"
           class="fixed right-2 bottom-20 z-50 shadow-lg rounded-full p-4 flex items-center gap-2"
           style="background-color:#25D366;">
            <!-- Icone SVG WhatsApp -->
            <i class="fa-brands fa-whatsapp fa-1x text-white"></i>
            <span class="hidden sm:inline text-white font-medium">Rejoindre</span>
        </a>

        <script src="https://code.jquery.com/jquery-3.7.1.min.js"
                integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        @stack('scripts')
    </body>
</html>
