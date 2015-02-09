<?php
namespace Drupal\custom\sonub\Controller; // -> Drupal -> module -> third -> src -> Controller
use Drupal\Core\Controller\ControllerBase ;
class Page2 extends ControllerBase {
    public function ShowPage() {
        // render_array();
        //

        return [
            '#theme' => 'Page2', // theme name that will be matched in *.module
            '#title' => 'Blog',
            '#myid' => 'abc',
        ];
    }
}
