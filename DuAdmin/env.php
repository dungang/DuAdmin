<?php
/**
 * Setup application environment
 */
$root = dirname(__DIR__);
require $root . '/vendor/autoload.php';
use Dotenv\Dotenv;
$dotenv = Dotenv::createUnsafeImmutable($root);
$dotenv->load();
defined('YII_DEBUG') or define('YII_DEBUG', getenv('YII_DEBUG') === 'true');
defined('YII_ENV') or define('YII_ENV', getenv('YII_ENV') ?: 'prod');