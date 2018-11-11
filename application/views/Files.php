<?php defined('SYSPATH') or die('No direct script access.');
/**
 * @var array    $files
 * @var array    $errors
 * @var string   $message
 *
 * @author     Novichkov Sergey(Radik) <novichkovsergey@yandex.ru>
 * @copyright  Copyrights (c) 2012 Novichkov Sergey
 */
?><!DOCTYPE html>
<html>
<head>
    <title>Pictures</title>
    <style type="text/css">
        *{ margin: 0; padding: 0; }
        html, body{ width: 100%; height: 100%; }
        a:hover{ text-decoration: none; }
        #wrap{ margin: 0 auto; padding-top: 20px; width: 960px; }
        #wrap h2{ margin-bottom: 15px; }
        #wrap .pictures img{ vertical-align: middle; margin-bottom: 10px; }
        #wrap .message{ padding: 5px; border: 3px solid #00f; color: #00f; margin-bottom: 20px; }
        #wrap .error{ padding: 5px; border: 3px solid #f00; color: #f00; margin-bottom: 20px; }
        #wrap .row, #wrap label{ display: block; margin-bottom: 5px; }
    </style>
</head>

<body>
<div id="wrap">
    <h2>Files</h2>
    <?php if (empty($files)) : ?>
        <p>Uploaded files not found</p>
    <?php else : ?>
        <div class="pictures">
            <?php foreach ($files as $file) : ?>
                <img src="<?php echo Route::url('preview', array('filename' => $file)) ?>" alt="">
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <h2>Upload</h2>
    <?php if ($message) : ?>
        <div class="message"><?php echo HTML::chars($message) ?></div>
    <?php endif; ?>
    <?php foreach ($errors as $error) : ?>
        <div class="error"><?php echo HTML::chars($error) ?></div>
    <?php endforeach; ?>
    <form action="upload" method="post" enctype="multipart/form-data">
        <label for="image_control">For upload picture please select the file and click upload button</label>
        <div class="row">
            <input type="file" name="image" id="image_control">
            <input type="submit" value="Upload">
        </div>
    </form>
</div>
</body>
</html>