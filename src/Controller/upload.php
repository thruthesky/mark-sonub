<?php


namespace Drupal\custom\sonub\Controller; // -> Drupal -> module -> third -> src -> Controller

use Drupal\Core\Controller\ControllerBase ;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\ConfigFormBase;


class upload extends ControllerBase{

        public function showPage(){


            $upload = \Drupal::formBuilder()->getForm( new uploader() );

            return [

                '#theme'=> 'register',
                '#title' => 'regiter',
                '#form' => $upload
                ];
        }

}
/**
 * @file
 * Page/form showing image styles in use.
 */

/**
 * Form for uploading and displaying an image using selected style.
 *
 * This page provides a form that allows the user to upload an image and choose
 * a style from the list of defined image styles to use when displaying the
 * the image. This serves as an example of integrating image styles with your
 * module and as a way to demonstrate that the styles and effects defined by
 * this module are available via Drupal's image handling system.
 *
 * @see theme_image_style()
 *
 * @ingroup image_example
 */


class uploader extends FormBase
{

    public function getFormId()
    {
        return 'upload';
    }

    public function buildForm(array $form, FormStateInterface $form_state)
    {


        // Use the #managed_file FAPI element to upload an image file.
        $form['image_example_image_fid'] = array(
            '#title' => t('Image'),
            '#type' => 'managed_file',
            '#description' => t('The uploaded image will be displayed on this page using the image style choosen below.'),
            '#default_value' => variable_get('image_example_image_fid', ''),
            '#upload_location' => 'public://image_example_images/',
        );



        // Submit Button.
        $form['submit'] = array(
            '#type' => 'submit',
            '#value' => t('Save'),
        );

        return $form;
    }

    /**
     * Verifies that the user supplied an image with the form..
     *
     * @ingroup image_example
     */
    public function validateForm(array &$form, FormStateInterface $form_state)
    {
        if (!isset($form_state['values']['image_example_image_fid']) || !is_numeric($form_state['values']['image_example_image_fid'])) {
            form_set_error('image_example_image_fid', t('Please select an image to upload.'));
        }
    }
    public function submitForm(array &$form, FormStateInterface $form_state)
        {
            // When using the #managed_file form element the file is automatically
            // uploaded an saved to the {file} table. The value of the corresponding
            // form element is set to the {file}.fid of the new file.
            //
            // If fid is not 0 we have a valid file.
            if ($form_state['values']['image_example_image_fid'] != 0) {
                // The new file's status is set to 0 or temporary and in order to ensure
                // that the file is not removed after 6 hours we need to change it's status
                // to 1. Save the ID of the uploaded image for later use.
                $file = file_load($form_state['values']['image_example_image_fid']);
                $file->status = FILE_STATUS_PERMANENT;
                file_save($file);

                // When a module is managing a file, it must manage the usage count.
                // Here we increment the usage count with file_usage_add().
                file_usage_add($file, 'image_example', 'sample_image', 1);

                // Save the fid of the file so that the module can reference it later.
                variable_set('image_example_image_fid', $file->fid);
                drupal_set_message(t('The image @image_name was uploaded and saved with an ID of @fid and will be displayed using the style @style.',
                    array(
                        '@image_name' => $file->filename,
                        '@fid' => $file->fid,
                        '@style' => $form_state['values']['image_example_style_name'],
                    )
                ));
            }
            // If the file was removed we need to remove the module's reference to the
            // removed file's fid, and remove the file.
            elseif ($form_state['values']['image_example_image_fid'] == 0) {
                // Retrieve the old file's id.
                $fid = variable_get('image_example_image_fid', FALSE);
                $file = $fid ? file_load($fid) : FALSE;
                if ($file) {
                    // When a module is managing a file, it must manage the usage count.
                    // Here we decrement the usage count with file_usage_delete().
                    file_usage_delete($file, 'image_example', 'sample_image', 1);

                    // The file_delete() function takes a file object and checks to see if
                    // the file is being used by any other modules. If it is the delete
                    // operation is cancelled, otherwise the file is deleted.
                    file_delete($file);
                }

                // Either way the module needs to update it's reference since even if the
                // file is in use by another module and not deleted we no longer want to
                // use it.
                variable_set('image_example_image_fid', FALSE);
                drupal_set_message(t('The image @image_name was removed.', array('@image_name' => $file->filename)));
            }

            // Save the name of the image style choosen by the user.
            variable_set('image_example_style_name', $form_state['values']['image_example_style_name']);
        }

        /**
         * Theme function displays an image rendered using the specified style.
         *
         * @ingroup image_example
         */
        function theme_images($variables)
        {
            $image = $variables['image'];
            $style = $variables['style'];

            // theme_image_style() is the primary method for displaying images using
            // one of the defined styles. The $variables array passed to the theme
            // contains the following two important values:
            // - 'style_name': the name of the image style to use when displaying the
            //   image.
            // - 'path': the $file->uri of the image to display.
            //
            // When given a style and an image path the function will first determine
            // if a derivative image already exists, in which case the existing image
            // will be displayed. If the derivative image does not already exist the
            // function returns an <img> tag with a specially crafted callback URL
            // as the src attribute for the tag. When accessed, the callback URL will
            // generate the derivative image and serve it to the browser.
            $output = theme('image_style',
                array(
                    'style_name' => $style,
                    'path' => $image->uri,
                    'getsize' => FALSE,
                )
            );
            $output .= '<p>' . t('This image is being displayed using the image style %style_name.', array('%style_name' => $style)) . '</p>';
            return $output;
        }

    }
