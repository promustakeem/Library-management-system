<?php
include 'dbconnect.php';

if (isset($_GET['book_name'])) {
    $book_name = $_GET['book_name'];

    $sql = "SELECT DISTINCT author_name FROM master_list_of_books WHERE book_name = ? AND status = 'Available'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $book_name);
    $stmt->execute();
    $result = $stmt->get_result();

    $authors = [];
    while ($row = $result->fetch_assoc()) {
        $authors[] = $row['author_name'];
    }

    echo json_encode(['authors' => $authors]);

    $stmt->close();
    $conn->close();
}
?>
