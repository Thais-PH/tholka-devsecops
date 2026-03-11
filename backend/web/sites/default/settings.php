<?php

/**
 * Configuration de la base de données via les variables d'environnement Docker
 */
$databases['default']['default'] = [
  'database' => getenv('MYSQL_DATABASE'),
  'username' => getenv('MYSQL_USER'),
  'password' => getenv('MYSQL_PASSWORD'),
  'prefix' => '',
  'host' => 'db', // "db" car c'est le nom de ton service dans docker-compose.yml
  'port' => '3306',
  'namespace' => 'Drupal\\mysql\\Driver\\Database\\mysql',
  'driver' => 'mysql',
  'autoload' => 'core/modules/mysql/src/Driver/Database/mysql/',
];

/**
 * Sel de hachage (Hash Salt) pour la sécurité
 */
$settings['hash_salt'] = 'Mets_Ici_Une_Suite_De_Lettres_Et_Chiffres_Au_Hasard_12345';

/**
 * Autoriser Nuxt à communiquer avec Drupal (CORS)
 */
$settings['cors_allowed_origins'] = ['*'];

/**
 * Chargement des services
 */
$settings['container_yamls'][] = $app_root . '/' . $site_path . '/services.yml';

/**
 * Configuration des répertoires de config (requis par Drupal 9/10+)
 */
$settings['config_sync_directory'] = 'sites/default/files/config_sync';