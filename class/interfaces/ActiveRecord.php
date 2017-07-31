<?php

/**
 * Interface ActiveRecord
 */
interface ActiveRecord{

    /**
     * @param $id
     * @return object
     */
    public function load($id);

    /**
     * @return Array of Objects / Exception on error
     */

    public static function loadAll();

    /**
     * @return mixed
     */
    public function update();

    /**
     * @return Inserted Object / Exception on error
     */
    public function save();

    /**
     * @return true / Exception on error
     */
    public function delete();
}