const submitAllBtn = document.getElementById('submitTasks'); // Get the Submit All button
submitAllBtn.addEventListener('click', () => {
    const rows = tableBody.querySelectorAll('tr'); // Get all table rows
    const tasks = []; // Array to store task data

    rows.forEach(row => {
        const tds = row.querySelectorAll('td'); // Get all table cells in the row
        const task = {
            description: tds[1].textContent,
            project: tds[2].textContent,
            date: tds[3].textContent,
            start: tds[4].textContent,
            end: tds[5].textContent,
            hours: tds[6].textContent
        };
        tasks.push(task);
    });

    // Send tasks data to the server using fetch
    fetch('submit_all.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(tasks)
    })
    .then(response => response.json())
    .then(data => {
        console.log(data); // Handle server response
    })
    .catch(error => {
        console.error('Error:', error);
    });
});
