<?php

namespace App\Support;

use Carbon\CarbonImmutable;
use Carbon\CarbonInterface;

/**
 * Horarios de atención y catálogo de servicios de la clínica.
 *
 * Es la única fuente de verdad para la agenda: la usan las validaciones del
 * backend y se comparte con el frontend para construir el calendario.
 */
final class AppointmentSchedule
{
    /** @var list<string> */
    public const SERVICES = [
        'Odontopediatría',
        'Ortodoncia',
        'Odontología general',
        'Prótesis',
    ];

    /**
     * Bloques de atención por día de la semana (0 = domingo).
     *
     * Cada día puede tener uno o varios turnos, por ejemplo mañana y tarde.
     *
     * @var array<int, list<array{0: int, 1: int}>>
     */
    public const OPENING_HOURS = [
        CarbonInterface::SUNDAY => [],
        CarbonInterface::MONDAY => [[10, 13], [16, 19]],
        CarbonInterface::TUESDAY => [[10, 13], [16, 19]],
        CarbonInterface::WEDNESDAY => [[10, 13], [16, 19]],
        CarbonInterface::THURSDAY => [[10, 13], [16, 19]],
        CarbonInterface::FRIDAY => [[16, 19]],
        CarbonInterface::SATURDAY => [[10, 13]],
    ];

    /**
     * Horarios disponibles (cada hora) para una fecha concreta.
     *
     * @return list<string>
     */
    public static function slotsFor(CarbonInterface $date): array
    {
        return self::weeklySlots()[$date->dayOfWeek] ?? [];
    }

    /**
     * Horarios disponibles agrupados por día de la semana.
     *
     * @return array<int, list<string>>
     */
    public static function weeklySlots(): array
    {
        $slots = [];

        foreach (self::OPENING_HOURS as $weekday => $ranges) {
            $slots[$weekday] = array_values(array_unique(array_merge(
                ...array_map(
                    static fn (array $range): array => self::hoursIn($range),
                    $ranges,
                ),
            )));

            sort($slots[$weekday]);
        }

        return $slots;
    }

    /**
     * Horarios de atención con etiquetas listas para mostrar.
     *
     * @return list<array{days: string, time: string, open: bool}>
     */
    public static function openingHours(): array
    {
        $weekdays = self::formatDay(CarbonInterface::MONDAY);
        $friday = self::formatDay(CarbonInterface::FRIDAY);
        $saturday = self::formatDay(CarbonInterface::SATURDAY);

        return [
            ['days' => 'Lunes a Jueves', 'time' => $weekdays, 'open' => $weekdays !== 'Cerrado'],
            ['days' => 'Viernes', 'time' => $friday, 'open' => $friday !== 'Cerrado'],
            ['days' => 'Sábados', 'time' => $saturday, 'open' => $saturday !== 'Cerrado'],
            ['days' => 'Domingos', 'time' => 'Cerrado', 'open' => false],
        ];
    }

    public static function today(): CarbonImmutable
    {
        return CarbonImmutable::now(self::timezone())->startOfDay();
    }

    public static function timezone(): string
    {
        return (string) config('clinic.timezone', 'America/Mexico_City');
    }

    /**
     * @param  array{0: int, 1: int}  $range
     * @return list<string>
     */
    private static function hoursIn(array $range): array
    {
        [$opens, $closes] = $range;

        return array_map(
            static fn (int $hour): string => sprintf('%02d:00', $hour),
            range($opens, $closes),
        );
    }

    /**
     * Horario de un día con sus turnos, listo para mostrar.
     */
    private static function formatDay(int $weekday): string
    {
        $ranges = self::OPENING_HOURS[$weekday] ?? [];

        if ($ranges === []) {
            return 'Cerrado';
        }

        return implode(' / ', array_map(
            static fn (array $range): string => sprintf('%02d:00 - %02d:00', $range[0], $range[1]),
            $ranges,
        ));
    }
}
