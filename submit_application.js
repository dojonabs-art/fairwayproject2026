// FAIRWAY SCHOOL - MAIN JAVASCRIPT FILE

// 1. SHOW / HIDE SIDEBAR ON MOBILE
function toggleSidebar() {
  let sidebar = document.getElementById("sidebar");
  if (sidebar.style.display === "none" || sidebar.style.display === "") {
    sidebar.style.display = "block";
  } else {
    sidebar.style.display = "none";
  }
}

// 2. CUSTOM POPUP MESSAGE (Better than alert)
function showPopup(message) {
  let popup = document.getElementById("popup");
  let popupText = document.getElementById("popupText");
  if (popup && popupText) {
    popupText.innerText = message;
    popup.style.display = "block";
  } else {
    alert(message);
  }
}

function closePopup() {
  let popup = document.getElementById("popup");
  if (popup) {
    popup.style.display = "none";
  }
}

// 3. CONFIRM BEFORE ACTION (For Headteacher Approve, Logout, Delete)
function confirmAction(message, link) {
  let answer = confirm(message);
  if (answer == true) {
    if (link) {
      window.location.href = link;
    }
    return true;
  } else {
    return false;
  }
}

// 4. LOGIN FORM VALIDATION
function validateLogin() {
  var email = document.getElementById("email").value;
  var password = document.getElementById("password").value;
  var role = document.getElementById("role").value;

  if (email == "" || password == "" || role == "") {
    alert("Please fill all fields and select your role");
    return false;
  }
  return true;
}

// 5. REGISTER FORM VALIDATION
function validateRegister() {
  let fullname = document.getElementById("fullname").value;
  let email = document.getElementById("regEmail").value;
  let role = document.getElementById("role").value;
  let password = document.getElementById("regPassword").value;
  let confirmPassword = document.getElementById("confirmPassword").value;

  if (fullname == "") {
    alert("Please enter your full name");
    return false;
  }
  if (email == "" || email.includes("@") == false) {
    alert("Please enter a valid email");
    return false;
  }
  if (role == "") {
    alert("Please select your role: Teacher, Headteacher, Director, Secretary or Bursar");
    return false;
  }
  if (password.length < 6) {
    alert("Password must be at least 6 characters");
    return false;
  }
  if (password != confirmPassword) {
    alert("Passwords do not match");
    return false;
  }
  showPopup("Registration Successful! You can now login.");
  return false;
}

// 6. ADMISSION FORM VALIDATION (Secretary)
  function validateAdmission() {
    var childName = document.getElementById("childName").value.trim();
    var parentPhone = document.getElementById("parentPhone").value.trim();
    if (childName === "") {
      alert("Please enter the full name of the child.");
      return false;
    }
    if (parentPhone === "") {
      alert("Please enter the parent phone number.");
      return false;
    }
    return true;
  }

  function filterByClass() {
    var selectedClass = document.getElementById("className").value;
    if (selectedClass !== "") {
      console.log("Filtering by class: " + selectedClass);
    }
  }

  function printReport() {
    window.print();
  }

  function quickSearch() {
    var name = prompt("Enter child name to search:");
    if (name) {
      alert("Searching for: " + name);
    }
  }

// 7. SEARCH TABLE (For View Admissions, Fees Report)
function searchTable() {
  let input = document.getElementById("searchBox").value.toUpperCase();
  let table = document.getElementById("studentsTable");
  if (!table) return;
  let rows = table.getElementsByTagName("tr");

  for (let i = 1; i < rows.length; i++) {
    let rowText = rows[i].innerText.toUpperCase();
    if (rowText.includes(input)) {
      rows[i].style.display = "";
    } else {
      rows[i].style.display = "none";
    }
  }
}

// 8. FILTER BY CLASS
function filterByClass() {
  let selectedClass = document.getElementById("filterClass").value.toUpperCase();
  let table = document.getElementById("studentsTable");
  if (!table) return;
  let rows = table.getElementsByTagName("tr");

  for (let i = 1; i < rows.length; i++) {
    let classCell = rows[i].getElementsByTagName("td")[2];
    if (classCell) {
      let classText = classCell.innerText.toUpperCase();
      if (selectedClass == "ALL" || classText.includes(selectedClass)) {
        rows[i].style.display = "";
      } else {
        rows[i].style.display = "none";
      }
    }
  }
}

// 9. SHOW CURRENT DATE ON DASHBOARDS
function showDate() {
  let dateElement = document.getElementById("todayDate");
  if (dateElement) {
    let today = new Date();
    dateElement.innerText = today.toDateString();
  }
}
window.onload = showDate;

// 10. HIGHLIGHT ACTIVE LINK IN SIDEBAR
function highlightActiveLink() {
  let currentPage = window.location.pathname.split("/").pop();
  let links = document.querySelectorAll(".sidebar a");
  for (let i = 0; i < links.length; i++) {
    let linkPage = links[i].getAttribute("href");
    if (linkPage == currentPage) {
      links[i].style.backgroundColor = "#0b5ed7";
      links[i].style.color = "white";
    }
  }
}
window.addEventListener("load", highlightActiveLink);

// 11. PRINT REPORT (For Director and Bursar)
function printReport() {
  window.print();
}

// 12. QUICK SEARCH PROMPT (For Teacher to find child)
function quickSearch() {
  let name = prompt("Enter child name or admission number to search:");
  if (name != null && name != "") {
    alert("Searching for: " + name);
  }
}