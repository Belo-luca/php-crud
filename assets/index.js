const signupModal = document.getElementById("signupModal");
const signupForm = document.getElementById("signupForm");
const signupPassword = document.getElementById("signup-password");
const signupPasswordRepeat = document.getElementById("signup-password-repeat");

// Verifica che le password siano uguali prima dell'invio.
signupForm.addEventListener("submit", function(event) {
    if (signupPassword.value !== signupPasswordRepeat.value) {
        event.preventDefault();
        alert("Le password non coincidono.");
    }
});

// Chiude il popup cliccando sullo sfondo.
window.addEventListener("click", function(event) {
    if (event.target === signupModal) {
        signupModal.style.display = "none";
    }
});