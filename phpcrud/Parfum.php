<?php
class Parfum {
    private $conn;
    private $table_name = "parfums";

    public $ParfumID;
    public $Name;
    public $Price;
    public $Gender;
    public $Volume;
    public $ImageURL;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Create a new parfum
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " (Name, Price, Gender, Volume, ImageURL) VALUES (:Name, :Price, :Gender, :Volume, :ImageURL)";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':Name', $this->Name);
        $stmt->bindParam(':Price', $this->Price);
        $stmt->bindParam(':Gender', $this->Gender);
        $stmt->bindParam(':Volume', $this->Volume);
        $stmt->bindParam(':ImageURL', $this->ImageURL);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Read all parfums
    public function readAll() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Read a single parfum by ID
    public function readSingle($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE ParfumID = :ParfumID";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':ParfumID', $id);
        $stmt->execute();
        return $stmt;
    }

    // Update a parfum
    public function update() {
        $query = "UPDATE " . $this->table_name . " SET Name = :Name, Price = :Price, Gender = :Gender, Volume = :Volume, ImageURL = :ImageURL WHERE ParfumID = :ParfumID";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':ParfumID', $this->ParfumID);
        $stmt->bindParam(':Name', $this->Name);
        $stmt->bindParam(':Price', $this->Price);
        $stmt->bindParam(':Gender', $this->Gender);
        $stmt->bindParam(':Volume', $this->Volume);
        $stmt->bindParam(':ImageURL', $this->ImageURL);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Delete a parfum
    public function delete($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE ParfumID = :ParfumID";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':ParfumID', $id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>
