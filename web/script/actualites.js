function filterNews(event, year) {
    event.preventDefault();

    // 1. Gérer l'état visuel des boutons
    const buttons = document.querySelectorAll('.btn-archive');
    buttons.forEach(btn => btn.classList.remove('active'));
    event.currentTarget.classList.add('active');

    // 2. Filtrer les cartes
    const cards = document.querySelectorAll('.news-card');
    cards.forEach(card => {
        if (year === 'all' || card.getAttribute('data-year') === year) {
            card.style.display = 'flex'; // On affiche
        } else {
            card.style.display = 'none'; // On cache
        }
    });
}