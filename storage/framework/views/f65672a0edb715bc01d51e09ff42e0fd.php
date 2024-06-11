<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>2307 GENERATOR</title>

          <?php echo app('Illuminate\Foundation\Vite')('resources/css/app.css'); ?>
    </head>
    
    <body >
        <div id="app">
        </div>
        <?php echo app('Illuminate\Foundation\Vite')('resources/js/app.js'); ?>
    </body>
</html>
<?php /**PATH D:\Systems\2307Generator\resources\views/welcome.blade.php ENDPATH**/ ?>