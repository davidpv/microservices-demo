# microservices-demo


## Description
A demo of a blog project with microservices.

All microservices use **MySQL** to store data and **RabbitMQ** as an asyncronous queue system.

## Installation

To initializate all project type `make init`

For help type `make`

## Traefik
Reverse proxy that redirects HTTTP requests to the correct microservice. You can review configuration in the file
compose.yaml and in the traefik folder.


## Microservice Users

A php Symfony's API microservices that manages the users with the following enpoints.

1. GET http://localhost/users  lists all users.
2. POST http://localhost/users creates a user with the following body parameters:
3. PATCH http://localhost/users/{userId}/disable disables a user and triggers the event that notifies the other microservices. 
4. PATCH http://localhost/users/{userId}/enable enable a user and triggers the event that notifies the other microservices. 

When a user is disabled all the posts created by the user are hidden. This action is triggered by a rabbitmq event.

## Microservice Blog

A php Symfony's API microservices that manages the publishing of posts with the following enpoints.

1. GET http://localhost/posts  lists all users.
2. POST http://localhost/posts creates a user with the following body parameters:

## Microservice Mailer

A python script the listen for a rabbitmq queue and send email when triggered by the microservices.

You can check the emails sent in the mailhog manager at http://localhost:8025

## Databases
Each microservices has it's own database. All accesible at:

localhost:33006
user: root
pwd: root

## API
You can use the preconfigured file **api.http** to make all requests of all endpoints

## Links:

- [API Entrypoint](http://localhost/)
- [Mailhog manager](http://localhost:8025/)
- [RabbitMQ manager](http://localhost:15672)




