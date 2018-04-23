<?php

/**
 * Custom Wordpress Recipe
 * Adding composer and npm install
 */

namespace Deployer;

//require_once __DIR__ . '/wordpress.php';
require_once __DIR__ . '/harmonic.php';

set('shared_files', ['.env']);
set('shared_dirs', ['web/wp-content/uploads']);
set('writable_dirs', ['web/wp-content/uploads']);

task('deploy', [
    'deploy:info',
    'deploy:prepare',
    'deploy:lock',
    'deploy:release',
    'deploy:update_code',
    'deploy:shared',
    'deploy:writable',
    'deploy:vendors',
    'deploy:symlink',
    'deploy:unlock',
    'cleanup'
])->desc('Deploy your project');

after('deploy', 'success');
