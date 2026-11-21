
    document.getElementById('loginForm').addEventListener('submit', async (evento) => {
      evento.preventDefault();

      const avviso = document.getElementById('avviso');
      avviso.textContent = '';

      try {
        const risposta = await fetch('accedi.php', {
          method: 'POST',
          body: new FormData(evento.currentTarget),
          headers: {
            'X-Requested-With': 'XMLHttpRequest'
          }
        });

        const dati = await risposta.json();
        if (dati.redirect) {
          window.location.href = dati.redirect;
        } else {
          avviso.textContent = dati.testo;
          alert(dati.testo);
        }
      } catch (errore) {
        avviso.textContent = 'Errore di comunicazione.';
      }
    });
  
