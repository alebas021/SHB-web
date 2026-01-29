# Sitio Web para Surtihogar Basmadji, C.A

Este proyecto consiste en una página web informativa para un negocio, desarrollada como proyecto académico.

El sitio permite a los usuarios visualizar los productos disponibles, conocer información del negocio y acceder a medios de contacto.

##Tecnologías utilizadas
- HTML5
- CSS3
- PHP
- MySQL
- phpMyAdmin
- WAMP

##Estructura del proyecto
- `/` Contiene la parte pública del sitio web
- `/admin` Contiene el panel de administración
- `/imagenes` Almacena las imágenes de la web, y tambien la de los productos
- `SHBdb` Base de datos del proyecto

## Panel de administración
El sistema cuenta con un panel de administración protegido por inicio de sesión, el cual permite:
- Agregar productos
- Editar productos
- Eliminar productos

El acceso se realiza a través de la ruta:
/admin/index.php

## Base de datos
El proyecto utiliza una base de datos MySQL llamada **SHBdb**, que contiene tablas para:
- Administradores
- Productos
- Categorías

> Nota: Para fines académicos, las credenciales se gestionan directamente desde la base de datos.

## Observaciones
Este proyecto fue desarrollado con fines educativos y no está destinado a un entorno de producción.

Desarrollado por: Alejandro Basmadji
