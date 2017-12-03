<?php
namespace Backtheweb\Linguo\Twig;

use Twig_Extension;
use Twig_SimpleFilter;
use Twig_SimpleFunction;
//use Illuminate\Translation\Translator;

use Backtheweb\Linguo\Translator;
use Backtheweb\Linguo\LoaderInterface;
use Backtheweb\Linguo\FileLoader;

class LinguoI18nExtension extends Twig_Extension
{
    /**
     * @var \Backtheweb\Linguo\Translator
     */
    protected $translator;

    /**
     * Create a new translator extension
     *
     * @param \Backtheweb\Linguo\Translator
     */
    public function __construct()
    {
        //$this->translator = $translator;
    }

    public function getName()
    {
        return 'twigLinguoTranslator';
    }


    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('numberFormat',   [$this, 'number' ],  ['is_safe' => ['html']]),
            new \Twig_SimpleFilter('currency',       [$this, 'currency'], ['is_safe' => ['html']]),
        );
    }

    public function getFunctions(){
        return array(
            new \Twig_SimpleFunction('__',  [$this, 'trans'],    ['is_safe' => ['html']]),
            new \Twig_SimpleFunction('_x',  [$this, 'trans'],    ['is_safe' => ['html']]),
            new \Twig_SimpleFunction('n__', [$this, 'plural'],   ['is_safe' => ['html']]),
        );
    }

    public function number($value, $locale = null)
    {
        $locale = $locale === null ? \App::getLocale() : $locale;
        $a      = new \NumberFormatter($locale, \NumberFormatter::DECIMAL);

        return $a->format($value);
    }

    public function currency($value, $currency = 'EUR', $locale = null, $round = true){

        if(!is_numeric($value)){
            return $value;
        }

        //$locale = $locale ? $locale : \Locale::getDefault();
        $locale = $locale === null ? \App::getLocale() : $locale;
        $fmt    = new \NumberFormatter($locale, \NumberFormatter::CURRENCY );

        $fmt->setTextAttribute(\NumberFormatter::CURRENCY_CODE, $currency);

        if($round){
            $fmt->setAttribute(\NumberFormatter::FRACTION_DIGITS, 0);
        }

        return $fmt->formatCurrency($value, $currency);
    }

    public function trans($msgId, $args = [], $domain = 'default' , $locale = null){


        if(null === $locale){
            $locale = app()->getLocale();
        }

        return App('linguo')->trans($msgId, $args, $domain, $locale);
    }

    public function plural($msgId, $plural, $count = 1,  $args = [], $domain = 'default' , $locale = null){

        if(null === $locale){
            $locale = app()->getLocale();
        }

        return App('linguo')->plural($msgId, $plural, $count, $args, $domain, $locale);
    }


}