<?php

class Posts extends DatabaseModel {

    /*  DB Tables:
    *
    */ 
    public function createPost(string $slug, array $translations): int {
        $this->db->beginTransaction();
        try {
            $statement = $this->db->prepare(
                "INSERT INTO posts (slug) VALUES (:slug)");
            $statement->execute(['slug' => $slug]);
            $postId = $this->db->lastInsertId();

            foreach ($translations as $locale => $data) {
                $statement = $this->db->prepare(
                    "INSERT INTO post_translations (
                        post_id, locale, title, content_md, content_html
                        ) VALUES (:post_id, :locale, :title, :content_md, :content_html)"
                );
                $statement->execute([
                    'post_id' => $postId,
                    'locale' => $locale,
                    'title' => $data['title'],
                    'content_md' => $data['content_md'],
                    'content_html' => $data['content_html']
                ]);
            }

            $this->db->commit();
            return $postId;
        } catch (Exception $e) {
            $this->db->rollback();
            throw $e;
        }
    }

    public function getAllByLocale(string $locale): array {
        $statement = $this->db->prepare(
            "SELECT p.id, p.slug, p.image_preview_url, p.created_at, p.updated_at, pt.title, pt.locale 
             FROM posts p 
             JOIN post_translations pt ON p.id = pt.post_id 
             WHERE pt.locale = :locale"
        );
        $statement->execute(['locale' => $locale]);
        return $statement->fetchAll();
    }

    public function getBySlugAndLocale(string $slug, string $locale, bool $is_md = false): ?array {
        $content_type = $is_md ? 'content_md' : 'content_html';
        $statement = $this->db->prepare(
            "SELECT p.id, p.slug, p.image_preview_url, pt.title, $content_type, pt.locale, pt.created_at, pt.updated_at
             FROM posts p 
             JOIN post_translations pt ON p.id = pt.post_id 
             WHERE p.slug = :slug AND pt.locale = :locale"
        );
        $statement->execute(['slug' => $slug, 'locale' => $locale]);
        return $statement->fetch() ?: null;
    }

}

?>