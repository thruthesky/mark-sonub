<?php
namespace Drupal\sonub\Controller;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\file\Element\ManagedFile;
use Drupal\file\FileInterface;




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

    public function buildForm(array $form, FormStateInterface $form_state)
    {
        $form['photo'] = array(
            '#type' => 'managed_file',
            '#upload_location' => 'public://upload/teacher/photo',
            '#ajax' => array(
                // Function to call when event on form element triggered.
                'callback' => 'Drupal\sonub\Controller\uploader::uploaderValidateCallback',
                // Javascript event to trigger Ajax. Currently for: 'onchange'.
                'event' => 'change',

            )

        );
        return $form;

    }
    public function validateForm(array &$form, FormStateInterface $form_state)
    {

        $photo = $form_state->getValues()['photo'][0];

        //$run = \ManagedFile::valueCallback($form_state->getValues()['photo']);

        $file = \Drupal\file\Entity\File::load( $photo );
        if ( $file ) {
            $filename = $file->getFilename();
        }

        /*
         * will make file save permanently by updating status.
         */

        if (!$file->isPermanent()) {
            $file->setPermanent();
            $file->save();
        }



        $id = \Drupal::currentUser()->getAccount()->id();
        $key = "photo:$id";
        \Drupal::state()->set( $key, $photo );



    }

    public function submitForm(array &$form, FormStateInterface $form_state)
    {


    }//class form
}