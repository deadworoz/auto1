Feature: Get the best vacancy for a candidate
    In order to recommend the best vacancy for a candidate
    As an API user
    I want to get the most interesting position for a candidate with a certain set of skills

    Scenario: Requesting the best vacancy
        When an API client sends a request to "/vacancy/the-best"
        Then the response should be received    
