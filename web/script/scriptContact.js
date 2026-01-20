document.getElementById('contactForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const form = this;
    
    fetch(form.action, {
        method: 'POST',
        body: new FormData(form),
        headers: {
            'Accept': 'application/json'
        }
    })
    .then(response => {
        if (response.ok) {
            // Show success message
            const successDiv = document.createElement('div');
            successDiv.className = 'alert alert-success';
            successDiv.textContent = 'Votre message a été envoyé avec succès! Nous revenons vers vous dès que possible.';
            form.parentNode.insertBefore(successDiv, form);
            
            // Reset form
            form.reset();
            
            // Scroll to success message
            successDiv.scrollIntoView({ behavior: 'smooth' });
        } else {
            throw new Error('Erreur lors de l\'envoi du formulaire');
        }
    })
    .catch(error => {
        const errorDiv = document.createElement('div');
        errorDiv.className = 'alert alert-error';
        errorDiv.textContent = 'Une erreur est survenue. Veuillez réessayer plus tard.';
        form.parentNode.insertBefore(errorDiv, form);
    });
});