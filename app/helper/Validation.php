<?php

namespace App\helper;

use App\Repository\MySqlUserRepository;

class Validation
{
    public const RULE_REQUIRED = 'required';
    public const RULE_EMAIL = 'email';
    public const RULE_MIN = 'min';
    public const RULE_MAX = 'max';
    public const RULE_MATCH = 'match';
    public const RULE_UNIQUE = 'unique';
    public array $data = [];
    public array $rules = [];
    public array $errors = [];

    public function __construct(array $data , array $rules)
    {
        $this->rules = $rules;
        $this->data = $data;
    }

    public function validate(){
        foreach ($this->rules as $attr => $rules){
            $value = $this->data[$attr];
            foreach ($rules as $rule){
                $ruleName = $rule;
                if (!is_string($rule)){
                    $ruleName = $rule[0];
                }
                if ($ruleName === self::RULE_REQUIRED && !$value){
                    $this->addErrorByRule($attr , self::RULE_REQUIRED);
                }
                if ($ruleName === self::RULE_EMAIL && !filter_var($value , FILTER_VALIDATE_EMAIL)){
                    $this->addErrorByRule($attr , self::RULE_EMAIL);
                }
                if ($ruleName === self::RULE_MIN && strlen($value) < $rule['min']){
                    $this->addErrorByRule($attr , self::RULE_MIN , $rule);
                }
                if ($ruleName === self::RULE_MAX && strlen($value) < $rule['max']){
                    $this->addErrorByRule($attr , self::RULE_MAX , $rule);
                }
                if ($ruleName === self::RULE_MATCH && $value !== $this->$rule['match']){
                    $this->addErrorByRule($attr , self::RULE_MATCH , $rule);
                }
                if ($ruleName === self::RULE_UNIQUE){
                    $uniqueAttr = $rule['attribute'] ?? $attr;
                    $stmt = new MySqlUserRepository();
                    $res = $stmt->findByEmail($value);
                    if ($res){
                        $this->addErrorByRule($attr , self::RULE_UNIQUE , ['field' => $attr]);
                    }
                }
            }
        }
        return empty($this->errors);
    }

    private function addErrorByRule(string $attr, string $rule , $params = [])
    {
        $message = $this->errorMessage()[$rule] ?? '';

        foreach ($params as $key => $value){
            $message = str_replace("{{$key}}" , $value , $message);
        }

        $this->errors[$attr][] = $message;
    }

    private function errorMessage(){
        return [
            self::RULE_REQUIRED => 'This field is required!',
            self::RULE_EMAIL => 'This field must be a valid email address!',
            self::RULE_MIN => 'Min length of this field must be {min}!',
            self::RULE_MAX => 'Max length of this field must be {max}!',
            self::RULE_MATCH => 'This field must be the same as {match}!',
            self::RULE_UNIQUE => 'Record with this {field} already exists',
        ];
    }

    public function hasError($attr){
        return $this->errors[$attr] ?? false;
    }

    public function getFirstError($attr){
        return $this->errors[$attr][0] ?? false;
    }
}