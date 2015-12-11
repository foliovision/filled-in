<?php

  include 'wp-load.php';

  $limit = 1000;
  $deleted = $limit;

  while( $deleted == $limit ){
    $deleted = $wpdb->query(  "DELETE FROM {$wpdb->prefix}filled_in_useragents 
                              WHERE id NOT IN ( SELECT user_agent FROM {$wpdb->prefix}filled_in_data WHERE 1)
                              LIMIT $limit" );
    sleep(5);
  }
  
  $wpdb->query( "OPTIMIZE TABLE {$wpdb->prefix}filled_in_useragents" );

  die("done");

?>