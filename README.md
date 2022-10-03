# qwentes

Clonare il progetto:
```
git clone git@github.com:fpiccolo/qwentes.git
```

Entrare nella directory del progetto:
```
cd qwentes
```

Inizializzare il progetto:
```
make init
```

Questo comando farà:
- la build delle immagini docker
- eseguirà il docker-compose up
- initializzerà il database
- eseguirà le migrations
- creerà il primo utente di default

L'utente di default avrà queste credenziali:
- email: `l.rossi@gmail.com`
- password: `Zaq12wsx%$`

Per creare un nuovo utente manualmente bisogna prima accedere al container con il comando `make sh` 
e una volta all'interno del container eseguire questo comando:
```
php bin/console.php user:create <givenName> <familyName> <email> <password>
```