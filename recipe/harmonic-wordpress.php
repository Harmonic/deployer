<?php

/**
 * Custom Wordpress Recipe
 * Adding composer and npm install
 */

namespace Deployer;

//require_once __DIR__ . '/wordpress.php';
require_once __DIR__ . '/harmonic.php';

set('shared_files', ['.env', 'web/wp-config.php']);
set('shared_dirs', ['wp-content/uploads']);
set('writable_dirs', ['wp-content/uploads']);

task('deploy', [
    'deploy:info',
    'deploy:prepare',
    'deploy:lock',
    'deploy:release',
    'deploy:update_code',
    'deploy:shared',
    'deploy:vendors',
    'deploy:writable',
    'deploy:clear_paths',
    'deploy:symlink',
    'harmonic:setup',
    'harmonic:gulp',
    'deploy:unlock',
    'cleanup'
])->desc('Deploy your project');

desc('Harmonic Remove Old Themes');
task('harmonic:remove-wp-themes', function () {
    run("cd {{release_path}} && wp --path='web' theme delete twentysixteen twentyseventeen twentyfifteen");
});

after('harmonic:setup', 'harmonic:remove-wp-themes');
after('deploy', 'success');