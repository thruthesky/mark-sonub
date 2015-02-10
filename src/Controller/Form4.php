<?php
namespace Drupal\sonub\Controller;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
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

    public function buildForm(array $form, FormStateInterface $form_state)
    {

        lib::log('Form4::buildForm()....');
        $form['photo'] = [
            '#type' => 'managed_file',
            '#upload_location' => 'public://upload/teacher/photo',
        ];
        return $form;
    }


    public function validateForm(array &$form, FormStateInterface $form_state)
    {
        lib::log('Form4::validateForm()....');
        $photo = $form_state->getValues()['photo'][0];

        lib::log('photo');
        lib::log( $photo );


        $id = \Drupal::currentUser()->getAccount()->id();
        $key = "photo:$id";
        \Drupal::state()->set( $key, $photo );


    }

    public function submitForm(array &$form, FormStateInterface $form_state)
    {
        lib::log('Form4::submitForm()....');
    }//class form
}