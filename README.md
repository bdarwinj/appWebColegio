# Sistema Escolar - Laravel

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
   git clone <URL-del-repositorio>
   cd school-system
