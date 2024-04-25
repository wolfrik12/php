<?php
$host = 'localhost';
$dbname = 'inline_test'; 
$username = 'root'; 
$password = ''; 

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

   
    $postsJson = file_get_contents('https://jsonplaceholder.typicode.com/posts');
    $posts = json_decode($postsJson, true);

    foreach ($posts as $post) {
        $stmt = $pdo->prepare("INSERT INTO posts (id, userId, title, body) VALUES (:id, :userId, :title, :body)");
        $stmt->execute($post);
    }

   
    $commentsJson = file_get_contents('https://jsonplaceholder.typicode.com/comments');
    $comments = json_decode($commentsJson, true);

    foreach ($comments as $comment) {
        $stmt = $pdo->prepare("INSERT INTO comments (id, postId, name, email, body) VALUES (:id, :postId, :name, :email, :body)");
        $stmt->execute($comment);
    }

    $postCount = count($posts);
    $commentCount = count($comments);
    echo "Загружено $postCount записей и $commentCount комментариев";

} catch(PDOException $e) {
    echo "Ошибка: " . $e->getMessage();
}
?>