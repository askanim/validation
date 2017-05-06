<?php
/**
 * Created by PhpStorm.
 * User: Леонид
 * Date: 12.04.2017
 * Time: 12:32
 */

namespace Validation\Validation;


class ProtectForm extends Protect
{

    /*
     * $array = array ( [type]:example'phone' => [post-name => post[post-name] ]
     *  :example:
     *  array( 'phone' => [ 'telephone' => $post_data['telephone'] ] ));
     * :end exaple:
     * variable type:
     * phone - telephone;
     * email - email;
     * text - long text; (html - textarea[text])
     * string - short text; (html - input[type=text])
     * password - array password[ [0] => password; [1] => confirm password ]; (html - input[type=password])
     *
     *
     * */

    public function pf_get_data($array)
    {
        $this->data_array = $array;
    }

    public function pf_error()
    {
        // return array errors
        return $this->error;
    }
    public function pf_json_error()
    {
        // return array errors with json
        return json_encode($this->error);
    }
    public function protect_password($callable_password) {
        $pass = $this->passwordCall();
        if ($pass === false) {
            $this->password_settings = true;
        }else {
            $this->password_settings = $callable_password($pass);
       }
    }
    public function validate() {
        $validate = $this->split_run();

        // if validate = 1 :
        // return error data


        // if validate = 2 :
        // return error data type

        // if validate = 3 :
        // return compleate function validate
        return $validate;

    }
    public function getDataAll() {
        return $this->data;
    }

}