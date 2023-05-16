## Shortr - Accorciatore di url sviluppato in laravel

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

### Esempio di utilizzo
Quando si apre la applicazione viene fatto il redirect a Google, che funge da identity provider.
In seguito si atterra sulla pagina home dell'app, è possibile accorciare gli url, fornendo un link, e si riceve un link accorciato.
Infine è possibile distribuire questo link accorciato e monitorare le statistiche relative al tipo di browser, luogo, sistema operativo, ecc...

