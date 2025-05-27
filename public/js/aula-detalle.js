document.addEventListener('DOMContentLoaded', function () {
    const rolUsuario = document.body.dataset.role;

    // Solo continuar si el usuario tiene permisos (admin o editor)
    if (rolUsuario === 'admin' || rolUsuario === 'editor') {

        // Menú contextual para equipos
        const menuEquipo = document.getElementById('equipoContextMenu');
        const btnEditarEquipo = document.getElementById('equipoContextEdit');
        const btnDuplicarEquipo = document.getElementById('equipoContextDuplicate');
        const formularioEliminarEquipo = document.getElementById('equipoContextDeleteForm');

        // Si el usuario no es admin, ocultar el botón de eliminar
        if (rolUsuario !== 'admin' && formularioEliminarEquipo) {
            formularioEliminarEquipo.style.display = 'none';
        }

        document.querySelectorAll('tbody tr.equipo-row').forEach(fila => {
            fila.addEventListener('click', function (evento) {
                const equipoId = this.dataset.id;
                const aulaId = menuEquipo.dataset.aulaId = this.dataset.aulaId;

                btnEditarEquipo.href = `/equipos/${equipoId}/edit/${aulaId}`;
                btnDuplicarEquipo.href = `/equipos/create/${aulaId}?duplicar=${equipoId}`;
                formularioEliminarEquipo.action = `/equipos/${equipoId}`;

                const rect = evento.target.getBoundingClientRect();
                menuEquipo.style.top = `${window.scrollY + rect.bottom}px`;
                menuEquipo.style.left = `${rect.left}px`;
                menuEquipo.style.display = 'block';
            });
        });

        // Ocultar menú contextual de equipos si se hace clic fuera
        document.addEventListener('click', function (evento) {
            if (!menuEquipo.contains(evento.target) && !evento.target.closest('tr.equipo-row')) {
                menuEquipo.style.display = 'none';
            }
        });

        // Menú contextual para materiales
        const menuMaterial = document.getElementById('materialContextMenu');
        const btnEditarMaterial = document.getElementById('materialContextEdit');
        const formularioEliminarMaterial = document.getElementById('materialContextDeleteForm');

        if (rolUsuario !== 'admin' && formularioEliminarMaterial) {
            formularioEliminarMaterial.style.display = 'none';
        }

        document.querySelectorAll('tr.material-row').forEach(fila => {
            fila.addEventListener('click', function (evento) {
                const materialId = this.dataset.id;
                const aulaId = menuMaterial.dataset.aulaId;

                btnEditarMaterial.href = `/materials/${materialId}/edit/${aulaId}`;
                formularioEliminarMaterial.action = `/materials/${materialId}`;

                const rect = evento.target.getBoundingClientRect();
                menuMaterial.style.top = `${window.scrollY + rect.bottom}px`;
                menuMaterial.style.left = `${rect.left}px`;
                menuMaterial.style.display = 'block';
            });
        });

        // Ocultar menú contextual de materiales si se hace clic fuera
        document.addEventListener('click', function (evento) {
            if (!menuMaterial.contains(evento.target) && !evento.target.closest('tr.material-row')) {
                menuMaterial.style.display = 'none';
            }
        });
    }
});
