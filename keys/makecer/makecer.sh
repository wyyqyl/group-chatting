#!/bin/sh
openssl req -new -out server.csr
openssl rsa -in privkey.pem -out server.key
openssl x509 -in server.csr -out server.crt -req -signkey server.key -days 365
