#!/bin/bash

# Get token from our api
curl -X POST -H 'Accept: application/json; indent=4' -H 'Content-Type:application/json' -d '{"username":"martin", "password":"test"}' http://127.0.0.1:8000/api-token-auth
