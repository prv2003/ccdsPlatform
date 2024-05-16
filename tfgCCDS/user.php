<?php
session_start();

if(!isset($_SESSION['email'])){
    header('Location:forms/centerLogin.php');
    exit();
}

$email = isset($_SESSION['email']) ? $_SESSION['email'] : $_SESSION['userData']['email'];

include 'db.php';

$stmtTeacher = $conexion->prepare("SELECT * FROM teacher WHERE email = ?");
$stmtTeacher->bind_param("s", $email);
$stmtTeacher->execute();
$resultadoTeacher = $stmtTeacher->get_result();
$fila = $resultadoTeacher->fetch_assoc();

$nombreUsuario = $fila['name'];
$passWord = $fila['pwd'];
$idCentro = $fila['center_id'];

$stmtCenter = $conexion->prepare("SELECT * FROM center WHERE center_id = ?");
$stmtCenter->bind_param("i", $idCentro);
$stmtCenter->execute();
$resultadoCentro = $stmtCenter->get_result();
$filaCentro = $resultadoCentro->fetch_assoc();

$nombreCentro = ($resultadoCentro->num_rows > 0) ? $filaCentro['name'] : 'Centro no encontrado';

$tiempoInactividad = 1800;

if (isset($_SESSION['ultima_actividad']) && (time() - $_SESSION['ultima_actividad']) > $tiempoInactividad) {
    session_unset();
    session_destroy();
    header("Location: forms/centerLogin.php");
    exit();
}

$_SESSION['ultima_actividad'] = time();


$texto = '';
if ($filaCentro['level'] == 'PLATINO') $texto = 'Con el fin de fomentar y reconocer el progreso continuo en los centros educativos, el programa de Centros Platino establece diversas condiciones de participación. Para demostrar un compromiso sólido con la mejora constante, se espera que cada centro desarrolle un Plan de Mejora, implemente innovaciones educativas y evidencie avances en indicadores clave.

Además, como parte de la participación activa en el programa, se requiere la asistencia a un mínimo de dos actividades programadas por DES. Estas actividades pueden incluir eventos destacados como el Día Europeo del Deporte Escolar, la Move Week, el Simposio Deporte, Educación y Salud, entre otros. La participación activa en estas iniciativas contribuirá al enriquecimiento del entorno educativo.

La búsqueda constante de la excelencia también implica involucrarse en proyectos de innovación. Cada centro platino debe participar en al menos un proyecto de innovación, contribuyendo así al avance y desarrollo del sistema educativo. Además, se espera un compromiso firme en la colaboración con la ONG Deporte para la Educación y la Salud, demostrando una responsabilidad social y contribuyendo al bienestar de la comunidad.

Los centros platino tendrán la oportunidad de estar informados sobre proyectos internacionales en curso, permitiéndoles participar en aquellos que sean de su interés. Sin embargo, para participar en proyectos financiados por la Comisión Europea, se requerirá obligatoriamente la firma de un convenio de colaboración conforme al modelo establecido por la Comisión Europea. Este convenio comprometerá al centro a cumplir con los requisitos de desarrollo y asistencia a reuniones, tanto nacionales como internacionales, establecidos por el cronograma del proyecto desde su inicio hasta su conclusión.

En resumen, la participación en el programa de Centros Platino no solo busca reconocer el esfuerzo continuo por la mejora educativa, sino también fomentar la participación en actividades, proyectos e iniciativas que enriquezcan la experiencia educativa y promuevan la colaboración a nivel nacional e internacional.' ;



elseif($filaCentro['level'] == 'ORO') $texto = 'El liderazgo en la Promoción de la Actividad Física y la Salud en el marco del Programa Colegios Comprometidos con el Deporte y la Salud se evidencia a través de diversas acciones que demuestran un compromiso destacado frente a otros centros, la comunidad local y las administraciones pertinentes.

En primer lugar, se espera que el centro ORO demuestre un liderazgo destacado al promover la Actividad Física y la Salud en comparación con otros centros educativos. Esto implica la implementación de iniciativas innovadoras, la creación de programas que fomenten un estilo de vida saludable y la colaboración activa con otras instituciones educativas.

La difusión de iniciativas internacionales, como la Declaración Global para la Actividad Física y el Plan de Acción Mundial para la Actividad Física, es fundamental para promover la conciencia global sobre la importancia de la Actividad Física y la Salud. El centro ORO debe realizar una difusión efectiva de estos documentos hacia otros grupos de interés más allá de la Comunidad Educativa, incluyendo la comunidad local y las administraciones relevantes.

La participación activa del máximo responsable de la organización en la promoción de la Actividad Física y la Salud se demuestra mediante la disponibilidad de vídeo(s) en los que participe, mostrando su compromiso personal con estas iniciativas. Esto puede involucrar a figuras como el Director General, Presidente, Director Titular o CEO.

