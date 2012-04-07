<?php

echo '<h1>All Unit-Tests</h1><br>';

foreach ($controllers as $controllerName => $controller) {
     echo anchor('unit-tests/' . $controller, $controllerName) . '<br>'; 
}