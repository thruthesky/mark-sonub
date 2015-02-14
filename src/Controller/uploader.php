<?php

/**
* @file
* Contains Drupal\ajax_example\AjaxExampleForm
*/

namespace Drupal\sonub\Controller;

use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\ChangedCommand;
use Drupal\Core\Ajax\CssCommand;
use Drupal\Core\Ajax\HtmlCommand;
use Drupal\Core\Ajax\InvokeCommand;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class uploader extends FormBase {


    public function showPage(){

        $id = \Drupal::currentUser()->getAccount()->id();
        $key = "photo:$id";

        $fid = \Drupal::state()->get($key);

        $file = \Drupal\file\Entity\File::load( $fid );
        $url = "";
        if ( $file ) {
            $url = $file->url();
        }

       $form =  \Drupal::formBuilder()->getForm('upload_form');
        return [
            '#theme' => 'register', // theme name that will be matched in *.module
            '#title' => 'register',
            '#url_photo' => $url,
            '#form' => $form

        ];



    }



    public function getFormId() {
        return 'upload_form';
    }

    public function buildForm(array $form, FormStateInterface $form_state) {

        $form['photo'] = array(
            '#type' => 'managed_file',
            '#upload_location' => 'public://upload/teacher/photo',
            '#ajax' => array(
    // Function to call when event on form element triggered.
                'callback' => 'Drupal\sonub\Controller\uploader::uploaderValidateCallback',

    // Javascript event to trigger Ajax. Currently for: 'onchange'.
                'event' => 'change',

                ),
            );

    return $form;
    }

    public function uploaderValidateCallback(array &$form, FormStateInterface $form_state) {
    // Instantiate an AjaxResponse Object to return.
    $ajax_response = new AjaxResponse();

    // Check if Username exists and is not Anonymous User ('').
    loadData('file',$form_state->getValues(['photo']));

    return $ajax_response;
    }

    public function submitForm(array &$form, FormStateInterface $form_state) {
        drupal_set_message('Nothing Submitted. Just an Example.');
    }

}