#!/bin/bash

function log_info {
        echo -e $(date '+%Y-%m-%d %T')"\e[1;32m $@\e[0m"
}

if [ -z "${MQTT_SERVER}" ]; then
  log_info "MQTT_SERVER variable must be set, exiting"
  exit 1
fi

while true
do
        log_info "Starting Nexus433"
        exec nexus433 -a ${MQTT_SERVER} --verbose -n 17
        sleep 10s
done
