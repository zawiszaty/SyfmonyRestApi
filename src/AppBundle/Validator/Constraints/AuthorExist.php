<?php

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class AuthorExist extends Constraint
{
    public $message = 'This author exist';

    public function validatedBy()
    {
        return 'author_exist'; // TODO: Change the autogenerated stub
    }

}