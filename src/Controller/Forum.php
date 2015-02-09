<?php
namespace Drupal\custom\sonub\Controller; // -> Drupal -> module -> third -> src -> Controller
use Drupal\Core\Controller\ControllerBase ;
class Forum extends ControllerBase {
    public function ShowPage() {
        // render_array();
        //

        return [
            '#theme' => 'Forum', // theme name that will be matched in *.module
            '#title' => 'Forum',
        ];
    }
}
