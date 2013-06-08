<?php

/*
Plugin Name: Squeeze Framework
Plugin URI: http://github.com/jdpedrie/squeeze
Description: A collection of libraries and a hopefully decent development framework to make the a hard job (writing decent code for WordPress) a little less painful.
Version: 1.0
Author: John Dennis Pedrie
Author URI: http://johnpedrie.com
License: TBD
*/

function squeeze_init() {

  $adminUsers = new SQAPP_Admin_Users();
  $adminOptions = new SQAPP_Admin_Options();

  // Create Menu
  $testMenu = new SQ_Menu();
  $testMenu->setPageTitle('Test Menu');
  $testMenu->setMenuTitle('Test Menu');
  $testMenu->setMenuCapability('manage_options');
  $testMenu->setSlug('SQ_menu');
  $testMenu->setFunction(array($adminOptions, 'options_page')); // Assign a callback that's set in our application
  $testMenu->execute();

  // A sub-menu
  $testSubMenu = new SQ_Menu();
  $testSubMenu->setMenuParent('SQ_menu');
  $testSubMenu->setPageTitle('Sub Menu');
  $testSubMenu->setMenuTitle('Sub Menu');
  $testSubMenu->setMenuCapability('manage_options');
  $testSubMenu->setSlug('SQ_sub_menu');
  $testSubMenu->setFunction(array($adminOptions, 'settings_page')); // Again, assign a callback from the application file.
  $testSubMenu->execute();

  // Display Custom Profile Fields
  add_action( 'show_user_profile', array($adminUsers, 'addUserFields') );
  add_action( 'edit_user_profile', array($adminUsers, 'addUserFields') );

  // Save Custom Profile Fields
  add_action( 'personal_options_update', array($adminUsers, 'saveUserFields') );
  add_action( 'edit_user_profile_update', array($adminUsers, 'saveUserFields') );

  // Add Columns to Users Table
  add_filter( 'manage_users_columns', array($adminUsers, 'showUserFieldsColumnNames') );
  add_filter( 'manage_users_custom_column', array($adminUsers, 'showUserFieldsColumnValues'), 10, 3 );
}

include "lib/core/squeeze.php";