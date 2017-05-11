#!/usr/bin/python
# coding=utf-8
import socket
import json
import MySQLdb as mdb
import sys

s = socket.socket()
host = '192.168.178.1'
port = 12345
s.bind((host, port))
s.listen(5)
msg = 'Thank you for connecting'
while True:
    c, addr = s.accept()
    print('Got connection from ', addr)
    data = json.loads(c.recv(4096).encode('utf-8'))
    Name = str(data["Name"])
    SEN_ID = str(data["SEN_ID"])
    Wert = str(data["Messwert"])
    adresse = str(addr[0])
    try:
        con = mdb.connect('localhost', 'root', 'Piroot', 'Sicherheitssystem')
        print("SQL-Connection successful")
    except _mysql.Error, e:
        print("SQL-Connection failed. Error %d: %s" % (e.args[0], e.args[1]))
    with con:
        cur = con.cursor()
        row_count = cur.execute("SELECT KN_ID FROM Sensorknoten WHERE Knotennamen = %s", (Name,))
        # Wenn ein Datenbankeintrag gefunden wird, wird die IPv4_Adresse erneuert
        if row_count == 1:
            KN_ID = cur.fetchone()
            cur.execute("""UPDATE Sensorknoten SET IPv4_Adresse = %s WHERE Knotennamen = %s""", (adresse, Name))
            cur.execute("""INSERT INTO Messwerte (SEN_ID, Messwert)VALUES(%s, %s)""", (SEN_ID, Wert))
            # Die zuletzt erstellte ID wird übergeben
            MessID = cur.lastrowid
            cur.execute("""INSERT INTO Sensorknoten_Messwerte (KN_ID, MESS_ID)VALUES(%s, %s)""", (KN_ID, MessID))
        # Wenn kein Datenbankeintrag gefunden wird, wird ein neuer Datenbankeintrag erstellt
        elif row_count == 0:
            cur.execute("""INSERT INTO Sensorknoten (Knotennamen, IPv4_Adresse)VALUES(%s, %s)""", (Name, adresse))
            # Die zuletzt erstellte ID wird übergeben
            KN_ID = cur.lastrowid
            cur.execute("""INSERT INTO Messwerte (SEN_ID, Messwert)VALUES(%s, %s)""", (SEN_ID, Wert))
            # Die zuletzt erstellte ID wird übergeben
            MessID = cur.lastrowid
            cur.execute("""INSERT INTO Sensorknoten_Messwerte (KN_ID, MESS_ID)VALUES(%s, %s)""", (KN_ID, MessID))
    con.close()
