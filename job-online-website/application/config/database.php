<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| DATABASE CONNECTIVITY SETTINGS
| -------------------------------------------------------------------
| This file will contain the settings needed to access your database.
|
| For complete instructions please consult the "Database Connection"
| page of the User Guide.
|
| -------------------------------------------------------------------
| EXPLANATION OF VARIABLES
| -------------------------------------------------------------------
|
|	['hostname'] The hostname of your database server.
|	['username'] The username used to connect to the database
|	['password'] The password used to connect to the database
|	['database'] The name of the database you want to connect to
|	['dbdriver'] The database type. ie: mysql.  Currently supported:
				 mysql, mysqli, postgre, odbc, mssql, sqlite, oci8
|	['dbprefix'] You can add an optional prefix, which will be added
|				 to the table name when using the  Active Record class
|	['pconnect'] TRUE/FALSE - Whether to use a persistent connection
|	['db_debug'] TRUE/FALSE - Whether database errors should be displayed.
|	['cache_on'] TRUE/FALSE - Enables/disables query caching
|	['cachedir'] The path to the folder where cache files should be stored
|	['char_set'] The character set used in communicating with the database
|	['dbcollat'] The character collation used in communicating with the database
|
| The $active_group variable lets you choose which connection group to
| make active.  By default there is only one group (the "default" group).
|
| The $active_record variables lets you determine whether or not to load
| the active record class
*/

$active_group = "windows";
$active_record = TRUE;

/*
 * Local windows
 */
$db['windows']['hostname'] = "localhost";
$db['windows']['username'] = "root";
$db['windows']['password'] = "";
$db['windows']['database'] = "hoangnhan2db";
$db['windows']['dbdriver'] = "mysql";
$db['windows']['dbprefix'] = "";
$db['windows']['pconnect'] = TRUE;
$db['windows']['db_debug'] = TRUE;
$db['windows']['cache_on'] = FALSE;
$db['windows']['cachedir'] = "application/ci_db_cache";
$db['windows']['char_set'] = "utf8";
$db['windows']['dbcollat'] = "utf8_general_ci";


/*
 * Local test database windows
 */
$db['test_database']['hostname'] = "localhost";
$db['test_database']['username'] = "root";
$db['test_database']['password'] = "";
$db['test_database']['database'] = "job_management2";
$db['test_database']['dbdriver'] = "mysql";
$db['test_database']['dbprefix'] = "";
$db['test_database']['pconnect'] = TRUE;
$db['test_database']['db_debug'] = TRUE;
$db['test_database']['cache_on'] = FALSE;
$db['test_database']['cachedir'] = "application/ci_db_cache";
$db['test_database']['char_set'] = "utf8";
$db['test_database']['dbcollat'] = "utf8_general_ci";


/*
 * Summer hosting
 */
$db['summer_host']['hostname'] = "sql107.byetcluster.com";
$db['summer_host']['username'] = "sum_1403815";
$db['summer_host']['password'] = "bandethuong";
$db['summer_host']['database'] = "sum_1403815_job_management";
$db['summer_host']['dbdriver'] = "mysql";
$db['summer_host']['dbprefix'] = "";
$db['summer_host']['pconnect'] = TRUE;
$db['summer_host']['db_debug'] = TRUE;
$db['summer_host']['cache_on'] = FALSE;
$db['summer_host']['cachedir'] = "application/ci_db_cache";
$db['summer_host']['char_set'] = "utf8";
$db['summer_host']['dbcollat'] = "utf8_general_ci";


/*
 * Local Linux
 */
$db['ubuntu']['hostname'] = "localhost";
$db['ubuntu']['username'] = "root";
$db['ubuntu']['password'] = "";
$db['ubuntu']['database'] = "job_management";
$db['ubuntu']['dbdriver'] = "mysql";
$db['ubuntu']['dbprefix'] = "";
$db['ubuntu']['pconnect'] = TRUE;
$db['ubuntu']['db_debug'] = TRUE;
$db['ubuntu']['cache_on'] = FALSE;
$db['ubuntu']['cachedir'] = "application/ci_db_cache";
$db['ubuntu']['char_set'] = "utf8";
$db['ubuntu']['dbcollat'] = "utf8_general_ci";


/* End of file database.php */
/* Location: ./system/application/config/database.php */