var mqtt = require('mqtt')
var client  = mqtt.connect('mqtt://mqtt')
const fs = require('fs');
var mysql = require('mysql');
 
client.on('connect', function () {
  client.subscribe('nexus433/#', function (err) {
    if (!err) {
      client.publish('presence', 'Hello mqtt')
    }
  })
})
 
client.on('message', function (topic, message, packet) {
  // message is Buffer
  if( message.toString() !== 'online' ){ 
    try{
      message = JSON.parse(message.toString());
      const topicName = topic.split('/')[2];
      const temp = String(message['temperature']);
      const hum = message['humidity'];
      const battery = message['battery'];
      const date = new Date();
      const cDate = date.getFullYear() + '-' + (date.getMonth() + 1) + '-' + 
                    date.getDate() + ' ' + date.getHours() + ':' + 
                    date.getMinutes() + ':' + date.getSeconds();
      var con = mysql.createConnection({
        host: "db",
        user: "tempuser",
        password: "#v5$$BjKzVy2YuS4m2P!rGER",
        database: "temps"
      });
      con.connect(function(err) {
        if (err){
          throw err;
        }
        // get the device ID if exists
        var deviceID = null;
        var getDeviceSQL = "SELECT id as id FROM device WHERE device_name = '" + topicName + "' AND deleted != 1 limit 1";
        con.query(getDeviceSQL, function (err, result) {
          if (err){ 
            con.end();
            throw err;
          } else if ( result.length === 0 || result[0].id === undefined ){
            var createDeviceSQL = "INSERT INTO device (device_name) VALUES ('"+topicName+"')";
            con.query(createDeviceSQL, function (err, result) {
                deviceID = result.insertId;
            });
          } else if ( result[0].id !== undefined ) {
            deviceID = result[0].id;
          }
          writeToDB(con, deviceID, temp, hum, battery);
        });

        var today = date.getFullYear() + '-' + addZ(date.getMonth() + 1) + '-' + addZ(date.getDate());
        var thisMonth = date.getFullYear() + '-' + addZ(date.getMonth() + 1);
        var dir = 'data/'+thisMonth;
        if (!fs.existsSync(dir)){
            fs.mkdirSync(dir);
        }
        var stream = fs.createWriteStream(dir+"/temp-" + today + ".csv", {flags:'a'});
        stream.write(cDate + ";" + topicName + ";" + temp.replace('.',',') + ";" + hum + "\n");
        stream.end();       
      });
    } catch( e ){

    }
  }
})

function writeToDB(con, deviceID, temp, hum, battery){
  var sql = "INSERT INTO temp (device_id, temp, hum, battery) VALUES ("+deviceID+", "+temp+", "+hum+", "+battery+")";
  con.query(sql, function (err, result) {
    if (err){ 
      con.end();
      throw err;
    }
    con.end();
  });
}

function addZ(n){return n<10? '0'+n:''+n;}