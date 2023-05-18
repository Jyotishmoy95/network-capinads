<?php

namespace App\Helpers;
use Config;
use Illuminate\Support\Str;
class Helper
{
    public static function applClasses()
    {
        // default data value
        $dataDefault = [
          'menu' => 'vertical-menu', 
          'theme' => 'light',
          'primaryColor' => 'violet',
          'projectTitle' => 'Capinads',
          'isMenuCollapsed' => false,
          'footerType' => 'static',
          'isScrollTop' => false,
          'memberPanelColor' => 'dark-blue'
        ];
        
        //if any key missing of array from custom.php file it will be merge and set a default value from dataDefault array and store in data variable
        $data = array_merge($dataDefault, config('custom.custom'));

        // all available option of materialize template
        $allOptions = [
          'menu' => array('vertical-menu','horizontal-menu'),
          'theme' => array('light'=>'light','dark'=>'dark'),          
          'isMenuCollapsed' => array(false,true),
          'footerType' => array('fixed'=>'fixed','static'=>'static','hidden'=>'hidden'),
          'projectTitle' => '',
          'primaryColor' => array('violet'=>'violet', 'green' => 'green', 'bright-blue' => 'bright-blue', 'orange' => 'orange', 'light-blue' => 'light-blue', 'dark-blue' => 'dark-blue'),
          'isScrollTop' => array(true,false),
          'memberPanelColor' => array('violet'=>'violet', 'green' => 'green', 'bright-blue' => 'bright-blue', 'orange' => 'orange', 'light-blue' => 'light-blue', 'dark-blue' => 'dark-blue'),
        ];

        $colors = [
          'violet' => 'color2',
          'green' => 'color3',
          'dark-blue' => 'color',
          'light-blue' => 'color1',
          'bright-blue' => 'color4',
          'orange' => 'color5'
        ];
        
        // footer class
        $footerBodyClass = [
          'fixed'=>'fixed-footer',
          'static'=>'footer-static',
          'hidden'=>'footer-hidden',
        ];
        $footerClass = [
          'fixed'=>'footer-sticky',
          'static'=>'footer-static',
          'hidden'=>'d-none',
        ];

        //if any options value empty or wrong in custom.php config file then set a default value
        foreach ($allOptions as $key => $value) {
          if (gettype($data[$key]) === gettype($dataDefault[$key])) {
            if (is_string($data[$key])) {
              if(is_array($value)){
                
                $result = array_search($data[$key], $value);
                if (empty($result)) {
                  $data[$key] = $dataDefault[$key];
                }
              }
            }
          } else {
            if (is_string($dataDefault[$key])) {
              $data[$key] = $dataDefault[$key];
            } elseif (is_bool($dataDefault[$key])) {
              $data[$key] = $dataDefault[$key];
            } elseif (is_null($dataDefault[$key])) {
              is_string($data[$key]) ? $data[$key] = $dataDefault[$key] : '';
            }
          }
        }

        //  above arrary override through dynamic data
        $layoutClasses = [
          'menu' => $data['menu'],
          'theme' => $data['theme'],    
          'isMenuCollapsed' => $data['isMenuCollapsed'],
          'footerType' => $footerBodyClass[$data['footerType']],
          'footerClass' => $footerClass[$data['footerType']],
          'projectTitle' => $data['projectTitle'],
          'isScrollTop' => $data['isScrollTop'],
          'primaryColor' => $colors[$data['primaryColor']],
          'memberPanelColor' => $colors[$data['memberPanelColor']],
        ];

        return $layoutClasses;
    }
    // updatesPageConfig function override all configuration of custom.php file as page requirements.
    public static function updatePageConfig($pageConfigs)
    {
        $demo = 'custom';
        $custom = 'custom';

        if (isset($pageConfigs)) {
            if (count($pageConfigs) > 0) {
                foreach ($pageConfigs as $config => $val) {
                    Config::set($demo . '.' . $custom . '.' . $config, $val);
                }
            }
        }
    }

    function dateFormat($dateTime, $format = "d-m-Y")
    {
        if ($dateTime == "0000-00-00" || $dateTime == "0000-00-00 00:00:00") {
            return " ";
        }
        $date = strtotime($dateTime);
        if (date('d-m-Y', $date) != '01-01-1970') {
            return date($format, $date);
        } else {
            return " ";
        }
    }

    function numberToWords($number)
    {
        $digit = new NumberFormatter("en", NumberFormatter::SPELLOUT);
        return $digit->format((int)$number);
    }

}