<?php

/**
 * Custom Wordpress Recipe
 * Adding composer and npm install
 */

namespace Deployer;

require_once __DIR__ . '/wordpress.php';
require_once __DIR__ . '/harmonic.php';

set('shared_files', ['wp-config.php', '.env']);

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
    'harmonic:gulp',
    'deploy:unlock',
    'cleanup'
])->desc('Deploy your project');

after('deploy', 'success');