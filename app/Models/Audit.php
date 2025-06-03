<?php

namespace App\Models;

use Carbon\Carbon;
use OwenIt\Auditing\Models\Audit as BaseAudit;


class Audit extends BaseAudit
{
    /**
     * Devuelve un arreglo de campos cambiados, con “old” y “new” formateados.
     * Ahora no usa getModified(), sino que compara directamente old_values y new_values.
     */
    public function getFormattedModifications(): array
    {
        if ($this->event !== 'updated') {
            return [];
        }

        $formatted = [];

        // Tomo todas las llaves que aparezcan en old_values o en new_values
        $oldArray = is_array($this->old_values) ? $this->old_values : [];
        $newArray = is_array($this->new_values) ? $this->new_values : [];

        $allKeys = array_unique(
            array_merge(
                array_keys($oldArray),
                array_keys($newArray)
            )
        );

        foreach ($allKeys as $field) {
            $oldRaw = $oldArray[$field] ?? null;
            $newRaw = $newArray[$field] ?? null;

            // Si son exactamente iguales (incluso ambos null), lo omito
            if ($oldRaw == $newRaw) {
                continue;
            }

            // Normalizar a texto (si viene array o null)
            $oldVal = (is_array($oldRaw) || $oldRaw === null) ? 'Sin dato' : $oldRaw;
            $newVal = (is_array($newRaw) || $newRaw === null) ? 'Sin dato' : $newRaw;

            // Formateo booleanos
            $formatBoolean = fn($val) =>
            $val === true || $val === 1 || $val === '1'
                ? 'Sí'
                : (($val === false || $val === 0 || $val === '0') ? 'No' : $val);

            $oldVal = $formatBoolean($oldVal);
            $newVal = $formatBoolean($newVal);

            // Si parece fecha “YYYY-MM-DD”, la convierto a “DD/MM/YYYY”
            $isDate = fn($val) => is_string($val) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $val);
            if ($oldVal !== 'Sin dato' && $isDate($oldVal)) {
                $oldVal = Carbon::parse($oldVal)->format('d/m/Y');
            }
            if ($newVal !== 'Sin dato' && $isDate($newVal)) {
                $newVal = Carbon::parse($newVal)->format('d/m/Y');
            }

            $formatted[] = [
                'field' => ucfirst(str_replace('_', ' ', $field)),
                'old'   => $oldVal ?: 'Sin dato',
                'new'   => $newVal ?: 'Sin dato',
            ];
        }

        return $formatted;
    }
}
