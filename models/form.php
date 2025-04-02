<?php

include (dirname (__FILE__).'/extension_factory.php');
include (dirname (__FILE__).'/data.php');
include (dirname (__FILE__).'/file_upload.php');

class FI_Form
{
   var $id            = null;
   var $name          = null;
   var $quickview     = null;
   var $options       = null;
   var $type          = null;

   var $extensions    = null;
   var $sources       = null;
   var $errors        = null;

   public static $aForms = array();

   function __construct ($values)
   {
      foreach ($values AS $key => $value)
          $this->$key = $value;

      if ($this->options != '')
         $this->options = unserialize ($this->options);
      $this->extensions = FI_Extension::load_by_form ($this->id);
      $this->errors     = new FI_Errors;
   }

   public static function load_all (&$pager, $type = 'form')
   {
      assert (is_a ($pager, 'FI_Pager'));
      global $wpdb;

      $forms = array ();

      $results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}filled_in_forms WHERE type= %s " . $pager->to_limits(), $type ), ARRAY_A);
      if (count ($results) > 0)
      {
         foreach ($results AS $result)
            $forms[] = new FI_Form ($result);
      }

      $pager->set_total ($wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM {$wpdb->prefix}filled_in_forms WHERE type = %s", $type ) ));
      return $forms;
   }

   public static function load_by_id ($id)
   {
      $id = intval( $id );
      if( isset( self::$aForms[$id] ) )
         return self::$aForms[$id];

      global $wpdb;

      $form = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}filled_in_forms WHERE id = %d", $id ), ARRAY_A);
      if( $form ){
         self::$aForms[$id] = new FI_Form ($form);
         return self::$aForms[$id];
      }

      return false;
   }

   public static function load_by_name ($name, $type='form')
   {
      global $wpdb;
      $form = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}filled_in_forms WHERE name = %s AND type = %s", $name, $type ), ARRAY_A);
      if ($form)
         return new FI_Form ($form);
      return false;
   }

   public static function create ($name, $type = 'form')
   {
      if (strlen ($name) > 0)
      {
         global $wpdb;
         
         $name = FI_Form::sanitize_name ($name);
         
         // First check if form already exists
         if ($wpdb->get_var( $wpdb->prepare( "SELECT count(id) FROM {$wpdb->prefix}filled_in_forms WHERE name = %s AND type = %s", $name, $type ) ) == 0)
         {
            $wpdb->query($wpdb->prepare( "INSERT INTO {$wpdb->prefix}filled_in_forms (name,type) VALUES (%s, %s)", $name, $type ) );
            return true;
         }
         
         if ($type == 'form')
            return __ ("A form of that name already exists", 'filled-in');
         else
            return __ ("A report of that name already exists", 'filled-in');
      }
      
      if ($type == 'form')
         return __ ("Invalid form name", 'filled-in');
      else
         return __ ("Invalid report name", 'filled-in');
   }

   function delete ()
   {
      global $wpdb;
      
      if ($wpdb->query ( $wpdb->prepare( "DELETE FROM {$wpdb->prefix}filled_in_forms WHERE id = %d" ), $this->id ) !== false)
         return true;
      return __ ("Failed to delete form", 'filled-in');
   }

   function update_options( $customsubmit, $customid, $strSubmitAnchor ){
      global $wpdb;

      $this->options['custom_submit'] = $customsubmit;
      $this->options['custom_id'] = $customid;
      $this->options['submit-anchor'] = $strSubmitAnchor;

      $wpdb->query( $wpdb->prepare( "UPDATE {$wpdb->prefix}filled_in_forms SET options = %s WHERE id = %d", serialize( $this->options ), $this->id ) );

      return true;
   }

   function update_details ($newname, $quick, $special)
   {
      assert (is_string ($newname));
      assert (is_string ($quick));

      global $wpdb;

      $type = $this->type;

      $name = FI_Form::sanitize_name ($newname);
      if (strlen ($name) > 0)
      {
         // First check if name is a duplicate
         if ($this->name == $name || $wpdb->get_var($wpdb->prepare( "SELECT count(id) FROM {$wpdb->prefix}filled_in_forms WHERE name= %s AND type = %s", $name, $type ) ) == 0)
         {
            $this->quickview = trim (preg_replace ('/[^A-Za-z0-9,\-_\[\]]/', '', $quick));
            $this->options['ajax']   = $special == 'ajax' ? 'true' : 'false';
            $this->options['upload'] = $special == 'upload' ? 'true' : 'false';

            $this->name = $name;
            $sql = $wpdb->prepare( "UPDATE {$wpdb->prefix}filled_in_forms SET name = %s, quickview = %s, options = %s WHERE id= %d", $name, $this->quickview, serialize( $this->options ), $this->id );
            if ($wpdb->query ($sql) !== false)
               return true;

            return sprintf (__ ("Failed to update %s %s", 'filled-in'), $type, $this->name);
         }

         return sprintf (__ ("A %s of that name already exists", 'filled-in'), $type);
      }

      return sprintf (__ ("Invalid %s name", 'filled-in'), $type);
   }

   public static function sanitize_name ($name)
   {
      // Sanitize the form name
      $name = trim ($name);
      $name = preg_replace ('/[^0-9a-zA-Z_\-:\.]/', '_', $name);
      
      // Reduce underscores
      $name = preg_replace ('/_+/', '_', $name);
      $name = trim ($name, '_');
      
      // First character must be alphabetic
      $name = preg_replace ('/^([0-9]*)(.*)/', '$2', $name);
      return $name;
   }

   function submit ($data_sources)
   {
      $this->sources = $data_sources;
      if ($this->sources->create ($this->id))
      {
         // Run pre
         $first = $this->run_stage (isset($this->extensions['pre']) ? $this->extensions['pre'] : array(), 'pre');

         // Pre filter
         $save = $this->sources->save (isset($this->extensions['filter']) ? $this->extensions['filter'] : array() );

         // Filter and post
         if ($first && $this->run_stage (isset($this->extensions['filter']) ? $this->extensions['filter'] : array(), 'filter'))
            $this->run_stage (isset($this->extensions['post']) ? $this->extensions['post'] : array() , 'post');

         return $save;
      }

      return false;
   }

   function run_stage ($extensions, $group)
   {
      if ( is_array($extensions) && count($extensions) > 0)
      {
         $errors = false;
         foreach ($extensions AS $pos => $extension)
         {
            if (($result = $extensions[$pos]->run ($this->sources)) !== true)
            {
               if( 'post' == $group ){
                  $aData = array();
                  $aData['date'] = date( 'Y-m-d H:i:s' );
                  $aData['result'] = $result;
                  $aData['form'] = $extension->form_id;
                  $aData['type'] = $extension->type;
                  $aData['config'] = $extension->config;

                  update_option( 'filled_in_recent_error_data', $aData );
                  update_option( 'filled_in_recent_error', 'yes' );
                  continue;
               }

               $errors = true;
               if ($group != 'filter')
                  break;           // We stop on first non-filter error
            }
         }

         if ($errors)
         {
            $this->errors->gather ($extensions);
            $this->errors->save ($this->id, $this->sources->id);
            return false;
         }
      }
      return true;
   }
}

?>