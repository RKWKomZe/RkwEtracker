<?php

return [
    'rkw_etracker:fetch' => [
        'class' => \RKW\RkwEtracker\Command\FetchCommand::class,
        'schedulable' => true,
    ],
    'rkw_etracker:send' => [
        'class' => \RKW\RkwEtracker\Command\SendCommand::class,
        'schedulable' => true,
    ]
];
