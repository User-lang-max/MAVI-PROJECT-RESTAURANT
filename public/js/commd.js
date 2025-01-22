document.addEventListener('DOMContentLoaded', async () => {
    // Récupération des données depuis Symfony
    const response = await fetch('/orders/stats');
    const data = await response.json();

    // Configuration du graphique
    const ctx = document.getElementById('myChart').getContext('2d');
    new Chart(ctx, {
        type: 'line', // Type de graphique
        data: {
            labels: data.labels, // Meal types (Petit déjeuner, Déjeuner, Dîner)
            datasets: [{
                label: 'Nombre de commandes',
                data: data.counts, // Nombre de commandes par mealType
                borderColor: 'rgba(75, 192, 192, 1)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderWidth: 1,
            }],
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                },
            },
        },
    });
});
