<?php

class Members {

    // The Table Fields
    private $id;
    private $first_name;
    private $last_name;

    //The database Connection
    private $conn;

    //The Constructor accepts an instance of the database Connection
    public function __construct($dbConn) {
        $this->conn = $dbConn;
    }

    //Get All Members
    public function read() {
        $sqlQuery = 'SELECT
                        id,
                        first_name,
                        last_name
                    FROM 
                        members'; //Request the data from the table

        //Prepare the statement
        $stmt = $this->conn->prepare($sqlQuery);

        //Execute the Query
        $stmt->execute();

        //Return the Data 
        return $stmt;
    }
}