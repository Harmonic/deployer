<?php

/**
 * Custom Laravel Recipe
 * Adding queue restarting, npm install etc
 */

namespace Deployer;

require_once __DIR__ . '/laravel.php';
require_once __DIR__ . '/harmonic.php';

desc('Harmonic Tasks');
task('harmonic:setup', function () {
    echo 'Running Laravel project configuration (migrations, compilation etc)';

    run('cd {{release_path}} && npm install');

    $stage = null;
    if (input()->hasArgument('stage')) {
        $stage = input()->getArgument('stage');
    }
    if ('production' == $stage) {
        run('cd {{release_path}} && npm run production');
    } else {
        run('cd {{release_path}} && npm run dev');
    }

    echo 'Project successfully configured!';
});

desc('Harmonic Laravel Queues');
task('harmonic:laravel-queue-restart', function () {
    run('cd {{release_path}} && php artisan queue:restart');
});

// after('artisan:cache:clear', 'harmonic:setup');
