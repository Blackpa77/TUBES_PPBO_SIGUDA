<?php
namespace App\Models;

use PDO;

class Admin {
    private $conn;
    private $table = "users";

    private $id;
    private $username;
    private $password;
    private $nama_lengkap;
    private $role;

    public function __construct($db) {
        $this->conn = $db;
    }

    // --- GETTER & SETTER ---
    public function getId() { return $this->id; }
    public function setId($id) { $this->id = $id; }

    public function getUsername() { return $this->username; }
    public function setUsername($username) { $this->username = $username; }

    public function setPassword($password) { 
        $this->password = $password; 
    }

    public function getNamaLengkap() { return $this->nama_lengkap; }
    public function setNamaLengkap($nama) { $this->nama_lengkap = $nama; }

    public function getRole() { return $this->role; }
    public function setRole($role) { $this->role = $role; }

    public function login($usernameInput, $passwordInput) {
        $query = "SELECT id, username, password, nama_lengkap, role 
                FROM " . $this->table . " 
                WHERE username = :username LIMIT 1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $usernameInput);
        $stmt->execute();

        if($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if(password_verify($passwordInput, $row['password'])) {
                $this->id = $row['id'];
                $this->username = $row['username'];
                $this->nama_lengkap = $row['nama_lengkap'];
                $this->role = $row['role'];
                return true;
            }
        }
        return false;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table . " 
                SET username=:username, password=:password, 
                    nama_lengkap=:nama_lengkap, role=:role";
        
        $stmt = $this->conn->prepare($query);
        
        $uname = htmlspecialchars(strip_tags($this->username));
        $nama = htmlspecialchars(strip_tags($this->nama_lengkap));
        $role = htmlspecialchars(strip_tags($this->role));
        $pass = password_hash($this->password, PASSWORD_DEFAULT);

        $stmt->bindParam(':username', $uname);
        $stmt->bindParam(':password', $pass);
        $stmt->bindParam(':nama_lengkap', $nama);
        $stmt->bindParam(':role', $role);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function update() {
        $query = "UPDATE " . $this->table . " 
                SET username=:username, nama_lengkap=:nama_lengkap, role=:role";
        
        if(!empty($this->password)) {
            $query .= ", password=:password";
        }
        
        $query .= " WHERE id=:id";
        
        $stmt = $this->conn->prepare($query);
        
        $uname = htmlspecialchars(strip_tags($this->username));
        $nama = htmlspecialchars(strip_tags($this->nama_lengkap));
        $role = htmlspecialchars(strip_tags($this->role));
        $id = htmlspecialchars(strip_tags($this->id));
        
        $stmt->bindParam(':username', $uname);
        $stmt->bindParam(':nama_lengkap', $nama);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':id', $id);
        
        if(!empty($this->password)) {
            $pass = password_hash($this->password, PASSWORD_DEFAULT);
            $stmt->bindParam(':password', $pass);
        }

        return $stmt->execute();
    }
}