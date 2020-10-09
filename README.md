
# Como iniciar el proyecto.

  

1 - Descargar repositorio:https://github.com/BorjaGalisteo/tmh_login

2 - Ejecutar composer install para descargar las dependencias.

3 - Puedes arrancar el servidor propio de symfony en otro terminal con `symfony server:start`

4 - Crea la base de datos `php bin/console doctrine:database:create`

He utilizado SqLite para que no haga falta servidor.

4- Ejecutar las migrations  `php bin/console doctrine:migrations:migrate`

  
  

# ¿Cómo funciona?

  

## WEB

  

Una vez tengas iniciado el servidor puedes acceder a

[http://127.0.0.1:8000/](http://127.0.0.1:8000/)

  

Verás una casilla en la que habria que poner el numero del movil.

![](https://lh4.googleusercontent.com/PF7JMvGUSod63Bvyc3M_gkFyr9LkwBXzVOqyWc3QBjRg6uPcPyXdnZSiN_Mg1fX87D9xx12RA7Huhi5U15Arla467oSNHPShXq-_mjYPkrTnOWkn7kaTjGPJPkuJexKolU7a6wtX)

Al generar el código automáticamente aparece otro formulario relleno para que puedas verificar tu código.

![](https://lh3.googleusercontent.com/JWva8wqFph3YkPA8y6JJdX-ldTaeP_48nGF3eoglsWF1D6nC3M4qT37TcXHWL5P2U-aLWMKmOfpKXMdxI5mKFMthsWwOv72R_SjaGa4qKoxC2XLjiBvKIIaE6_TsxRcde9oclPeo)

Si pulsamos sobre CHECK code sabremos si el código es correcto o no.

![](https://lh5.googleusercontent.com/JUQ3CjJbvOnTgdcy70Ipb97tcvM8D9lsTRDUUojctfd1GtpwTpUWuufATebuPh4Lxe_Tsgmbgci_gWN9GdrMlwddBkeX7sfV3IpZUxWMEaQL-xDBCknzcmEfSXPq5JSJS4QXmq3o)

  

Si volvemos a pulsar sobre el botón, el código ya habrá sido usado por lo que no será un código válido.

![](https://lh6.googleusercontent.com/Dp23BlzIkWl4N7COuWnaGDPexoHJgDT5ogw81HtAYdMKf6ZDm31hQttp6jfSpAbGbyUueANill1e8tSvDGeKF58wk2Thgj3_p67pSfZ87PJoSRnvKhMYAzp2-JffeHRbV9V3VwfB)

  
  

Si esperamos más de 5 minutos, el código quedará invalidado.

  

Si utilizamos el código 0000 siempre podremos usarlo, es el codigo maestro.

![](https://lh4.googleusercontent.com/XP6yVSNvRqeUQRZkHhsL2E5LAR-pjDPyaFM1HzIgTmJGIW9Of2XM5h27j2_OGDdSixW3efkAlLHPMXB5CCb9G2pNNFTGXew6vDJ_SpC-NhGJED-NGZzkEZ8bYKBQfVe3TAAIRUZe)

  
  

## En consola.

  

Tenemos 2 comandos, ambos utilizan la misma API que la web, no se ha duplicado nada.

  

Para crear el código utilizamos, nos dará como output el codigo creado para nosotros.

`php bin/console code:generate 615359140`

![](https://lh4.googleusercontent.com/GrDQG4VA-CeYbOWa4BG9MlUmu6ywfEoeeqoZEa3nNIo23XWXyV6uSJovW6aJT-z8rpjAy0EYKXPCVYpiiI3dTH-Q_jbsAk03_LNdvfVJB0pXSW3xj9_JPUYQVNbI3XUm6_MkcGAh)

  

Para comprobar si nuestro código es correcto debemos utilizar el comando  
`php bin/console code:check 615359140 11b8`

  

Nos devolverá 1 en caso de OK y 0 en caso de KO

![](https://lh5.googleusercontent.com/QHhI-zaKfFJ2shYI7Y1XZTKcA1r16aIpnpyugc9HPFKBgh7g3sJ3z8fh9KvMHXHZsa93bnTC1CHew2lbS6WGq8y7yRlL0woHBozb7oblj2e55zMRLfwxEzdEh2H7uQq-vBYUgTik)

  
  
  

Test Unitarios

  

Se han realizado varios test unitarios, no tiene un coverage del 100%, he realizado diferentes tests en los que se puede ver la utilización de conceptos como mocks y dataproviders.

  

![](https://lh4.googleusercontent.com/KERERBi2oNvYISXF7ha1ecjiAnyk8YG2Yo68FBKpfLWkT3xAKzZt5RbKdOjyiD3e6v0qxpXRRqH9e96smR8E7YtdFGGje95SBBuytvjJy5R3LNAIR97cKnxCxwJ5XQI0p2Uy_PDd)

  
  

Documentación de la API

  

He realizado una colección de postman, por lo que solo haría falta añadirla y poder hacer pruebas con los 3 endpoints que he creado.

  

[https://www.getpostman.com/collections/ca54adfbe6a9eec7784f](https://www.getpostman.com/collections/ca54adfbe6a9eec7784f)

  

Posibles mejoras

  

Hay cositas que se podrían mejorar pero creo que con el código que hay puede verse la utilización de los principios SOLID, la arquitectura hexagonal y DDD.

  

Para mi gusto el CodeController acabó teniendo demasiadas dependencias inyectadas, quizás se podría haber separado en varios Controllers, pero no quería complicarme más.

  

El verificacion code master (0000) está commiteado en el código, cosa que a nivel de seguridad es un 0. Idealmente podriamos tenerlo en algún storage hasheado para consultarlo, pero de nuevo… no he querido dedicar tantísimo tiempo.

  

La parte de javascript para lo visual y demás soy consciente de que es basura de código pero simplemente está hecho para poder utilizar la API que es lo importante en la prueba.

  

La documentación acostumbro a utilizar Swagger para que se vaya generando a la par que programas, en esta ocasión o he querido invertir más tiempo, con la colección de postman tambien podemos hacer pruebas.

  

Acostumbro a mover la carpeta Controller dentro de Infrastructure pero en este caso lo he dejado en src para facilitar la compresion.

  

En los comandos existe una constante llamada SERVER para que si en caso de que el server:puerto levantado no sea el mismo se pueda cambiar. No es perfecto, pero ya es algo.
