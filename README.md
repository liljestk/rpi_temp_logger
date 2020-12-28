# Raspberry Pi based wireless temperature and humidity logger

To be used for wirelessly logging temperature and humidity data. The connection between sender and receiver is not encrypted or in any way regulated; new devices may be added without any additional configuration. This does however mean that multiple systems of this setup may interfere with one another as the receiver will pick up any sender within range.

![grafana example](https://github.com/liljestk/rpi_temp_logger/blob/main/images/grafana_example.png)

## Docker and Docker-Compose Required 

## Based on the following open-source repositories
- https://github.com/Brassn/nexus433-docker
- https://github.com/aquaticus/nexus433

## Setup
1. Check HW setup on https://github.com/aquaticus/nexus433
2. Clone the repository
3. Rename the .env_template as .env
4. Edit the .env file (add passwords etc.)
5. CD into the directory
6. Run "sudo chown -R 472:472 data/" to set permissions for Grafana
7. Run docker-compose up -d --build

## Services
### Bridge
- Runs the nexus433 service that listens on 433MHz senders
### MQTT
- Mosquitto service the relay the 433MHz sender messages
### Listener
- A Node application that stores the 433MHz data in both MySQL and CSV
### MySQL
- Used to store the data
### Samba 
- Used to create a network share for the collected data
### Grafana
- Used to visualize the data
### Renamer
- Used for renaming the devices as they tend to change device id when the batteries are depleted
### Adminer 
- Direct database access, used if needed

## Notes
- The initial database setup creates a user for the listener service: check db/create_db.sql
