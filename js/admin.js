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
        .then(response => response.text())
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
        .then(response => response.text())
        .catch(error => console.error("Error:", error));
    }
}