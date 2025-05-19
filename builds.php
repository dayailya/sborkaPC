<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$pdo = new PDO("mysql:host=localhost;dbname=pc_configurator;charset=utf8", "root", "");

$sql = "SELECT b.*, 
        c1.name AS cpu_name, 
        c2.name AS motherboard_name, 
        c3.name AS ram_name,
        c4.name AS gpu_name,
        c5.name AS psu_name,
        c6.name AS storage_name,
        c7.name AS case_name,
        c8.name AS cooling_name
        FROM builds b
        LEFT JOIN components c1 ON b.cpu_id = c1.id
        LEFT JOIN components c2 ON b.motherboard_id = c2.id
        LEFT JOIN components c3 ON b.ram_id = c3.id
        LEFT JOIN components c4 ON b.gpu_id = c4.id
        LEFT JOIN components c5 ON b.psu_id = c5.id
        LEFT JOIN components c6 ON b.storage_id = c6.id
        LEFT JOIN components c7 ON b.case_id = c7.id
        LEFT JOIN components c8 ON b.cooling_id = c8.id
        ORDER BY b.created_at DESC";

$builds = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Сохранённые сборки</title>
</head>
<body>
    <h2>Сохранённые сборки</h2>
    <p><a href="admin.php">Назад в админку</a></p>
    <table border="1" cellpadding="6" cellspacing="0">
        <tr>
            <th>ID</th>
            <th>Пользователь</th>
            <th>Название</th>
            <th>CPU</th>
            <th>Материнская плата</th>
            <th>RAM</th>
            <th>GPU</th>
            <th>PSU</th>
            <th>Storage</th>
            <th>Case</th>
            <th>Cooling</th>
            <th>Дата</th>
        </tr>
        <?php foreach ($builds as $b): ?>
        <tr>
            <td><?= $b['id'] ?></td>
            <td><?= htmlspecialchars($b['user']) ?></td>
            <td><?= htmlspecialchars($b['name']) ?></td>
            <td><?= htmlspecialchars($b['cpu_name']) ?></td>
            <td><?= htmlspecialchars($b['motherboard_name']) ?></td>
            <td><?= htmlspecialchars($b['ram_name']) ?></td>
            <td><?= htmlspecialchars($b['gpu_name']) ?></td>
            <td><?= htmlspecialchars($b['psu_name']) ?></td>
            <td><?= htmlspecialchars($b['storage_name']) ?></td>
            <td><?= htmlspecialchars($b['case_name']) ?></td>
            <td><?= htmlspecialchars($b['cooling_name']) ?></td>
            <td><?= $b['created_at'] ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
