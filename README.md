# XWC Symfony Sandbox
## What is XWC Symfony?

It is an open source CMS built on Symfony2 framework with use of the Twig 
templating engine as well as the Doctrine ORM. The project is an initiative 
of Tangent Labs Ltd.


## Requirements

Symfony is only supported on PHP 5.3.2 and up. To check the compatibility of
your environment with Symfony, you can run the `web/check.php` script, bundled
with this sandbox.


## Installation instructions

1. [Fork the project on github](http://help.github.com/forking/)
2. Set permissions

		chmod 777 app/cache -R
		chmod 777 app/logs -R
3. Set dbal connection and orm in app/config/config.yml

		doctrine.dbal:
      host:     localhost
      dbname:   xwc_sandbox
      user:     root
      password: root
    doctrine.orm: ~
4. create database

    php app/console doctrine:database:create
5. create table on database

    php app/console doctrine:schema:create
6. load fixtures via sql  
		  
        INSERT INTO Tag ( name , parent_name , tag_order) VALUES
        ('html', NULL , '0'),
			  ('html_attributes', 'html', 0),
			  ('html_body', 'html', 20),
			  ('html_body_footer', 'html_body', 100),
			  ('html_body_header', 'html_body', 25),
			  ('html_head', 'html', 10),
			  ('html_head_link', 'html_head', 12),
			  ('html_head_meta', 'html_head', 11),
			  ('html_head_script', 'html_head', 13),
			  ('html_head_title', 'html_head', 12);

7. go to "http://WEBSERVER/xwc_sandbox/web/app_dev.php/show/PAGE°NAME"

## Recommendation on YML / PHP / XML configuration

* We use YML for configuration
* We use twig for templating

