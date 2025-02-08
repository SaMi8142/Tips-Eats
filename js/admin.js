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

function approveReport(post_id, report_type) {
    if (confirm("Are you sure you want to approve this report?")) {
        fetch("reportApproval.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ action: "approve", post_id: post_id, report_type: report_type }) // Send ID
        })
        .then(response => {
            window.location.reload();
            return response.text();
        })
        .catch(error => console.error("Error:", error));
    }
}

function disapproveReport(post_id, report_type) {
    if(confirm("Are you sure you want to disapprove this report?")){
        fetch("reportApproval.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ action: "disapprove", post_id: post_id, report_type: report_type })
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

        // Define month order for sorting
        const monthNames = [
            "January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December"
        ];

        // Convert data to objects with sortable keys
        let dataPairs = data.map(item => {
            let [year, monthName] = item.report_month.split("-"); // Extract year and month name
            return {
                year: parseInt(year), // Convert year to integer
                month: monthNames.indexOf(monthName), // Get numerical month index (0-based)
                monthLabel: `${monthName} ${year}`, // Display format (e.g., "January 2025")
                value: item.total_reports
            };
        });

        // Sort data chronologically by year and month
        dataPairs.sort((a, b) => (a.year - b.year) || (a.month - b.month));

        // Extract sorted labels and values
        let labels = dataPairs.map(pair => pair.monthLabel);
        let values = dataPairs.map(pair => pair.value);

        // Call function to create the line chart
        createLineChart(labels, values);
    })
    .catch(error => console.error("Error fetching data:", error));




// Function to create a Chart.js line chart
function createLineChart(labels, values) {
    // Define the correct order of months
    const monthOrder = [
        "January", "February", "March", "April", "May", "June",
        "July", "August", "September", "October", "November", "December"
    ];

    // Create an array of objects for sorting
    let dataPairs = labels.map((month, index) => ({
        month,
        value: values[index]
    }));

    // Sort by the predefined month order
    dataPairs.sort((a, b) => monthOrder.indexOf(a.month) - monthOrder.indexOf(b.month));

    // Extract sorted labels and values
    const sortedLabels = dataPairs.map(pair => pair.month);
    const sortedValues = dataPairs.map(pair => pair.value);

    // Create the chart
    const ctx = document.getElementById("reportLineChart").getContext("2d");
    new Chart(ctx, {
        type: "line",
        data: {
            labels: sortedLabels,
            datasets: [{
                label: "Total Reports",
                data: sortedValues,
                borderColor: "#FF5733",
                backgroundColor: "rgba(255, 87, 51, 0.2)",
                borderWidth: 2,
                tension: 0.3,
                pointRadius: 4,
                pointBackgroundColor: "#FF5733"
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: "top" }
            },
            scales: {
                x: { title: { display: true, text: "Month" } },
                y: {
                    title: { display: true, text: "Number of Reports" },
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        callback: function(value) {
                            return Number.isInteger(value) ? value : null;
                        }
                    }
                }
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

// Hamburger menu for mobile devices
const hamburger = document.querySelector('.hamburger');
const sideNavbar = document.querySelector('.side-navbar');

hamburger.addEventListener('click', () => {
    hamburger.classList.toggle('active');
    sideNavbar.classList.toggle('active');
});

// Close menu when clicking outside
document.addEventListener('click', (e) => {
    if (!sideNavbar.contains(e.target) && !hamburger.contains(e.target)) {
        hamburger.classList.remove('active');
        sideNavbar.classList.remove('active');
    }
});