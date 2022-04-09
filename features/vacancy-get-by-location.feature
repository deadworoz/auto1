Feature: Get vacancies by a certain location
    In order to show list of vacancies
    As an API user
    I want to find all positions at a certain location (by country or by city)
    and be able to sort by seniority level and salary (ascending order only)

    Scenario: Requesting list of vacancies in Berlin
        When an API client sends a request to "/vacancy?city=Berlin"
        Then the response should be received

    Scenario: Requesting list of vacancies in Spain
        When an API client sends a request to "/vacancy?country=ES"
        Then the response should be received

    Scenario: Requesting list of vacancies in Germany that is sorted by salary
        When an API client sends a request to "/vacancy?country=ES&sortedBy=salary"
        Then the response should be received

    Scenario: Requesting list of vacancies in Germany that is sorted by seniority level
        When an API client sends a request to "/vacancy?country=ES&sortedBy=level"
        Then the response should be received
