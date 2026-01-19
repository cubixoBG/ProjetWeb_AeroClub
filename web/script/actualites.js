    function filterNews(event, year) {

        event.preventDefault();
        const buttons = document.querySelectorAll('.btn-archive');
        buttons.forEach(btn => btn.classList.remove('active'));
        event.target.classList.add('active');

        // permet d'afficher ou de masquer les articles
        const articles = document.querySelectorAll('.news-card');
        
        articles.forEach(article => {
            // si l'article a la bonne année, on l'affiche (display: block)
            if (article.getAttribute('data-year') === year) {
                article.style.display = 'block';
                
                // Petite animation d'apparition (optionnel mais joli)
                article.style.opacity = '0';
                setTimeout(() => article.style.opacity = '1', 50);
            } else {
                // Sinon on le cache
                article.style.display = 'none';
            }
        });
        document.addEventListener("DOMContentLoaded", function() {
    filterNews(null, '2009');
});
}

    