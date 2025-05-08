<?php

namespace App\Models;

use Carbon\Carbon;
use OwenIt\Auditing\Models\Audit as BaseAudit;


class Audit extends BaseAudit
{
    public function getFormattedModifications(): array
    {
        if ($this->event !== 'updated') return [];

        $formatted = [];

        foreach ($this->getModified() as $field => $newValue) {
            $oldRaw = $this->old_values[$field] ?? null;
            $newRaw = is_array($newValue) && isset($newValue['new']) ? $newValue['new'] : $newValue;

            $oldRaw = is_array($oldRaw) || $oldRaw === null ? 'Sin dato' : $oldRaw;
            $newRaw = is_array($newRaw) || $newRaw === null ? 'Sin dato' : $newRaw;

            $formatBoolean = fn($val) => $val === true || $val === 1 || $val === '1' ? 'Sí' : ($val === false || $val === 0 || $val === '0' ? 'No' : $val);

            $oldVal = $formatBoolean($oldRaw);
            $newVal = $formatBoolean($newRaw);

            $isDate = fn($val) => is_string($val) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $val);
            if ($oldVal !== 'Sin dato' && $isDate($oldVal)) {
                $oldVal = Carbon::parse($oldVal)->format('d/m/Y');
            }
            if ($newVal !== 'Sin dato' && $isDate($newVal)) {
                $newVal = Carbon::parse($newVal)->format('d/m/Y');
            }

            $formatted[] = [
                'field' => ucfirst(str_replace('_', ' ', $field)),
                'old' => $oldVal ?: 'Sin dato',
                'new' => $newVal ?: 'Sin dato',
            ];
        }

        return $formatted;
    }
}
