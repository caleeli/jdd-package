<?php
// MAIN
$rename = new RenamePackage();
$vendor = inputParam(1, 'Vendor name: ');
$name = inputParam(2, 'Package name: ');
$description = inputParam(3, 'Description: ');
$icon = inputParam(4, 'Icon: ');

$rename->handle("{$vendor}/{$name}", $description, $icon);

function inputParam($index, $label)
{
    global $argv;
    if (empty($argv[$index])) {
        do {
            echo $label;
            $name = rtrim(fgets(STDIN, 1024));
        } while (!$name);
        return $name;
    } else {
        $value = rtrim($argv[$index]);
        if ($value === '__NAME__') {
            $value = basename(__DIR__);
        }
        return $value;
    }
}

// CLASS
class RenamePackage
{
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle($name, $description, $icon)
    {
        list($vendor, $package) = explode('/', $name);
        $vendor = $this->camel($vendor);
        $package = $this->camel($package);
        $namespace = "$vendor\\$package";
        $this->replace(__DIR__, 'JDD' . '\Example', $namespace);
        $this->replaceFile(__DIR__ . '/src/Console/Commands/UpdatePackage.php', 'example:jdd-update', str_replace('/', '-', $name) . ':jdd-update');
        $this->replaceFile(__DIR__ . '/src/PackageServiceProvider.php', 'jdd/example', $name);
        $this->replaceFile(__DIR__ . '/composer.json', 'JDD\\\\Example', "$vendor\\\\$package");
        $this->replaceFile(__DIR__ . '/vue.config.js', 'jdd/example', $name);
        $this->replaceFile(__DIR__ . '/package.json', 'jdd-example', $name);
        $composer = json_decode(file_get_contents(__DIR__ . '/composer.json'));
        $composer->name = $name;
        $composer->version = '0.1.0';
        !$description ?: $composer->description = $description;
        !$icon ?: $composer->extra->icon = $icon;
        file_put_contents(__DIR__ . '/composer.json', json_encode($composer, JSON_PRETTY_PRINT));
    }

    /**
     * Camelize $text
     *
     * @param string $text
     *
     * @return string
     */
    private function camel($text)
    {
        return preg_replace('/\W+/', '', preg_replace_callback('/\w+/', function ($m) {
            return ucfirst($m[0]);
        }, $text));
    }

    /**
     * Replace $find by $replace in a directory ($path)
     *
     * @param string $path
     * @param mixed $find
     * @param mixed $replace
     */
    private function replace($path, $find, $replace)
    {
        foreach (glob("$path/*") as $path1) {
            if ($path1 === __DIR__ . '/vendor' || $path1 === __DIR__ . '/node_modules') {
                continue;
            }
            if (is_dir($path1)) {
                $this->replace($path1, $find, $replace);
            } else {
                $this->replaceFile($path1, $find, $replace);
            }
        }
    }

    /**
     * Replace $find by $replace in a file ($path)
     *
     * @param string $path
     * @param mixed $find
     * @param mixed $replace
     */
    private function replaceFile($path, $find, $replace)
    {
        file_put_contents($path, str_replace($find, $replace, file_get_contents($path)));
    }
}
