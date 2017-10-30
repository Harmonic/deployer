<?php

/**
 * Custom Wordpress Recipe
 * Adding composer and npm install
 */

namespace Deployer;

require_once __DIR__ . '/wordpress.php';
require_once __DIR__ . '/harmonic.php';

desc('Harmonic Tasks');
task('harmonic:setup', function() {
    echo "Running project configuration (node, gulp, compilation etc)";
    run("cd {{release_path}} && npm install");
    run("cd {{release_path}} && node_modules/gulp/bin/gulp.js build");
    
    $stage = null;
    if (input()->hasArgument('stage')) {
        $stage = input()->getArgument('stage');
    }
    if ('production' == $stage) {
        run("cd @{{release_path}} && node_modules/gulp/bin/gulp.js --production");
    } else {
        run("cd @{{release_path}} && node_modules/gulp/bin/gulp.js");
    }

    echo "Project successfully configured!";
});

task('deploy', [
    'deploy:prepare',
    'deploy:lock',
    'deploy:release',
    'deploy:update_code',
    'deploy:shared',
    'deploy:writable',
    'deploy:vendors',
    'deploy:clear_paths',
    'deploy:symlink',
    'harmonic:setup',
    'deploy:unlock',
    'cleanup'
])->desc('Deploy your project');

after('deploy', 'success');