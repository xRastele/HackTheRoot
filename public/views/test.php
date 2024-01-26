<?php
require_once __DIR__.'/../../src/repository/UserRepository.php';

$userRepository = new UserRepository();
$users = $userRepository->getAllUsers();

foreach ($users as $user) {
    echo $user->getUserId() . ' - ' . $user->getUsername() . ' - ' . $user->getEmail() . ' - ' .$user->getPassword() .'<br>';
}
?>
