<?php

namespace Backtheweb\Linguo;

use Illuminate\Filesystem\Filesystem;

class FileLoader implements LoaderInterface
{
    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    /**
     * The default path for the loader.
     *
     * @var string
     */
    protected $path;

    /**
     * All of the namespace hints.
     *
     * @var array
     */
    protected $hints = [];

    /**
     * Create a new file loader instance.
     *
     * @param  \Illuminate\Filesystem\Filesystem  $files
     * @param  string  $path
     */
    public function __construct(Filesystem $files, $path)
    {
        $this->path  = $path;
        $this->files = $files;
    }

    /**
     * Load the messages for the given locale.
     *
     * @param  string  $locale
     * @param  string  $domain
     * @param  string  $namespace
     * @return array
     */
    public function load($locale, $domain, $namespace = null)
    {
        if (is_null($namespace) || $namespace == '*') {
            return $this->loadPath($this->path, $locale, $domain);
        }

        return $this->loadNamespaced($locale, $domain, $namespace);
    }

    /**
     * Load a namespaced translation group.
     *
     * @param  string  $locale
     * @param  string  $domain
     * @param  string  $namespace
     * @return array
     */
    protected function loadNamespaced($locale, $domain, $namespace)
    {
        if (isset($this->hints[$namespace])) {
            $lines = $this->loadPath($this->hints[$namespace], $locale, $domain);

            return $this->loadNamespaceOverrides($lines, $locale, $domain, $namespace);
        }

        return [];
    }

    /**
     * Load a local namespaced translation group for overrides.
     *
     * @param  array  $lines
     * @param  string  $locale
     * @param  string  $domain
     * @param  string  $namespace
     * @return array
     */
    protected function loadNamespaceOverrides(array $lines, $locale, $domain, $namespace)
    {
        $file = "{$this->path}/vendor/{$namespace}/{$locale}/{$domain}.php";

        if ($this->files->exists($file)) {
            return array_replace_recursive($lines, $this->files->getRequire($file));
        }

        return $lines;
    }

    /**
     * Load a locale from a given path.
     *
     * @param  string  $path
     * @param  string  $locale
     * @param  string  $domain
     * @return array
     */
    protected function loadPath($path, $locale, $domain)
    {
        $pathName = "{$path}/{$locale}/{$domain}.php";

        if ($this->files->exists($pathName)) {

            return $this->files->getRequire($pathName);

        } else {

            $lang = \Locale::getPrimaryLanguage($locale);

            $pathName = "{$path}/{$lang}/{$domain}.php";

            if ($this->files->exists($pathName)) {

                return $this->files->getRequire($pathName);
            }
        }

        return [];
    }


    /**
     * Add a new namespace to the loader.
     *
     * @param  string  $namespace
     * @param  string  $hint
     * @return void
     */
    public function addNamespace($namespace, $hint)
    {
        $this->hints[$namespace] = $hint;
    }
}
