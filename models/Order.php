<?php
class Order {
    private $conn;
    private $table_name = "orders";

    public $id;
    public $user_id;
    public $receiver_name;
    public $phone;
    public $address;
    public $note;
    public $total_amount;
    public $status;
    public $payment_method;
    public $payment_status;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Get all orders for a specific user
    public function readByUserId($user_id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE user_id = ? ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$user_id]);
        return $stmt;
    }

    // Get single order details
    public function readOne($id, $user_id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ? AND user_id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id, $user_id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if($row) {
            $this->id = $row['id'];
            $this->receiver_name = $row['receiver_name'];
            $this->phone = $row['phone'];
            $this->address = $row['address'];
            $this->note = $row['note'];
            $this->total_amount = $row['total_amount'];
            $this->status = $row['status'];
            $this->payment_method = $row['payment_method'];
            $this->payment_status = $row['payment_status'];
            $this->created_at = $row['created_at'];
            return true;
        }
        return false;
    }

    // Get items for a specific order
    public function getOrderItems($order_id) {
        $query = "SELECT * FROM order_items WHERE order_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$order_id]);
        return $stmt;
    }
}
?>
