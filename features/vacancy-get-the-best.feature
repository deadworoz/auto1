Feature: Get the best vacancy for a candidate
    In order to recommend the best vacancy for a candidate
    As an API user
    I want to get the most interesting position for a candidate with a certain set of skills

    Scenario: Requesting the best vacancy
        Given the request body is:
          """
          {
              "skills": ["Java", "J2SE", "Spring", "Bamboo", "Docker"],
              "seniorityLevel": "Senior",
              "wantsToLieLowInBruges": false
          }
          """
        When an API client sends a POST request to "/api/vacancy/the-best"
        Then the response status code should be 200
        And the vacancy exists in the response

    Scenario: Bad request
        Given the request body is:
          """
          {
              "skills": ["Java", "J2SE", "Spring", "Bamboo", "Docker"],
              "seniorityLevel": "Cool Bro",
              "wantsToLieLowInBruges": 1
          }
          """
        When an API client sends a POST request to "/api/vacancy/the-best"
        Then the response status code should be 400        
