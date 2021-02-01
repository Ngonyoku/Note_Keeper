<?php 

class Notes {

    private $id;
    private $title;
    private $description;
    private $dateCreated;
    private $categoryId;
    public $memberId;

    private $conn;

    public function __construct($dbConn) {
        $this->conn = $dbConn;
    }

    //CRUD Operations---------------------------------------------------------

    //Get All Notes in the Database
    public function readAllNotes() {
        $stmt
            = $this->conn->prepare(
                'SELECT
                    c.category_name as category_name,
                    m.first_name as first_name,
                    m.last_name as last_name,
                    n.id,
                    n.category_id,
                    n.member_id,
                    n.title,
                    n.description,
                    n.date_created
                FROM 
                    note_keeper.notes n
                INNER JOIN
                    category c ON n.category_id = c.id
                INNER JOIN 
                    members m ON n.member_id = m.id
                ORDER BY
                    n.date_created'
            )
        ;
        $stmt->execute();
        return $stmt;
    }

    //Gett All Notes in the database By User ID
    public function readAllByUser() {
        $stmt
            = $this->conn->prepare(
                'SELECT
                    c.category_name as category_name,
                    m.first_name as first_name,
                    m.last_name as last_name,
                    n.id,
                    n.category_id,
                    n.member_id,
                    n.title,
                    n.description,
                    n.date_created
                FROM 
                    note_keeper.notes n
                INNER JOIN
                    category c ON n.category_id = c.id
                INNER JOIN 
                    members m ON n.member_id = m.id
                WHERE
                    n.member_id = :id
                ORDER BY
                    n.date_created
                '
            )
        ;
        $stmt->bindParam(':id', $this->memberId);
        $stmt->execute();
        return $stmt;
    }
    //Setters --------------------------------------------------
    public function setId($_id) {
        $this->id = $_id;
    }

    public function setTitle($_title) {
        $this->title = $_title;
    }

    public function setDescription($_desc) {
        $this->description = $_desc;
    }

    public function setDateCreated($_dateCreated) {
        $this->dateCreated = $_dateCreated;
    }

    public function setCategoryId($_catId) {
        $this->categoryId = $_catId;
    }

    public function setMemberId($_memberId) {
        $this->memberId = $_memberId;
    }

    //Getters ---------------------------------------------------
    public function getId() {
        return $this->id;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getDateCreated() {
        return $this->dateCreated;
    }

    public function getCategoryId() {
        return $this->categoryId;
    }

    public function getMemberId() {
        return $this->memberId;
    }
}