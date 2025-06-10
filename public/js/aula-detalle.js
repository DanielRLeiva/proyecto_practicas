document.addEventListener('DOMContentLoaded', function () {
    const rolUsuario = document.body.dataset.role;  // Obtiene el rol del usuario desde el atributo data-role del body

    // Solo continuar si el usuario es admin o editor (tiene permisos)
    if (rolUsuario === 'admin' || rolUsuario === 'editor') {

        // Elementos del menú contextual para equipos
        const menuEquipo = document.getElementById('equipoContextMenu');
        const btnEditarEquipo = document.getElementById('equipoContextEdit');
        const btnDuplicarEquipo = document.getElementById('equipoContextDuplicate');
        const formularioEliminarEquipo = document.getElementById('equipoContextDeleteForm');

        // Si no es admin, oculta el botón/el formulario para eliminar equipos
        if (rolUsuario !== 'admin' && formularioEliminarEquipo) {
            formularioEliminarEquipo.style.display = 'none';
        }

        // Para cada fila de equipos, agrega evento click para mostrar menú contextual con opciones edit/duplicate/delete
        document.querySelectorAll('tbody tr.equipo-row').forEach(fila => {
            fila.addEventListener('click', function (evento) {
                const equipoId = this.dataset.id;
                const aulaId = menuEquipo.dataset.aulaId = this.dataset.aulaId;

                // Actualiza los enlaces y acción del formulario con el id correspondiente
                btnEditarEquipo.href = `/equipos/${equipoId}/edit/${aulaId}`;
                btnDuplicarEquipo.href = `/equipos/create/${aulaId}?duplicar=${equipoId}`;
                formularioEliminarEquipo.action = `/equipos/${equipoId}`;

                // Posiciona y muestra el menú contextual debajo de la fila clickeada
                const rect = evento.target.getBoundingClientRect();
                menuEquipo.style.top = `${window.scrollY + rect.bottom}px`;
                menuEquipo.style.left = `${rect.left}px`;
                menuEquipo.style.display = 'block';
            });
        });

        // Oculta menú contextual de equipos al hacer clic fuera del menú o fila
        document.addEventListener('click', function (evento) {
            if (!menuEquipo.contains(evento.target) && !evento.target.closest('tr.equipo-row')) {
                menuEquipo.style.display = 'none';
            }
        });

        // Elementos del menú contextual para materiales
        const menuMaterial = document.getElementById('materialContextMenu');
        const btnEditarMaterial = document.getElementById('materialContextEdit');
        const formularioEliminarMaterial = document.getElementById('materialContextDeleteForm');

        // Si no es admin, oculta el formulario para eliminar materiales
        if (rolUsuario !== 'admin' && formularioEliminarMaterial) {
            formularioEliminarMaterial.style.display = 'none';
        }

        // Evento click para filas de materiales, muestra menú contextual para editar o eliminar
        document.querySelectorAll('tr.material-row').forEach(fila => {
            fila.addEventListener('click', function (evento) {
                const materialId = this.dataset.id;
                const aulaId = menuMaterial.dataset.aulaId;

                btnEditarMaterial.href = `/materials/${materialId}/edit/${aulaId}`;
                formularioEliminarMaterial.action = `/materials/${materialId}`;

                // Posiciona y muestra menú contextual
                const rect = evento.target.getBoundingClientRect();
                menuMaterial.style.top = `${window.scrollY + rect.bottom}px`;
                menuMaterial.style.left = `${rect.left}px`;
                menuMaterial.style.display = 'block';
            });
        });

        // Oculta menú contextual de materiales al hacer clic fuera del menú o fila
        document.addEventListener('click', function (evento) {
            if (!menuMaterial.contains(evento.target) && !evento.target.closest('tr.material-row')) {
                menuMaterial.style.display = 'none';
            }
        });
    }
});
