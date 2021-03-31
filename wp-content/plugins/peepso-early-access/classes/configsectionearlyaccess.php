<?php

class PeepSoConfigSectionEarlyAccess extends PeepSoConfigSectionAbstract
{

    private function color_code($string) {

        $color = 'black';

        switch($string) {
            case 'DONE':
            case 'RC':
            case 'YES':
                $color = 'green';
                break;
            case 'BETA':
                $color = 'orange';
                break;
            case 'ALPHA':
            case 'NO':
                $color = 'red';
                break;
            default:
                $color = 'black';
        }

        return "<span style='color:$color'><b>$string</b></span>";
    }

    public function register_config_groups()
    {
        $this->set_context('full');

        /**** ABOUT EARLY ACCESS ****/

        $this->set_field(
            'early_access',
            '
            Thank you for installing PeepSo Early Access and helping us improve our product! This plugin lets you enable hidden <i>future features</i> of PeepSo. 
            
            <br/><br/>
            
            Please pay close attention to the descriptions of each feature. If a <b>feature is supported</b>, you can send community questions and <b>support tickets</b>. But if the feature is <b>not marked as production ready</b>, it means we can\'t guarantee anything - <b>do not install it on your live site</b>, even if it\'s supported. In some rare cases we are not open for feedback as the feature is in a stage too early for that. Such features are clearly marked. 
            
            <br/><br/>
            
            Each feature goes through <b>four stages</b>: "ALPHA", "BETA", "RC" (release candidate) and "DONE" (ready for release). 
            
            <br/><br/>
            
            More often than not, <b>enabling</b> the <i>future feature</i> here only unlocks a configuration option for the feature which still remains disabled by default - please <b>read the description carefully</b>, to learn where a given feature is located and how to configure it.
           
            <br/><br/>
            
            <b>Please bear in mind, the Early Access features will remain enabled even if you deactivate the Early Access plugin. The only way to turn a feature off is to use the config settings below.</b>
 
            ',
            'message'
        );

        $this->set_group(
            'early_access',
            'About PeepSo Early Access'
        );


        $PeepSoEarlyAccess = PeepSoEarlyAccessPlugin::get_instance();

        foreach($PeepSoEarlyAccess->areas as $key => $area) {



            /****  META ****/

            ob_start();
            ?>
            <table class="wp-list-table widefat striped" style="margin-left:20px;max-width:250px;">
                <tr>
                    <td>
                        Development stage
                    </td>
                    <td>
                        <?php echo $this->color_code($area['state']);?>
                    </td>
                </tr>
                <tr>
                    <td>
                        Production ready
                    </td>
                    <td>
                        <?php echo  $this->color_code($area['production'] ? "YES" : "NO");?>
                    </td>
                </tr>

                <tr>
                    <td>
                        Supported
                    </td>
                    <td>
                        <?php echo  $this->color_code($area['support'] ? "YES" : "NO");?>
                    </td>
                </tr>

                <tr>
                    <td>
                        Open for feedback
                    </td>
                    <td>
                        <?php echo  $this->color_code($area['feedback'] ? "YES" : "NO");?>
                    </td>
                </tr>
            </table>
            <?php
            $meta = ob_get_clean();

            $this->set_field(
                $key.'_meta',
                $meta,
                'message'
            );



            /****  DESC ****/

            $this->set_field(
                $key.'_desc',
                $area['desc'],
                'message'
            );



            /****  PEEPSO_DEV_MODE WARNING ****/

            if(PeepSo::is_dev_mode($key, FALSE)) {
                $this->set_field(
                    $key.'_dev_mode_override',
                    '<span style="color:red"><strong>Even if disabled, this setting will be overruled</strong> by PEEPSO_DEV_MODE or PEEPSO_DEV_MODE_'.strtoupper($key).' defined somewhere else.</span>',
                    'message'
                );
            }



            /****  ON/OFF SWITCH ****/

            $this->set_field(
                'dev_mode_' . $key,
                'Enable',
                'yesno_switch'
            );

            /****  BUILD GROUP ****/

            $this->set_group(
                $key,
                $area['name']
            );
        }
    }
}