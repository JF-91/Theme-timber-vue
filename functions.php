<?php


namespace App;

use Timber\Timber;

// Load Composer dependencies.
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/src/StarterSite.php';

Timber::init();

new StarterSite();