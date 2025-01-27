<?php
include 'connection.php';
header('Content-Type: application/json');
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $comment_id = isset($_POST['comment_id']) ? intval($_POST['comment_id']) : null;
    $action = isset($_POST['action']) ? $_POST['action'] : null;
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

    if (!$comment_id || !$action || !$user_id) {
        echo json_encode(['success' => false, 'message' => 'Invalid request data.']);
        exit;
    }

    if ($action === 'like') {
        $sql = "INSERT IGNORE INTO commentlikes (comment_id, user_id) VALUES (?, ?)";
    } elseif ($action === 'unlike') {
        $sql = "DELETE FROM commentlikes WHERE comment_id = ? AND user_id = ?";
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid action.']);
        exit;
    }

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $comment_id, $user_id);
    if (!$stmt->execute()) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $stmt->error]);
        exit;
    }
    $stmt->close();

    // Get the updated like count
    $like_sql = "SELECT COUNT(*) AS like_count FROM commentlikes WHERE comment_id = ?";
    $stmt = $conn->prepare($like_sql);
    $stmt->bind_param("i", $comment_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $like_row = $result->fetch_assoc();
    $like_count = $like_row['like_count'];
    $stmt->close();

    echo json_encode(['success' => true, 'new_like_count' => $like_count]);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}

$conn->close();
?>
