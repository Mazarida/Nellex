<?php
$arUrlRewrite = array (
    1 =>
        array (
            'CONDITION' => '#^/online/([\\.\\-0-9a-zA-Z]+)(/?)([^/]*)#',
            'RULE' => 'alias=$1',
            'ID' => NULL,
            'PATH' => '/desktop_app/router.php',
            'SORT' => 100,
        ),
    9 =>
        array (
            'CONDITION' => '#^/catalog/favorite/filter/(.+?)/apply/\\??(.*)#',
            'RULE' => 'SMART_FILTER_PATH=$1&$2',
            'ID' => 'bitrix:catalog.smart.filter',
            'PATH' => '/catalog/favorite.php',
            'SORT' => 100,
        ),
    8 =>
        array (
            'CONDITION' => '#^/catalog/favorite/#',
            'RULE' => '',
            'ID' => 'bitrix:catalog.section',
            'PATH' => '/catalog/favorite.php',
            'SORT' => 100,
        ),
    7 =>
        array (
            'CONDITION' => '#^/catalog/filter/(.+?)/apply/\\??(.*)#',
            'RULE' => 'SMART_FILTER_PATH=$1&$2',
            'ID' => 'bitrix:catalog.smart.filter',
            'PATH' => '/catalog/index.php',
            'SORT' => 100,
        ),
    6 =>
        array (
            'CONDITION' => '#^/catalog/([\\w\\d\\-]+)/(\\?(.*))?#',
            'RULE' => 'ELEMENT_CODE=$1',
            'ID' => 'bitrix:catalog.element',
            'PATH' => '/catalog/detail.php',
            'SORT' => 100,
        ),
    4 =>
        array (
            'CONDITION' => '#^/bitrix/services/ymarket/#',
            'RULE' => '',
            'ID' => '',
            'PATH' => '/bitrix/services/ymarket/index.php',
            'SORT' => 100,
        ),
    2 =>
        array (
            'CONDITION' => '#^/online/(/?)([^/]*)#',
            'RULE' => '',
            'ID' => NULL,
            'PATH' => '/desktop_app/router.php',
            'SORT' => 100,
        ),
    0 =>
        array (
            'CONDITION' => '#^/stssync/calendar/#',
            'RULE' => '',
            'ID' => 'bitrix:stssync.server',
            'PATH' => '/bitrix/services/stssync/calendar/index.php',
            'SORT' => 100,
        ),
    5 =>
        array (
            'CONDITION' => '#^/personal/#',
            'RULE' => '',
            'ID' => 'bitrix:sale.personal.section',
            'PATH' => '/personal/index.php',
            'SORT' => 100,
        ),
    3 =>
        array (
            'CONDITION' => '#^/rest/#',
            'RULE' => '',
            'ID' => NULL,
            'PATH' => '/bitrix/services/rest/index.php',
            'SORT' => 100,
        ),
);
