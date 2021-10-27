<?php

use Ramsey\Uuid\Uuid;

$uuidPattern = trim(Uuid::VALID_PATTERN, '^$');

return [
    ''                        => 'site/index',
    'tokopedia/shop/showcase' => 'tokopedia/shop/showcase',
];