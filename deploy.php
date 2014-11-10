<?php
require 'recipe/common.php';
require 'recipe/symfony.php';

server('main', '5.135.165.207', 1342)
    ->path('/box/www/webapp')
    ->user('floran');

set('repository', 'git@github.com:shked0wn/Wineot.git');
?>