# Webhook Commander

Under development ! :)

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/cf491f0c33a541f294be1ba2f02b6128)](https://www.codacy.com/app/GBProd/webhook-commander?utm_source=github.com&utm_medium=referral&utm_content=gbprod/webhook-commander&utm_campaign=badger)
[![Build Status](https://travis-ci.org/gbprod/webhook-commander.svg?branch=master)](https://travis-ci.org/gbprod/webhook-commander)
[![codecov](https://codecov.io/gh/gbprod/webhook-commander/branch/master/graph/badge.svg)](https://codecov.io/gh/gbprod/webhook-commander)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/gbprod/webhook-commander/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/gbprod/webhook-commander/?branch=master)
[![Dependency Status](https://www.versioneye.com/user/projects/574a9caace8d0e004130d3aa/badge.svg)](https://www.versioneye.com/user/projects/574a9caace8d0e004130d3aa)

This application allows to launch commands triggered by github webhooks.
I use it for continous delivery.

## Installation

```bash
git clone git@github.com:gbprod/webhook-commander.git
cd webhook-commander
make deploy
```

This will ask you a secret, generate a random one (with http://www.sha1.fr/ for example).

Setup an web access to this application (`web/app.php`).
Example using Apache2 virtualhost:

```xml
<VirtualHost *:80>
        ServerName webhook.my-url.com
        DocumentRoot /var/www/html/webhook-commander/web
        <Directory /var/www/html/webhook-commander/web>
                AllowOverride All
                Order allow,deny
                Allow from all
                <IfModule mod_rewrite.c>
                        Options -MultiViews
                        RewriteEngine On
                        RewriteCond %{REQUEST_FILENAME} !-f
                        RewriteRule ^(.*)$ app.php [QSA,L]
                </IfModule>
        </Directory>
</VirtualHost>

```

Create a webhook for your Github project.
Go to your project settings -> Webhooks and services -> Add webhook

Fill the form with something like:

 * Payload URL: http://webhook.my-url.com/webhook/callback
 * Content type: application/json
 * Secret: The secret you've entered during deploy
 * Select: Just the push event
 * Check Active

Configure your triggers in `app/config/parameter.yml`:

```yaml
parameters:
    secret: YourSecretWithGithub
    triggers:
        app1:                          # Just a reminder name
            repository: foo/bar        # The repository (only webhooks triggered by this repository will run command)
            branch: master             # The branch (only webhooks triggered by this branch will run command)
            path: /var/www/html/my_app # Path where the command should be executed
            command: make deploy       # The command to run
        app2:
            repository: gbprod/cowboys
            branch: master
            path: /var/www/html/cowboys
            command: git pull && make deploy
```

## Requirements

 * PHP 5.5+

## Licence

This package is under [MIT Licence](LICENCE).
Feel free to contribute !