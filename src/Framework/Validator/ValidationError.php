<?php

namespace Framework\Validator;

class ValidationError
{
    /**
     * @var string
     */
    private $key;
    /**
     * @var string
     */
    private $rule;

    /**
     * @var array
     */
    private $messages = [
        'required' => 'Le champs %s est requis',
        'empty' => 'Le champs %s ne peux être vide',
        'slug' => 'Le champs %s n\'est pas un slug valide',
        'minLength' => 'Le champs %s doit contenir plus de %d caractères',
        'maxLength' => 'Le champs %s doit contenir moins de %d caractères',
        'betweenLength' => 'Le champs %s doit contenir entre %d et %d caractères',
        'dateTime' => 'Le champs %s doit être une date valide',
        'exists' => 'Le champs %s n\'existe pas dans la table %S',
        'unique' => 'Le champs %s doit être unique',
        'filetype' => 'Le champs %s n\'est pas au format valide (%s)',
        'uploaded' => 'Vous devez uploader un fichier',
    ];
    /**
     * @var array
     */
    private $attributes;

    /**
     * ValidationError constructor.
     * @param string $key
     * @param string $rule
     * @param array $attributes
     */
    public function __construct(string $key, string $rule, array $attributes = [])
    {
        $this->key = $key;
        $this->rule = $rule;
        $this->attributes = $attributes;
    }

    /**
     * @return mixed
     */
    public function __toString()
    {
        $params = array_merge([$this->messages[$this->rule], $this->key], $this->attributes);
        return call_user_func_array('sprintf', $params);
    }
}
