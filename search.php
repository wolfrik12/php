<html>
<head>
    <title>Поиск записей</title>
</head>
<body>
    <form action="search.php" method="GET">
        <input type="text" name="search" placeholder="Введите текст для поиска (минимум 3 символа)">
        <button type="submit">Найти</button>
    </form>

    <?php
    
    $host = 'localhost';
    $dbname = 'inline_test'; 
    $username = 'root'; 
    $password = ''; 

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        
        $search = isset($_GET['search']) ? $_GET['search'] : '';

        if (strlen($search) >= 3) {
            $stmt = $pdo->prepare("SELECT posts.title, comments.body 
                                   FROM posts 
                                   INNER JOIN comments ON posts.id = comments.postId 
                                   WHERE comments.body LIKE :search");
            $stmt->execute(['search' => '%' . $search . '%']);
            $results = $stmt->fetchAll();

            if (count($results) > 0) {
                foreach ($results as $result) {
                    echo "<h3>{$result['title']}</h3>";
                    echo "<p>{$result['body']}</p>";
                }
            } else {
                echo "Ничего не найдено";
            }
        } elseif (!empty($search)) {
            echo "Минимальная длина запроса - 3 символа";
        }
    } catch(PDOException $e) {
        echo "Ошибка: " . $e->getMessage();
    }
    ?>
</body>
</html>