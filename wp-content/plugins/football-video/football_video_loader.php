<?php

class FootballVideoLoader extends MvcPluginLoader {

    var $db_version = '1.0';
    var $tables = array();

    function activate() {

        // This call needs to be made to activate this app within WP MVC

        $this->activate_app(__FILE__);

        // Perform any databases modifications related to plugin activation here, if necessary

        require_once ABSPATH.'wp-admin/includes/upgrade.php';

        add_option('football_video_db_version', $this->db_version);

        // Use dbDelta() to create the tables for the app here
        // $sql = '';
        // dbDelta($sql);
        global $wpdb;
        $sql = '
            CREATE TABLE '.$wpdb->prefix.'football_videos (
              id bigint(20) NOT NULL auto_increment,
              title varchar(255) NOT NULL,
              competition varchar(255) NULL,
              competitionUrl varchar(255) NULL,
              matchviewUrl varchar(255) NULL,
              thumbnail varchar(255) NULL,
              data_date datetime NULL,
              videos text NULL,
              PRIMARY KEY  (id)
            )';
        dbDelta($sql);

    }

    function deactivate() {

        // This call needs to be made to deactivate this app within WP MVC

        $this->deactivate_app(__FILE__);

        // Perform any databases modifications related to plugin deactivation here, if necessary

    }

}
