<?php

class Members {

    // The Table Fields
    public $id;
    public $first_name;
    public $last_name;

    //The database Connection
    private $conn;

    //The Constructor accepts an instance of the database Connection
    public function __construct($dbConn) {
        $this->conn = $dbConn;
    }

    //Get All Members
    public function read() {
        $stmt = //Prepare the statement
            $this->conn->prepare(
                'SELECT 
                    id,first_name,last_name 
                FROM 
                    note_keeper.members'
            )
        ;
        $stmt->execute();//Execute the Query

        // return $stmt;//Return the Data 

        if ($stmt->rowCount() > 0) {
            $membersArray = array();
            $membersArray['members'] = array();
            while($tuple = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($tuple);

                $memberItem = array('id' => $id, 'first_name' => $first_name, 'last_name' => $last_name);
                array_push($membersArray['members'], $memberItem);
            }

            return $membersArray;
        } else {
            return null;
        }
    }

    //Returns only one Member
    public function readById() {
        $stmt = //Prepate the Statement
            $this->conn->prepare(
                'SELECT 
                    id,first_name,last_name 
                FROM 
                    note_keeper.members 
                WHERE 
                    id = :id 
                LIMIT 
                    0, 1'
            )
        ;
        
        $stmt->bindParam(':id', $this->id);//Bind the Parameters
        $stmt->execute(); //Execute the statemet
        $tuple = $stmt->fetch(PDO::FETCH_ASSOC);//Fetch the record and store it as an Associative Array
        //Populate the Properties
        $this->id = $tuple['id'];
        $this->first_name = $tuple['first_name'];
        $this->last_name = $tuple['last_name'];
    }

    //Create a Member
    public function create() {
        $stmt = //Prepare the statement
            $this->conn->prepare(
                'INSERT INTO 
                    note_keeper.members
                SET 
                    first_name = ?,
                    last_name = ?'
            )
        ;

        //Clean the Data
        $this->first_name = htmlspecialchars(stripcslashes(strip_tags($this->first_name)));
        $this->last_name = htmlspecialchars(stripcslashes(strip_tags($this->last_name)));

        //Bind the Parameters
        $stmt->bindParam(1, $this->first_name);
        $stmt->bindParam(2, $this->last_name);

        if ($stmt->execute()) return true;

        printf("Error: %s.\n", $stmt->error);
        return false;
    }

    public function updateAll() {
        $stmt = 
            $this->conn->prepare(
                'UPDATE 
                    note_keeper.members
                SET
                    first_name = :first_name,
                    last_name = :last_name
                WHERE
                    id = :id'
            )
        ;

        //Clean the Data
        $this->first_name = htmlspecialchars(stripcslashes(strip_tags($this->first_name)));
        $this->last_name = htmlspecialchars(stripcslashes(strip_tags($this->last_name)));

        //Bind the Parameters
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':first_name', $this->first_name);
        $stmt->bindParam(':last_name', $this->last_name);

        if($stmt->execute()) return true;

        printf("Error: %s.\n", $stmt->error);
        return false;
    }
}