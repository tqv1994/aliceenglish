<?php

class ApiFootballLoader extends MvcPluginLoader {

    var $db_version = '1.0';
    var $tables = array();

    function activate() {

        // This call needs to be made to activate this app within WP MVC

        $this->activate_app(__FILE__);

        // Perform any databases modifications related to plugin activation here, if necessary

        require_once ABSPATH.'wp-admin/includes/upgrade.php';

        add_option('api_football_db_version', $this->db_version);

        global $wpdb;
        $sql = '
            CREATE TABLE '.$wpdb->prefix.'bets (
              id bigint(20) NOT NULL auto_increment,
              bet_id bigint(11),
              name varchar(255) NOT NULL,
              PRIMARY KEY  (id)
            )';
        dbDelta($sql);
        $sql = '
            CREATE TABLE '.$wpdb->prefix.'bookmakers (
              id bigint(20) NOT NULL auto_increment,
              bookmaker_id bigint(11),
              name varchar(255) NOT NULL,
              PRIMARY KEY  (id)
            )';
        dbDelta($sql);
        $sql = '
            CREATE TABLE '.$wpdb->prefix.'leagues (
              id bigint(11) NOT NULL auto_increment,
              league_id bigint(11),
              name varchar(255) NOT NULL,
              type varchar(128) NULL,
              logo varchar(255) NULL,
              data text NULL,
              PRIMARY KEY  (id)
            )';
        dbDelta($sql);
        $sql = '
            CREATE TABLE '.$wpdb->prefix.'fixtures (
              id bigint(20) NOT NULL auto_increment,
              fixture_id bigint(11),
              timezone varchar(128) NULL,
              date varchar(128) NULL,
              timestamp bigint(20) NULL,
              data text NULL,
              active int(11) NULL,
              PRIMARY KEY  (id)
            )';
        dbDelta($sql);
        $sql = '
            CREATE TABLE '.$wpdb->prefix.'seasons (
              id bigint(20) NOT NULL auto_increment,
              season_id int(11),
              year int(10) NULL,
              data text NULL,
              PRIMARY KEY  (id)
            )';
        dbDelta($sql);

        $sql = '
            CREATE TABLE '.$wpdb->prefix.'odds (
              id bigint(20) NOT NULL auto_increment,
              fixture_id int(11),
              data text NULL,
              PRIMARY KEY  (id)
            )';
        dbDelta($sql);
        try {
            $sql = 'ALTER TABLE ' . $wpdb->prefix . 'fixtures ADD `active` int(11) NULL;';
            dbDelta($sql);
        }catch (Exception $e){

        }

    }

    function deactivate() {

        // This call needs to be made to deactivate this app within WP MVC

        $this->deactivate_app(__FILE__);

        // Perform any databases modifications related to plugin deactivation here, if necessary

    }

}
