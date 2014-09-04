<?php

interface Container {
    /**
     * Checks if a $x exists.
     *
     * @param unknown $x
     *
     * @return boolean
     */
    function contains($x);
}