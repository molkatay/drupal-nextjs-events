# Events app using Drupal 10, Next JS, TailwindCss

# Docker Compose configuration to run PHP 8.2 with Nginx, PHP-FPM, PostgreSQL 15 and varnish.

Overview
This Docker Compose configuration lets you run easily PHP 8.2 with Nginx, PHP-FPM, PostgreSQL 15 and varnsih. It exposes 4 services:

- web (Nginx)
- php (PHP 8.2 with PHP-FPM)
- db (PostgreSQL 15)
- Varnish

The PHP image comes with the most commonly used extensions and is configured with xdebug. 
The UUID extension for PostgreSQL has been added. 
Nginx default configuration is set up for Drupal 10.

# Install prerequisites
For now the project has been tested on Linux only but should run fine on Docker for Windows and Docker for Mac.

You will need:

- Docker CE
- Docker Compose
- Git (optional)

