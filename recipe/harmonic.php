<?php

/**
 * Custom harmonic recipe
 */

namespace Deployer;

require_once __DIR__ . '/common.php';

set('default_stage', 'production');
set('ssh_multiplexing', true);
set('clear_paths', [ '.git', 'deploy.php', 'bitbucket-pipelines.yml' ]);
set('shared_files', ['.env']);

desc('Harmonic Tasks');
task('harmonic:php7.1-reload', function() {
    run("sudo service php7.1-fpm reload");
});

after('deploy:vendors', 'deploy:clear_paths');
after('cleanup', 'harmonic:php7.1-reload');