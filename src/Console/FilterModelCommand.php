<?php

namespace Miracuthbert\Filters\Console;

use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;

class FilterModelCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'filter:model';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new filter class for a model';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Filter model';

    /**
     * Execute the console command.
     *
     * @return mixed
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function handle()
    {
        parent::handle();

        $this->createFilterScope();
    }

    /**
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function createFilterScope()
    {
        $path = __DIR__ . '/stubs/filter-scope.stub';

        $stub = $this->files->get($path);

        $stub = str_replace(
            'DummyClass',
            '\\' . $this->qualifyClass($this->getNameInput()),
            $stub
        );

        $this->line('Copy lines below to the related model.');
        $this->line('---------------------------------------------');

        $this->warn($stub);

        $this->line('---------------------------------------------');
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/stubs/filter-model.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\\' . config('filters.namespace', 'filters');
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['force', null, InputOption::VALUE_NONE, 'Create the class even if the filter model already exists'],
        ];
    }
}
