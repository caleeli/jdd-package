<?php
// MAIN
$rename = new RenamePackage();
if ($argc !== 2 || empty($argv[1])) {
    die("ERROR: Expected\n" . '       php rename-package.php vendor/package');
}
$rename->handle($argv[1]);

// CLASS
class RenamePackage
{
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle($name)
    {
        list($vendor, $package) = explode('/', $name);
        $vendor = $this->camel($vendor);
        $package = $this->camel($package);
        $namespace = "$vendor\\$package";
        $this->replace(__DIR__, 'JDD' . '\Example', $namespace);
        $this->replaceFile(__DIR__ . '/src/Console/Commands/UpdatePackage.php', 'example:jdd-update', str_replace('/', '-', $name) . ':jdd-update');
        $this->replaceFile(__DIR__ . '/src/PackageServiceProvider.php', 'jdd/example', $name);
    }

    private function camel($text)
    {
        return preg_replace('/\W+/', '', preg_replace_callback('/\w+/', function ($m) {return ucfirst($m[0]);}, $text));
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
