<?php
// groq_config.php
// La clave de Groq vive SOLO acá (servidor). No la subas a GitHub ni la pegues en el JavaScript.
return [
    'api_key'       => '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',   // crearla en console.groq.com > API Keys
    'model'         => 'openai/gpt-oss-20b',        // si Groq depreca el modelo, se cambia acá
    'require_login' => true,                        // true = solo usuarios con sesión válida pueden usar la IA
];
