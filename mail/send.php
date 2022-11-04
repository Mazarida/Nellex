<?php

$r       = '=?UTF-8?B?'.base64_encode('Клиент').'?=';
$s       = '=?UTF-8?B?'.base64_encode('Nellex').'?=';
$subject = '=?UTF-8?B?'.base64_encode('Тестовое письмо').'?=';

// append e-mail addresses
$s      .= ' <noreply@'.$_SERVER['SERVER_NAME'].'>';
$r      .= ' <toaster16mb@gmail.com>';

// create header
$header  = 'MIME-Version: 1.0' . "\r\n";
$header .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
//		$header .= 'To: ' . $r. "\r\n";
$header .= 'From: ' . $s. "\r\n";

$msg     = file_get_contents(dirname(__FILE__).'/mail.html');
$mail_sent = mail($r, $subject, $msg, $header);
var_dump($mail_sent);
$s       = '=?UTF-8?B?'.base64_encode('Nellex').'?=';
$subject = '=?UTF-8?B?'.base64_encode('Тестовое письмо').'?=';

// append e-mail addresses
$s      .= ' <noreply@'.$_SERVER['SERVER_NAME'].'>';
$r       = '=?UTF-8?B?'.base64_encode('Клиент').'?=';
$r      .= ' <z-z-z-z-z-z-z-z@yandex.ru>';

// create header
$header  = 'MIME-Version: 1.0' . "\r\n";
$header .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
//		$header .= 'To: ' . $r. "\r\n";
$header .= 'From: ' . $s. "\r\n";

$msg     = file_get_contents(dirname(__FILE__).'/mail.html');
$mail_sent = mail($r, $subject, $msg, $header);
var_dump($mail_sent);

print_r(error_get_last());