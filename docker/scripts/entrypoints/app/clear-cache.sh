#!/bin/bash
set -e

redis-cli -h "$REDIS_HOST" -p "$REDIS_PORT" flushall
