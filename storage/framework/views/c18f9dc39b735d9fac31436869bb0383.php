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
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

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

    
    <?php echo $__env->make('layouts.component.sidebaruser', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    
    <div class="main-content">

        <?php echo $__env->yieldContent('content'); ?>

    </div>

</div>

</body>
</html><?php /**PATH C:\xampp\htdocs\projectmagang\resources\views/layouts/mainuser.blade.php ENDPATH**/ ?>