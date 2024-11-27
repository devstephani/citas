- Roles: https://spatie.be/docs/laravel-permission/v6/installation-laravel
- Alerts: https://sweetalert2.github.io/
- Auth: Jetstream
- Livewire
- Calendar: https://github.com/omnia-digital/livewire-calendar
- Logs: https://github.com/jeremykenedy/laravel-logger

# TODO

- Revisar por que los modales se recargan cada segundo
- Bitácora (10$)
  - Observer?
- Alerts
  - Observer?
- Re-name (modules, views)

- Modal abre solo en empleados
- Revisar selección de servicio (name null)
- Actualizar servicio no coloca al empleado correcto
- Cliente realiza pago y admin confirma
- Añadir pago desde cliente, cuando se mande sea con el pago y el admin acepta o cancela (citas canceladas se muestran)
- Editar cliente
- Empleado*
- No carga la asistencia

- Registrar / editar empleado (añadir servicios)
- sistema de puntuación para servicios y paquetes

# DONE
----------------------------------------------------------------------------------------
✔ Facturacion (7$)
- Finalizada la cita, el empleado da concluido el servicio y se manda un email con: servicio, fecha, duracion, costo y estado de pagado
- Finalizada la cita, el admin da concluido el paquete y se manda un email con: servicio, fecha, duracion, costo y estado de pagado
----------------------------------------------------------------------------------------
✔ Calendario (25$)
- Registros de agendacion de servicios y paquetes
- Para el cliente, se muestran sus citas
- Para el empleado, se muestran sus citas
- Para el admin, se muestran todas las citas
- En una misma fecha pueden haber varias citas
- Un servicio puede estar citado varias veces el mismo dia
- Un paquete no puede estar citado a la misma hora de un servicio que lo contenga
- Un paquete puede estar citado varias veces el mismo dia
- Recordatorio via email a las 00 del dia y 1 hora antes del mismo
----------------------------------------------------------------------------------------
✔ Blog (20$)
- Titulo
- Fecha de creacion
- Contenido
  - Imagenes, texto, enlaces
- Comentarios
- Me gustas y no me gustas
- Acceso publico, interaccion autenticada
- Orden de carga: fecha de creado
- Inhabilitar
----------------------------------------------------------------------------------------
✔ Perfil (8$)
- Modificar datos básicos
 - Nombre, email, contraseña
- Recuperar contraseña
- Cambiar contraseña
----------------------------------------------------------------------------------------
✔ Usuario
- Formulario de registro
- Registro de clientes que vayan al local y no tengan cuenta
----------------------------------------------------------------------------------------
✔ Migrar todo el proyecto a laravel y liwewire - plantilla (20$)
- Autenticacion (admin, empleado, cliente)
- Roles
- Permisos
- Base de datos
----------------------------------------------------------------------------------------
✔ Formulario de servicios y paquetes (12$)
- Servicio
  - Nombre, precio, descripcion, imagen, activo, descuento (se aplica cada 4 servicios en el historial del cliente)
- Paquete
  - Nombre, precio, descripcion, lista de servicios, imagen, activo
----------------------------------------------------------------------------------------
✔ Empleado (17$)
- Nombre, email, contraseña
- Servicios que ofrece
----------------------------------------------------------------------------------------
✔ Reportes
- Asistencia de empleado (seleccionar empleado)
- Asistencia de todos los empleados
- Servicios y paquetes
  - Fecha | Clientes | Ingresos
- Usuarios
  - Fecha | Usuarios | Servicios | Paquetes
  - Fecha | Servicio o paquete | Costo
- Pagos
  - Fecha | Servicio o paquete | Empleado | Costo
----------------------------------------------------------------------------------------
  COSTE TOTAL: 109$ - Descuento a 85$
----------------------------------------------------------------------------------------

Admin:
- Registra servicios y paquetes
- Aceptar, cancelar, re-agendar citas
- Publicar en blog
- Inhabilitar servicios y paquetes
- Dar de baja a empleados
- Acceso a todos los reportes
- Puede borrar comentarios
- Registro de empleados y clientes
- Caso alterno, registra al cliente manual, selecciona el servicio o paquete, lo conecta con el cliente y anota el pago

Cliente:
- Agendar en calendario
 - Servicios y paquetes
 - Comprarlos
 - Enviar pago
   - Comentar servicios y paquetes
- Acceso al blog
- Acceso al probador

Empleado:
- Marca asistencia
- Reportes personales (asistencia y trabajos)
- Re-agendar mas no aceptar
- Publicar blog
- Agregar servicios y paquetes

Flujo del calendario:
1. Cliente verifica la disponibilidad
2. El admin la valida
3. Se le notifica al cliente de que puede agendar
4. Agenda y manda el pago
5. Admin verifica
6. Empleado recibe notificion

Plantillas
- Reportes
- Correo

Notificar recordatorio por correo