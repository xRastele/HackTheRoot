# HackTheRoot
A web application designed for learning cybersecurity through basic Capture The Flag (CTF) challenges

## Prerequisites

To operate this application, it's essential to have the following tool installed:

- Docker: For detailed installation instructions, visit [this link](https://docs.docker.com/get-docker/).

## Setup

1. Begin by cloning this repository onto your local machine: `git clone https://github.com/xRastele/HackTheRoot.git`

2. Navigate into the cloned repository: `cd HackTheRoot`

3. Start the application using the following command: `docker-compose up`

## Launching

Upon a successful initiation of the application with the `docker-compose up` command, you can access your website at:

[http://localhost:8080](http://localhost:8080)

## Customization

If you want to tailor Docker settings to your preferences, you can make adjustments by modifying the files `docker-compose.yml`, `nginx/nginx.conf`, or the `Dockerfile` located within the `php` and `nginx` directories.
