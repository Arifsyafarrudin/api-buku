<?php  
require 'config.php';  

function getBooks() {  
    global $pdo;  
    $stmt = $pdo->query("SELECT * FROM books");  
    return $stmt->fetchAll(PDO::FETCH_ASSOC);  
}  

function createBook($data) {  
    global $pdo;  

    // Ambil ID buku terakhir yang ada  
    $stmt = $pdo->query("SELECT MAX(id) AS max_id FROM books");  
    $maxId = $stmt->fetch(PDO::FETCH_ASSOC)['max_id'];  
    
    // Ganti ID baru dengan ID terakhir + 1 jika ada  
    $newId = $maxId ? $maxId + 1 : 1;  

    // Sisipkan buku  
    $stmt = $pdo->prepare("INSERT INTO books (id, title, author, published_year) VALUES (:id, :title, :author, :published_year)");  
    return $stmt->execute(['id' => $newId, 'title' => $data['title'], 'author' => $data['author'], 'published_year' => $data['published_year']]);  
}  

function updateBook($id, $data) {  
    global $pdo;  
    $stmt = $pdo->prepare("UPDATE books SET title = :title, author = :author, published_year = :published_year WHERE id = :id");  
    return $stmt->execute(['title' => $data['title'], 'author' => $data['author'], 'published_year' => $data['published_year'], 'id' => $id]);  
}  

function deleteBook($id) {  
    global $pdo;  
    $stmt = $pdo->prepare("DELETE FROM books WHERE id = :id");  
    $stmt->execute(['id' => $id]);  

    // Reset ID AUTO_INCREMENT ke ID tertinggi + 1 setelah penghapusan  
    $stmt = $pdo->query("SELECT MAX(id) AS max_id FROM books");  
    $maxId = $stmt->fetch(PDO::FETCH_ASSOC)['max_id'];  
    $newAutoIncrement = $maxId ? $maxId + 1 : 1;  

    // Reset AUTO_INCREMENT  
    $pdo->exec("ALTER TABLE books AUTO_INCREMENT = $newAutoIncrement");  
}  

if ($_SERVER['REQUEST_METHOD'] === 'GET') {  
    echo json_encode(getBooks());  
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {  
    $data = json_decode(file_get_contents("php://input"), true);  
    if (isset($data['title'], $data['author'], $data['published_year'])) {  
        createBook($data);  
        echo json_encode(['status' => 'Book created']);  
    } else {  
        echo json_encode(['error' => 'Invalid input']);  
    }  
} elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {  
    $data = json_decode(file_get_contents("php://input"), true);  
    $id = $_GET['id'];  
    if (isset($data['title'], $data['author'], $data['published_year'])) {  
        updateBook($id, $data);  
        echo json_encode(['status' => 'Book updated']);  
    } else {  
        echo json_encode(['error' => 'Invalid input']);  
    }  
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {  
    $id = $_GET['id'];  
    deleteBook($id);  
    echo json_encode(['status' => 'Book deleted']);  
}  
?>