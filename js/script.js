document.addEventListener('DOMContentLoaded', () => {
    //Show alerts
    var selectedRow = null;

    function showAlert(message, className){
        const div = document.createElement('div');
        div.className = `alert alert-${className}`;

        div.appendChild(document.createTextNode(message));
        const container = document.querySelector('.container');
        const main = document.querySelector('.main');
        container.insertBefore(div, main);

        setTimeout(() => document.querySelector('.alert').remove(), 3000);
    }

    //Clear all fields
    function clearFields(){
        document.querySelector('#firstName').value = '';
        document.querySelector('#lastName').value = '';
        document.querySelector('#rollNo').value = '';
    }

    // Function to load student data from the database
    function loadStudentData() {
        $.ajax({
        url: '../php/get_student.php',
        method: 'GET',
        success: function(response) {
            var students = JSON.parse(response);
            renderStudentTable(students);
        },
        error: function(xhr, status, error) {
            console.log('Error: ' + error);
        }
        });
    }

        // Function to render student table
    function renderStudentTable(students) {
        var studentTable = $('#student-list');
        studentTable.empty();
    
        if (students.length > 0) {
        students.forEach(function(student) {
            var row = $('<tr>');
            row.append($('<td>').text(student.firstName));
            row.append($('<td>').text(student.lastName));
            row.append($('<td>').text(student.rollNo));
            row.append($('<td>').html('<a href="#" class="btn btn-warning btn-sm edit">Edit</a> <a href="#" class="btn btn-danger btn-sm delete">Delete</a>'));
            studentTable.append(row);
        });
        } else {
        var row = $('<tr>');
        row.append($('<td colspan="4">').text('No students found.'));
        studentTable.append(row);
        }
    }
    
         // Call the loadStudentData function to fetch and render student data
        loadStudentData();

    //Add Data to database
    function addStudentToDatabase(firstName, lastName, rollNo){
        $.ajax({
            type: "POST",
            url: "..//php/add_student.php",
            data: {
                firstName: firstName,
                lastName: lastName,
                rollNo: rollNo
            },
            success: function(response){
                showAlert("Student Data Added", "success");
    },
    error: function(xhr, status, error){
        showAlert("Error adding student data", "danger");
            }
        });
    }

    //Add Data
    document.querySelector('#student-form').addEventListener('submit', (e) =>{
        e.preventDefault();

        //Get Form values
        const firstName = document.querySelector("#firstName").value;
        const lastName = document.querySelector("#lastName").value;
        const rollNo = document.querySelector("#rollNo").value;
        //validate
        if(firstName == "" || lastName == "" || rollNo == ""){
            showAlert("Please fill in all fields", "danger");
        }else{
            if(selectedRow == null){
                const list = document.querySelector("#student-list");
                const row = document.createElement("tr");
                row.innerHTML = `
                <td>${firstName}</td>
                <td>${lastName}</td>
                <td>${rollNo}</td>
                <td>
                <a href="#" class="btn btn-warning btn-sm edit">Edit</a>
                <a href="#" class="btn btn-danger btn-sm delete">Delete</a>
                
                `;
                list.appendChild(row);
                showAlert("Student Data Added", "success");

                //Add student data to database
                addStudentToDatabase(firstName, lastName, rollNo);
            }
            else{
                selectedRow.children[0].textContent = firstName;
                selectedRow.children[1].textContent = lastName;
                selectedRow.children[2].textContent = rollNo;
                selectedRow = null;

                //Update student data in the database
                addStudentToDatabase(firstName, lastName, rollNo);

                showAlert("Student Data Updated", "success");
            }
            clearFields();
        }
    });

    //Edit Data
    document.querySelector('#student-list').addEventListener('click', (e) => {
        target = e.target;
        if(target.classList.contains("edit")){
            selectedRow = target.parentElement.parentElement;
            document.querySelector("#firstName").value = selectedRow.children[0].textContent;
            document.querySelector("#lastName").value = selectedRow.children[1].textContent;
            document.querySelector("#rollNo").value = selectedRow.children[2].textContent;
        }else if(target.classList.contains("delete")){
            target.parentElement.parentElement.remove();

    //Delete student data from the database
        const firstName = target.parentElement.parentElement.children[0].textContent;
        const lastName = target.parentElement.parentElement.children[1].textContent;
        const rollNo = target.parentElement.parentElement.children[2].textContent;
        deleteStudentFromDatabase(firstName, lastName, rollNo);

        showAlert("Student Data Deleted", "danger");
            }
        });
    });