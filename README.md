# Buscaminas-Servidor :bomb:


<a href="https://www.php.net" target="_blank" rel="noreferrer"> <img src="https://raw.githubusercontent.com/devicons/devicon/master/icons/php/php-original.svg" alt="php" width="40" height="40"/> </a> 
 <a href="https://laravel.com/" target="_blank" rel="noreferrer"> <img src="https://raw.githubusercontent.com/devicons/devicon/master/icons/laravel/laravel-plain-wordmark.svg" alt="laravel" width="40" height="40"/> </a>
 Desafío de Buscaminas realizado durante la asignatura de Desarrollo Web Entorno Servidor

# Manual para el usuario :computer:

Para lanzar el servidor bastará con el siguiente comando
```bash
php -S 127.0.0.1:9090  
```

### _Rutas que se van a utilizar_

+ Creación de partidas
+ Creación de usuarios
+ Iniciar sesión con tu usuario

****
# Manual para el administrador :closed_lock_with_key:

# Enunciado :books:

Vamos a realizar una aplicación WEB que permita gestionar partidas de buscamina. La aplicación guardará las partidas activas y el histórico de las partidas jugadas (hayan sido ganadas o perdidas); también se contabilizará la cantidad de partidas ganadas.
Asimismo la aplicación permitirá un sistema de gestión de usuarios accesible solo por los administradores.
Nuestra aplicación tendrá los siguientes roles: **administrador** y **jugador**.

### _Administrador_

El administrador gestionará: 
+ Altas
+ Bajas
+ Modificaciones
+ Activaciones 
+ Accesos de los usuarios. 

El administrador será otro jugador que podrá seleccionar como quiere acceder a la aplicación. 

Si accede como administrador podrá: 
+ Listar los usuarios 
+ Buscar un usuario concreto 
+ Registrar 
+ Modificar y eliminar usuarios 

También estará habilitado para cambiar la contraseña de un usuario concreto.
Si entra como jugador será un jugador más.

### _Jugador_

El jugador podrá crear partidas _personalizadas_ o _estándar_. <br>
Si en la url se especifica tamaño de tablero y minas se creará un buscaminas con esas características. 
```
ip:puerto/tamaño tablero/número de minas
```
En caso contrario se creará un buscaminas con un tamaño y número de minas predefinidos (esta cantidad deberá estar parametrizada en la clase de constantes de la aplicación).

El jugador jugará indicando **(POST + json)** qué casilla quiere destapar, el cliente le informará de lo que pueda ocurrir: 
+ No tienes partida creada
+ No tienes partida abierta
+ Partida abierta y has destapado una casilla no mina
+ Partida abierta y has destapado una mina… 

En caso de que no haya partida abierta se informa de ello. 

En caso de partida abierta se informa al cliente de ello y se le enviarán los tableros en json para que el cliente haga lo que estime oportuno con ellos.


El jugador podrá solicitar rendirse, (verbo y forma de proporcionar información al servidor depende del programador). Se cerrará esa partida y se informará al cliente de cómo estaban los tableros y de que se ha cerrado esa partida que se considera perdida.


El jugador también podrá solicitar un cambio de contraseña, para ello debe proporcionar su email al servidor (piensa el verbo y el modo más correcto de hacer esto).


Finalmente el jugador podrá solicitar el ranking de jugadores. Se le devolverá una lista de usuarios ordenada de mayor a menor de más ganadas a menos. De igual manera el verbo y la forma de solicitar el ranking depende del programador.

------
# Ejercicio buscaminas

clase buscaminas
iniciartablero()
colocarminar(2)
generarpista()



verbo get para crear la partida
verbo port se juega con el