<?php
    if($_SERVER['SERVER_NAME'] == 'localhost')
    {
        $dbname     = 'hugo-mvp';        
        $host       = 'localhost';
        $dbuser     = 'root';
        $dbPassword = '';
    } else {
        $dbname     = 'hugomvp';        
        $host       = '166.62.8.9';
        $dbuser     = 'hugomvp';
        $dbPassword = 'Hugo@MVP!1';
    }
    
    define('DBNAME', $dbname);
    define('HOST', $host);
    define('DBUSER', $dbuser);
    define('DBPASSWORD', $dbPassword);
?>