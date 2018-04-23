```
 _                      _                            _     _           
| |    ___   __ _    __| | ___    ___ __ _ _ __ ___ | |__ (_) ___  ___ 
| |   / _ \ / _` |  / _` |/ _ \  / __/ _` | '_ ` _ \| '_ \| |/ _ \/ __|
| |__| (_) | (_| | | (_| |  __/ | (_| (_| | | | | | | |_) | | (_) \__ \
|_____\___/ \__, |  \__,_|\___|  \___\__,_|_| |_| |_|_.__/|_|\___/|___/
            |___/ 
```
## Versión 18.4 (2018-04-22)
* Added: Actualizada la versión de ACE Editor de 1.2.6 a 1.3.3
* Added: Agregados administradores de Deshacer/Rehacer independientes por cada archivo cargado.
* Added: Agregadas opciones sobre el menú Edición para eventos de Deshacer y Rehacer
* Added: Agregada herramienta básica de minimap para la navegación rápida del código sobre su vista miniatura.  Por defecto deshabilitada por rendimiento en archivos grandes.
* Fixed: Eventos de deshacer y rehacer ahora no toman cambios globales de todos los archivos


## Versión 17.3 (2017-03-01)
* Added: Actualizada la versión de fotn-awesome a 4.7.0
* Added: Agregadas 8 extensiones extra para formatos de script SQL
* Added: Actualizada la versión de ACE Editor de 1.2.2 a 1.2.6
* Added: Se devuelve la funcionalidad del editor para Deshacer.  Tener presente que actúa sobre el marco general, no sobre cada archivo separado.


## Versión 16.4 (2016-04-17)
* Added: Herramienta para comparación de diferencias entre archivos abiertos (Diff) con temas visuales y de salida
* Added: Buscador de archivos remotos
* Added: Módulo genérico para visualizar diferencias (diff) entre archivos o cadenas
* Added: Ahora se permite activar o desactivar el autocompletado de código en caliente mientras se escribe
* Added: Actualización Font-Awesome 4.6.1
* Fixed: Eventos de deshacer y rehacer son ahora capturados desde el editor y sus opciones ocultas
* Enhan: La apertura de archivos y carpetas se hace ahora con doble clic.  Eso permite que sean seleccionados con un clic simple para aplicar operaciones de archivo sin necesidad de abrirlos previamente.
* Enhan: Mejorados detalles de las vistas Diff
* Enhan: Agregado acceso directo desde herramientas al visor de diferencias de archivos
* Enhan: Mejorados enlaces en las pestañas de herramientas superiores.  Se deja sólo el icono para ahorrar espacio en futuras herramientas.


## Versión 16.3 (2016-02-07)
* Added: Agregado acceso directo Ctrl+Q para cerrar el archivo actual
* Added: Agregado acceso directo Ctrl+O para apertura de archivos
* Added: Operaciones simples con archivos y carpetas (crear/eliminar/permisos/etc)
* Added: Validaciones durante almacenamiento para archivos sin permisos
* Added: Nueva opción del menu permite ver u ocultar los números de línea, widgets de plegado de código y errores de sintaxis
* Added: Se permite activar o desactivar en caliente el chequeo de sintaxis
* Added: Lista de selección en la barra de menu permite ahora cambiar el modo de resaltado de sintaxis de lenguaje en caliente
* Added: Soporte a lenguajes y archivos: Basic, URL, INF, DAT, ASP, ASP .Net, LOG, Archivos separados por coma (CSV), Plantillas XML (XSL), Windows Script File (WSF), Archivos léame (1ST,ME,NOW,README), ASI Doc (ANS), AutoDesk Export File (ASC), Fountain Script, Revisable Form Text Document (RFT), LaTeX Style (STY), Tabular Separated File (TAB), Lenguaje Forth (4TH), Ada specification files (ADS), Borland C++ MakeFile (BCP), Visual C# Script (CSX), Content Serve Template (CST), CakePHP Template (CTP), Delphi Form (DFM), BeanShell Script (BSH), Haskell Script (HAS), Literate Haskell Script (LHS,LIT), Lisp Program Source Code File (LSP), MarkDown (markdn), PL/I Source Code (PL1,PLI), PL/B Source File (PLC), Small Basic Project (SB), Source code (SRC), Swift Source Code File (SWIFT), Turbo C++ (TCC), Tk Script (TK)
* Added: Acceso directo en menu de herramientas al selector de colores
* Added: Acceso directo en menu de archivo a creacion de nuevos archivos
* Enhan: Mejorados enlaces en barra de menu para evitar barra de estado
* Enhan: Presentación de la consola remota y explorador web
* Enhan: Después de crear un archivo éste es abierto automáticamente
* Enhan: Mejora sobre JQueryFileTree.  Ahora se utiliza fork propio con más posibilidades
* Enhan: Ahora sólo son cargados para edición las extensiones de archivo conocidas como de texto
* Fixed: Algunas operaciones de visualización realizadas sobre el editor principal son ahora ejecutadas también sobre el editor clonado (split views)
* Fixed: Mejorada la detección del tipo de fichero por su extensión.  Algunos como Mush se podían confundir por ejemplo con los sh (por patrón similar)


## Versión 16.2 (2016-02-01)
* Added: Soporte a vistas clonadas del archivo horizontal y verticalmente 
* Added: Consola de comandos remota
* Added: Barra superior para agregar áreas de trabajo, editores y módulos adicionales
* Added: Utilidad para exploración de colores RGB
* Added: Utilidad de navegador embebido para facilitar revisión de sitios web desde el editor
* Enhan: Optimización y minimización de archivos JS y CSS
* Enhan: Mensaje de almacenamiento fugaz, ya no requiere ser cerrado por el usuario
* Enhan: Reescritura de funciones para cómputo de interfaz con mejora sustancial en rendimiento y apariencia
* Enhan: Rediseño y maquetación de todos los marcos del aplicativo para hacerlos más claros
* Enhan: Se previene el cierre accidental de la pestaña o ventana completa del editor
* Enhan: Mejorada la visualizacion del explorador de archivos
* Fixed: Mejoras en maquetación y cálculo dinámico de marcos
* Enhan: Actualizacion ACE version 1.2.2


## Versión 16.1 (2016-01-07)
* Added: Manejo de múltiples archivos en pestañas desde un solo editor!
* Added: Opciones de menu depuracion de archivos
* Added: Opciones de menu para enrollar o desenrollar porciones de codigo
* Added: Opciones de menu para manipular areas de texto seleccionadas
* Enhan: Mejorado explorador de archivos, ahora su carga se hace dinámicamente
* Enhan: Se simplifican los path de navegación de archivos y se permite navegar incluso a la raiz del disco duro
* Added: Ayudas de accesos directo de teclado en opciones de menú
* Added: Comandos de seleccionar todo y cerrar archivo en el menú superior
* Added: Indicadores de columna y fila actual en la barra de estado
* Fixed: Cálculos y aplicaicón de tamaños a objetos cuando se redimensiona ventana
* Fixed: Al cambiar entre archivos diferentes se recuerdan ubicaciones de cursor
* Enhan: Eliminación de librerías innecesarias
* Fixed: Archivo demo siempre es limpiado


## Versión 15.11.13 (2015-11-13)

* Added: Posibilidad de dos paneles dinamicos (izquierdo y derecho)
* Added: Se agrega por defecto la navegación de archivos al lado izquierdo del editor.
* Fixed: Opcion de salir en menu Archivo no cerraba la ventana
* Fixed: Estilos en ancho de editor cuando se ocultan paneles son aplicados ahora correctamente
* Enhan: Se cambia el tamaño predeterminado de apertura de archivo
* Enhan: Barra de estado muestra la ruta completa al archivo.
* Enhan: Disminuida la altura de la barra de menu con personalización de estilos
* Enhan: Reubicada la opcion de preferencias hacia el menu de Editar
* Enhan: Agregados archivos independientes para los marcos
* Enhan: Margenes de editor ajustadas para presentar errores del lenguage


## Versión 15.11 (2015-11-01)

* Added: Agregadas opciones de formato, caracteres invisibles y edicion sobre la barra de menu
* Added: Agregada prediccion de codigo y snippets
* Added: Agregada la deteccion de errores de sintaxis sobre el lenguaje utilizado
* Added: Inicio a soporte para cargar formatos de imagen
* Added: Posibilidad de pantalla completa
* Added: Opciones de aumentar o disminuir tamano de fuente
* Enhan: Actualizacion de la version de ACE
* Enhan: Eliminado el marco indicativo del limite de impresion
* Enhan: Barras de progreso en operaciones
* Enhan: Reorganizadas las opciones del menu


## Versión 15.10 (2015-10-06)

* Added: Combo de navegacion por sistema de archivos
* Added: La carga del arbol de archivos se hace por demanda
* Added: Soporte a idiomas Hindi, Portugues e Ingles
* Enhan: Velocidad de apertura


## Versión 15.9 (2015-10-03)

  * Primer lanzamiento oficial
    Adecuaciones desde el modulo original de Practico para crear una version StandAlone