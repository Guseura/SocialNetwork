<?php

require "rb.php";

R::setup( 'mysql:host=localhost;dbname=Dreamer',
    'root', '' );

session_start();