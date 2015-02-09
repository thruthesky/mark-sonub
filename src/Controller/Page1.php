<?php
namespace Drupal\custom\sonub\Controller; // -> Drupal -> module -> third -> src -> Controller
use Drupal\Core\Controller\ControllerBase ;
class Page1 extends ControllerBase {
    public function ShowPage() {
        // render_array();
        //

        return [
            '#theme' => 'Page1', // theme name that will be matched in *.module
            '#title' => 'testimonial',
        ];
    }
}

