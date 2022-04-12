<?php

declare(strict_types=1);

namespace App\Tests\Behat;

use App\Enum\SeniorityLevel;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;

final class VacancyContext implements Context
{
    /** @var KernelInterface */
    private KernelInterface $kernel;

    /** @var Response|null */
    private ?Response $response;

    private ?array $parsedJson = null;

    private array $requestBody = [];

    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * @BeforeScenario
     */
    public function before()
    {
        $this->response = null;
        $this->parsedJson = null;
        $this->requestBody = [];
    }

    /**
     * @When an API client sends a :method request to :path
     */
    public function anApiClientSendsARequestTo(string $path, string $method): void
    {
        $request = Request::create(
            $path,
            $method,
            [],
            [],
            [],
            $method !== 'GET' ? ['CONTENT_TYPE' => 'application/json'] : [],
            $method !== 'GET' ? json_encode($this->requestBody) : null,
        );
        $this->response = $this->kernel->handle($request);
        if ($this->response !== null && $this->response->getStatusCode() < 300) {
            $this->parsedJson = json_decode($this->response->getContent(), true, 512, JSON_THROW_ON_ERROR);
        }
    }

    /**
     * Checks, that current page response status is equal to specified
     * Example: Then the response status code should be 200
     * Example: And the response status code should be 400
     *
     * @Then /^the response status code should be (?P<code>\d+)$/
     */
    public function theResponseStatusCodeShouldBe(string $codeStr): void
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
     * @Then the response contains vacancies
     */
    public function theResponseContainsVacancies(): void
    {
        $this->throwIfNoJson();
        $vacancies = $this->getVacancies();
        if (count($vacancies) === 0) {
            throw new \RuntimeException('No vacancies');
        }
    }

    /**
     * @Then all vacancies contains :city as a city
     */
    public function allVacanciesContainsSpecificCity(string $city): void
    {
        $this->throwIfNoJson();
        $vacancies = $this->getVacancies();
        foreach ($vacancies as $vacancy) {
            $vacancyCity = $vacancy['city'] ?? null;
            if ($city !== $vacancyCity) {
                throw new \RuntimeException('Unexpected city');
            }
        }
    }

    /**
     * @Then all vacancies contains :countryCode as a country
     */
    public function allVacanciesContainsSpecificCountryCode(string $countryCode): void
    {
        $this->throwIfNoJson();
        $vacancies = $this->getVacancies();
        foreach ($vacancies as $vacancy) {
            $vacancyCountryCode = $vacancy['country'] ?? null;
            if ($countryCode !== $vacancyCountryCode) {
                throw new \RuntimeException('Unexpected country');
            }
        }
    }

    /**
     * @Given the request body is:
     */
    public function theRequestBodyIs(PyStringNode $string)
    {
        $this->requestBody = json_decode($string->getRaw(), true, 512, JSON_THROW_ON_ERROR);
    }

    /**
     * @Then the vacancy exists in the response
     */
    public function theVacancyExistsInTheResponse()
    {
        $this->throwIfNoJson();
        $vacancyId = $this->parsedJson['recommendedVacancy']['id'] ?? null;
        if ($vacancyId === null) {
            throw new \RuntimeException('No vacancy');
        }
    }

    /**
     * @Then vacancies are sorted by seniority level
     */
    public function vacanciesAreSortedBySeniorityLevel()
    {
        $this->throwIfNoJson();
        $vacancies = $this->getVacancies();
        $levels = SeniorityLevel::orderedValues();
        $prevPos = -1;
        foreach ($vacancies as $vacancy) {
            $level = $vacancy['seniorityLevel'];
            $pos = array_search($level, $levels, true);
            assert($pos !== false);
            if ($prevPos <= $pos) {
                $prevPos = $pos;
                continue;
            }

            throw new \RuntimeException('Array is not sorted');
        }
    }

    /**
     * @Then vacancies are sorted by salary
     */
    public function vacanciesAreSortedBySalary()
    {
        $this->throwIfNoJson();
        $this->throwIfNoJson();
        $vacancies = $this->getVacancies();        
        $prevSalary = -1;
        foreach ($vacancies as $vacancy) {
            $salary = $vacancy['salary'];            
            if ($prevSalary <= $salary) {
                $prevSalary = $salary;
                continue;
            }

            throw new \RuntimeException('Array is not sorted');
        }
    }

    private function throwIfNoJson(): void
    {
        if ($this->parsedJson === null) {
            throw new \RuntimeException('No json');
        }
    }

    private function getVacancies(): array
    {
        return $this->parsedJson['items'] ?? [];
    }
}
