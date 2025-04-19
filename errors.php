<?php
// ตรวจสอบว่าตัวแปร $errors มีค่าหรือไม่
if (isset($errors) && count($errors) > 0) : ?>
    <div class="error">
        <?php foreach ($errors as $error) : ?>
            <p><?php echo $error ?></p>
        <?php endforeach ?>
    </div>
<?php endif; ?>