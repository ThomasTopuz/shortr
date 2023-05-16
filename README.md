## Shortr - Accorciatore di url sviluppato in laravel
[![Laravel logo](https://embed-ssl.wistia.com/deliveries/fece433e54f817872309273fb46fe6e9.jpg "Shiprock, New Mexico by Beau Rogers")](https://embed-ssl.wistia.com/deliveries/fece433e54f817872309273fb46fe6e9.jpg)

### Obiettivi del progetto

### Gli obiettivi del progetto sono:
- creare un interfaccia semplice ed intuitiva per un applicazione che accorcia gli url
- utilizzare correttamente i design patterns del framework Laravel

### Nice to have
- sistema di autenticazione per avere una panoramica sui "miei url"
- analitiche sui dispositivi che visitano gli url privati

### Implementazione
Ho sviluppato una applicazione web che permette di accorciare gli url tramite un interfaccia semplice ed intuitiva,
gestendo l'autenticazione tramite il protocollo OpenId Connect utilizzando Google come Identity Provider.

### Librerire utilizzate
Oltre a laravel ho utilizzato le seguenti librerie
- sinergi/browser-detector per riconoscere il browser della richiesta, per le statistiche
- stevebauman/location per trovare la posizione geografica di una richiesta, sempre per le statistiche
- laravel/socialite per quanto rigurara l'autenticazione tramite protocollo openidconnect

### Esempio di utilizzo
Quando si apre la applicazione viene fatto il redirect a Google, che funge da identity provider.
In seguito si atterra sulla pagina home dell'app, è possibile accorciare gli url, fornendo un link, e si riceve un link accorciato.
Infine è possibile distribuire questo link accorciato e monitorare le statistiche relative al tipo di browser, posizione geografica e sistema operativo.

### Setup in locale
Per eseguire il progetto in locale è necessario seguire i seguenti step

Installare php, composer e laravel sul proprio ambiente

Clonare il progetto
```
git clone git@github.com:ThomasTopuz/shortr.git
```

Aggiungere un file .env seguedo l'esempio di .env.example

Eseguire il database locale ed il web server tramite docker docker compose
```
docker compose  up
```

Navigare sull'app all'indirizzo
```
localhost:8000
```
