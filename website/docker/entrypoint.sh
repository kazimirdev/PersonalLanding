#!/bin/bash
set -e

# Substitute environment variables in SQL file using sed
sed "s/\${DB_NAME}/$DB_NAME/g" /docker-entrypoint-initdb.d/create_schema.sql > /docker-entrypoint-initdb.d/init.sql

# Continue with MySQL startup
exec "$@"
