<?php
include '../config.php';

Admin::endSession();
header('Location: login.html');
