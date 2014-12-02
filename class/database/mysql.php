<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/

if (!defined('RCX_ROOT_PATH'))  exit();

if ( !defined("SQL_LAYER") )
{
  define("SQL_LAYER", "mysql");

  include_once(RCX_ROOT_PATH."/class/database.php");
  /**
  * Description
  *
  * @param type $var description
  * @return type description
  */
  class Database extends AbsDatabase
  {
    var $db_connect;
    var $query_log;
    var $bg = 'bg1';
    var $query_result;
    var $num_queries = 0;
    var $row = array();
    var $rowset = array();
    var $cache = array();
    var $caching = false;
    var $cached = false;
    /**
    * connect to the database
    * 
    */
    function connect($server, $user, $pass, $persistent=0)
    {
      if ($persistent == 1)
      {
        $this->db_connect = @mysql_pconnect($server, $user, $pass);
      }
      else
      {
        $this->db_connect = @mysql_connect($server, $user, $pass);
      }

      return $this->db_connect;
    }
    /**
    * slect the database
    * 
    */
    function select_db($db)
    {
      return mysql_select_db($db, $this->db_connect);
    }
    /**
    * Close MySQL connection
    * 
    */
    function close()
    {
      if($this->query_result)
      {
        @mysql_free_result($this->query_result);  
      }

      return mysql_close($this->db_connect);
    }
    /**
    * perform a query on the MySQL database with debug info if set
    * also perform sql cache
    */
    function query($sql, $limit=0, $start=0, $cache = false)
    {
      // Remove any pre-existing queries
      unset($this->query_result);
      // Check cache
      $this->caching = false;
      $this->cache = array();
      $this->cached = false;
      if($sql !== '' && $cache)
      {
        $hash = md5($sql);
        if(strlen($cache))
        {
          $hash = $cache . $hash;
        }
        $filename = RCX_ROOT_PATH.'/cache/sql/sql_'.$hash.'.php';
        if(@file_exists($filename))
        {
          $set = array();
          include($filename);
          $this->cache = $set;
          $this->cached = true;
          $this->caching = false;
          return 'cache';
        }
        // missing cache file
//        echo 'cache is missing: ', $filename, '<br />';
        $this->caching = $hash;
      }
      // not cached
//      echo 'sql: ', htmlspecialchars($sql), '<br />';
      if (($this->debug & 8) || ($this->debug & 16))
      {
        $this->query_log[] = $sql;
      }
      else
      {
        $this->query_log[] = 0;
      }
      // deprecatory
      if (!empty($limit))
      {
        if (empty($start))
        {
          $start = 0;
        }
        $sql = $sql. " LIMIT ".intval($start).",".intval($limit)."";
      }

      if ($this->debug & 16)
      {
        $output = '';
        if (function_exists('xdebug_call_function'))
        {
          if (function_exists('xdebug_call_class'))
          {
            if ($caller_class = xdebug_call_class())
            {
              $output = "<b>".$caller_class." ::</b> ";
            }
          }
          $output .= "<b>".xdebug_call_function()."()</b><br />";
        }
        $output .= count($this->query_log).": ".$sql;

        $this->bg = ($this->bg == 'bg3') ? $this->bg = 'bg1' : $this->bg = 'bg3';
        echo "<div align='left' style='border-top:1px dashed #003030; padding: 3px;' class='".$this->bg."'>".$output."</div>";
      }

      if($sql != '')
      {
        $this->num_queries++;
        $this->query_result = @mysql_query($sql, $this->db_connect);
      }
      if($this->query_result)
      {
        unset($this->row[$this->query_result]);
        unset($this->rowset[$this->query_result]);
        return $this->query_result;
      }
      else
      {
        return false;
      }
    }
    /**
    * Depracted, use $db->query()
    * For backward compatibility only
    */
    function queryF($sql, $limit=0, $start=0, $cache = false)
    {
      $result = $this->query($sql, $limit, $start, $cache = false);
    
      return $result;
    }
    /**
    * generate an ID for a new row
    * 
    * This is for compatibility only. Will always return 0, because MySQL supports
    * autoincrement for primary keys.
    * 
    * @param string $sequence name of the sequence from which to get the next ID
    * @return int always 0, because mysql has support for autoincrement
    */
    function genId($sequence)
    {
      return 0;
    }
    /**
    * Get number of affected rows in previous MySQL operation
    *
    * @return Returns the number of affected rows on success, and -1 if the last query failed.
    */
    function affected_rows()
    {
      return @mysql_affected_rows($this->db_connect);
    }
    /**
    * Get number of rows in result
    * 
    * @param resource query result
    * @return The number of rows in a result set on success, or FALSE on failure.
    */
    function num_rows($resource)
    {
      if($resource === 'cache' && $this->cached)
      {
        return count($this->cache);
      }

      return @mysql_num_rows($resource);
    }
    /**
    * Get number of fields in result
    *
    * @param resource $result query result
    * @return Returns the number of fields in the result set resource on success,
    * or FALSE on failure.
    */
    function num_fields($resource)
    {
      return @mysql_num_fields($resource);
    }
    /**
    * Get the name of the specified field in a result
    *
    * @param resource $result query result
    * @param int numerical field index
    * @return The name of the specified field index on success, or FALSE on failure.
    */
    function field_name($resource, $index)
    {
      return @mysql_field_name($resource, $index);
    }
    /**
    * Get field type
    *
    * @param resource $result query result
    * @param int $offset numerical field index
    * @return The returned field type will be one of "int", "real", "string", "blob",
    * and others as detailed in the MySQL documentation.
    */
    function field_type($resource, $offset)
    {
      return @mysql_field_type($resource, $offset);
    }
    /**
    * Fetch a result row as an associative array
    *
    * @return Returns an array that corresponds to the fetched row,
    * or FALSE if there are no more rows.
    */
    function fetch_array($resource)
    {
      if($resource === 'cache' && $this->cached)
      {
        return count($this->cache) ? array_shift($this->cache) : false;
      }
      
      $this->row[$resource] = @mysql_fetch_array($resource);
      
      if($this->caching)
      {
        if($this->row[$resource] === false)
        {
          $this->write_cache();
        }
        $this->cache[] = $this->row[$resource];
      }
      return $this->row[$resource];
    }
    /**
    * Fetch a result row as an object
    *
    * @return Returns an object with properties that correspond to the fetched row,
    * or FALSE if there are no more rows.
    */
    function fetch_object($resource)
    {
      return @mysql_fetch_object($resource);
    }
    /**
    * Get a result row as an enumerated array
    * 
    * @param resource $resource
    * @return Returns an numerical array that corresponds to the fetched row,
    * or FALSE if there are no more rows.
    */
    function fetch_row($resource)
    {
      return @mysql_fetch_row($resource);
    }
    /**
    * Get the ID generated from the previous INSERT operation
    * 
    * @return The ID generated for an AUTO_INCREMENT column by the previous INSERT query
    * on success, 0 if the previous query does not generate an AUTO_INCREMENT value, or
    * FALSE if no MySQL connection was established.
    */
    function insert_id()
    {
      return @mysql_insert_id($this->db_connect);
    }
    /**
    * Returns the text of the error message from previous MySQL operation
    * 
    * @return bool Returns the error text from the last MySQL function,
    * or '' (the empty string) if no error occurred. 
    * @return int Returns the error number from the last MySQL function,
    * or 0 (zero) if no error occurred. 
    */
    function error()
    {
      if ($this->debug & 1)
      {
        return mysql_errno($this->db_connect) . ": " . mysql_error($this->db_connect);
      }
    }
    /**
    * Fetch a result row as an n-d associative array
    * 
    * @param resource $result
    * @return array set
    */
    function fetch_rowset($resource = 0)
    {
      if($resource === 'cache' && $this->cached)
      {
        return $this->cache;
      }
      while($this->rowset[$resource] = @mysql_fetch_array($resource))
      {
        if($this->caching)
        {
          if($this->row[$resource] === false)
          {
            $this->write_cache();
          }
          $this->cache[] = $this->row[$resource];
        }
        $result[] = $this->rowset[$resource];
      }
      if($this->caching)
      {
        $this->write_cache();
      }

      return $result;
    }
    /**
    * will free all memory associated with the result identifier result.
    * 
    * @param resource query result
    * @return bool TRUE on success or FALSE on failure. 
    */
    function free_result($resource = 0)
    {
      if($resource === 'cache')
      {
        $this->caching = false;
        $this->cached = false;
        $this->cache = array();
      }
      if($this->caching)
      {
        $this->write_cache();
      }
      if(!$resource)
      {
        $resource = $this->query_result;
      }
      if ($resource)
      {
        unset($this->row[$resource]);
        unset($this->rowset[$resource]);
        @mysql_free_result($resource);
        return true;
      }
      else
      {
        return false;
      }
    }
    /**
    * Fetch a result row as an associative array
    *
    * @return Returns an associative array that corresponds to the fetched row,
    * or FALSE if there are no more rows.
    */
    function fetch_assoc($resource = 0)
    {
      if($resource === 'cache' && $this->cached)
      {
        return count($this->cache) ? array_shift($this->cache) : false;
      }
      
      $this->row[$resource] = @mysql_fetch_assoc($resource);
      
      if($this->caching)
      {
        if($this->row[$resource] === false)
        {
          $this->write_cache();
        }
        $this->cache[] = $this->row[$resource];
      }
      return $this->row[$resource];
//      return @mysql_fetch_assoc($resource);
    }
    /**
    * Escapes special characters in a string for use in a SQL statement
    *
    * @return Returns the escaped string.
    */
    function escape($str)
    {
      if (@function_exists('mysql_real_escape_string'))
      {
        return @mysql_real_escape_string($str, $this->db_connect);
      }
      else
      {
        return @mysql_escape_string($str);
      }
    }
    /**
    * Get result data
    *
    * @return The contents of one cell from a MySQL result set on success,
    * or FALSE on failure.
    */
    function result($query_id = 0, $row = 0)
    {
      return @mysql_result($query_id, $row);
    }
    /**
    * Write sql cache to file
    *
    * @return
    */
    function write_cache()
    {
      if(!$this->caching)
      {
        return;
      }
      $f = fopen(RCX_ROOT_PATH.'/cache/sql/sql_'.$this->caching.'.php', 'w');
      $data = var_export($this->cache, true);
      @flock($f,LOCK_EX);
      @fputs($f, '<?php $set = ' . $data . '; ?>');
      @flock($f,LOCK_UN);
      @fclose($f);
      @chmod(RCX_ROOT_PATH.'/cache/sql/sql_'.$this->caching.'.php', 0777);
      $this->caching = false;
      $this->cached = false;
      $this->cache = array();
    }
    /**
    * Clear cache files
    *
    * @return
    */
    function clear_cache($prefix = '')
    {
      $this->caching = false;
      $this->cached = false;
      $this->cache = array();
      $prefix = 'sql_' . $prefix;
      $prefix_len = strlen($prefix);
      $res = opendir(RCX_ROOT_PATH.'/cache/sql');
      if($res)
      {
        while(($file = readdir($res)) !== false)
        {
          if(substr($file, 0, $prefix_len) === $prefix)
          {
            @unlink(RCX_ROOT_PATH.'/cache/sql/'.$file);
          }
        }
      }
      @closedir($res);
    }
  } // END CLASS
} // END DEFINE
?>