<?php
$wa = \Webapp::getInstance();
$rq = $wa->request;
?>

<nav>
  <a href="<?php echo $wa->route('public/home') ?>">Public Home</a> - 
  <a href="<?php echo $wa->route('private/home') ?>">Private Home</a> - 
  <a target="_blank" href="https://github.com/nrctkno/Molecule_PHP">About Molecule</a>
</nav>
<br />