<?php

namespace Viviniko\Support\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Composer;
use Illuminate\Filesystem\Filesystem;

class CreateMigrationCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description;

    /**
     * @var string
     */
    protected $stub;

    /**
     * @var string
     */
    protected $migration;

    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    /**
     * @var \Illuminate\Support\Composer
     */
    protected $composer;

    /**
     * Create a new notifications table command instance.
     *
     * @param  \Illuminate\Filesystem\Filesystem  $files
     * @param  \Illuminate\Support\Composer    $composer
     */
    public function __construct(Filesystem $files, Composer $composer)
    {
        parent::__construct();

        $this->files = $files;
        $this->composer = $composer;
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $path = $this->laravel->databasePath().'/migrations';

        $fullPath = $this->laravel['migration.creator']->create($this->migration, $path);

        $this->files->put($fullPath, $this->files->get($this->stub));

        $this->info('Migration created successfully!');

        $this->composer->dumpAutoloads();
    }
}
