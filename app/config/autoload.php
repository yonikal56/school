<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// $autoload['packages'] = array(APPPATH.'third_party', '/usr/local/shared');
$autoload['packages'] = array();

// $autoload['libraries'] = array('user_agent' => 'ua');
$autoload['libraries'] = array('database', 'email', 'session', 'parser', 'form_validation', 'pagination', 'galleriesparser');

// $autoload['drivers'] = array('cache');
$autoload['drivers'] = array();

// $autoload['helper'] = array('url', 'file');
$autoload['helper'] = array('url', 'file', 'debugging', 'password', 'form', 'gallery');

// $autoload['config'] = array('config1', 'config2');
$autoload['config'] = array();

// $autoload['language'] = array('lang1', 'lang2');
$autoload['language'] = array();

// $autoload['model'] = array('first_model' => 'first');
$autoload['model'] = array('site_model');