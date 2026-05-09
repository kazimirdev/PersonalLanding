<?php

class Product extends DatabaseModel {

    public function getAllProductsByLocale(string $locale): array {
        $statement = $this->db->prepare(
            "SELECT p.id, 
                    p.slug, 
                    p.created_at, 
                    p.updated_at,
                    pt.name,
                    pp.price,
                    pp.currency
             FROM products p 
             LEFT JOIN product_translations pt ON p.id = pt.product_id AND pt.locale = :locale
             LEFT JOIN product_prices pp ON p.id = pp.product_id
             ORDER BY p.created_at DESC"
        );
        $statement->execute(['locale' => $locale]);
        return $statement->fetchAll();
    }

    public function getProductById(int $id): ?array {
        $statement = $this->db->prepare(
            "SELECT p.id, p.slug, p.created_at, p.updated_at, pt.name, pt.description_md, pt.locale, pp.price, pp.currency
             FROM products p 
             LEFT JOIN product_translations pt ON p.id = pt.product_id
             LEFT JOIN product_prices pp ON p.id = pp.product_id
             WHERE p.id = :id"
        );
        $statement->execute(['id' => $id]);
        return $statement->fetch() ?: null;
    }

    public function createProduct(string $slug, array $translations): int {
        $this->db->beginTransaction();
        try {
            $statement = $this->db->prepare(
                "INSERT INTO products (slug) VALUES (:slug)"
            );
            $statement->execute(['slug' => $slug]);
            $productId = $this->db->lastInsertId();

            foreach ($translations as $locale => $data) {
                $statement_product_translations = $this->db->prepare(
                    "INSERT INTO product_translations (
                        product_id, locale, name, description_md, description_html
                        ) VALUES (
                            :product_id, 
                            :locale, 
                            :name, 
                            :description_md, 
                            :description_html)"
                );
                $statement_product_translations->execute([
                    'product_id' => $productId,
                    'locale' => $locale,
                    'name' => $data['name'],
                    'description_md' => $data['description_md'],
                    'description_html' => $data['description_html']
                ]);
            }

            $this->db->commit();
            return $productId;
        } catch (Exception $e) {
            $this->db->rollback();
            throw $e;
        }
    }

    public function deleteById(int $id): void {
        $statement = $this->db->prepare("DELETE FROM products WHERE id = :id");
        $statement->execute(['id' => $id]);
    }

    public function getCountByLocale(string $locale): int {
        $statement = $this->db->prepare(
            "SELECT COUNT(DISTINCT p.id) as count
             FROM products p
             LEFT JOIN product_translations pt ON p.id = pt.product_id
             WHERE pt.locale = :locale OR pt.locale IS NULL"
        );
        $statement->execute(['locale' => $locale]);
        $result = $statement->fetch();
        return (int)($result['count'] ?? 0);
    }
}

?>