Actuar como verificadores de otros centros implica evaluar la calidad de los contenidos y las iniciativas implementadas por otros centros. Un centro ORO debe realizar al menos una verificación anual a otro centro, elaborando informes detallados sobre la calidad de las prácticas relacionadas con la Actividad Física y la Salud.

Para los centros ORO, se espera un compromiso aún más elevado. Además de cumplir con las condiciones anteriores, deben realizar un mínimo de una verificación anual a otro centro, contribuyendo así a la mejora continua de la calidad de las iniciativas de promoción de la Actividad Física y la Salud en el ámbito educativo.

En la página web del centro, se debe evidenciar la participación en el Programa Colegios Comprometidos con el Deporte y la Salud, incluyendo el logo de acuerdo con las directivas de uso. Además, se espera que la institución publique información relativa a las actuaciones de promoción de la actividad física y la salud en secciones vinculadas a la web institucional.

Por último, se requiere que el centro disponga de un documento de Plan de liderazgo aprobado por la Dirección y presentado al Consejo Escolar, evidenciando así una estrategia planificada y respaldada a nivel institucional para liderar iniciativas de promoción de la Actividad Física y la Salud.' ;



elseif($filaCentro['level'] == 'PLATA') $texto = 'Los centros educativos con la distinción "Plata" en el Programa Colegios Comprometidos con el Deporte y la Salud se destacan por cumplir con una serie de requisitos que demuestran su liderazgo y progreso constante en la promoción de la actividad física y la salud. Estas instituciones deben comprometerse a:

Mantener un diálogo continuo con Grupos de Interés, asegurando una comunicación abierta y participativa. Asimismo, deben contar con un programa de "Deporte y Salud para todos" revisado y actualizado para adaptarse a las necesidades cambiantes de la comunidad educativa.

Establecer canales de comunicación efectivos que les permitan informar y sensibilizar a todos los grupos de interés, garantizando transparencia en sus iniciativas.

Implementar mediciones que les permitan evaluar y mostrar el nivel de consecución de objetivos del programa de Deporte y Salud en comparación con el curso anterior, promoviendo así la mejora continua y la rendición de cuentas.

Evidenciar un aumento significativo en la sensibilización hacia la práctica y promoción del Deporte y la Salud, tanto entre los profesores como en el Personal de Administración y Servicios (PAS).

Realizar campañas, eventos y proyectos dirigidos a alumnos, familias y otros grupos de interés para mejorar la concienciación sobre los beneficios del deporte y fomentar hábitos de vida saludables en la comunidad educativa.

Participar en el Moving Schools Challenger o, en caso de no participar, argumentar debidamente la elección de otras acciones de naturaleza similar, proporcionando resultados medibles.

Presentar una cartera de servicios integral que cubra aspectos de los cuatro ejes del modelo Actividad Física-Nutrición-Prevención sanitaria-Ocio saludable.

Disponer de una memoria detallada con conclusiones sobre el programa Colegios Comprometidos con el Deporte y la Salud, incluyendo información cuantitativa y cualitativa, gráficos, opiniones de grupos de interés y una valoración por parte del Equipo Directivo.

Informar regularmente al Consejo Escolar sobre el progreso del programa en el centro desde el curso anterior, alcanzando así el nivel bronce en el acta correspondiente.

Elaborar una ficha de buenas prácticas que documente y comparta experiencias exitosas en la promoción de la actividad física y la salud.';



else $texto = 'Los centros educativos distinguidos con la categoría "Bronce" en el Programa Colegios Comprometidos con el Deporte y la Salud asumen un papel proactivo en la promoción de un estilo de vida saludable, comprometiéndose con una serie de requisitos fundamentales.

Para comenzar, deben realizar un exhaustivo estudio de situación basado en los cuatro ejes de promoción de la Actividad Física y la Salud. Este análisis se complementa con la prioritización de necesidades mediante la herramienta de Autoevaluación anual proporcionada por la ONG, siendo esencial evidenciar estos procesos antes de enero de 2024.

Asimismo, se espera que los centros "Bronce" dispongan de un Mapa de Valores Educativos, Deportivos y de Salud coherente con su Proyecto Educativo de Centro, presentándolo antes de enero de 2024 como parte integral de su compromiso.

La planificación estratégica cobra relevancia con la elaboración de un Programa Marco de despliegue de la promoción de la Actividad Física y la Salud. Este programa deberá incluir objetivos y actuaciones claramente definidos, siendo necesario evidenciar su existencia antes de mayo de 2024.

Para llevar a cabo estos compromisos, se exige la formación de un Equipo de trabajo responsable del despliegue del Programa, compuesto por al menos dos personas y con la aprobación del Equipo Directivo, evidenciándose esta estructura antes de marzo de 2024.

