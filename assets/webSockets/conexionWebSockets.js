var conn;
var reconnectInterval = 1000; // Tiempo de espera para reconectar en milisegundos, por ejemplo, 5 segundos.
var reconnecting = false;

function connect() {
   conn = new WebSocket("ws://192.168.1.145:8000"); // Cambia la dirección IP y el puerto a tu configuración
  //conn = new WebSocket("ws:172.31.87.8:8000")
  conn.onopen = function () {
    console.log("Conexión establecida");
    console.log("al grupo que pertenesco", idgrupo)
    conn.send(
      JSON.stringify({
        action: "ladding",
        data: {
          rut: rut,
          name: name,
          idgrupoibelong: idgrupo,
          email: email,
          idestado:6
        },
      })
    );
    reconnecting = false;
  };

  conn.onclose = function (e) {
    console.log("Conexión cerrada. Intentando reconectar...");
    reconnect();
  };

  conn.onerror = function (error) {
    console.error("Error en la conexión", error);
    reconnect();
  };
}

function reconnect() {
  if (!reconnecting) {
    reconnecting = true;
    setTimeout(connect, reconnectInterval);
  }
}

// Iniciar la conexión por primera vez.
connect();
