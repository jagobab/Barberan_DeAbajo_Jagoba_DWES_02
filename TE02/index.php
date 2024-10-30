<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jagoba Barberan TE</title>
</head>
<body>
    <form action="reserva.php" method="post">

        <label for="nombre">Nombre: </label>
        <input type="text" name="nombre" id="nombre" placeholder="Nombre...">

        <label for="apellido">Apellido: </label>
        <input type="text" name="apellido" id="apellido" placeholder="Apellido...">
       

        <label for="dni">DNI: </label>
        <input type="text" name="dni" id="dni" placeholder="DNI...">
        <br>

        <label for="modelo">Seleccione modelo: </label>
        <select name="modelo" id="modelo">
            <option value="Lancia Stratos">Lancia Stratos</option>
            <option value="Audi Quattro">Audi Quattro</option>
            <option value="Ford Escort RS1800">Ford Escort RS1800</option>
            <option value="Subaru Impreza 555">Subaru Impreza 555</option>
        </select>
        <br>

        <label for="fechaInicio">Fecha de inicio de alquiler: </label>
        <input type="date" name="fechaInicio" id="fechaInicio">

        <label for="duracion">Duracion del alquiler: </label>
        <input type="number" name="duracion" id="duracion">

        <input type="submit" value="Enviar Datos">
    </form>
</body>
</html>



