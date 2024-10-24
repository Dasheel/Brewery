<!DOCTYPE html>
<html>
<head>
    <title>Birrerie</title>
</head>
<body>
<h1>Lista delle Birrerie</h1>
<ul id="brewery-list"></ul>

<!-- Paginazione -->
<div id="pagination">
    <button id="prev-page">Precedente</button>
    <span id="current-page">Pagina 1</span>
    <button id="next-page">Successiva</button>
</div>

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
                        const li = document.createElement('li');
                        const name = brewery.name || 'Nome non disponibile';
                        const street = brewery.street || 'Via non disponibile';
                        const city = brewery.city || 'Città non disponibile';
                        const stateProvince = brewery.state_province || 'Provincia non disponibile';
                        const phone = brewery.phone || 'Telefono non disponibile';

                        li.textContent = `${name} - ${street}, ${city}, ${stateProvince} - ${phone}`;
                        breweryList.appendChild(li);
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
