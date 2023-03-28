// Temps avant rafraîchissement en secondes ----------------
var refresh_time = 300;

//-- fonction qui reset le timer ----------------
function resetTimer() {
    clearTimeout(timeOut);
    timeOut = setTimeout(redirectToLogout, refresh_time * 1000);
}

function redirectToLogout() {
    localStorage.setItem('errorSession', 'Votre session a expirée.')
    window.location.href = "src/deconnexion.php";
}

var timeOut = setTimeout(redirectToLogout, refresh_time * 1000);

//-- Réinitialise le timer à chaque action de l'utilisateur grâce à la fonction ----------------
$(document).on('click mousemove keypress', resetTimer);