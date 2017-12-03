<?php
namespace Backtheweb\Linguo\Command;

use Config;

use Illuminate\Console\Command;
use League\Flysystem\Exception;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class ConvertCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'linguo:convert {domain=default}';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Convert domain a po file to php array, use default as default domain';

    /**
     * Folders to seek for missing translations
     *
     * @var  array
     */

    protected $signature = 'linguo:convert {domain=default}';

    protected $sources = [];
    /**
     * Create a new command instance.
     *
     * @param \Illuminate\Config\Repository $configRepository
     */

    protected $potPathName = null;

    /**
     * @var string
     */
    protected $potFile  = null;

    /**
     * @var string
     */
    protected $i18nPath = null;

    /** @var array  */
    protected $locales = [];

    /**
     * @return int
     * @throws Exception
     */
    public function fire()
    {
        $this->sources     = Config::get('linguo.sources');
        $this->potPathName = Config::get('linguo.potPathName');
        $this->i18nPath    = Config::get('linguo.i18nPath');
        $this->locales     = Config::get('linguo.locales');

        $domain            = $this->argument('domain');

        if(!$this->locales){

            throw new Exception('Locales not defined on config');
        }

        foreach($this->locales as $locale){

            $base   = $this->i18nPath . '/' . $locale . '/';

            $poFile = $base .  $domain . '.po';
            $target = $base .  $domain . '.php';


            $po = \Gettext\Translations::fromPoFile($poFile);

            $po->toPoFile($poFile);

            // Build

            $po->setDomain($domain);
            \Gettext\Generators\PhpArray::toFile($po, $target);

            $msg = sprintf('<info>Done!</info> Build translations for %s %s', $po->count(), $locale);
            $this->line($msg);
        }

        return 0;
    }
}