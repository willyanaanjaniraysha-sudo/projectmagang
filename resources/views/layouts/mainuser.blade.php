<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   
    <title>E-Aspirasi</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"><!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   
    <title>E-Aspirasi</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        html{
            overflow-y: scroll; /* selalu sediakan ruang scrollbar, cegah lebar halaman berubah-ubah antar page */
            scrollbar-gutter: stable;
        }

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        body{
            background:#f4f7f6;
            font-family: Arial, sans-serif;
        }

        .layout-wrapper{
            display:flex;
            min-height:100vh;
        }

        .main-content{
            flex:1;
            padding:30px;
            overflow-x:hidden;
        }
    </style>
</head>
<body>

<div class="layout-wrapper">

    {{-- SIDEBAR --}}
    @include('layouts.component.sidebaruser')

    {{-- CONTENT --}}
    <div class="main-content">

        @yield('content')

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>         

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        body{
            background:#f4f7f6;
            font-family: Arial, sans-serif;
        }

        .layout-wrapper{
            display:flex;
            min-height:100vh;
        }

        .main-content{
            flex:1;
            padding:30px;
            overflow-x:hidden;
        }
    </style>
</head>
<body>

<div class="layout-wrapper">

    {{-- SIDEBAR --}}
    @include('layouts.component.sidebaruser')

    {{-- CONTENT --}}
    <div class="main-content">

        @yield('content')

    </div>

</div>

</body>
</html>