<?php
// saved_builds.php
$host = 'localhost';
$db   = 'pc_configurator';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    die("Ошибка подключения к БД: " . $e->getMessage());
}

$stmt = $pdo->query("SELECT * FROM builds ORDER BY created_at DESC");
$builds = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Сохранённые сборки</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        .build { margin-bottom: 15px; padding: 10px; border: 1px solid #ccc; border-radius: 5px; }
        .build h3 { margin: 0 0 10px 0; }
        .build ul { margin: 0; padding-left: 20px; }
        .btn-load { margin-top: 10px; display: inline-block; padding: 5px 10px; background: #007BFF; color: white; text-decoration: none; border-radius: 4px; }
    </style>
</head>
<body>
    <h1>Сохранённые сборки</h1>

    <?php if ($builds): ?>
        <?php foreach ($builds as $build): ?>
            <div class="build">
                <h3><?= htmlspecialchars($build['name']) ?> (<?= number_format($build['price'], 0, '', ' ') ?> ₽)</h3>
                <p><strong>Создана:</strong> <?= $build['created_at'] ?></p>
                <ul>
                    <?php
                        $components = json_decode($build['components'], true);
                        foreach ($components as $comp) {
                            echo '<li>' . htmlspecialchars($comp['name']) . '</li>';
                        }
                    ?>
                </ul>
                <form action="index.php" method="POST">
                    <input type="hidden" name="load_build" value="<?= $build['id'] ?>">
                    <button type="submit" class="btn-load">Загрузить сборку</button>
                </form>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Нет сохранённых сборок.</p>
    <?php endif; ?>
</body>
</html>
