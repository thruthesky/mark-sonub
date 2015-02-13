<?php
namespace Drupal\sonub\Controller;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;



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
        $form['photo'] = [
            '#type' => 'managed_file',
            '#upload_location' => 'public://upload/teacher/photo',
        ];
        $form['submit'] = [
            '#type' => 'submit',
            '#value' => 'REG'
        ] ;
        return $form;
    }


    public function validateForm(array &$form, FormStateInterface $form_state)
    {

        $photo = $form_state->getValues()['photo'][0];



        $file = \Drupal\file\Entity\File::load( $photo );
        if ( $file ) {
            $filename = $file->getFilename();
        }


        $id = \Drupal::currentUser()->getAccount()->id();
        $key = "photo:$id";
        \Drupal::state()->set( $key, $photo );

    }

    public function submitForm(array &$form, FormStateInterface $form_state)
    {


        $photo = $form_state->getValues()['photo'][0];

        $file = \Drupal\file\Entity\File::load( $photo );

        $file->setPermanent(); // no work

    }//class form
}