<main>
    <div class="dashboard-containers">
        <?php
        // Example of dynamic content for the dashboard
        
        $dashboardItems = [
            [
                'title' => 'Blog Posts', 
                'count' => $countPosts ?? 0,
                'link' => '/admin/blog-posts',
            ],
            [
                'title' => 'Blog Tags', 
                'count' => $countTags ?? 0,
                'link' => '/admin/blog-tags',
            ],
            [
                'title' => 'Products', 
                'count' => $countProducts ?? 0,
                'link' => '/admin/products',
            ],
            [
                'title' => 'Product Categories', 
                'count' => $countCategories ?? 0,
                'link' => '/admin/product-categories',
            ],
            [
                'title' => 'Orders', 
                'count' => $countOrders ?? 0,
                'link' => '/admin/orders',
            ],
            [
                'title' => 'Customers', 
                'count' => $countCustomers ?? 0,
                'link' => '/admin/customers',
            ],
        ];
        
        foreach ($dashboardItems as $item) {
            echo "<div class='dashboard-item'>";
            echo "<div class='dashboard-item-header'><h2>" . $item['title'] . ":</h2><span class='dashboard-item-count'><h2>" . $item['count'] . "</h2></span></div>";
            echo "<div class='dashboard-item-body'>";
            echo "<a href='" . $item['link'] . "' class='dashboard-item-link'><div>Show " . $item['title'] . "</div></a>";
            echo "</div>";
            echo "</div>";
        }
        ?>
    </div>
</main>