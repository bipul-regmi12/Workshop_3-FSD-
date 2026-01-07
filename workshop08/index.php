<?php
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/app/controllers/employee_controller.php';

use Jenssegers\Blade\Blade;

$blade = new Blade(__DIR__ . '/app/views', __DIR__ . '/cache');
$data = handleEmployeeRequest();

echo $blade->render($data['view'], $data);