Finalmente, el respaldo institucional se materializa en un Acta del Consejo Escolar, en la que se presentan los aspectos mencionados y se aprueba el desarrollo del Programa en el centro educativo. Este documento es esencial para la inclusión de las acciones planificadas dentro de la PGA 2024-25 y debe evidenciarse antes de mayo de 2024.

Estos requisitos subrayan el compromiso y la planificación integral de los centros "Bronce" en la implementación de programas que fomenten la Actividad Física y la Salud, demostrando así una dedicación estratégica y participativa de la comunidad educativa en este importante ámbito.';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interfaz de Usuario CCDS</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
            text-align: justify;
        }

        header {
            background-color: #333;
            color: #fff;
            padding: 15px;
            text-align: center;
        }

        nav {
            background-color: #444;
            color: #fff;
            padding: 10px;
            text-align: center;
        }

        section {
            display: flex;
            justify-content: space-between;
            padding: 20px;
        }

        article {
            flex: 2;
            margin-right: 20px;
        }

        aside {
            flex: 1;
        }
        table{
            margin: auto;
            width: 100%;
            height: 80%;
        }


        footer {
            background-color: #333;
            color: #fff;
            padding: 10px;
            text-align: center;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
        #centerLevels{
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .currentLevel {
            margin-bottom: 20px;
        }

        .completedLevels {
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            background-color: #007BFF;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .button:hover {
            background-color: #0056b3;
        }
        #misDatos{
            background-color: #fff;
            padding: 20px;
            margin-bottom: 100px;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }
        .general{
            background-color: lightgrey;
        }
    </style>
</head>
<body>
    <header>
        <h1>Interfaz Usuario de <?php echo $nombreUsuario;?></h1>
        <h2><?php echo $nombreCentro;?></h2>
    </header>
    
    <nav>
        <a href="#centerLevels" class="button">NIVELES</a>
        <a href="#verificaciones" class="button">VERIFICACIONES</a>
        <a href="#misDatos" class="button">MIS DATOS</a>
        <a href="pwdChange.php" class="button">CAMBIAR CONTRASEÑA</a>
        <a href="mailto:prv@educacondeporte.org" class="button">CONTÁCTANOS</a>
        <a href="logout.php" class="button">CERRAR SESIÓN</a>
        
    </nav>
    
    <section id="centerLevels">
        <article>
            <h2>Niveles del Centro:</h2>
            
            <div class="currentLevel">
                <h3>Nivel que se está cursando actualmente: <?php echo $filaCentro['level'];?></h3>
                <p>¿En que consiste este nivel?: <?php echo nl2br($texto);?></p>
            </div>

            <div class="completedLevels">
                <h3>Niveles Superados: <?php 
                if ($filaCentro['level'] == 'PLATINO') echo 'BRONCE, PLATA, ORO' ;
                elseif($filaCentro['level'] == 'ORO') echo 'BRONCE, PLATA' ;
                elseif($filaCentro['level'] == 'PLATA') echo 'BRONCE';
                else echo 'Aún no se han superado niveles';
                ?></h3>
            </div>
        </article>
    </section>
    <section id="verificaciones">
        <article>
            <h2>Verificaciones de Nivel:</h2>
            <?php if ($filaCentro['level'] == 'PLATINO') echo '<p>Tras superar el nivel Platino, no es necesario que se realice una verificación tradicional, sin embargo
            si habrá de poder probarse la participación en eventos y el cumplimiento de los requisitos del nivel Platino especificados anteriormente.</p>';?>

        </article>
    </section>
    <section id="misDatos">
    <article>
        <h2>Mis Datos:</h2>
        <table>
        <tr>
                <td class = 'general'><strong>DATOS DEL USUARIO</strong></td>
                <td class = 'general'></td>
            </tr>
            <tr>
                <td>Nombre Completo:</td>
                <td><?php echo $nombreUsuario; ?></td>
            </tr>
            <tr>
                <td>Correo electrónico:</td>
                <td><?php echo $email; ?></td>
            </tr>
            <tr>
                <td>Contraseña de acceso:</td>
                <td id='pwd'><strong><?php for ($i = 0; $i < mb_strlen($passWord, 'UTF-8'); $i++) echo '•'; ?></strong></td>
            </tr>
            <tr>
                <td class = 'general'><strong>DATOS DEL CENTRO</strong></td>
                <td class = 'general'></td>
            </tr>
            <tr>
                <td>Nombre del Centro:</td>
                <td><?php echo $nombreCentro; ?></td>
            </tr>
            <tr>
                <td>Localidad:</td>
                <td><?php echo $filaCentro['city']; ?></td>
            </tr>
        </table>
    </article>
    </section>
    <footer>
        <p>&copy; 2024 Deporte para la Educación y la Salud (DES) - Programa CCDS</p>
    </footer>
</body>
</html>
