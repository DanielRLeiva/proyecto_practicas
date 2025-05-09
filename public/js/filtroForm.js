document.getElementById("toggleFilterForm").addEventListener("click", function() {
    var form = document.getElementById("filterForm");
    if (form.style.display === "none") {
        form.style.display = "block";
    } else {
        form.style.display = "none";
    }
});

document.addEventListener("DOMContentLoaded", function() {
    // Obtener los elementos de fecha de inicio y fecha de fin
    var fechaInicio = document.getElementById("fecha_inicio");
    var fechaFin = document.getElementById("fecha_fin");

    // Al cambiar la fecha de inicio, actualizar el mínimo de la fecha de fin
    fechaInicio.addEventListener("change", function() {
        var fechaInicioValor = fechaInicio.value;
        // Establecer la fecha mínima de la fecha de fin igual a la fecha seleccionada en la de inicio
        fechaFin.setAttribute("min", fechaInicioValor);
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