<p align="center">
  <img src="https://ibb.co/vCJYT469" alt="Sistema de Pagos Escolar" />
</p>

<h1 align="center">Sistema Escolar - Laravel</h1>

Este proyecto es una aplicación de gestión escolar desarrollada con Laravel y MySQL. El sistema permite administrar estudiantes, cursos, inscripciones, pagos, mensualidades, usuarios y configuraciones generales del colegio. Además, se incluyen funcionalidades de exportación a PDF y Excel, backup y restauración de la base de datos, y un completo sistema de autenticación y gestión de usuarios.

## Características

- **Gestión de Estudiantes:**  
  - Registro, actualización e importación masiva (desde Excel).
  - Visualización detallada del historial de pagos.
  - Búsqueda y filtrado mediante DataTables.

- **Gestión de Cursos:**  
  - Administración de cursos con secciones y jornadas.
  - Edición y eliminación de cursos mediante ventanas modales.
  - Exportación de estudiantes por curso a PDF y Excel (hojas separadas por curso).

- **Inscripciones y Promoción:**  
  - Registro de inscripciones y promoción automática de estudiantes entre cursos.
  - Seguimiento del estado de inscripciones.

- **Pagos y Mensualidades:**  
  - Registro de pagos, con opción de seleccionar el periodo (mes) mediante nombres (Enero, Febrero, etc.) o dejarlo opcional.
  - Generación de recibos en PDF en orientación horizontal.
  - Cálculo del balance de mensualidades (considerando los meses transcurridos) y detección de mensualidades pendientes.
  - Visualización del estado de cuenta de mensualidades por estudiante y global mediante DataTables con carga asíncrona.

- **Gestión de Usuarios y Contraseñas:**  
  - Autenticación nativa con Laravel.
  - Cambio de contraseña personal y, para administradores, cambio de contraseña de otros usuarios.
  - El administrador puede eliminar usuarios desde el listado.

- **Backup y Restauración de la Base de Datos:**  
  - Funcionalidad para generar respaldos de la base de datos mediante mysqldump (usando Symfony Process para seguridad).
  - Restauración de la base de datos a partir de un archivo SQL.

- **Frontend Moderno:**  
  - Utiliza Bootstrap (CDN) para el diseño responsivo.
  - Select2 para campos de selección con búsqueda.
  - DataTables para una experiencia interactiva en tablas.

## Requisitos

- PHP ^8.1  
- Laravel Framework 10.x  
- MySQL  
- Composer  
- Node.js y npm (para compilar assets, si se utiliza Laravel Mix)

## Instalación

1. **Clonar el repositorio:**
   ```bash
   git clone [Repositorio](https://github.com/bdarwinj/appWebColegio.git)
   cd school-system
   ```
2. **Instalar dependencias:**
   ```bash
   composer install
   npm install
   npm run dev
   ```
3. **Configuración del entorno:**
   - Copiar el archivo `.env.example` a `.env`  
   - Configurar los parámetros de la base de datos y otros parámetros necesarios.
4. **Ejecutar migraciones y seeds:**
   ```bash
   php artisan migrate --seed
   ```

## Uso

**Acceso:**  
Inicia la aplicación en tu servidor local o en producción y accede a través de la URL configurada (por ejemplo, http://localhost).

**Dashboard:**  
El dashboard muestra un resumen general con estadísticas, información de cursos y alumnos por curso. Desde aquí, puedes acceder a las secciones de estudiantes, cursos, inscripciones, pagos, mensualidades y más.

**Gestión de Estudiantes y Cursos:**  
Desde el menú principal, puedes acceder a la lista de estudiantes y cursos. Los administradores tienen acceso a opciones de edición y eliminación a través de modales y botones.

**Pagos y Mensualidades:**  
- En la sección de pagos, se registra el pago con un campo de selección para el período en el que se muestra el nombre de los meses y se puede dejar opcional.  
- La sección de mensualidades permite configurar la tarifa de un curso y actualizarla automáticamente para todos los cursos con el mismo nombre (independientemente de la sección o jornada).  
- Se puede consultar el estado de cuenta de mensualidades, mostrando los estudiantes en mora, el total adeudado y el número de mensualidades pendientes.

**Exportación:**  
Se pueden exportar los datos de estudiantes a PDF (en orientación apaisada) y a Excel (con hojas separadas por curso y una hoja final con todos los estudiantes).

**Gestión de Usuarios:**  
Los administradores pueden cambiar contraseñas (propias y de otros usuarios) y eliminar usuarios.

**Backup y Restauración:**  
En la sección de configuración, los administradores pueden generar respaldos de la base de datos y restaurarlos desde un archivo SQL.

## Licencia

El uso, copia, modificación o distribución de este software requiere autorización previa y expresa del titular de los derechos. Queda prohibido utilizar el código de la aplicación sin permiso. Cualquier uso no autorizado será considerado una violación de los derechos de autor y estará sujeto a sanciones legales, incluyendo la obligación de indemnizar al titular de los derechos por los daños y perjuicios ocasionados.

Para solicitar autorización, contáctame a través de [bdarwinj@gmail.com].
