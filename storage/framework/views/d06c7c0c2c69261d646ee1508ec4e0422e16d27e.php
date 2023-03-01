<!DOCTYPE html>
<html>
<head>
    <title>nacivnsa_reser</title>
    <style>
        div {
            font-size: 22px;
        }
    </style>
</head>
<body>
    <div>
        <?php
            if(DB::connection()->getPdo())
            {
                echo "Successfully connected to the database => "
                             .DB::connection()->getDatabaseName();
            }
        ?>
    </div>
</body>
</html><?php /**PATH C:\xampp\htdocs\Proyectos\reservacion\resources\views/gfg.blade.php ENDPATH**/ ?>