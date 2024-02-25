<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIMPRODPEK</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/home_style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/bootstrap-icons/font/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">



</head>

<body>

    <!-- Navbar -->

    <!-- Content -->
    <div class="container mt-5">
        <section id="about">
            <div class="content">
                <img src="{{ asset('assets/image/gambar2.png') }}" alt="Gambar" class="image blink-animation">
                <div class="text">
                    <h1 class="judul">CV. MARECA YASA MEDIA</h1>
                    <h2 class="judul2">ACCORDING TO WHAT YOU NEED</h2>
                    <p class="paragraf">
                        Lorem Ipsum is simply dummy text the printing and typesetting
                        <br>industry. Lorem Ipsum has been the industry's standard dummy text ever since
                        <br>the 1500s. Lorem Ipsum has been the industry'stext ever since the 1500s. Lorem
                    </p>
                    <div class="buttons">
                        <a href="{{ route('login') }}" class="neon-button login-button text-center">Login</a>
                        <a href="{{ route('register') }}" class="neon-button login-button  text-center">Register</a>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Footer -->

    <!-- link boostrap -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    @include('vendor.sweetalert.alert')
</body>

</html>
