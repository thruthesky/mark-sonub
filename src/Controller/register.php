<?php
/**
 * Created by PhpStorm.
 * User: makii
 * Date: 1/20/2015
 * Time: 10:27 PM
 */


namespace Drupal\custom\sonub\Controller; // -> Drupal -> module -> third -> src -> Controller
use Drupal\Core\Controller\ControllerBase ;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\ConfigFormBase;
class register extends ControllerBase {
    public function ShowPage() {

        $form = \Drupal::formBuilder()->getForm( new Form4() );

        $markup = [
            '#theme' => 'register', // theme name that will be matched in *.module
            '#title' => 'register',
            '#form' => $form
        ];
        return $markup;
    }
}
class Form4 extends FormBase {
    public function getFormId()
    {
        return 'form4';
    }
    public function buildForm( array $form, FormStateInterface $form_state ) {
        $form['email'] = [
            '#type' => 'textfield',
            '#placeholder' => 'Email',
            '#default_value' => '',
        ];
        $form['name'] = [
            '#type' => 'textfield',
            '#placeholder' => 'First Name',
            '#default_value' => ''
            //\Drupal::state()->get('sonub.email')
        ];
        $form['upload'] = array(
            '#id'  => 'file_id',
            '#type' => 'file',
            '#title' => t('Choose a file'),
            '#upload_location' => 'public://test',
            '#title_display' => 'invisible',
            '#progress_message' => $this->t('Please wait...'),
            '#size' => 1,
            '#theme_wrappers' => array(),
            '#weight' => -10,
        );
        $form['action']['submit'] = [
            '#type' => 'submit',
            '#value' => 'Register',
            '#prefix' => '<div class="button">',
            '#suffix' => '</div>',
        ];
        return $form;
    }

    public function validateForm(array &$form, FormStateInterface $form_state)
    {

        $email = $form_state->getValue('email');
        $name = $form_state->getValue('name');
        $upload = $form_state->getValue('upload');

        if(!file_exists($upload)) {
            @mkdir('images/', 0777);
        }
        if (empty($name)) {
            $form_state->setErrorByName(
                '#register',
                "Please fill out ALL fields!"
            );
        }
        $re = preg_match("/^[a-zA-Z0-9][a-zA-Z0-9]{3,}@[a-zA-Z0-9]{3,}\.[a-zA-Z0-9]{2,}$/", $email);
        if (!$re) {
            $form_state->setErrorByName(
                '#register',
                "Wrong Email Format"
            );
            return false;
        }
        return;
    }
    public function submitForm( array &$form, FormStateInterface $form_state ) {
        // parent::submitForm( $form, $form_state);
        $email = $form_state->getValue('email');
        $name = $form_state->getValue('name');
        $upload = $form_state->getValue('FileName');
/*
 * if(!file_exists('images/'.$upload){
            @mkdir("images/$upload/", 0777);
        }
 */
        $insert =  db_insert('sonub')
            ->fields(['name'=>$name, 'lastname'=> 'red', 'email'=>$email , 'password'=> '1234', 'photo' => $upload ])
            ->execute();
        if($insert){
            echo '<script type="text/javascript"> alert("Successfully Inserted!");</script>';
        }
        else {
            echo '<script type="text/javascript"> alert("Sorry Invalid Entry!");</script>';
        }
        return;


    }//formsubmit
/***
        db_insert('sonub')
        ->fields(['name'=>$name, 'lastname'=>$lastname, 'email'=>$email , 'password'=>$password])
        ->execute();


    public static function add($email)
    {
        db_insert('member')
            ->fields(['email' => $email])
            ->execute();
    }
 ***/fs
}//class form