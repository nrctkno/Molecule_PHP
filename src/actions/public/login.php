<?php
$wa = \Webapp::getInstance();

//You can force a redirect to the private section if the user is authenticated
if ($wa->session->hasVar('user') && ($wa->session->getVar('user') !== false)) {
  return $wa->respondRedirect('private/home');
}


if ($wa->request->isPost()) {
  $username = $wa->request->getParam('username');
  $password = $wa->request->getParam('password');

  if (empty($username) || empty($password)) {
    $wa->session->addFlash('info', 'Username and pasword are required.');
  } else {

    $user = UserRepository::getUser($username, $password);

    if (empty($user)) {
      $wa->session->addFlash('info', 'Wrong credentials');
    } else {
      $wa->session->setVar('user', $user);
      return $wa->respondRedirect('private/home');
    }
  }
}
?>


<?php \Webapp::view_import('shared/layout_head.php') ?>

<h2>Login</h2>

<form method="POST" action="">
  <div><input type="text" name="username" placeholder="your username (anything)" required="" autofocus=""></div>
  <div><input type="password" name="password" placeholder="your password (anything)" required=""></div>
  <div><button type="submit">Continue</button></div>
</form>

<?php \Webapp::view_import('shared/layout_foot.php') ?>