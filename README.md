# Buscaminas-Servidor :bomb:


<a href="https://www.php.net" target="_blank" rel="noreferrer"> <img src="https://raw.githubusercontent.com/devicons/devicon/master/icons/php/php-original.svg" alt="php" width="40" height="40"/> </a> 
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

#### Archivo JSON
```json
{
    "idUsuario" : 1,
    "idParttida" : 101
}
```

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
  "password": "default123",
  "Personas": [
    {
      "email": "admin@example.com",
      "password": "admin123",
      "idUsuario": "",
      "nombre": "John Doe",
      "partidasJugadas": 10,
      "partidasGanadas": 5,
      "admin": 1
    }
  ]
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

****
# Estructura de la Base de Datos :memo:

+ Nombre de la base de datos -> _Buscaminas_
### Tabla persona

| idUsuario | password | nombre | email | partidasJugadas | partidasGanadas | admin |
| ----------|-----------|-------|-------|-------------|--------- | ------ |
| 1 | default123 | default | email@gmail.com | 1|1|0|

+ ``idUsuario`` -> Es auto incremental
+ ``admin`` -> 0 si es admin, 1 si no lo es

### Tabla Partida

| idPartida | idUsuario | tableroOculto | tableroJugador | finalizado |
|-----------|-----------|---------------|----------------|------------|
|1 | 1| [-,-,-] | [] | 0 |

+ ``idPartida`` -> Es auto incremental
+ ``idUsuario`` -> Clave foránea de la tabla Persona
+ ``finalizado`` -> 0 si la partida ha finalizado, 1 si no finalizó aún

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

------
# Ejercicio buscaminas

clase buscaminas
iniciartablero()
colocarminar(2)
generarpista()



verbo get para crear la partida
verbo port se juega con el