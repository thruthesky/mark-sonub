<?php
namespace Drupal\custom\sonub\Controller; // -> Drupal -> module -> third -> src -> Controller

use Drupal\Core\Controller\ControllerBase ;

class displayQuery extends ControllerBase {

   // public $message = "Its just a message";
    //public $results = "";

    public function runQuery() {


      db_insert('sonub')
            ->fields(['name'=>'makii', 'lastname'=>'me','email'=>'makii@gmail.com' , 'password'=>'makii'])
            ->execute();

        $results = db_select( 'sonub' )
            ->fields('sonub', [ 'id','name' ] )
            ->execute();
        $output = null;
        while ( $row = $results->fetchAssoc() ){
            $output .= "$row[id] = $row[name] \r\n";
        }
        $markup = [
            '#theme' => 'displayQuery', // theme name that will be matched in *.module
            '#title' => 'return query',
            '#results' => $output,
        ];
        return $markup;

    }
}




