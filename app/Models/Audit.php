<?php

namespace App\Models;

use Carbon\Carbon;
use OwenIt\Auditing\Models\Audit as BaseAudit;

class Audit extends BaseAudit
{
    /**
     * Devuelve un arreglo con los campos modificados, mostrando valores “old” y “new” formateados.
     * 
     * Nota: En lugar de usar getModified(), compara directamente old_values y new_values.
     */
    public function getFormattedModifications(): array
    {
        // Solo procesar si el evento fue una actualización
        if ($this->event !== 'updated') {
            return [];
        }

        $formatted = [];

        // Asegurar que old_values y new_values son arrays
        $oldArray = is_array($this->old_values) ? $this->old_values : [];
        $newArray = is_array($this->new_values) ? $this->new_values : [];

        // Obtener todas las claves presentes en old_values o new_values (evitar perder algún campo)
        $allKeys = array_unique(
            array_merge(
                array_keys($oldArray),
                array_keys($newArray)
            )
        );

        // Recorrer todas las claves para comparar valores antiguos y nuevos
        foreach ($allKeys as $field) {
            $oldRaw = $oldArray[$field] ?? null;
            $newRaw = $newArray[$field] ?? null;

            // Si son iguales (==) se omite (no hubo cambio)
            if ($oldRaw == $newRaw) {
                continue;
            }

            // Normalizar valores que pueden ser array o null a texto "Sin dato"
            $oldVal = (is_array($oldRaw) || $oldRaw === null) ? 'Sin dato' : $oldRaw;
            $newVal = (is_array($newRaw) || $newRaw === null) ? 'Sin dato' : $newRaw;

            // Formatear booleanos a texto legible ("Sí" o "No")
            $formatBoolean = fn($val) =>
            $val === true || $val === 1 || $val === '1'
                ? 'Sí'
                : (($val === false || $val === 0 || $val === '0') ? 'No' : $val);

            $oldVal = $formatBoolean($oldVal);
            $newVal = $formatBoolean($newVal);

            // Si el valor tiene formato de fecha "YYYY-MM-DD", convertir a "DD/MM/YYYY"
            $isDate = fn($val) => is_string($val) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $val);
            if ($oldVal !== 'Sin dato' && $isDate($oldVal)) {
                $oldVal = Carbon::parse($oldVal)->format('d/m/Y');
            }
            if ($newVal !== 'Sin dato' && $isDate($newVal)) {
                $newVal = Carbon::parse($newVal)->format('d/m/Y');
            }

            // Guardar la modificación formateada para mostrar
            $formatted[] = [
                // Capitalizar y reemplazar guiones bajos por espacios para mejor presentación
                'field' => ucfirst(str_replace('_', ' ', $field)),
                'old'   => $oldVal ?: 'Sin dato',
                'new'   => $newVal ?: 'Sin dato',
            ];
        }

        return $formatted;
    }
}
