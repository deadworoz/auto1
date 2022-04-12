Feature: Get vacancies by a certain location
    In order to show list of vacancies
    As an API user
    I want to find all positions at a certain location (by country or by city)
    and be able to sort by seniority level and salary (ascending order only)

    Scenario: Requesting list of vacancies in Berlin
        When an API client sends a GET request to "/vacancy/by-city/Berlin?sortBy=seniorityLevel"
        Then the response status code should be 200
        And the response contains vacancies
        And all vacancies contains Berlin as a city
        And all vacancies contains DE as a country
        And vacancies are sorted by seniority level

    Scenario: Requesting list of vacancies in Spain
        When an API client sends a GET request to "/vacancy/by-country/ES"
        Then the response status code should be 200
        And the response contains vacancies
        And all vacancies contains ES as a country

    Scenario: Requesting list of vacancies in Germany that is sorted by salary
        When an API client sends a GET request to "/vacancy/by-country/DE?sortBy=salary"
        Then the response status code should be 200
        And the response contains vacancies
        And all vacancies contains DE as a country
        And vacancies are sorted by salary

    Scenario: Requesting list of vacancies in not existing country
        When an API client sends a GET request to "/vacancy/by-country/XX?sortBy=salary"
        Then the response status code should be 400        
