<?php

use Ramsey\Uuid\Uuid;

$uuidPattern = trim(Uuid::VALID_PATTERN, '^$');

return [
    ''             => 'site/index',
    'sms'          => 'notification/sms',
    'email'        => 'notification/email',
    'push'         => 'notification/push',
    'pushOverseas' => 'notification/pushOverseas',
    'wa'           => 'notification/wa',

];


