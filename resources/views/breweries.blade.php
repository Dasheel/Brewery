<!DOCTYPE html>
<html lang="it">
<head>
    <title>Birrerie</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h1 class="text-center mb-4">Lista delle Birrerie</h1>

    <table class="table table-striped">
        <thead>
        <tr>
            <th>Nome</th>
            <th>Città</th>
            <th>Stato/Provincia</th>
            <th>Telefono</th>
            <th>Indirizzo</th>
            <th>Sito Internet</th>
        </tr>
        </thead>
        <tbody id="brewery-list">
        </tbody>
    </table>

    <div id="pagination" class="d-flex justify-content-between">
        <button id="prev-page" class="btn btn-outline-primary">Precedente</button>
        <span id="current-page" class="align-self-center">Pagina 1</span>
        <button id="next-page" class="btn btn-outline-primary">Successiva</button>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const accessToken = localStorage.getItem('access_token');
        if (!accessToken) {
            window.location.href = '/login';
            return;
        }

        let currentPage = 1;
        const perPage = 10;

        function fetchBreweries(page) {
            fetch(`/api/breweries-list?page=${page}&per_page=${perPage}`, {
                method: 'GET',
                headers: {
                    'Authorization': 'Bearer ' + accessToken,
                    'Accept': 'application/json',
                },
            })
                .then(response => {
                    if (response.ok) {
                        return response.json();
                    } else if (response.status === 401) {
                        localStorage.removeItem('access_token');
                        window.location.href = '/login';
                    } else {
                        throw new Error('Errore nella risposta del server.');
                    }
                })
                .then(data => {
                    const breweryList = document.getElementById('brewery-list');
                    breweryList.innerHTML = '';

                    data.data.forEach(brewery => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                        <td>${brewery.name || ''}</td>
                        <td>${brewery.city || ''}</td>
                        <td>${brewery.state_province || ''}</td>
                        <td>${brewery.phone || 'N/A'}</td>
                        <td>${brewery.street || ''}</td>
                        <td>${brewery.website_url || ''}</td>
                    `;
                        breweryList.appendChild(row);
                    });

                    document.getElementById('current-page').textContent = 'Pagina ' + currentPage;
                })
                .catch(error => {
                    console.error('Errore:', error);
                    alert('Si è verificato un errore durante il recupero delle birrerie.');
                });
        }

        document.getElementById('prev-page').addEventListener('click', function() {
            if (currentPage > 1) {
                currentPage--;
                fetchBreweries(currentPage);
            }
        });

        document.getElementById('next-page').addEventListener('click', function() {
            currentPage++;
            fetchBreweries(currentPage);
        });

        fetchBreweries(currentPage);
    });
</script>
</body>
</html>
