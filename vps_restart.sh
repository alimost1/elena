#!/bin/bash
WP_CONTAINER=$(docker ps -q -f name=wordpress | head -n 1)
docker restart $WP_CONTAINER
echo "=== CONTAINER $WP_CONTAINER RESTARTED ==="
