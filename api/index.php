<?php
// Punto de entrada único para el runtime PHP de Vercel (vercel-community/php).
// Vercel enruta todas las peticiones aquí (ver vercel.json); delegamos al mismo
// front controller que se usa en desarrollo local bajo /public.
require __DIR__ . "/../public/index.php";
