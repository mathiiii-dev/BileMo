<?php

namespace App\Service;

use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Response;

class ResponseService
{
    private SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public function setUpResponse($data, string $groups): Response
    {
        return new Response($this->serializer->serialize(
            $data, 'json', SerializationContext::create()->setGroups([$groups])
        ));
    }
}
