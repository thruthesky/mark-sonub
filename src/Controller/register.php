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
class Form4 extends FormBase
{
    public function getFormId()
    {
        return 'form4';
    }
    public function buildForm( array $form, FormStateInterface $form_state ) {

        /**
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

         $form['upload'] = [
            '#name' => 'fileToUpload',
            '#type' => 'file',
        ];

        $form['upload'] = array(
        '#name' => 'files[' . implode('_', $form['#parents']) . ']',
        '#type' => 'file',
        '#title' => t('Choose a file'),
        '#title_display' => 'invisible',
        '#size' => 22,
        '#theme_wrappers' => array(),
        '#weight' => -10,
        );

         *  * */

        $form['upload'] = [
            '#type' => 'managed_file',
            '#upload_location' => 'public://uploads/',
        ];

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

      echo $files = $form_state->getValue('files[upload]');

        if(empty($file)){
            $form_state->setErrorByName(
                '#register',
                "Filename is still Empty"
            );
            return false;
        }
        /*
         *
                $re = preg_match("/^[a-zA-Z0-9][a-zA-Z0-9]{3,}@[a-zA-Z0-9]{3,}\.[a-zA-Z0-9]{2,}$/", $email);
                 if (!$re) {
                     $form_state->setErrorByName(
                         '#register',
                         "Wrong Email Format"
                     );
                     return false;
                 }
         */
        return;
    }

    public function submitForm( array &$form, FormStateInterface $form_state ) {

        function file_copy(FileInterface $source, $destination = NULL, $replace = FILE_EXISTS_RENAME) {
            if (!file_valid_uri($destination)) {
                if (($realpath = drupal_realpath($source->getFileUri())) !== FALSE) {
                    \Drupal::logger('file')->notice('File %file (%realpath) could not be copied because the destination %destination is invalid. This is often caused by improper use of file_copy() or a missing stream wrapper.', array('%file' => $source->getFileUri(), '%realpath' => $realpath, '%destination' => $destination));
                }
                else {
                    \Drupal::logger('file')->notice('File %file could not be copied because the destination %destination is invalid. This is often caused by improper use of file_copy() or a missing stream wrapper.', array('%file' => $source->getFileUri(), '%destination' => $destination));
                }
                drupal_set_message(t('The specified file %file could not be copied because the destination is invalid. More information is available in the system log.', array('%file' => $source->getFileUri())), 'error');
                return FALSE;
            }

            if ($uri = file_unmanaged_copy($source->getFileUri(), $destination, $replace)) {
                $file = $source->createDuplicate();
                $file->setFileUri($uri);
                $file->setFilename(drupal_basename($uri));
                // If we are replacing an existing file re-use its database record.
                // @todo Do not create a new entity in order to update it, see
                //   https://drupal.org/node/2241865
                if ($replace == FILE_EXISTS_REPLACE) {
                    $existing_files = entity_load_multiple_by_properties('file', array('uri' => $uri));
                    if (count($existing_files)) {
                        $existing = reset($existing_files);
                        $file->fid = $existing->id();
                        $file->setOriginalId($existing->id());
                        $file->setFilename($existing->getFilename());
                    }
                }
                // If we are renaming around an existing file (rather than a directory),
                // use its basename for the filename.
                elseif ($replace == FILE_EXISTS_RENAME && is_file($destination)) {
                    $file->setFilename(drupal_basename($destination));
                }

                $file->save();

                // Inform modules that the file has been copied.
                \Drupal::moduleHandler()->invokeAll('file_copy', array($file, $source));

                return $file;
            }
            return FALSE;
        }

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
 ***/
}//class form