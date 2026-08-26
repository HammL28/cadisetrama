<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body>
    
<div class="container py-4">
    @yield('content')
</div>

{{-- SCRIPT SWEETALERT2 DARI CDN --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- POP-UP AUTOMATIS GLOBAL (SUCCESS) --}}
@if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            timer: 2500,
            showConfirmButton: false,
            customClass: {
                popup: 'rounded-4'
            }
        });
    </script>
@endif

{{-- POP-UP AUTOMATIS GLOBAL (ERROR) --}}
@if(session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: "{{ session('error') }}",
            confirmButtonColor: '#7c3aed',
            customClass: {
                popup: 'rounded-4'
            }
        });
    </script>
@endif

</body>
</html>