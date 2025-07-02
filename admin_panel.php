<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

require 'db.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, name, description, location, date, contact, status, image FROM items ORDER BY id DESC";
$result = $conn->query($sql);
if (!$result) {
    die("Query failed: " . $conn->error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Admin Panel - Lost & Found System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <style>
        :root {
            --primary: #4361ee;
            --secondary: #3a0ca3;
            --success: #4cc9f0;
            --danger: #f72585;
        }
        body {
            background-color: #f5f7fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .admin-header {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            padding: 1.5rem;
            margin-bottom: 2rem;
            border-radius: 0 0 10px 10px;
        }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            margin-bottom: 2rem;
        }
        .table thead th {
            background-color: var(--primary);
            color: white;
        }
        .status-badge {
            padding: 0.35rem 0.65rem;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        .status-lost {
            background-color: rgba(247, 37, 133, 0.1);
            color: var(--danger);
        }
        .status-found {
            background-color: rgba(76, 201, 240, 0.1);
            color: var(--success);
        }
        .action-btn {
            padding: 0.25rem 0.5rem;
            font-size: 0.85rem;
            margin-right: 0.25rem;
        }
        .item-image {
            width: 60px;
            height: auto;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <header class="admin-header">
        <div class="container d-flex justify-content-between align-items-center">
            <h1><i class="fas fa-user-shield me-2"></i>Admin Panel</h1>
            <a href="logout.php" class="btn btn-outline-light" aria-label="Logout">
                <i class="fas fa-sign-out-alt me-1"></i> Logout
            </a>
        </div>
    </header>

    <main class="container">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="fas fa-list me-2"></i>All Reported Items</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Item Name</th>
                                <th>Description</th>
                                <th>Location</th>
                                <th>Date</th>
                                <th>Contact</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($result->num_rows > 0): ?>
                                <?php $serial = 1; ?>
                                <?php while ($row = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td><?= $serial++ ?></td>
                                        <td><?= htmlspecialchars($row['id']) ?></td>
                                        <td>
                                            <?php 
                                            $imagePath = $row['image'];
                                            if (!empty($imagePath) && strpos($imagePath, 'uploads/') !== 0) {
                                                $imagePath = 'uploads/' . $imagePath;
                                            }

                                            if (!empty($row['image']) && file_exists($imagePath)) {
                                                echo '<img src="' . htmlspecialchars($imagePath) . '" class="item-image" alt="Item Image">';
                                            } else {
                                                echo '<span class="text-muted">No image</span>';
                                            }
                                            ?>
                                        </td>
                                        <td><?= htmlspecialchars($row['name']) ?></td>
                                        <td><?= htmlspecialchars($row['description']) ?></td>
                                        <td><?= htmlspecialchars($row['location']) ?></td>
                                        <td><?= date('M j, Y', strtotime($row['date'])) ?></td>
                                        <td><?= htmlspecialchars($row['contact']) ?></td>
                                        <td>
                                            <span class="status-badge <?= $row['status'] === 'found' ? 'status-found' : 'status-lost' ?>">
                                                <?= ucfirst(htmlspecialchars($row['status'])) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <a href="edit_item.php?id=<?= urlencode($row['id']) ?>" class="btn btn-sm btn-primary action-btn">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="delete_item.php?id=<?= urlencode($row['id']) ?>" class="btn btn-sm btn-danger action-btn" onclick="return confirm('Are you sure you want to delete this item?');">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="10" class="text-center py-4 text-muted">No items found in database</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
$conn->close();
?>
