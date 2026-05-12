<?php

class Order extends DatabaseModel {

    public function getAllOrders(): array {
        $statement = $this->db->prepare(
            "SELECT o.id, 
                    o.product_id, 
                    o.order_status, 
                    o.email,
                    o.total_price,
                    o.currency,
                    o.created_at,
                    pt.name as product_name
             FROM orders o
             LEFT JOIN product_translations pt ON o.product_id = pt.product_id AND pt.locale = :locale
             ORDER BY o.created_at DESC"
        );
        $statement->execute(['locale' => $GLOBALS['locale'] ?? 'en']);
        return $statement->fetchAll();
    }

    public function getOrderById(int $id): ?array {
        $statement = $this->db->prepare(
            "SELECT o.*, 
                    pt.name as product_name
             FROM orders o
             LEFT JOIN product_translations pt ON o.product_id = pt.product_id
             WHERE o.id = :id"
        );
        $statement->execute(['id' => $id]);
        return $statement->fetch() ?: null;
    }

    public function updateOrderStatus(int $id, string $status): void {
        $statement = $this->db->prepare(
            "UPDATE orders SET order_status = :status, updated_at = CURRENT_TIMESTAMP WHERE id = :id"
        );
        $statement->execute(['status' => $status, 'id' => $id]);
    }

    public function deleteById(int $id): void {
        $statement = $this->db->prepare("DELETE FROM orders WHERE id = :id");
        $statement->execute(['id' => $id]);
    }

    public function getCount(): int {
        $statement = $this->db->prepare("SELECT COUNT(*) as count FROM orders");
        $statement->execute();
        $result = $statement->fetch();
        return (int)($result['count'] ?? 0);
    }
}

?>
