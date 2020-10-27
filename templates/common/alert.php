<!-- common/alert -->
<?php if (isset($_SESSION['message'])): ?>
<div class="alert alert-info">
    <?= $_SESSION['message'] ?>
</div>
<?php unset($_SESSION['message']); ?>
<?php endif; ?>