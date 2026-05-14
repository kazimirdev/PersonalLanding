#!/bin/bash
set -e

# Substitute environment variables in SQL file
envsubst < /docker-entrypoint-initdb.d/create_schema.sql > /docker-entrypoint-initdb.d/init.sql

# Continue with MySQL startup
exec "$@"
