<?php

namespace App\Api\App\EventListener;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\Validator\Exception\ValidatorException;

class ApiExceptionListener
{
    /**
     * @var $isKernelDebug bool
     */
    public $isKernelDebug;


    /**
     * ApiExceptionListener constructor.
     *
     * @param bool $isKernelDebug
     */
    public function __construct(bool $isKernelDebug)
    {
        $this->isKernelDebug = $isKernelDebug;
    }

    /**
     * OnKernelException
     *
     * @param GetResponseForExceptionEvent $event
     */
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $throwException = $event->getException();

        $errorBody = [
            'code' => $throwException->getCode(),
            'message' => $throwException->getMessage(),
        ];

        if ($throwException instanceof ValidatorException) {
            $errorBody['message'] = 'Invalid data has been sent';
        }

        if ($this->isKernelDebug) {
            $errorBody['exception'] = [
                'class' => get_class($throwException),
            ];
            $errorBody['trace'] = $throwException->getTrace();
        }

        $event->setResponse(new JsonResponse(['success' => false, 'error' => $errorBody]));
    }
}
