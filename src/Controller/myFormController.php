<?php

namespace Drupal\sonub\Controller; // -> Drupal -> module -> third -> src -> Controller

use Drupal\Core\Controller\ControllerBase;

class myFormController {

    static function add()
    {
        $email = null;
        $name = null;
        $pswd = null;

       db_insert('sonub')
            ->fields(['name'=>$name, 'email'=> $email, 'password'=>$pswd])
            ->execute();

    }

    /*


      // Returns all participant names stored in database.
      static function getAll() {
          return db_query('SELECT name FROM {sonub}')->fetchCol();
      }


       * Stores participant name in database.
       *
       * @param $name
       *   participant name.

    static function add($name) {
        db_insert('sonub')->fields(array('name' => $name))->execute();
    }


     * Deletes participant name in database.
     *
     * @param $name
     *   participant name.

    static function delete($name) {
        db_delete('bingo')->condition('name', $name)->execute();
    } **/
}