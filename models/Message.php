<?php
class Message
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getMessages()
    {
        $query = "SELECT m.id, u.username, u.profile_picture, m.message, m.timestamp
                  FROM messages m
                  JOIN users u ON m.user_id = u.id
                  ORDER BY m.timestamp ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addMessage($userId, $message)
    {
        $query = "INSERT INTO messages (user_id, message) VALUES (:user_id, :message)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':message', $message);

        return $stmt->execute();
    }
}
