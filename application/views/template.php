<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Styles -->
    <?php foreach ($styles as $file) {
        echo HTML::style($file, array('media' => 'screen'), TRUE), "\n";
    } ?>
    <!-- Scripts -->
    <?php foreach ($scripts as $file) {
        echo HTML::script($file, NULL, TRUE), "\n";
    } ?>
</head>
<body class="text-center">
<?php if (isset($entry)): ?>
    <?= $entry; ?><?php endif; ?>
</body>
</html>