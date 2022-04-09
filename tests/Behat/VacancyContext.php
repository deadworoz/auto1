<?php

declare(strict_types=1);

namespace App\Tests\Behat;

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;

final class VacancyContext implements Context
{
    /** @var KernelInterface */
    private $kernel;

    /** @var Response|null */
    private $response;

    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * @When an API client sends a request to :path
     */
    public function anApiClientSendsARequestTo($path)
    {
        $this->response = $this->kernel->handle(Request::create($path, 'GET'));
    }

    /**
     * Checks, that current page response status is equal to specified
     * Example: Then the response status code should be 200
     * Example: And the response status code should be 400
     *
     * @Then /^the response status code should be (?P<code>\d+)$/
     */
    public function theResponseStatusCodeShouldBe($codeStr): void
    {
        $code = (int) $codeStr;
        if ($this->response === null) {
            throw new \RuntimeException('No response received');
        }
        
        $got = $this->response->getStatusCode();        
        if ($this->response->getStatusCode() !== $code) {
            throw new \RuntimeException("Unexpected status code. Got {$got}");
        }
    }
    
    /**
     * @Then the response should be received
     */
    public function theResponseShouldBeReceived(): void
    {
        if ($this->response === null) {
            throw new \RuntimeException('No response received');
        }
    }
}
