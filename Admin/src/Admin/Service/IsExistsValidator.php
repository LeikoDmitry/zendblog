<?php

namespace Admin\Service;

use Doctrine\Common\Persistence\ObjectRepository;
use DoctrineModule\Validator\ObjectExists;


class IsExistsValidator
{
    protected $validator;
    protected $repository;

    public function __construct(ObjectRepository $objectRepository)
    {
        $this->repository = $objectRepository;
    }

    public function isExists($value, array $fields)
    {
        $this->validator = new ObjectExists([
            'object_repository' => $this->repository,
            'fields' => $fields,
        ]);

        return $this->validator->isValid($value);
    }

}