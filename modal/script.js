const openModalBtn = document.getElementById('openModal');
const modal = document.getElementById('myModal');
const closeModal = document.getElementsByClassName('close')[0];
const submitFormBtn = document.getElementById('submitForm');
const insertForm = document.getElementById('insertForm');
const tableBody = document.getElementById('tableBody'); // Added line
const deleteButtons = document.querySelectorAll('.deleteButton');


closeModal.addEventListener('click', () => {
    modal.style.display = 'none';
    // sessionStorage.setItem('modalState', 'closed');
});

window.addEventListener('click', (event) => {
    if (event.target === modal) {
        modal.style.display = 'block';
    }
});

// Existing code to open the modal and close the modal remains the same
openModalBtn.addEventListener('click', () => {
    modal.style.display = 'block';
    // sessionStorage.setItem('modalState', 'open');

    // Fetch data from the server and populate the table
    fetch('get_data.php') // Replace with the actual URL to fetch data
    .then(response => response.json())
    .then(data => {
        tableBody.innerHTML = ''; // Clear existing content
// Populate the table with fetched data
data.forEach(item => {
    const newRow = document.createElement('tr');
    newRow.innerHTML = `
        <td>${item.task_name}</td>
        <td>${item.project_name}</td>
        <td>${item.date}</td>
        <td>${item.start}</td>
        <td>${item.end}</td>
        <td>${item.hours}</td>
        <td>
            <a class="btn btn-sm btn-primary" href="submit_task.php?task_id=${item.timesheet_id}">Submit</a>
            <button class="btn btn-sm btn-danger" onclick="deleteTask(${item.timesheet_id})">Delete</button>
        </td>
    `; 

    tableBody.appendChild(newRow);
    document.getElementById("totalHours").innerHTML = item.total;
});

// Add table heading (thead)
const tableHead = document.createElement('thead');
tableHead.innerHTML = `
`;
tableBody.parentNode.insertBefore(tableHead, tableBody);
tableBody.parentNode.appendChild(tableFooter);
    })
    .catch(error => {
        console.error();
    });
});

submitFormBtn.addEventListener('click', () => {
    const formData = new FormData(insertForm);

    fetch('insert.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(result => {
        //console.log(); // You can display this message in the modal or handle it as needed
        
        if(typeof result.error !== 'undefined'){
            document.getElementById("alertMsg").innerHTML = '<div class="alert mt-2 text-center col-md-4 mx-auto alert-danger"><strong>'+ result.error+'</strong></div>' ;
        }else{
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td>${result.description}</td>
                <td>${result.project}</td>
                <td>${result.date}</td>
                <td>${result.start}</td>
                <td>${result.end}</td>
                <td>${result.hours}</td>
                <td><a class="btn btn-sm btn-primary" href="submit_task.php?task_id=${result.id}">Submit</a>
                <button class="btn btn-sm btn-danger" onclick="deleteTask (${result.id})">Delete</button></td>          
            `;
            document.getElementById("totalHours").innerHTML = result.total;
        
            tableBody.appendChild(newRow);
        }
        
        
        // Clear the form fields
        // refreshPage();
        preventDefault();

        insertForm.reset();
        
    })
    .catch(error => {
        console.error();
    });
});
function refreshPage() {
    location.reload();
}
function deleteTask (task_id){
    var url = 'delete_task.php?task_id='+ task_id; // Replace with the URL you want to request

    fetch(url)
    .then(function (response) {
        if (!response.ok) {
            // Handle the error if the response status is not ok (e.g., 404, 500, etc.)
            throw new Error('Network response was not ok');
        }
        
        return response.json(); // Parse the response body as JSON
    })
    .then(function (data) {
        // Handle the JSON data
        if(typeof data.success !== 'undefined'){
            document.getElementById("alertMsg").innerHTML = '<div class="alert alert-success"><strong>'+ data.success+'</strong></div>' ;
        }else{
            document.getElementById("alertMsg").innerHTML = '<div class="alert alert-danger"><strong>'+ data.error+'</strong></div>' ;
        }
        // Fetch data from the server and populate the table
        fetch('get_data.php') // Replace with the actual URL to fetch data
        .then(response => response.json())
        .then(data => {
            tableBody.innerHTML = ''; // Clear existing content
        // Populate the table with fetched data
        data.forEach(item => {
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td>${item.task_name}</td>
                <td>${item.project_name}</td>
                <td>${item.date}</td>
                <td>${item.start}</td>
                <td>${item.end}</td>
                <td>${item.hours}</td>
                <td>
                    <a class="btn btn-sm btn-primary" href="submit_task.php?task_id=${item.timesheet_id}">Submit</a>
                    <button class="btn btn-sm btn-danger" onclick="deleteTask(${item.timesheet_id})">Delete</button>
                </td>
            `; 

            tableBody.appendChild(newRow);
            document.getElementById("totalHours").innerHTML = item.total;
        });
            console.log(data);
        });
        });
    
    // fetch('delete_task.php', {
    //     method: 'GET',
    //     data: task_id
    // })
    // .then(response => response.json())
    // .then(result => {
    //     //console.log(); // You can display this message in the modal or handle it as needed
        
    //     if(result.success != ''){
    //         document.getElementById("alertMsg").innerHTML = '<div class="alert alert-success"><strong>'+ result.success+'</strong></div>' ;
    //     }else{
    //         document.getElementById("alertMsg").innerHTML = '<div class="alert alert-danger"><strong>'+ result.error+'</strong></div>' ;
    //     }
    // });
}




//================================================================================================================================================================================================




