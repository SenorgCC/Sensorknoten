import socket
import json

#@192.168.0.1
s= socket.socket()

host = '192.168.0.23'
port = 12345

s.bind((host, port))

s.listen(5)

msg = 'Thank you for connecting'

while True:
    c, addr = s.accept()
    print('Got connection from ', addr[0])
    data = json.loads(c.recv(4096).decode('utf-8'))
    print('Hostname: ', data["HostName"], 'Wert: ', data["Wert"], 'Grenzwert: ', data["Grenzwert"])
    #s.sendto("1".encode('utf-8'), (host, port))
    c.close()

#
#
#
