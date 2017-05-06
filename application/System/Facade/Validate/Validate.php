<?php
/**
 * Created by PhpStorm.
 * User: strim
 * Date: 22.04.2017
 * Time: 16:14
 */

namespace Application\System\Facade\Validate;


use Validation\Validation\ProtectForm;

class Validate
{
    private $error;
    private $data;
    public function validateUser($array_form)
    {
        $protect = new ProtectForm();
        $protect->pf_get_data($array_form);

        $protect->protect_password(function ($password) {
            if (strlen($password) >= 4) {
                return false;
            }
            return true;
        });

        $valid = $protect->validate();
        if ($valid == 3) {
            $this->error = $protect->pf_error();
            if (!empty($this->error)) {
                return false;
            } else {
                $this->data = $protect->getDataAll();
                return true;
            }
        } elseif ($valid == 2) {
            exit('type_error');
        } elseif ($valid == 1) {
            exit('data_error');
        }

    }
    public function getData() {
        return $this->data;
    }
    public function getError()
    {
        return $this->error;
    }
}