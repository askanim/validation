<?php
/**
 * Created by PhpStorm.
 * User: Леонид
 * Date: 12.04.2017
 * Time: 13:15
 */

namespace Validation\Validation;


class Protect
{
    # not limited test
    private $phone; // Array
    # not limited test
    private $email; // Array
    # not limited test
    private $text; // Array
    # not limited test
    private $string; // Array
    # array limited value count(2) test
    private $password; // Array

    # password protected
    protected $pass;

    # not limited password test array
    private $password_array; // Array

    # my settings
    private $my_settings;

    # password settings
    protected $password_settings;


    # array base request;
    protected $data_array; // Getting an array of data

    # array data response
    protected $data;

    # array type;
    private $type_array;

    # return array Error;
    protected $error;

    # return json array Error;
    private $json_error;

    # error data;
    private $data_error;

    # error type;
    private $error_type;



    private function phone($type)
    {
        $this->phone = $this->data_array[$type];
    }
    private function email($type)
    {
        $this->email = $this->data_array[$type];
    }
    private function password($type)
    {
        $this->password = $this->data_array[$type];
    }
    private function password_array($type)
    {
        $this->password_array = $this->data_array[$type];
    }
    private function string($type)
    {
        $this->string = $this->data_array[$type];
    }
    private function text($type)
    {
        $this->text = $this->data_array[$type];
    }
    private function my_settings($type)
    {
        $this->my_settings = $this->data_array[$type];
    }



    protected function pf_empty_string()
    {
        # Check for empty (string)
        $string = $this->empty_data('string');
        if($string === false):

            foreach ($this->string As $key => $value) {

                if(!empty($value)):
                    $this->data['string'][$key] = $value;
                else:
                    $this->error[$key] = false;
                endif;
            }
        endif;

    }
    protected function pf_empty_text()
    {
        # The text field is not necessarily
        # Check for empty
        # if this empty else add text (not description)
        $text = $this->empty_data('text');
        if ($text === false):
            foreach ($this->string As $key => $value) {
                if (!empty($value)):
                    $this->data['text'][$key] = $value;
                else:
                    $this->data['text'][$key] = 'not description';
                endif;
            }
        endif;

    }

    protected function pf_email($email)
    {
        #verefication email string
        //$email =
        if ($email === false):
            foreach ($this->email As $key => $value) {
                if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->data['email'][$key] = $value;
                } else {
                    $this->error[$key] = false;
                }
            }
        endif;

    }
    # true validate default:
    # +79261234567 #89261234567 #79261234567 #+7 926 123 45 67
    # 8(926)123-45-67 #123-45-67 #9261234567 #79261234567
    #(495)1234567 #(495) 123 45 67 #89261234567 #8-926-123-45-67 #8 927 1234 234
    #8 927 12 12 888 #8 927 12 555 12 #8 927 123 8 123

    protected function pf_phone()
    {
        #verefication phone string

        $phone = $this->empty_data('phone');
        if ($phone === false):
            foreach ($this->phone As $key => $value){
                if (is_array($value)):
                    if(preg_match($value[1], $value[0])):
                        $this->data['phone'][$key] = $value[0];
                    else:
                        $this->error[$key] = false;
                    endif;
                else:
                    if(preg_match('/^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,10}$/', $value)):
                        $this->data['phone'][$key] = $value;
                    else:
                        $this->error[$key] = false;
                    endif;
                endif;
            }
        endif;

    }

    protected function pf_password()
    {
        $password = $this->empty_data('password');
        if ($password === false):

            $this->pass($this->password);

        endif;
    }
    protected function pf_password_array()
    {
        $password_array = $this->empty_data('password_array');
        if ($password_array === false):
            foreach ($this->password_array As $key => $value) {
                $this->pass($value);
            }
        endif;
    }
    /*
     * FUNCTION pf_my_settings NOT WORKED
     *
     * */
    protected function pf_my_settings()
    {
        $my_settings = $this->empty_data('my_settings');

        if ($my_settings === false):
            foreach ($this->my_settings As $key => $value){
                if (!empty(is_array($value))):
                    if(!empty($value['value'])) :
                        $call = $value['callable'];
                        $my_set = $call($value['value']);
                        if($my_set === false ):
                            $this->data[$key] = $value['value'];
                        else:
                            $this->error[$key] = false;
                        endif;


                    endif;
                else:
                    $this->error[$key] = false;
                endif;
            }
        endif;
    }

    protected function split_run () {


        #main function

        // start search array type

        foreach ($this->data_array As $key => $value) {

            $this->search_data($key);
        }
        if(!empty($this->type_array)) {
            foreach ($this->type_array As $key => $value) {
                 if($value == 'string'): $this->pf_empty_string();
                 endif;
                 if ($value == 'text'): $this->pf_empty_text();
                 endif;
                 if($value == 'phone'): $this->pf_phone();
                 endif;
                 if ($value == 'password'): $this->pf_password();
                 endif;
                 if ($value == 'password_array'): $this->pf_password_array();
                 endif;
                 if ($value == 'email'): $this->pf_email($this->empty_data('email'));
                 endif;
                 if ($value == 'my_settings'): $this->pf_my_settings();
                 endif;
            }


            // return 1 if data error not date
            if (!empty($this->data_error)):

                return 1;
            endif;

            // return 2 if type error not type
            if (!empty($this->error_type)):

                return 2;
            endif;
            return 3;// return 3 if compleate this function validation return 3;
        }else {
            // return 2 if type error not type
            if (!empty($this->error_type)):

                return 2;
            endif;

        }


    }
    private function pass($password) {

        $pass = $password[0];
        foreach ($pass As $key => $value) {
            $pass_one = $value;
            $pass_one_key = $key;
        }
        // login or register
        if(isset($password[1])):
            // register validation

            $pass_confirm = $password[1];
            foreach ($pass_confirm As $key => $value) {
                $pass_two = $value;
                $pass_two_key = $key;
            }
            if($pass_one === $pass_two):

                if($this->password_settings === false):
                    $this->data['password'][$pass_one_key] = $pass_one;
                else:
                    $this->error[$pass_one_key] = false;
                    $this->error[$pass_two_key] = false;
                endif;
            else:
                $this->error[$pass_one_key] = false;
                $this->error[$pass_two_key] = false;
            endif;
        else:
            // login validation

            if($this->password_settings === false):
                $this->data['password'][$pass_one_key] = $pass_one;
            else:
                $this->error[$pass_one_key] = false;
            endif;
        endif;

    }
    protected function passwordCall ()
    {
        if(isset($this->data_array['password'][0])) :
            $pass = $this->data_array['password'][0];
            if(count($pass) > 1):
                return false;
            else:
                foreach ($pass As $key => $value) {
                    $val = $value;
                }
                return $val;
            endif;
        else:
            return false;
        endif;
    }


    private function empty_data($type)
    {
        if(!empty(isset($this->$type))):
            return false;
        else:
            $this->data_error[$type] = false;
        endif;
    }
    private function search_data($type) {
        if (method_exists(get_class(),$type)):

            if(!empty(isset($this->data_array[$type]))):
                $this->$type($type);
                $this->type_array[] = $type;
            else:
                $this->data_error[$type] = false;
            endif;
        else:
            $this->error_type[$type] = false;
        endif;
    }
}