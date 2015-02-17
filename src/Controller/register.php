<?php
/**
 * Created by PhpStorm.
 * User: makii
 * Date: 1/20/2015
 * Time: 10:27 PM
 */


namespace Drupal\sonub\Controller;
use Drupal\Core\Controller\ControllerBase ;

class register extends ControllerBase {
    public function ShowPage() {

        //$file = file_load($form_state['values']['my_file_field']);



        $id = \Drupal::currentUser()->getAccount()->id();
        $key = "photo:$id";
        $fid = \Drupal::state()->get($key);

        print_r($fid);

        $url = "";
        if ( $fid ) {
            $file = \Drupal\file\Entity\File::load( $fid );
            if ( $file ) {
                $url = $file->url();
            }
        }


        $form = \Drupal::formBuilder()->getForm( new Form4(), $url );
        $markup = [
            '#theme' => 'register', // theme name that will be matched in *.module
            '#title' => 'register',
            '#url_photo' => $url,
            '#form' => $form
        ];
        return $markup;
    }
}

