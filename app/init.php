<?php

use ReCaptcha\ReCaptcha;

//requiere el autoload que carga todo lo que tiene que ver con el captcha
require_once '../../vendor/autoload.php';

//es la clave privada que se conpativilisa con el captcha recibido
$recaptcha = new ReCaptcha('6LduPXgUAAAAAD0lb7-L6t8TbXS4j5oOa0qiFeik');
