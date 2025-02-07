var alr_clicked = false;

function popup_logout() {
    var popup = document.getElementById("popuplogout");
    if (alr_clicked == false) {
        popup.style.display = "block";
        alr_clicked = true;
    } else {
        popup.style.display = "none";
        alr_clicked = false;
    }
}

function approveReport(post_id) {
    if (confirm("Are you sure you want to approve this report?")) {
        fetch("reportApproval.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ action: "approve", post_id: post_id }) // Send ID
        })
        .then(response => {
            window.location.reload();
            return response.text();
        })
        .catch(error => console.error("Error:", error));
    }
}

function disapproveReport(post_id) {
    if(confirm("Are you sure you want to disapprove this report?")){
        fetch("reportApproval.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ action: "disapprove", post_id: post_id })
        })
        .then(response => {
            window.location.reload();
            return response.text();
        })
        .catch(error => console.error("Error:", error));
    }
    
}

fetch("backend/getReportCounts.php") // Fetch data from PHP script
    .then(response => response.json()) // Convert response to JSON
    .then(data => {
        console.log(data); // Debugging: Check the retrieved data

        // Extract labels (report types) and values (counts)
        let labels = data.map(item => item.report_issue);
        let values = data.map(item => item.total_reports);

        // Call function to create a pie chart
        createPieChart(labels, values);
    })
    .catch(error => console.error("Error fetching data:", error));

// Function to create a Chart.js pie chart
function createPieChart(labels, values) {
    const ctx = document.getElementById("reportPieChart").getContext("2d");
    new Chart(ctx, {
        type: "pie", // Change chart type to "pie"
        data: {
            labels: labels, // X-axis labels
            datasets: [{
                label: "Report Counts",
                data: values, // Y-axis values
                backgroundColor: [
                    "#39a871", "#ffd1a9", "#ffe9d7", "#994700", "#EEE", "222"
                ], // Different colors for each slice
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: "bottom" } // Move legend to bottom
            }
        }
    });
}

fetch("backend/getReportsByMonth.php") // Fetch data from PHP script
    .then(response => response.json()) // Convert response to JSON
    .then(data => {
        console.log(data); // Debugging: Check retrieved data

        // Extract labels (months) and values (report counts)
        let labels = data.map(item => item.report_month);
        let values = data.map(item => item.total_reports);

        // Call function to create the line chart
        createLineChart(labels, values);
    })
    .catch(error => console.error("Error fetching data:", error));

// Function to create a Chart.js line chart
function createLineChart(labels, values) {
    const ctx = document.getElementById("reportLineChart").getContext("2d");
    new Chart(ctx, {
        type: "line",
        data: {
            labels: labels, // X-axis: Months
            datasets: [{
                label: "Total Reports",
                data: values, // Y-axis: Number of reports
                borderColor: "#FF5733", // Line color
                backgroundColor: "rgba(255, 87, 51, 0.2)", // Light fill under the line
                borderWidth: 2,
                tension: 0.3, // Smooth curve
                pointRadius: 4, // Point size
                pointBackgroundColor: "#FF5733"
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: "top" } // Position of the legend
            },
            scales: {
                x: { title: { display: true, text: "Month" } },
                y: { title: { display: true, text: "Number of Reports" }, beginAtZero: true }
            }
        }
    });
}

function fetchActiveUsers() {
    fetch("backend/getActiveUsers.php")
        .then(response => response.json())
        .then(data => {
            document.getElementById("activeUsersCount").innerText = data.active_users;
        })
        .catch(error => console.error("Error:", error));
}

// Refresh every 5 seconds
setInterval(fetchActiveUsers, 5000);

// Fetch immediately on page load
fetchActiveUsers();

function fetchTotalReports() {
    fetch("backend/getTotalReports.php")
        .then(response => response.json())
        .then(data => {
            document.getElementById("totalReportCount").innerText = data.report_sum;
        })
        .catch(error => console.error("Error:", error));
}

// Refresh every 5 seconds
setInterval(fetchTotalReports, 5000);

// Fetch immediately on page load
fetchTotalReports();



function fetchPendingReports() {
    fetch("backend/getPendingReports.php")
        .then(response => response.json())
        .then(data => {
            document.getElementById("totalPendingCount").innerText = data.pending_sum;
        })
        .catch(error => console.error("Error:", error));
}

// Refresh every 5 seconds
setInterval(fetchPendingReports, 5000);

// Fetch immediately on page load
fetchPendingReports();


function displayPost(post_id){
    
}