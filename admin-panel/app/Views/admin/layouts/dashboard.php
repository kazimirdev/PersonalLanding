<main>
    <div class="dashboard-containers">
        <?php
        // Example of dynamic content for the dashboard
        
        $dashboardItems = [
            [
                'title' => 'Content Posts', 
                'count' => $countPosts ?? 0,
                'link' => '/content',
            ],
            [
                'title' => 'Content Tags', 
                'count' => $countTags ?? 0,
                'link' => '/content-tags',
            ],
            [
                'title' => 'Products', 
                'count' => $countProducts ?? 0,
                'link' => '/products',
            ],
            [
                'title' => 'Product Categories', 
                'count' => $countCategories ?? 0,
                'link' => '/product-categories',
            ],
            [
                'title' => 'Orders', 
                'count' => $countOrders ?? 0,
                'link' => '/orders',
            ],
            [
                'title' => 'Customers', 
                'count' => $countCustomers ?? 0,
                'link' => '/customers',
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