const apiUrl = "/backend/crud/students.php";

const studentIDInput = document.getElementById("student_id");
const gmailInput = document.getElementById("gmail");
const statusInput = document.getElementById("status");
const studentHidden = document.getElementById("student_id_hidden");
const saveBtn = document.getElementById("saveBtn");
const clearBtn = document.getElementById("clearBtn");
const tableBody = document.querySelector("#studentsTable tbody");

async function fetchStudents(){
    const res = await fetch(apiUrl+"?action=read");
    const students = await res.json();
    tableBody.innerHTML = '';
    students.forEach(st => {
        const row = document.createElement("tr");
        row.innerHTML = `
            <td>${st.id}</td>
            <td>${st.student_id}</td>
            <td>${st.gmail}</td>
            <td>${st.status}</td>
            <td>
                <button onclick="editStudent(${st.id}, '${st.student_id}', '${st.gmail}', '${st.status}')">Edit</button>
                <button onclick="deleteStudent(${st.id})">Delete</button>
            </td>
        `;
        tableBody.appendChild(row);
    });
}

function editStudent(id, student_id, gmail, status){
    studentHidden.value = id;
    studentIDInput.value = student_id;
    gmailInput.value = gmail;
    statusInput.value = status;
    saveBtn.textContent = "Update";
}

function clearForm(){
    studentHidden.value = '';
    studentIDInput.value = '';
    gmailInput.value = '';
    statusInput.value = 'active';
    saveBtn.textContent = "Save";
}

async function deleteStudent(id){
    if(confirm("Are you sure you want to delete this student?")){
        await fetch(apiUrl+"?action=delete&id="+id);
        fetchStudents();
    }
}

studentIDInput.addEventListener("input", () => {
    studentIDInput.value = studentIDInput.value.toUpperCase();
  });
  

async function showError(msg) {
    alert(msg); // temporary (we’ll replace with modal/toast later)
  }

  saveBtn.addEventListener("click", async () => {
    const id = studentHidden.value;
  
    const payload = {
      student_id: studentIDInput.value,
      gmail: gmailInput.value,
      status: statusInput.value
    };
  
    const url = id
      ? apiUrl + "?action=update"
      : apiUrl + "?action=create";
  
    if (id) payload.id = id;
  
    const res = await fetch(url, {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(payload)
    });
  
    const data = await res.json();
  
    if (!res.ok) {
      showError(data.error || "Something went wrong");
      return;
    }
  
    clearForm();
    fetchStudents();
  });
clearBtn.addEventListener("click", clearForm);

// Initial load
fetchStudents();
