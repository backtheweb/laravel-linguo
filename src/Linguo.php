<?php

namespace Backtheweb\Linguo;

use Symfony\Component\Translation\TranslatorInterface;

class Linguo implements TranslatorInterface
{
    /** @var \Gettext\Translator[]  */
    protected $translators = [];

    /** @var array  */
    protected $translations = [];

    /** @var FileLoader */
    protected $loader = null;

    /** @var string  */
    protected $locale = 'en';

    /** @var   */
    protected $fallback = 'en';

    /** @var string  */
    protected $domain = 'default';

    /** @var array  */
    protected $domains = [];

    /**
     * Linguo constructor.
     * @param LoaderInterface $loader
     * @param array $options
     */
    public function __construct(LoaderInterface $loader, Array $options = [] )
    {
        $this->loader = $loader;

        $this->setOptions($options);

        $this->getTranslator($this->locale);
    }

    public function setOptions(array $options) {

        $class_methods = get_class_methods($this);

        foreach ($options as $key => $value) {
            $method = 'set' . ucfirst($key);
            if(in_array($method, $class_methods)){
                $this->$method($value);
            }
        }

        return $this;
    }

    public function getTranslator($locale)
    {

        if(!isset($this->translators[$locale])){

            $this->translators[$locale] = new \Gettext\Translator();

            $this->loadDefaultDomain($locale);
            $this->loadDomains($locale);
        }

        return $this->translators[$locale];
    }

    /**
     * @param string $msgid
     * @param array $parameters
     * @param string $domain
     * @param null $locale
     * @return mixed|string
     */
    public function trans($msgid, array $parameters = array(), $domain = 'default', $locale = null)
    {
        if(null === $locale ){
            $locale = $this->locale;
        }

        $string = $this->getTranslator($locale)->dgettext($domain, $msgid);
        $string = strtr($string, $parameters);

        return $string;
    }

    public function transChoice($msgid, $number, array $parameters = array(), $domain = null, $locale = null)
    {
        throw new Exceptipon ('transchoice method is not supported');
    }

    /**
     * @param $msgid
     * @param $plural
     * @param int $count
     * @param array $args
     * @param string $domain
     * @param null $locale
     * @return mixed|string
     */
    public function plural($msgid, $plural, $count = 1, Array $args = [], $domain = 'default', $locale = null)
    {
        if(null === $locale ){
            $locale = $this->locale;
        }

        $string = $this->getTranslator($locale)->dngettext($domain, $msgid, $plural, $count);

        if($args){

            $string = strtr($string, $args);

        } else {

            $string = strtr($string, [':count' => $count]);
        }

        return $string;
    }

    public function loadDefaultDomain($locale){

        $this->loadDomain($this->domain, $locale);
    }

    public function loadDomains($locale)
    {
        foreach ($this->domains as $domain){
            $this->loadDomain($domain, $locale);
        }
    }

    public function loadDomain($domain, $locale)
    {

        if(!$this->loader){

            throw new Exception('Linguo file loader not initialized');
        }

        if(!isset($this->translations[$domain][$locale])){

            $this->translations[$domain][$locale] = $this->loader->load($locale, $domain);
        }

        $this->getTranslator($locale)->loadTranslations( $this->translations[$domain][$locale] );
    }

    /**
     * @param $fallback
     */
    public function setFallback($fallback)
    {
        $this->fallback = $fallback;
    }

    /**
     * @return FileLoader|LoaderInterface
     */
    public function getLoader()
    {
        return $this->loader;
    }

    /**
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * @param string $locale
     * @return Linguo
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;

        return $this;
    }

    /**
     * @return string
     */
    public function getDomain ()
    {
        return $this->domain;
    }

    /**
     * @param string $domain
     * @return Linguo
     */
    public function setDomain ($domain)
    {
        $this->domain = $domain;
        return $this;
    }

    /**
     * @return array
     */
    public function getDomains()
    {
        return $this->domains;
    }

    public function addDommain($domain)
    {
        $this->domains[] = $domain;
    }

    /**
     * @param array $domains
     * @return Linguo
     */
    public function setDomains (Array $domains = [])
    {
        $this->domains = $domains;
        return $this;
    }

}