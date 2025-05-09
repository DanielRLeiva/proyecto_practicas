document.addEventListener("DOMContentLoaded", function() {
    // Obtener los elementos de fecha de inicio y fecha de fin
    var fechaInicio = document.getElementById("fecha_inicio");
    var fechaFin = document.getElementById("fecha_fin");

    // Función para actualizar el valor mínimo de la fecha de fin
    function actualizarMinFechaFin() {
        var fechaInicioValor = fechaInicio.value;
        fechaFin.setAttribute("min", fechaInicioValor);
    }

    // Llamar a la función para establecer el mínimo de la fecha de fin al cargar la página
    if (fechaInicio.value) { // Solo actualiza si ya hay una fecha de inicio seleccionada
        actualizarMinFechaFin();
    }

    // Al cambiar la fecha de inicio, actualizar el mínimo de la fecha de fin
    fechaInicio.addEventListener("change", function() {
        actualizarMinFechaFin();
    });

    // Al cambiar la fecha de fin, asegurarse que no sea anterior a la fecha de inicio
    fechaFin.addEventListener("change", function() {
        var fechaFinValor = fechaFin.value;
        if (fechaFinValor < fechaInicio.value) {
            // Si la fecha de fin es menor que la de inicio, se puede alertar al usuario o restablecerla
            alert("La fecha de fin no puede ser anterior a la fecha de inicio.");
            fechaFin.value = ""; // Esto borra el valor seleccionado
        }
    });
});
