<?php

class Database
{
    private $host = '127.0.0.1';
    private $user = 'root';
    private $pass = '';
    private $name = 'tms';
    private $conn;

    public function __construct()
    {
        $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->name);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function establishConnection()
    {
        return $this->conn;
    }
}

class TaskManager
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function addTask($taskName)
    {
        $conn = $this->db->establishConnection();
        $query = $conn->prepare("INSERT INTO tasks (taskName) VALUES (?)");
        $query->bind_param("s", $taskName);
        $query->execute();
        $query->close();
    }

    public function markTaskAsDone($taskId)
    {
        $conn = $this->db->establishConnection();
        $query = $conn->prepare("UPDATE tasks SET is_done = IF(is_done = 0, 1, 0) WHERE taskId = ?");
        $query->bind_param("i", $taskId);
        $query->execute();
        $query->close();
    }

    public function getTasks()
    {
        $conn = $this->db->establishConnection();
        $taskQuery = $conn->query("SELECT * FROM tasks");

        $tasks = [];
        while ($row = $taskQuery->fetch_assoc()) {
            $tasks[] = $row;
        }

        return $tasks;
    }

    public function getUsers()
    {
        $conn = $this->db->establishConnection();
        $userQuery = $conn->query("SELECT * FROM users");
        $users = [];
        while ($row = $userQuery->fetch_assoc()) {
            $users[] = $row;
        }
        return $users;
    }

    public function addUser($name)
    {
        $conn = $this->db->establishConnection();
        $query = $conn->prepare("INSERT INTO users (name) VALUES (?)");
        $query->bind_param("s", $name);
        $query->execute();
        $query->close();
    }

    public function updateUser($userId, $name)
    {
        $conn = $this->db->establishConnection();
        $query = $conn->prepare("UPDATE users SET name = ? WHERE userId = ?");
        $query->bind_param("si", $name, $userId);
        $query->execute();
        $query->close();
    }

    public function deleteUser($userId)
    {
        $conn = $this->db->establishConnection();
        $query = $conn->prepare("DELETE FROM users WHERE userId = ?");
        $query->bind_param("i", $userId);
        $query->execute();
        $query->close();
    }

    // Additional methods for tasks
    public function addTaskWithUser($taskName, $userId)
    {
        $conn = $this->db->establishConnection();
$query = $conn->prepare("INSERT INTO tasks (taskName, userId) VALUES (?, ?)");

if (!$query) {
    die('Error preparing statement: ' . $conn->error);
}

$query->bind_param("si", $taskName, $userId);
$query->execute();
$query->close();

    }

    public function updateTask($taskId, $taskName, $userId)
    {
        $conn = $this->db->establishConnection();
        $query = $conn->prepare("UPDATE tasks SET taskName = ?, userId = ? WHERE taskId = ?");
        $query->bind_param("sii", $taskName, $userId, $taskId);
        $query->execute();
        $query->close();
    }

    public function deleteTask($taskId)
    {
        $conn = $this->db->establishConnection();
        $query = $conn->prepare("DELETE FROM tasks WHERE taskId = ?");
        $query->bind_param("i", $taskId);
        $query->execute();
        $query->close();
    }
}
