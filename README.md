
✅ Este código lo pegas en tu `README.md` y se renderiza automáticamente en GitHub.

📎 Puedes usar otros tipos de diagramas también: `sequenceDiagram`, `classDiagram`, `stateDiagram`, etc.

---

### ✅ OPCIÓN 2: Usar una herramienta externa como **https://app.diagrams.net/** (Draw.io)

1. Crea tu diagrama (estructura MVC, peticiones, etc.).
2. **Exporta como imagen (.png o .svg)** o como código `XML`.
3. Guarda la imagen en tu repositorio (por ejemplo en `/docs/diagrama.png`).
4. En el `README.md` o donde quieras, incluyes la imagen:


```mermaid
flowchart TD
  %% Sección: Usuario y Dominio
  Usuario([👤 Usuario])
  Usuario -->|Solicita acceso| Dominio[🌐 portal_mdq.local]

  %% Sección: Vista principal
  Dominio -->|Carga vista inicial| LoginView[login.php]
  Dominio -->|Vista después de login| DashboardView[dashboard.php]

  %% Sección: JS y peticiones
  LoginView -->|Validación| LoginJS[funcion_login.js]
  DashboardView -->|Funcionalidad JS| DashboardJS[funcion_dashboard.js]

  %% Sección: Peticiones AJAX hacia controladores
  LoginJS -->|AJAX| LoginControlador[LoginControlador.php]
  DashboardJS -->|AJAX| DashboardControlador[DashboardControlador.php]

  %% Otras vistas que usan JS y hacen peticiones
  DashboardView --> SoporteView[soportes.php]
  DashboardView --> TrabajadoresView[trabajadores.php]
  DashboardView --> ProblemasView[problemas.php]
  DashboardView --> SubproblemasView[subproblemas.php]
  DashboardView --> RolesView[roles.php]

  %% Vistas a JS
  SoporteView --> SoporteJS[funcion_soporte.js]
  TrabajadoresView --> TrabajadoresJS[funcion_trabajadores.js]
  ProblemasView --> ProblemasJS[funcion_problemas.js]
  SubproblemasView --> SubproblemasJS[funcion_subproblemas.js]
  RolesView --> RolesJS[funcion_roles.js]

  %% JS a controladores
  SoporteJS --> SoporteControlador[SoportesControlador.php]
  TrabajadoresJS --> TrabajadoresControlador[TrabajadoresControlador.php]
  ProblemasJS --> ProblemasControlador[ProblemasControlador.php]
  SubproblemasJS --> SubproblemasControlador[SubproblemasControlador.php]
  RolesJS --> RolesControlador[RolesControlador.php]

  %% Controladores a modelos
  LoginControlador --> LoginModelo[LoginModelos.php]
  DashboardControlador --> DashboardModelo[DashboardModelos.php]
  SoporteControlador --> SoporteModelo[SoportesModelos.php]
  TrabajadoresControlador --> TrabajadoresModelo[TrabajadoresModelos.php]
  ProblemasControlador --> ProblemasModelo[ProblemasModelos.php]
  SubproblemasControlador --> SubproblemasModelo[SubproblemasModelos.php]
  RolesControlador --> RolesModelo[RolesModelos.php]

  %% Modelos y base de datos
  LoginModelo -->|Consulta/Inserta| BD[(🗃️ Base de Datos)]
  DashboardModelo -->|Consulta| BD
  SoporteModelo -->|Inserta/Consulta| BD
  TrabajadoresModelo -->|Consulta| BD
  ProblemasModelo -->|Consulta| BD
  SubproblemasModelo -->|Consulta| BD
  RolesModelo -->|Consulta| BD

  %% Regresos de datos
  BD --> LoginModelo
  BD --> DashboardModelo
  BD --> SoporteModelo
  BD --> TrabajadoresModelo
  BD --> ProblemasModelo
  BD --> SubproblemasModelo
  BD --> RolesModelo

  %% Flujo de regreso
  LoginModelo --> LoginControlador
  DashboardModelo --> DashboardControlador
  SoporteModelo --> SoporteControlador
  TrabajadoresModelo --> TrabajadoresControlador
  ProblemasModelo --> ProblemasControlador
  SubproblemasModelo --> SubproblemasControlador
  RolesModelo --> RolesControlador

  LoginControlador --> LoginJS
  DashboardControlador --> DashboardJS
  SoporteControlador --> SoporteJS
  TrabajadoresControlador --> TrabajadoresJS
  ProblemasControlador --> ProblemasJS
  SubproblemasControlador --> SubproblemasJS
  RolesControlador --> RolesJS

  LoginJS --> LoginView
  DashboardJS --> DashboardView
  SoporteJS --> SoporteView
  TrabajadoresJS --> TrabajadoresView
  ProblemasJS --> ProblemasView
  SubproblemasJS --> SubproblemasView
  RolesJS --> RolesView

```


🏛️ Municipalidad Distrital de Quilmaná
Proyecto desarrollado para mejorar la atención, registro y seguimiento del área de Informática, optimizando los tiempos de respuesta y la trazabilidad de incidencias.

📌 Créditos
Desarrollado por la Unidad de Informática – Municipalidad de Quilmaná
© 2025 – Todos los derechos reservados.