<?php

return [
    '~^articles/(\d+)$~' => [\App\Controllers\ArticlesController::class, 'show'],
    '~^hello/(.*)$~' => [\App\Controllers\MainController::class, 'sayHello'],
    '~^bye/(.*)$~' => [\App\Controllers\MainController::class, 'sayBye'],
    '~^$~' => [\App\Controllers\MainController::class, 'main'],
];
