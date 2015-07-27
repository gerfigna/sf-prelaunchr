sf-prelaunchr
========================

sf-prelaunchr is a Symfony2 adapted version of [harrystech/prelaunchr](https://github.com/harrystech/prelaunchr) originally written on Rails.

Read [How to Gather 100,000 E-mails in One Week](http://inbound.org/articles/view/how-to-gather-100-000-e-mails-in-one-week-includes-successful-templates-code-everything-you-need) for more information.


How to install
--------------

Edit the config file located at app/config/parameters.yml, and then

```
#!bash

# Install project dependences
php composer.phar install

# Create db structure
php app/console schema:update --force

# Create an admin user and promote it
php app/console fos:user:create admin
php app/console fos:user:promote admin ROLE_ADMIN

```


Customize it and endjoy !
