<?php
include 'config.php';

User::endSession();
header('Location: ./');
