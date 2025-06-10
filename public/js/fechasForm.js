document.addEventListener("DOMContentLoaded", function() {
    // Obtiene inputs de fecha de inicio y fin
    var fechaInicio = document.getElementById("fecha_inicio");
    var fechaFin = document.getElementById("fecha_fin");

    // Actualiza el atributo "min" de fechaFin para que no pueda ser anterior a fechaInicio
    function actualizarMinFechaFin() {
        var fechaInicioValor = fechaInicio.value;
        fechaFin.setAttribute("min", fechaInicioValor);
    }

    // Si ya hay fecha de inicio al cargar, ajusta el mínimo de fechaFin
    if (fechaInicio.value) {
        actualizarMinFechaFin();
    }

    // Cada vez que cambia fechaInicio, actualiza mínimo permitido para fechaFin
    fechaInicio.addEventListener("change", function() {
        actualizarMinFechaFin();
    });

    // Valida que fechaFin no sea anterior a fechaInicio, si pasa, alerta y borra valor
    fechaFin.addEventListener("change", function() {
        var fechaFinValor = fechaFin.value;
        if (fechaFinValor < fechaInicio.value) {
            alert("La fecha de fin no puede ser anterior a la fecha de inicio.");
            fechaFin.value = "";
        }
    });
});
