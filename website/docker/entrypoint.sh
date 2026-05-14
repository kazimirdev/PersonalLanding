#!/bin/bash
set -e

# Check if source SQL file exists and process it
if [ -f "/tmp/create_schema.sql" ]; then
    sed "s/\${DB_NAME}/$DB_NAME/g" /tmp/create_schema.sql > /docker-entrypoint-initdb.d/create_schema.sql
fi

# Continue with MySQL startup
exec "$@"
