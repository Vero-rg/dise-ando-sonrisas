<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Identidad de la clínica
    |--------------------------------------------------------------------------
    |
    | Datos compartidos por la landing y el panel de administración.
    |
    */

    'name' => 'Diseñando Sonrisas',

    'tagline' => 'Ortodoncia y Odontopediatría',

    'dentist' => [
        'name' => 'Dra. Adriana Gómez',
        'credentials' => 'Cirujana Dentista · Ortodoncia · Odontopediatra',
    ],

    /*
    |--------------------------------------------------------------------------
    | Logotipos
    |--------------------------------------------------------------------------
    |
    | Rutas base dentro de /public. Se detecta automáticamente la extensión
    | (svg, png, webp, jpg, jpeg o avif). Si el archivo no existe, la interfaz
    | muestra el logotipo de texto como respaldo.
    |
    */

    'logos' => [
        'header' => 'images/mi-logo-principal',
        'footer' => 'images/mi-logo-blanco',
    ],

    'timezone' => 'America/Mexico_City',

    /*
    |--------------------------------------------------------------------------
    | Contacto
    |--------------------------------------------------------------------------
    |
    | El número de WhatsApp se guarda en formato internacional, sin signos ni
    | espacios, listo para construir enlaces https://wa.me/{numero}.
    |
    */

    'whatsapp' => '523328012102',

    'phones' => [
        ['label' => '33 2801 2102', 'number' => '3328012102'],
    ],

    'address' => [
        'line1' => 'Av. Valle de Atemajac 1704',
        'line2' => 'Jardines del Valle, 45138 Zapopan, Jal.',
        'reference' => 'Llega 10 minutos antes de tu cita para revisar tu expediente.',
    ],

    'map' => [
        'embed_url' => 'https://www.google.com/maps?q=Av.%20Valle%20de%20Atemajac%201704%2C%20Jardines%20del%20Valle%2C%2045138%20Zapopan%2C%20Jal.&output=embed',
        'link' => 'https://www.google.com/maps/search/?api=1&query=Av.%20Valle%20de%20Atemajac%201704%2C%20Jardines%20del%20Valle%2C%2045138%20Zapopan%2C%20Jal.',
    ],

];
