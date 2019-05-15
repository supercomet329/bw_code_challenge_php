Brightwheel code challenge

# Overview

- Service to accept POST requests to /email
  - Can swap out email providers (currently support mailchimp and mailgun)
  - All fields are required (to, to_name, from, from_name, email, subject, body)
  - Validates email (checks if there's a '@' in the field)

# Installation

- ensure you have a way to run php 7+ (brew install php, or some other method)
- ensure you have composer installed (https://getcomposer.org/download/)
- run `composer install` to install the dependencies (defined in package.{json|lock})

# Setup
- run `cp config/autoload/email_config.local.php.dist config/autoload/email_config.local.php`
- Change values in email_config.local.php
    - MAILCHIMP_API_KEY -> your mailchimp API key
    - SENDING_DOMAIN -> your mailgun sending domain
    - MAILGUN_API_KEY -> your mailgun API key
    
# Running the app
- run `composer run serve --timeout=0`
- Make a POST request to http://localhost:8080/email
  - Example request
    curl -X "POST" "http://localhost:8080/email" \
         -H 'Content-Type: application/json' \
         -d $'{
      "from": "noreply@mybrightwheel.com",
      "body": "<h1>Your Bill</h1><p>$10</p>",
      "to": "fake@example.com",
      "subject": "A Message from Brightwheel",
      "from_name": "Brightwheel",
      "to_name": "Mr. Fake"
    }'
- To change the email provider, change the `current_provider` value to either `mailchimp` or `mailgun`    

# Testing the app
- run `composer test`


# Other info

- I chose PHP, and the [Zend Expressive Framework](https://docs.zendframework.com/zend-expressive/)
I'm familiar with PHP for my day-to-day work. I chose Expressive, because I think using middleware
to build an app is helpful for being able to separate concerns, and compose new functionality. 

- Things I left out: 
    - async or queueing processing. Ideally, in production, we'd get a request, and respond immediately, and then do the actual sending asynchronously 
    - any sort of front end, or a way to interact with the service other than directly with HTTP
