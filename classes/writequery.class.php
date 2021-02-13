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

        //Gets the id of a new row after a query is ran
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

        //checks the number of arguments in passed to the query
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

        /**
         * Function to create a Connection and run an SQL Query
         * @param string $Query - string SQL query
         */
        function SQLIWriteQuery($Query)
        {
            $this->c_connection = new Connection();
            $this->runquery($Query);

        }

        /**
         * Function to create a Connection and run a PDO SQL Query
         * @param string $Query - string SQL query
         * @param array $Params - Array of parameters used 
         */
        function PDOWriteQuery($Query,$Params,$Debug = false)
        {
            $this->c_connection = new PDOConnection();
            $this->runpdoquery($Query,$Params,$Debug);

        }

        /**
         * Run the query and store the results and number of results in variables
         * @param string $query - string SQL query
         */
        function runquery($query)
        {
            $this->c_query = $query;
            if($this->c_query){
                 $this->c_results=$this->c_connection->query($this->c_query);
                 $this->c_insertid = mysqli_insert_id($this->c_connection->getconnection());
            }
        }

        
        /**
         * Run the query and store the results and number of results in variables
         * @param string $query - string PDO SQL query
         * @param array $params - Array of parameters used
         */
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
