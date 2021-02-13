<?php

    class ReadQuery
    {
        //Class Variables
        var $c_connection;
        var $c_query;
        var $c_database = DBNAME;
        var $c_results;
        var $c_number_of_results;

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

        //Get Results
        function getresults()
        {
            return $this->c_results;
        }

        //Get Number Of Results
        function getnumberofresults()
        {
            return $this->c_number_of_results;
        }

        //checks the number of arguments in passed to the query
        function __construct(){
          $argv = func_get_args();
          switch( func_num_args() ) {
              case 1:
                  print("This method of reading data is now deprecated.");
                  break;
              case 2:
                  self::PDOReadQuery( $argv[0], $argv[1] );
                  break;
              case 3:
                  self::PDOReadQuery( $argv[0], $argv[1], $argv[2] );
           }
        }

        /**
         * Function to create a Connection and run an SQL Query
         * @param string $Query - string SQL query
         */
        function SQLIReadQuery($Query)
        {
            $this->c_connection = new Connection();
            $this->runquery($Query);
        }

         /**
         * Function to create a Connection and run a PDO SQL Query
         * @param string $Query - string SQL query
         * @param array $Params - Array of parameters used 
         */
        function PDOReadQuery($Query,$Params)
        {
            $this->c_connection = new PDOConnection();
            $this->runpdoquery($Query,$Params);
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
                $this->c_number_of_results=$this->c_results->num_rows;
            }
        }

        /**
         * Run the query and store the results and number of results in variables
         * @param string $query - string PDO SQL query
         * @param array $params - Array of parameters used
         */
        function runpdoquery($query,$params)
        {
            $this->c_query = $query;
            if($this->c_query){
                $this->c_results=$this->c_connection->query($this->c_query,$params);

                $this->c_number_of_results=$this->c_results->rowCount();

            }
        }

    }
?>