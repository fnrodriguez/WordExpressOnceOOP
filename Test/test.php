<?php
/**
 * Created by PhpStorm.
 * User: frank
 * Date: 2/24/2018
 * Time: 9:26 AM
 */
require_once __DIR__ . '/../vendor/autoload.php';
use OnceOOP\WP_ONCE;



echo WP_ONCE::wp_nonce_field();
echo WP_ONCE::wp_nonce_url();
WP_ONCE::wp_nonce_ays();

