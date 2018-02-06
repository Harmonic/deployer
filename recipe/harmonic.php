<?php

/**
 * Custom harmonic recipe
 */

namespace Deployer;

require_once __DIR__ . '/common.php';

set('default_stage', 'production');
set('ssh_multiplexing', true);
set('clear_paths', ['.git', 'deploy.php', 'bitbucket-pipelines.yml']);
set('shared_files', ['.env']);
set('keep_releases', 3);

desc('Reload PHP');
task('harmonic:php7.1-reload', function () {
    run("sudo service php7.1-fpm reload");
});

desc('Harmonic Tasks');
task('harmonic:setup', function () {
    echo "Running project configuration (node, compilation etc)";
    run("cd {{release_path}} && npm install");

    echo "Project successfully configured!";
});

desc('Run Gulp (if requested)');
task('harmonic:gulp', function () {
    $gulp = get('gulp', false);
    if ($gulp) {
        run("cd {{release_path}} && node_modules/gulp/bin/gulp.js build");
        $stage = null;
        if (input()->hasArgument('stage')) {
            $stage = input()->getArgument('stage');
        }

        if ('production' == $stage) {
            run("cd {{release_path}} && node_modules/gulp/bin/gulp.js --production");
        } elseif ($gulp) {
            run("cd {{release_path}} && node_modules/gulp/bin/gulp.js");
        }
    }
});

after('deploy:symlink', 'harmonic:setup');
after('harmonic:setup', 'harmonic:gulp');
after('deploy:vendors', 'deploy:clear_paths');
after('cleanup', 'harmonic:php7.1-reload');
after('deploy:failed', 'deploy:unlock');