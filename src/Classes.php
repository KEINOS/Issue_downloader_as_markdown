<?php

class MyClass
{
    public static function return_message($message)
    {
        return (string) $message;
    }

    public function echo_message($message)
    {
        echo $this->return_message($message);
    }
}
