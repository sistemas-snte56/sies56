# ¿Cuál es la idea principal o el problema central que busca resolver SIES56?

---

## El Problema

La Sección 56 del SNTE administra una estructura territorial compuesta por **11 regiones** y **246 delegaciones** distribuidas a lo largo del estado de Veracruz. Cada delegación agrupa a un número variable de integrantes cuya información personal, sindical, académica y laboral ha sido manejada históricamente de forma **fragmentada, manual y dispersa**.

Esta situación genera problemas concretos:

- Información desactualizada o incompleta por delegación
- Dificultad para consultar y cruzar datos entre regiones
- Imposibilidad de generar estadísticas confiables de forma ágil
- Procesos lentos que dependen de hojas de cálculo enviadas por correo o en físico
- Falta de control sobre quién accede, modifica o consulta la información

---

## La Idea Principal

**Centralizar y digitalizar el padrón sindical de la Sección 56 del SNTE** en una plataforma web moderna, segura y estructurada, que reemplace los procesos manuales actuales y se convierta en el punto único de gestión de la información sindical.

SIES56 no busca ser un simple directorio de integrantes. Su propósito es ser una **herramienta estratégica** que le permita a la Directiva Seccional tener acceso a información actualizada, confiable y segmentada, respetando en todo momento la jerarquía y estructura territorial de la organización.

---

## La Solución

Un sistema web con tres niveles de acceso bien definidos:

| Rol | Función principal |
|---|---|
| **Administrador General** | Control total del sistema, catálogos, usuarios y padrón completo |
| **Representante Regional** | Consulta de la información de su región y sus delegaciones |
| **Delegado** | Captura y actualización del padrón de su propia delegación |

Cada delegación podrá **importar su padrón desde un archivo Excel** estandarizado, agilizando la carga inicial de datos y las actualizaciones periódicas, con validación automática antes de integrar la información al sistema.

---

## En una sola frase

> SIES56 resuelve la fragmentación y desorganización del padrón sindical de la Sección 56 del SNTE, centralizando en una plataforma web moderna toda la información de sus integrantes, con acceso controlado por rol y estructura territorial.

# Especificación Técnica y Arquitectura de Negocio: Proyecto SIES56

## Contexto del Proyecto
Centralización, digitalización y administración del padrón sindical de la **Sección 56 del SNTE** en el estado de Veracruz (11 regiones, 246 delegaciones y más de 8,000 agremiados).

---

## 1. Arquitectura de Datos y Entidades Principales

### Modelo de Entidad Distribuida (Persona vs. Adscripción)
* **Entidad Persona (Registro Unificado Global):** Se identifica unívocamente por **CURP** o **RFC**.
  * **Atributos:** `apellido_paterno`, `apellido_materno`, `nombre`, `genero` (M, H), `telefono`, `email`, `rfc`, `curp`, `estatus_global`.
* **Entidad Adscripción Laboral (Pertenencia Delegacional):** Permite la **Doble Adscripción / Pluralidad Funcional** (ej. docente matutino en Secundaria y vespertino en Media Superior).
  * **Atributos:** `numero_personal`, `funcion` (`DIRECTIVO`, `DOCENTE`, `PAAE`), `fecha_ingreso`, `nivel_id`, `delegacion_id`, `estatus_adscripcion`.

### Integración de Usuarios en Sistema
* **Inexistencia de usuarios fantasma:** Todo usuario operativo (`users`) debe estar enlazado obligatoriamente a un registro existente en la tabla de integrantes (`integrante_id`).
* El **Administrador General** asigna correo y credenciales temporales al integrante promovido a un rol operativo.

---

## 2. Jerarquía de Roles y Matriz de Permisos

1. **Administrador General:** Control total sobre catálogos, usuarios, reasignaciones, revisión de solicitudes de baja y administración global del padrón.
2. **Coordinador (Auditor General):** Rol puramente **observador/auditor** (solo lectura). Acceso a logs, métricas e historial de movimientos regionales/delegacionales sin capacidad de edición ni autorización.
3. **Representante Regional:** Visibilidad y monitoreo exclusivo del padrón y reportes correspondientes a las delegaciones pertenecientes a su región asignada.
4. **Delegado:** Gestión operativa del padrón de su propia delegación (Carga masiva vía Excel, edición local de adscripciones, solicitudes de baja y reactivación directa de integrantes).

---

## 3. Reglas de Negocio y Ciclo de Vida del Agremiado

### A. Carga Masiva (Excel)
* **Criterio Transaccional ("Todo o Nada"):** Si el archivo contiene errores de formato, inconsistencias o datos duplicados inválidos, el sistema rechaza la totalidad de la carga y genera un reporte detallado de errores para corrección.
* **Integración de Existentes:** Al cargar un integrante ya existente (identificado por CURP/RFC), sus datos personales se actualizan automáticamente y se vincula la nueva adscripción a su perfil global.

### B. Gestión de Bajas (Soft Delete + Flujo de Aprobación)
1. **Solicitud por el Delegado:** El Delegado inicia la baja seleccionando el motivo (*Fallecimiento, Cambio de Sindicato, Cambio de Delegación, Retiro*, etc.).
2. **Estatus Transitorio:** El registro pasa inmediatamente a **"Pendiente de Autorización"**, manteniéndose visible en la delegación de origen únicamente bajo esa etiqueta transitoria.
3. **Autorización y Resolución por el Administrador General:**
   * **Bajas de Impacto Global** (*Fallecimiento, Cambio de Sindicato, Jubilación/Retiro*): Al ser autorizadas, cancelan de forma automática y en cascada **todas las adscripciones activas** del integrante en el sistema.
   * **Bajas de Impacto Local** (*Cambio de Delegación, Cambio de Nivel*): Al ser autorizadas, desactivan **únicamente la adscripción** de la delegación solicitante, manteniendo intactas sus demás adscripciones.
   * Una vez autorizada la baja, el integrante deja de figurar activamente en la delegación de origen.

### C. Reactivación / Reingreso
* **Ejecución Directa y Automática:** Un Delegado puede buscar a un integrante inactivo/dado de baja en la base de datos global utilizando su CURP/RFC. Al solicitar su reingreso o alta de nueva adscripción, el proceso se ejecuta de **forma automática y de efecto inmediato**, sin requerir autorización previa del Administrador General.

### D. Gobernanza de Catálogos
* Las Regiones (11), Delegaciones (246) y Niveles Educativos son catálogos protegidos administrados exclusivamente por el Administrador General mediante seeders y paneles centralizados.

---

## 4. Auditoría, Registro de Actividad y Reportes

* **Trazabilidad y Bitácora (Logs):** Registro detallado e inalterable de cada alta, modificación, solicitud de baja, aprobación, reactivación o cambio de adscripción, incluyendo usuario, fecha/hora y motivo.
* **Métricas y Tableros:**
  * Indicadores por Nivel Educativo y Función.
  * Consolidado de agremiados por Delegación y por Región.
  * Reportes de movilidad demográfica (bajas por retiro, traslados interdelegacionales, nuevos ingresos).
