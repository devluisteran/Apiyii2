# Aplicación Yii2

Aplicación web desarrollada en **Yii2** que consume la API pública [JSONPlaceholder](https://jsonplaceholder.typicode.com/users), filtra los usuarios cuyo correo electrónico termina en `.biz` y los muestra en una tabla interactiva con **Bootstrap 5** y **DataTables**. Incluye ordenamiento por nombre vía query string y manejo de errores tanto en backend como en frontend.

## Funcionalidades

- ✅ Consumo de API externa (`https://jsonplaceholder.typicode.com/users`)
- ✅ Filtro backend: solo usuarios con email que termine en `.biz`
- ✅ Interfaz responsiva con Bootstrap 5
- ✅ Tabla dinámica con DataTables (búsqueda, paginación, ordenamiento)
- ✅ Ordenamiento por nombre mediante query string (`?sort=asc` / `?sort=desc`)
- ✅ Manejo de errores (API caída, timeout, etc.) con mensajes amigables
- ✅ Estado vacío manejado (cuando no hay usuarios `.biz`)
- ✅ Arquitectura con Service Layer para consumo de API

---

##  Requisitos previos

- PHP 8.0 o superior
- [Composer](https://getcomposer.org/)
- Servidor web (Apache / Nginx) o PHP built-in server
- Git (opcional, para clonar)
- Navegador web moderno

---

##  Instalación

### 1. Clonar el repositorio
```bash
git clone https://github.com/devluisteran/Apiyii2.git
cd Apiyii2
```
### 2. Instalar dependencias con Composer
```bash
composer install
```
### 3. Ejecutar el servidor integrado de PHP 
```bash
php yii serve
```
## Uso
### Página principal de usuarios

· URL: http://localhost:8080/usuarios.php

Ordenamiento

Añade ?sort=asc o ?sort=desc a la URL de la vista para ordenar los usuarios por nombre alfabéticamente.

Ejemplo:

```
http://localhost:8080/usuarios.php?sort=asc
http://localhost:8080/usuarios.php?sort=desc
```
Endpoint API (JSON)

· GET http://localhost:8080/index.php?r=api/user/index
    Devuelve un JSON con la estructura:

```json
{
  "success": true,
  "data": [
    { "id": 1, "name": "Leanne Graham", "email": "Sincere@april.biz", "username": "Bret" },
    ...
  ]
}
```
## Detalles de implementación

### Backend (Yii2)

· Se creó un service (UserService) con dos métodos:
  · getUsersFromApi(): realiza la petición GET a la API externa y retorna el array de usuarios.
  · filterBizEmails($users): filtra aquellos cuyo email termina en .biz.
· El controlador ApiController usa el servicio, captura excepciones y devuelve siempre una respuesta JSON con success y data (o message en caso de error).

### Frontend

· Archivo usuarios.php independiente, sin necesidad de layout de Yii2, para simplificar.
· Uso de jQuery, Bootstrap 5 y DataTables desde CDN.
· Fetch a index.php?r=api/user/index, parseo de la respuesta y carga en DataTables.
· Lectura de window.location.search para obtener ?sort=asc/desc y establecer el orden inicial de la tabla.
· Manejo de errores: si la API falla, se muestra una alerta y un mensaje en la tabla.

---

### ⚠️ Manejo de errores

· Backend: Cualquier excepción (fallo de conexión, timeout, HTTP error) es capturada y se devuelve { "success": false, "message": "..." }.
· Frontend: Se verifica response.ok y result.success. Ante un error se muestra una alerta y la tabla muestra un mensaje en rojo.
· Estado vacío: Si después del filtro no hay usuarios con email .biz, DataTables muestra el mensaje "No hay datos disponibles en la tabla".

---

