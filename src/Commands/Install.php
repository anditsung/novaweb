<?php


namespace Tsung\Novaweb\Commands;


use Illuminate\Console\Command;
use Illuminate\Console\DetectsApplicationNamespace;
use Illuminate\Support\Str;

class Install extends Command
{
    use DetectsApplicationNamespace;

    protected $signature = "novaweb:install {--force}";

    protected $description = "Install novaweb";

    public function handle()
    {
        $this->pInfo("Installing Novaweb...");

        $this->novaInstall();
    }

    private function novaInstall()
    {
        $this->novaPublish();

        $this->updateWebRoute();

        $this->novaRegister();

        $this->spatiePublish();
    }

    private function novaPublish()
    {
        $this->novaAssets();
        $this->novaConfigPath();
        $this->novaLanguages();
        $this->novaViews();
        $this->call('view:clear');
    }

    private function novaRegister()
    {
        $this->novaProvider();
        $this->novaRegisterProvider();
        //$this->novaGenerateUserResource();
        $this->pInfo('Nova scaffolding installed successfully.');
    }

    private function novaProvider()
    {
        $this->pInfo("Publishing Nova Provider");
        $this->call('vendor:publish', ['--tag' => 'nova-provider', '--force' => $this->option('force')]);
        $this->pInfo("Done Publishing Nova Provider");
    }

    private function novaRegisterProvider()
    {
        $namespace = Str::replaceLast('\\', '', $this->getAppNamespace());

        $appConfigContent = file_get_contents(config_path('app.php'));
        if (strpos($appConfigContent, 'NovaServiceProvider') === false) {
            $appConfigContent = str_replace(
                "{$namespace}\\Providers\EventServiceProvider::class,".PHP_EOL,
                "{$namespace}\\Providers\EventServiceProvider::class,".PHP_EOL."        {$namespace}\Providers\NovaServiceProvider::class,".PHP_EOL,
                $appConfigContent);
            file_put_contents(config_path('app.php'), $appConfigContent);
        }
    }

    // tidak perlu diproses karena sudah termasuk dalam package
    private function novaGenerateUserResource()
    {
        $this->pInfo('Generating User Resource...');
        $this->callSilent('nova:resource', ['name' => 'User']);
        copy(base_path('/nova/src/Console/stubs/user-resource.stub'), app_path('Nova/User.php'));
        $this->pInfo("Done Generating User Resource");
    }

    private function novaAssets()
    {
        $this->pInfo("Publishing Nova Assets");
        $this->call('vendor:publish', [ '--tag' => 'nova-assets', '--force' => true]);
        $this->pInfo("Done Publishing Nova Assets");

        $this->pInfo("Publishing Novaweb Assets");
        $this->call('vendor:publish', ['--tag' => 'novaweb-assets', '--force' => true]);
        $this->pInfo("Done Publishing Novaweb Assets");
    }

    private function novaConfigPath()
    {
        $this->pInfo("Publishing Laravel Nova Config");
        $novaPathRegex = "/('path' => '\/).*(',)/i";

        // publish nova config and change the path for nova
        $this->call('vendor:publish', ['--tag' => 'nova-config', '--force' => $this->option('force')] );
        $this->pComment('Nova config published');
        $this->pComment('Changing Nova path');
        $novaConfigContent = file_get_contents(config_path('nova.php'));
        $pathName = $this->ask('nova path', 'nova');
        $novaPath = "'path' => '/" . $pathName . "',";
        $novaConfigContent = preg_replace($novaPathRegex, $novaPath, $novaConfigContent);
        file_put_contents(config_path('nova.php'), $novaConfigContent);
        $this->pComment("Nova path change to '{$pathName}'");
        $this->pInfo("Done Publishing Nova Config");
    }

    private function novaLanguages()
    {
        $this->pInfo("Publishing Nova Languages");
        $this->call('vendor:publish', [ '--tag' => 'nova-lang', '--force' => $this->option('force')]);
        $this->pInfo("Done Publishing Nova Languages");
    }

    private function novaViews()
    {
        $this->pInfo("Publishing Nova Views");
        $this->call('vendor:publish', [ '--tag' => 'nova-views', '--force' => $this->option('force')]);
        $this->pInfo('Done Publishing Nova Views');
    }

    private function updateWebRoute()
    {
        $this->pInfo('Updating Web Route');
        copy(__DIR__ . '/../Stubs/web.stub', base_path('/routes/web.php'));
        $this->pInfo("Done Updating Web Route");
    }

    private function spatiePublish()
    {
        $this->pInfo('Publishing Spatie Permission');
        $this->call('vendor:publish', [ '--provider' => "Spatie\Permission\PermissionServiceProvider"]);
        $this->pInfo("Done Publishing Spatie Permission");
    }

    private function pComment($message)
    {
        $this->comment("[+] {$message}");
    }

    private function pInfo($message)
    {
        $this->info("[*] {$message}");
    }
}