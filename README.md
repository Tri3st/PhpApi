# README.md

## Basic Auth

The use of the basic Auth aithorization:

Send the header 'Authorization: Basic <credentials>'

Where <credentials> is the base64 encoding of the username and password joined by a single colon.

e.g. 
```shell
martin:test

bWFydGluOnRlc3Q

'Authorization: Basic bWFydGluOnRlc3Q'
```

An online base64 encoder/decoder can be found [here](https://www.base64encode.org).

