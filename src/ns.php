<?php
require __DIR__ . '/vendor/autoload.php';

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputArgument;

$application = new Application();

$application->register('ns:command')
    ->setDescription('Crea un nuevo comando')
    ->addArgument('nombre', InputArgument::REQUIRED, 'Nombre del comando')
    ->setCode(function ($input, $output) {
        $nombre = $input->getArgument('nombre');

        $template = "<?php\n\n namespace App\\Command;\nuse Shell;\n\nclass {$nombre}Command extends Shell {\n    public function execute(array \$arguments) {\n        // Lógica del comando $nombre\n    }\n}\n";

        $directory = __DIR__ . "/src/app/Command";

        if (!is_dir($directory)) {
            mkdir($directory, 0777, true);
        }

        $fileName = $directory . "/{$nombre}Command.php";

        if (!file_exists($fileName)) {
            file_put_contents($fileName, $template);
            $output->writeln("<info>Archivo '$nombre.php' creado con éxito.</info>");

            // Crear los directorios source, process, ingest
            $subDirectories = ['source', 'process', 'ingest'];
            foreach ($subDirectories as $subDir) {
                $subDirPath = __DIR__ . "/src/app/{$subDir}";
                if (!is_dir($subDirPath)) {
                    mkdir($subDirPath, 0777, true);
                    $output->writeln("<info>Creado directorio '$subDir'.</info>");
                }
                $name = ucwords($subDir);

                $templateDir = "<?php\n\nnamespace app\\$subDir; \n\nclass $nombre$name {\n\n        // Lógica del comando $nombre$name \n\n\n}";

            
                $subDirFileName = "{$subDirPath}/$nombre$name.php";
                if (!file_exists($subDirFileName)) {
                    file_put_contents($subDirFileName,$templateDir );
                    $output->writeln("<info>Archivo '{$nombre}{$name}.php' creado en '$subDir'.</info>");
                } else {
                    $output->writeln("<comment>El archivo '{$nombre}{$name}.php' ya existe en '$subDir'.</comment>");
                }
            }
        } else {
            $output->writeln("<comment>El archivo '$nombre.php' ya existe.</comment>");
        }
    });

$application->run();
