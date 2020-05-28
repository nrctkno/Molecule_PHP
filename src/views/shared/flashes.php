<?php $sess = \Webapp::getInstance()->session; ?>

<?php if ($sess->hasFlash('info')): ?>
  <div>
    <?php foreach ($sess->getFlash('info') as $e): ?>
        <p class="info" class="alert-danger text-center"><?php echo $e ?></p>
    <?php endforeach; ?>
  </div>
<?php endif; ?>