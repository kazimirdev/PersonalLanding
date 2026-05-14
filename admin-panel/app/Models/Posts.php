<?php

class Posts extends DatabaseModel {

    /*  DB Tables:
    *
    */ 
    public function createContentPost(
                                string $slug, 
                                array $translations, 
                                string $image_preview_url): int {
        $this->db->beginTransaction();
        try {
            $statement = $this->db->prepare(
                    "INSERT INTO posts (
                    slug, image_preview_url
                    ) VALUES (:slug, :image_preview_url)"
            );
            $statement->execute([
                'slug' => $slug, 
                'image_preview_url' => $image_preview_url
                ]);
            $postId = $this->db->lastInsertId();

            foreach ($translations as $locale => $data) {
                $statement_post_translations = $this->db->prepare(
                    "INSERT INTO post_translations (
                        post_id, locale, title, content_md, content_html, content_preview
                        ) VALUES (
                            :post_id, 
                            :locale, 
                            :title, 
                            :content_md, 
                            :content_html,
                            :content_preview)"
                );
                $statement_post_translations->execute([
                    'post_id' => $postId,
                    'locale' => $locale,
                    'title' => $data['title'],
                    'content_md' => $data['content_md'],
                    'content_html' => $data['content_html'],
                    'content_preview' => $data['content_preview'] ?? null
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
            "SELECT p.id, 
                    p.slug, 
                    p.image_preview_url, 
                    p.created_at, 
                    p.updated_at, 
                    pt.title, 
                    pt.locale,
                    pt.content_md,
                    pt.content_html,
                    pt.content_preview
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
            "SELECT p.id, p.slug, p.image_preview_url, pt.title, $content_type, pt.locale, p.created_at, p.updated_at, pt.content_preview
             FROM posts p 
             JOIN post_translations pt ON p.id = pt.post_id 
             WHERE p.slug = :slug AND pt.locale = :locale"
        );
        $statement->execute(['slug' => $slug, 'locale' => $locale]);
        return $statement->fetch() ?: null;
    }

    public function getById(int $id): ?array {
        $statement = $this->db->prepare(
            "SELECT p.id, p.slug, p.image_preview_url, p.created_at, p.updated_at
             FROM posts p 
             WHERE p.id = :id"
        );
        $statement->execute(['id' => $id]);
        $post = $statement->fetch();
        
        if (!$post) {
            return null;
        }

        // Fetch all translations
        $statement_trans = $this->db->prepare(
            "SELECT locale, title, content_md, content_html, content_preview
             FROM post_translations
             WHERE post_id = :id
             ORDER BY locale"
        );
        $statement_trans->execute(['id' => $id]);
        $translations = $statement_trans->fetchAll();

        // Organize translations by locale
        $post['translations'] = [];
        foreach ($translations as $translation) {
            $post['translations'][$translation['locale']] = $translation;
        }

        return $post;
    }

    public function getCountByLocale(string $locale): int {
        $statement = $this->db->prepare(
            "SELECT COUNT(DISTINCT p.id) as count
             FROM posts p
             JOIN post_translations pt ON p.id = pt.post_id
             WHERE pt.locale = :locale"
        );
        $statement->execute(['locale' => $locale]);
        $result = $statement->fetch();
        return (int)($result['count'] ?? 0);
    }

    public function deleteById(int $id): void {
        $statement = $this->db->prepare("DELETE FROM posts WHERE id = :id");
        $statement->execute(['id' => $id]);
    }

    public function updateContentPost(
                                int $id,
                                string $slug, 
                                array $translations, 
                                string $image_preview_url): void {
        $this->db->beginTransaction();
        try {
            // Update post metadata
            $statement = $this->db->prepare(
                    "UPDATE posts SET slug = :slug, image_preview_url = :image_preview_url WHERE id = :id"
            );
            $statement->execute([
                'id' => $id,
                'slug' => $slug, 
                'image_preview_url' => $image_preview_url
            ]);

            // Update translations
            foreach ($translations as $locale => $data) {
                $statement_trans = $this->db->prepare(
                    "UPDATE post_translations SET 
                        title = :title, 
                        content_md = :content_md, 
                        content_html = :content_html,
                        content_preview = :content_preview
                    WHERE post_id = :post_id AND locale = :locale"
                );
                $statement_trans->execute([
                    'post_id' => $id,
                    'locale' => $locale,
                    'title' => $data['title'],
                    'content_md' => $data['content_md'],
                    'content_html' => $data['content_html'],
                    'content_preview' => $data['content_preview'] ?? null
                ]);
            }

            $this->db->commit();
        } catch (Exception $e) {
            $this->db->rollback();
            throw $e;
        }
    }


}


?>