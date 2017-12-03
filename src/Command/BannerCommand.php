<?php
namespace Backtheweb\Linguo\Command;

use Config;

use Illuminate\Console\Command;
use Illuminate\Config\Repository;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class BannerCommand extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'linguo:banner';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Display all files where the argument is used as a lemma';

    public function __construct( Repository $configRepository )
    {
        parent::__construct( $configRepository );
    }

    public function fire()
    {

        $banner = <<< END_BANNER
                                                            .
 .o8                           oooo            .   oooo                                              .o8       
"888                           `888          .o8   `888                                             "888       
 888oooo.   .oooo.    .ooooo.   888  oooo  .o888oo  888 .oo.    .ooooo.  oooo oooo    ooo  .ooooo.   888oooo.  
 d88' `88b `P  )88b  d88' `"Y8  888 .8P'     888    888P"Y88b  d88' `88b  `88. `88.  .8'  d88' `88b  d88' `88b 
 888   888  .oP"888  888        888888.      888    888   888  888ooo888   `88..]88..8'   888ooo888  888   888 
 888   888 d8(  888  888   .o8  888 `88b.    888 .  888   888  888    .o    `888'`888'    888    .o  888   888 
 `Y8bod8P' `Y888""8o `Y8bod8P' o888o o888o   "888" o888o o888o `Y8bod8P'     `8'  `8'     `Y8bod8P'  `Y8bod8P' 
                                                                                                               
                                                                                                               
                                                                                                               

END_BANNER;

        $this->info($banner);
    }
}