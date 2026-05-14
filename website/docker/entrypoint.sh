#!/bin/bash
set -e

# Substitute environment variables and copy to init directory
sed "s/\\\${DB_NAME}/$DB_NAME/g" /config/create_schema.sql > /docker-entrypoint-initdb.d/01-create_schema.sql

# Run the original MySQL entrypoint
exec /usr/local/bin/docker-entrypoint.sh "$@"
