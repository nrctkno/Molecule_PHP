<?php
$wa = \Webapp::getInstance();
//write your own logic here
$user = $wa->session->getVar('user');
?>


<?php \Webapp::view_import('shared/layout_head.php') ?>

<h2>Welcome to the private section, <?php echo $user->name ?></h2>

<a href="<?php echo $wa->route('private/logout') ?>">Logout</a>

<?php \Webapp::view_import('shared/layout_foot.php') ?>