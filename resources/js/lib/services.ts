import type { Component } from 'vue';
import { Baby, Crown, Smile, Stethoscope } from '@lucide/vue';

export const serviceIcons: Record<string, Component> = {
    Odontopediatría: Baby,
    Ortodoncia: Smile,
    'Odontología general': Stethoscope,
    Prótesis: Crown,
};

export const serviceDescriptions: Record<string, string> = {
    Odontopediatría:
        'Atención amable y especializada para las primeras sonrisas de la casa.',
    Ortodoncia:
        'Alineamos tus dientes y corregimos la mordida con brackets y alineadores.',
    'Odontología general':
        'Consultas, limpiezas y resinas para mantener tu boca sana.',
    Prótesis:
        'Recuperamos tu sonrisa con prótesis fijas, removibles y coronas.',
};

export const fallbackServiceIcon = Stethoscope;
