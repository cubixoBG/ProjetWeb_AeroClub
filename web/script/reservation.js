let currentUserId = null;

function closeModal() {
    document.getElementById('reservation-modal').style.display = "none";
}

async function openReservation(id, name, userId) {
    const modal = document.getElementById('reservation-modal');
    const body = document.getElementById('modal-body');
    if (!modal || !body) return;
    if (currentUserId === null) currentUserId = userId;

    modal.style.display = "block";

    if (!currentUserId) {
        showAuthForms(id, name);
    } else {
        showBookingForm(id, name);
    }
}

function showAuthForms(activiteId, activiteName) {
    const body = document.getElementById('modal-body');
    body.innerHTML = `
        <div class="auth-flex">
            <div class="auth-box">
                <h4>Connexion</h4>
                <form onsubmit="handleAuth(event, 'login', ${activiteId}, '${activiteName}')">
                    <input type="email" name="email" placeholder="Email" required>
                    <input type="password" name="mdp" placeholder="Mot de passe" required>
                    <button type="submit" class="btn-reserve">Se connecter</button>
                </form>
            </div>
            <hr>
            <div class="auth-box">
                <h4>Créer un compte</h4>
                <form onsubmit="handleAuth(event, 'register', ${activiteId}, '${activiteName}')">
                    <input type="text" name="name" placeholder="Prénom" required>
                    <input type="text" name="lastname" placeholder="Nom" required>
                    <input type="email" name="email" placeholder="Email" required>
                    <input type="password" name="mdp" placeholder="Mot de passe" required>
                    <button type="submit" class="btn-reserve">S'inscrire</button>
                </form>
            </div>
        </div>
        <div id="authMsg" style="margin-top:10px; font-weight:bold; color:red;"></div>
    `;
}

async function handleAuth(event, type, id, name) {
    event.preventDefault();
    const formData = new FormData(this);
    console.log("ID Activité envoyé :", formData.get('id_activite'));
    formData.append('action', type);

    const response = await fetch('api/api_reservation.php', {
        method: 'POST',
        body: formData
    });
    const result = await response.json();

    if (result.success) {
        if (type === 'login') {
            currentUserId = result.user_id;
            showBookingForm(id, name);
        } else {
            document.getElementById('authMsg').style.color = "green";
            document.getElementById('authMsg').innerText = result.message;
        }
    } else {
        document.getElementById('authMsg').innerText = result.message;
    }
}

function showBookingForm(id, name) {
    const body = document.getElementById('modal-body');
    body.innerHTML = `
        <h3>Réserver votre vol : ${name}</h3>
        <form id="resForm" style="margin-top:20px;">
            <input type="hidden" name="id_activite" value="${id}">
            <div style="margin-bottom:20px; text-align:left;">
                <label style="display:block; margin-bottom:8px; font-weight:bold;">Date et Heure du vol :</label>
                <input type="datetime-local" name="date_reservation" required 
                       min="${new Date().toISOString().slice(0, 16)}" 
                       style="width:100%; padding:12px; border:1px solid #ccc; border-radius:5px;">
            </div>
            <button type="submit" id="submitBtn" class="btn-reserve" style="width:100%;">Confirmer le vol ✈️</button>
            <div id="resMsg" style="margin-top:15px; font-weight:bold;"></div>
        </form>
    `;

    document.getElementById('resForm').onsubmit = async function (e) {
        e.preventDefault();
        const response = await fetch('api/api_reservation.php', {
            method: 'POST',
            body: new FormData(this)
        }); const result = await response.json();
        if (result.success) {
            currentUserId = result.user_id;
            alert("Connexion réussie !");
            window.location.reload();
        }
    };
}