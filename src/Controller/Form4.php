<?php
namespace Drupal\sonub\Controller;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

use Drupal\file\Element\ManagedFile;
use Drupal\file\FileInterface;
use LMS\Lib;




/**
 *
 *
 * @todo get callback event for file upload.
 *
 * Class Form4
 * @package Drupal\sonub\Controller
 */
class Form4 extends FormBase
{
    public function getFormId()
    {
        return 'form4';
    }

    public function buildForm(array $form, FormStateInterface $form_state, $url=null)
    {


        $form['username'] = array(
            '#type' => 'textfield',
        );
        $form['photo'] = array(
            '#type' => 'managed_file',
            '#upload_location' => 'public://upload/teacher/photo',

        );
        $form['submit'] = array(
            '#type' => 'submit',
            '#value' => 'Submit Now',
            '#prefix' => "<div class='photo'><img id='photo-id' src='$url' width='100' height='100'></div>",

        );
        return $form;
    }
    public function validateForm(array &$form, FormStateInterface $form_state)
    {





        $fid = $form_state->getValues()['photo'][0];
        $file = \Drupal\file\Entity\File::load( $fid );
        $file->setPermanent();
        $file->save();


        if ( $file ) {
            $filename = $file->getFilename();
        }




        $id = \Drupal::currentUser()->getAccount()->id();
        $key = "photo:$id";
        \Drupal::state()->set( $key, $fid );



    }

    public function submitForm(array &$form, FormStateInterface $form_state)
    {



        $photo = $form_state->getValues()['photo'][0];

        $file = \Drupal\file\Entity\File::load( $photo );



    }//class form
}