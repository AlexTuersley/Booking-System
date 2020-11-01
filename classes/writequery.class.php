<?php


    class WriteQuery
    {
        //Class Variables
        var $c_connection;
        var $c_query;
        var $c_database = DBNAME;
        var $c_results;
        var $c_insertid;

        //Set Connection
        function setconnection($connection)
        {
            $this->c_connection = $connection;
        }

        //Get Connection
        function getconnection()
        {
            return $this->c_connection;
        }

        //Set Query
        function setquery($query)
        {
            $this->c_query = $query;
        }

        //Get Query
        function getquery()
        {
            return $this->c_query;
        }
        function getinsertid()
        {
            return $this->c_insertid;
        }

        //Set Database
        function setdatabase($database)
        {
            $this->c_database = $database;
        }

        //Get Database
        function getdatabase()
        {
            return $this->c_database;
        }

        function __construct(){
          $argv = func_get_args();
          switch( func_num_args() ) {
              case 1:
                  print("This method of writing data is now deprecated.");
                  break;
              case 2:
                  self::PDOWriteQuery( $argv[0], $argv[1] );
                  break;
              case 3:
                  self::PDOWriteQuery( $argv[0], $argv[1], $argv[2] );
           }
        }

        //Write Query Constrcutor
        function SQLIWriteQuery($Query)
        {
            $this->c_connection = new Connection();
            $this->runquery($Query);

        }
        //Write Query with Parameters
        function PDOWriteQuery($Query,$Params,$Debug = false)
        {
            $this->c_connection = new PDOConnection();
            $this->runpdoquery($Query,$Params,$Debug);

        }

        //Run Query
        function runquery($query)
        {
            $this->c_query = $query;
            if($this->c_query){
                 $this->c_results=$this->c_connection->query($this->c_query);
                 $this->c_insertid = mysqli_insert_id($this->c_connection->getconnection());
            }
        }
        //Run Query with Parameters
        function runpdoquery($query,$Params,$debug)
        {
            $this->c_query = $query;
            if($this->c_query){
                 $this->c_results=$this->c_connection->query($this->c_query,$Params,$debug);
                 $this->c_insertid = $this->c_connection->getLastInsertId();
            }
        }

    }

?>
