<?php
include 'connection.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();  // Start the session if it's not started
}

$user_id = $_SESSION['user_id'];  // Logged-in user's ID

// Fetch total sales per month from January to July
$query = "
    SELECT 
        MONTH(ordered_at) AS month,
        SUM(order_finalprice) AS total_sales
    FROM Orders
    WHERE seller_id = ? 
    AND order_status = 'delivered'
    AND MONTH(ordered_at) BETWEEN 1 AND 7
    GROUP BY MONTH(ordered_at)
    ORDER BY MONTH(ordered_at)
";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Initialize arrays for months and sales
$months = ["January", "February", "March", "April", "May", "June", "July"];
$sales_data = array_fill(0, 7, 0);  // Default all months to 0

// Populate sales data
while ($row = $result->fetch_assoc()) {
    $sales_data[$row['month'] - 1] = (float)$row['total_sales']; // Store sales based on month index
}

$stmt->close();
$conn->close();

// Output JavaScript variables
echo '
    const xArray = ' . json_encode($months) . ';
    const yArray = ' . json_encode($sales_data) . ';

    const data = [{
        x: xArray,
        y: yArray,
        type: "bar",
        orientation: "v",
        marker: { color: "rgba(0,0,255,0.6)" }
    }];

    const layout = { title: "Monthly Sales Report" };

    Plotly.newPlot("myPlot", data, layout);
';
?>
