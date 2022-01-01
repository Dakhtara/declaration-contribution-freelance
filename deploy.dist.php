<?php

namespace Deployer;

require 'recipe/symfony4.php';
//require 'contrib/discord.php';

// Project name
set('application', 'declaration-contribution-freelance');

set('keep_releases', 2);
// Project repository
set('repository', 'git@github.com:Dakhtara/declaration-contribution-freelance.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', false);
set('ssh_multiplexing', true);
set('default_timeout', 600);
// Shared files/dirs between deploys
add('shared_files', ['.env']);
add('shared_dirs', ['var/log', 'var/sessions']);

// Writable dirs by web server
add('writable_dirs', []);
// Hosts
host('host.com')
    ->user('my_custom_user')
    ->identityFile('path_to_identity_file')
    ->forwardAgent(true)
    ->multiplexing(true)
    ->set('deploy_path', '/path_to_deploy/{{application}}');

// Tasks
set('env', function () {
    return [
        'APP_ENV' => 'prod',
        'APP_DEBUG' => 0,
    ];
});

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

// Migrate database before symlink new release.
//before('deploy:symlink', 'database:migrate');
