<?php

$passwords = [
    'adaniel0982',
    'bisean47564',
    'milii2783',
    'asaa35423'
];

foreach ($passwords as $password) {
    echo htmlspecialchars($password) . " : ";
    echo password_hash($password, PASSWORD_DEFAULT);
    echo "<br><br>";
}

?>