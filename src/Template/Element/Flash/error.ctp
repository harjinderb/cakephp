<?php
if (!isset($params['escape']) || $params['escape'] !== false) {
    $message = ($message);
}
?>
<div class="alert alert-danger" onclick="this.classList.add('hidden');"><?= $message ?></div>
