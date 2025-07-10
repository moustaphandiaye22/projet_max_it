<main>
      <?php 
    // require dirname(__DIR__) . '/layout/header.php';
    // require dirname(__DIR__) . '/layout/sidebar.php';
      echo $ContentForLayout;
        
      ?>
</main>

<style>
    .sidebar {
        background-color: #ffffff;
        box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
    }
    .notification-dot {
        width: 8px;
        height: 8px;
        background-color: #ef4444;
        border-radius: 50%;
        position: absolute;
        top: -2px;
        right: -2px;
    }
</style>