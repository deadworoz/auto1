Feature: Get vacancy information by its ID
    In order to show detailed information about a vacancy
    As an API user
    I need to get information about a certain position by its ID

    Scenario: Requesting information about position with ID 21
        When an API client sends a GET request to "/api/vacancy/21"
        Then the response status code should be 200
