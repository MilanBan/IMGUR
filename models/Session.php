<?php

namespace app\models;

class Session {

    protected const FLASH_KEY = 'flash_messages';
    protected static bool $start = false;

    public function __construct() {
        if (!self::$start){
            session_start();
            self::$start = true;
            $ad = Advertising::getInstance();
            $ad->nextRendering();
        }
        $flashMessages = $_SESSION[self::FLASH_KEY] ?? [];
        foreach ( $flashMessages as $key => &$flashMessage ) {
            $flashMessage['remove'] = true;
        }

        $_SESSION[self::FLASH_KEY] = $flashMessages;
    }

    public static function setFlash( $key, $message ) {
        $_SESSION[self::FLASH_KEY][$key] = [
            'remove' => false,
            'value'  => $message,
        ];
    }

    public static function getFlash( $key ) {
        return $_SESSION[self::FLASH_KEY][$key]['value'] ?? false;
    }

    public static function set( $key, $value ) {
        $_SESSION[$key] = $value;
    }

    public static function get( $key ) {
        return $_SESSION[$key] ?? false;
    }
    public function update( $key, $value ) {
        unset( $_SESSION[$key] );
        $_SESSION[$key] = $value;
    }

    public function remove( $key ) {
        unset( $_SESSION[$key] );
    }

    public function destroy(){
        session_unset();
        session_destroy();
    }

    public function __destruct() {
        $flashMessages = $_SESSION[self::FLASH_KEY] ?? [];
        foreach ( $flashMessages as $key => &$flashMessage ) {
            if ( $flashMessage['remove'] ) {
                unset( $flashMessages[$key] );
            }
        }

        $_SESSION[self::FLASH_KEY] = $flashMessages;
    }
}