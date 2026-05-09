<?php

class ContentTags extends DatabaseModel {

    public function getAllTags(): array {
        $statement = $this->db->prepare(
            "SELECT * FROM tags ORDER BY name ASC"
        );
        $statement->execute();
        return $statement->fetchAll();
    }

    public function getTagById(int $id): ?array {
        $statement = $this->db->prepare(
            "SELECT * FROM tags WHERE id = :id"
        );
        $statement->execute(['id' => $id]);
        return $statement->fetch() ?: null;
    }

    public function createContentTag(string $slug, array $translations): int {
        $this->db->beginTransaction();
        try {
            $statement = $this->db->prepare(
                "INSERT INTO tags (name) VALUES (:name)"
            );
            $statement->execute(['name' => $slug]);
            $tagId = $this->db->lastInsertId();
            $this->db->commit();
            return $tagId;
        } catch (Exception $e) {
            $this->db->rollback();
            throw $e;
        }
    }

    public function deleteById(int $id): void {
        $statement = $this->db->prepare("DELETE FROM tags WHERE id = :id");
        $statement->execute(['id' => $id]);
    }

    public function getCount(): int {
        $statement = $this->db->prepare("SELECT COUNT(*) as count FROM tags");
        $statement->execute();
        $result = $statement->fetch();
        return (int)($result['count'] ?? 0);
    }
}

?>
