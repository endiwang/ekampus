<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class PageMakeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:page {module} {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scaffold module page';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $module = $this->argument('module');
        $name = $this->argument('name');

        $controllerClass = str($name)->studly().'Controller';
        $controllerName = str($module)->studly().'\\'.$controllerClass;
        $controllerPath = app_path('Http/Controllers/'.str($module)->studly().'/'.$controllerClass.'.php');
        $controllerNamespace = 'App\\Http\\Controllers\\'.$controllerName;

        $viewPath = base_path('resources/views/pages/'.str($module)->kebab()->lower().'/'.str($name)->kebab()->lower());
        $indexViewPath = $viewPath.'/index.blade.php';

        $headerPath = resource_path('views/layouts/master/header_menu.blade.php');

        $sidebarDirectory = resource_path('views/layouts/master/sidebar');
        $sidebarPath = $sidebarDirectory.'/'.str($module)->kebab()->lower().'.blade.php';

        $routePath = base_path('routes/web/'.str($module)->kebab()->lower().'.php');
        $routeName = str($name)->kebab()->lower();
        $uri = str($name)->kebab()->lower();

        // create controller
        $this->call('make:controller', [
            'name' => $controllerName,
            '--invokable' => true,
            '--quiet' => true,
            '--type' => 'index',
        ]);
        $controllerContent = file_get_contents($controllerPath);
        $controllerContent = str_replace([
            '{MODULE}', '{NAME}',
        ], [
            str($module)->kebab()->lower(), str($name)->kebab()->lower(),
        ], $controllerContent);
        file_put_contents($controllerPath, $controllerContent);

        $this->info('Created controller: '.$controllerName);

        // create index view
        if (! file_exists($indexViewPath)) {
            if (! file_exists($viewPath)) {
                mkdir($viewPath, 0755, true);
            }
            copy(base_path('stubs/page/index.blade.stub'), $indexViewPath);

            $this->info('Created view: '.$indexViewPath);
        }

        // create sidebar
        if (! file_exists($sidebarPath)) {
            copy(base_path('stubs/page/sidebar.stub'), $sidebarPath);
            $this->info('Created sidebar: '.$sidebarPath);
        }

        $mainViewPath = resource_path('views/layouts/master/main.blade.php');
        $mainViewPathContent = file_get_contents($mainViewPath);
        if (! str_contains($mainViewPathContent, strtolower($module).'.'.$routeName)) {
            $sidebarStubContentMenu = file_get_contents(base_path('stubs/page/sidebar-menu.stub'));
            $sidebarStubContentMenu = str_replace([
                '{MODULE}', '{ROUTE_NAME}',
            ], [
                str($module)->lower(), strtolower($module).'.'.$routeName,
            ], $sidebarStubContentMenu);

            $mainViewPathContent = str_replace([
                '{{-- sidebar menu --}}',
            ], [
                $sidebarStubContentMenu,
            ], $mainViewPathContent);

            file_put_contents($mainViewPath, $mainViewPathContent);

            $this->info('Updated main view: '.$mainViewPath);
        }

        $headerContent = file_get_contents($headerPath);

        if (! str_contains($headerContent, $routeName)) {
            $headerStubContent = file_get_contents(base_path('stubs/page/header-menu.stub'));
            $headerStubContent = str_replace([
                '{MODULE}', '{ROUTE_NAME}',
            ], [
                str($module)->headline(), strtolower($module).'.'.$routeName,
            ], $headerStubContent);
            $headerContent = str_replace([
                '{{-- header menu --}}',
            ], [
                $headerStubContent,
            ], $headerContent);
            file_put_contents($headerPath, $headerContent);
            $this->info('Updated header menu: '.$headerPath);
        }

        // create route
        if (! file_exists($routePath)) {
            $routeContent = file_get_contents(base_path('stubs/page/route.stub'));
            $routeContent = str_replace([
                '{MODULE}', '{URI}', '{CONTROLLER}', '{CONTROLLER_NAMESPACE}', '{ROUTE_NAME}',
            ], [
                strtolower($module), $uri, $controllerClass, $controllerNamespace, $routeName,
            ], $routeContent);
            file_put_contents($routePath, $routeContent);
            $this->info('Created route: '.$routePath);
        }

        return Command::SUCCESS;
    }
}
