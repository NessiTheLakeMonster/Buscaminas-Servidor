# Buscaminas-Servidor :bomb:


<a href="https://www.php.net" target="_blank" rel="noreferrer"> <img src="https://raw.githubusercontent.com/devicons/devicon/master/icons/php/php-original.svg" alt="php" width="40" height="40"/> </a> 
 Desafío de Buscaminas realizado durante la asignatura de Desarrollo Web Entorno Servidor
 
 + Proyecto realizado por [Inés María Barrera Llerena](https://github.com/NessiTheLakeMonster)

****

# Manual para el usuario :computer:

Para lanzar el servidor bastará con el siguiente comando
```bash
php -S 127.0.0.1:9090  
```

### Creación de la partida
+ Ruta para partida personalizada -> ``http://ip:puerto/jugar/[Nº casillas]/[Nº de minas]`` con el verbo ``GET``
+ Ruta para partida por defecto -> ``http://ip:puerto/jugar/`` con el verbo ``GET``

Por defecto creará un tablero de 10 casillas con 2 minas.

Siempre se deberá iniciar sesión antes de crear la partida
```JSON
{
    "email" : "emailDefault@gmail.com",
    "password" : "default123"
}
```

### Jugar una partida seleccionada

Primeramente el usuario deberá entrar en una partida abierta y que además la partida le pertenezca.
+ Ruta -> ``http://ip:puerto/jugar/[idPartida]`` con el verbo ``POST``

Además se debe añadir el JSON donde el usuario inicia sesión y además dice que casilla va a destapar.
```JSON
{
    "email" : "emailDefault@gmail.com",
    "password" : "default123",
    "Casilla" : [numero de casilla que quieras destapar]
}
```

En caso de querer ser un cagao y rendirse, se deberá modificar la ruta 
+ Ruta -> ``http://ip:puerto/jugar/[idPartida]/rendirse`` con el verbo ``POST``

### Ver el ranking de las personas que han jugado
+ Ruta -> ``http://ip:puerto/ranking`` con el verbo ``GET``

****
# Manual para el administrador :closed_lock_with_key:

Para realizar las gestiones en modo administrador hay que iniciar sesión obligatoriamente en cada operación que se quiera realizar.
### Iniciar sesión

```JSON
{
    "email" : "emailDefault@gmail.com",
    "password" : "default123"
}
```

### Agregar usuarios
+ Ruta -> ``http://ip:puerto/admin`` con el verbo ``POST``

Estructura que se debe seguir para añadir un usuario a la base de datos
```JSON
{
  "email": "default@email.com",
  "password": "ines12",
  "Personas": {
    "idUsuario": "",
    "password": "testpassword",
    "nombre": "Test User",
    "email": "test@example.com",
    "partidasJugadas": 10,
    "partidasGanadas": 5,
    "admin": false
  }
}
```

### Listar usuarios
+ Ruta para listar todos los usuarios -> ``http://ip:puerto/admin/`` con el verbo ``GET``
+ Ruta para buscar un usuario concreto -> ``http://ip:puerto/admin/[idUsuario]`` con el verbo ``GET``

Estructura que se debe seguir, como es ``GET`` solo hace falta iniciar sesión
```JSON
{
    "email" : "emailDefault@gmail.com",
    "password" : "default123"
}
```

### Borrar usuarios
+ Ruta -> ``http://ip:puerto/admin/[idUsuario]`` con el verbo ``DELETE``

Estructura que se debe seguir, en este caso con ``DELETE`` solo hace falta iniciar sesión
```JSON
{
    "email" : "emailDefault@gmail.com",
    "password" : "default123"
}
```

### Modificar usuarios
+ Ruta -> ``http://ip:puerto/admin/[idUsuario]`` con el verbo ``PUT``
  
Estructura que se debe seguir, los dos primeros cambios es el usuario administrador que inicua sesión. Los demás campos pertencen a los datos que se van a actualizar del ususario el cual hemos especificado su ID en la ruta.
```JSON
{
  "email": "default@email.com",
  "password": "default123",
  "New password": "newpassword",
  "New nombre" : "nombrePrueba",
  "New email" : "email@email.nose",
  "New admin" : true
}
```
***

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

