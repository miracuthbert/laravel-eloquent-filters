<?php

namespace Miracuthbert\Filters\Console;

use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;

class FilterMakeCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'filter:make';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Eloquent filter class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Filter';

    /**
     * Build the class with the given name.
     *
     * @param  string $name
     * @return string
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function buildClass($name)
    {
        $stub = parent::buildClass($name);

        $column = $this->option('column');

        $relation = $this->option('relation');

        if ($relation) {
            $stub = $this->replaceRelation($stub, $relation);
        }

        return $column ? $this->replaceColumn($stub, $column) : $stub;
    }

    /**
     * Replace the "COLUMN_NAME" in template.
     *
     * @param string $stub
     * @param string $column
     * @return string
     */
    protected function replaceColumn($stub, $column)
    {
        return str_replace('COLUMN_NAME', $column, $stub);
    }

    /**
     * Replace the "RELATIONSHIP" in template.
     *
     * @param string $stub
     * @param string $relation
     * @return string
     */
    protected function replaceRelation($stub, $relation)
    {
        return str_replace('RELATIONSHIP', $relation, $stub);
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        if ($this->option('bool')) {
            return __DIR__ . '/stubs/bool.filter.stub';
        }

        if ($this->option('null')) {
            return __DIR__ . '/stubs/null.filter.stub';
        }

        if ($this->option('order')) {
            return __DIR__ . '/stubs/order.filter.stub';
        }

        if ($this->option('relation')) {
            return __DIR__ . '/stubs/relation.filter.stub';
        }

        return __DIR__ . '/stubs/filter.stub';
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
            ['column', null, InputOption::VALUE_OPTIONAL, 'Indicates the column the filter should be implemented on'],

            ['bool', null, InputOption::VALUE_NONE, 'Indicates if generated filter should be a boolean filter class'],

            ['null', null, InputOption::VALUE_NONE, 'Indicates if generated filter should be a null check filter class'],

            ['order', null, InputOption::VALUE_NONE, 'Indicates if generated filter should be an order filter class'],

            ['relation', null, InputOption::VALUE_OPTIONAL, 'Generate a filter class for the given relationship'],

            ['force', null, InputOption::VALUE_NONE, 'Create the class even if the filter already exists'],
        ];
    }
}
