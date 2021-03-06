from Adafruit_ADS1x15 import ADS1x15
import Adafruit_DHT
from time import sleep
import time, signal, sys, os, math
import RPi.GPIO as GPIO
import smbus
import socket
import json

class Sensor:
    # Dictionary fuer die Zuweisung von ID und Sensorname
    # Sensorliste = {1: "Temperatursensor",
    #              2: "Luftfeuchtigkeit",
    #              3: "Flammensensor",
    #              4: "Lichtschranke",
    #              5: "Mikrofon",
    #              6: "Lichtsensor"
    #              7: "Schocksensor"}

    def __init__(self, SEN_ID, Analog_PIN, Digital_PIN):
        self.SEN_ID = SEN_ID
        self.Sensorname = socket.gethostname()
        self.Messwert = ""
        self.Status = 0
        self.Analog_PIN = Analog_PIN
        self.Digital_PIN = Digital_PIN
        GPIO.setmode(GPIO.BCM)
        GPIO.setwarnings(False)
        if Digital_PIN:
            GPIO.setup(self.Digital_PIN, GPIO.IN, pull_up_down=GPIO.PUD_OFF)
        # Umsetzung mit dem pcf8591 AD-Wandler
        self.bus = smbus.SMBus(1)
        self.address = 0x48

    def cleanup(self):
        GPIO.cleanup()

    def add_event_flammensensor(self):
        GPIO.add_event_detect(self.Digital_PIN, GPIO.BOTH, callback=self.flammen_mikro_event, bouncetime=100)

    def add_event_mikrofon(self):
        GPIO.add_event_detect(self.Digital_PIN, GPIO.BOTH, callback=self.flammen_mikro_event, bouncetime=100)

    def eventhandler(self, null):
        self.Status = 1
        sensor_information = {"Name": self.Sensorname,
                              "SEN_ID": self.SEN_ID,
                              "Status": self.Status,
                              "Messwert": "TRUE"}
        json_data = json.dumps(sensor_information)
        self.senden(json_data)

    def flammen_mikro_event(self, null):
        self.Status = 1
        self.bus.write_byte(self.address, self.Analog_PIN)
        Analog_Wert = self.bus.read_byte(self.address)
        Digital_Wert = GPIO.input(self.Digital_PIN)
        if Digital_Wert == 1:
            if Analog_Wert < 255:
                sensor_information = {"Name": self.Sensorname,
                                      "SEN_ID": self.SEN_ID,
                                      "Status": self.Status,
                                      "Messwert": "TRUE"}
                json_data = json.dumps(sensor_information)
                self.senden(json_data)
                return
            elif Analog_Wert == 255:
                self.Status = 2
                sensor_information = {"Name": self.Sensorname,
                                      "SEN_ID": self.SEN_ID,
                                      "Status": self.Status,
                                      "Messwert": "0"}
                json_data = json.dumps(sensor_information)
                self.senden(json_data)
        else:
            self.Status = 1
            sensor_information = {"Name": self.Sensorname,
                                  "SEN_ID": self.SEN_ID,
                                  "Status": self.Status,
                                  "Messwert": "FALSE"}
            json_data = json.dumps(sensor_information)
            self.senden(json_data)

    def sensorcheck_analog(self):
        try :
            self.bus.write_byte(self.address, self.Analog_PIN)
            if self.bus.read_byte(self.address) > 0:
                return True
            else:
                return False
        except IOError:
            return False
    def flammensensor(self):
        if self.sensorcheck_analog():
            self.Status = 1
            self.bus.write_byte(self.address, self.Analog_PIN)
            Analog_Wert = self.bus.read_byte(self.address)
            Digital_Wert = GPIO.input(self.Digital_PIN)

            if Digital_Wert == 1 and Analog_Wert < 255:
                sensor_information = {"Name": self.Sensorname,
                                      "SEN_ID": self.SEN_ID,
                                      "Status": self.Status,
                                      "Messwert": "TRUE"}
                json_data = json.dumps(sensor_information)
                self.senden(json_data)
                return
            elif Digital_Wert == 1 and Analog_Wert == 255:
                self.Status = 2
                sensor_information = {"Name": self.Sensorname,
                                      "SEN_ID": self.SEN_ID,
                                      "Status": self.Status,
                                      "Messwert": "0"}
                json_data = json.dumps(sensor_information)
                self.senden(json_data)
                return
            else:
                return

        else:
            self.Status = 0
            sensor_information = {"Name": self.Sensorname,
                                  "SEN_ID": self.SEN_ID,
                                  "Status": self.Status,
                                  "Messwert": "0"}
            json_data = json.dumps(sensor_information)
            self.senden(json_data)
            return

    def temperatur(self):
        # humidity, temperatur = Adafruit_DHT.read_retry(11, 4)
        # Read_Retry versucht innerhalb von 15 Sekunden Messungen durchzufuehren und gibt das Ergebnis aus
        # als ein array, wo humidity, temp angegeben werden
        temperatur = Adafruit_DHT.read_retry(11, self.Digital_PIN)[1]
        # Die Messtemperatur muss zwischen 0 und 50C liegen, sonst ist der Sensor defekt
        if 0 < temperatur <= 50:
            self.Status = 1
            self.Messwert = str(temperatur)
        elif not temperatur:
            self.Status = 0
            self.Messwert = 0
        else:
            self.Status = 2
            self.Messwert = 0

        sensor_information = {"Name": self.Sensorname,
                              "SEN_ID": self.SEN_ID,
                              "Status": self.Status,
                              "Messwert": str(self.Messwert)}
        json_data = json.dumps(sensor_information)
        self.senden(json_data)

    def luftfeuchtigkeit(self):
        humidity = Adafruit_DHT.read_retry(11, self.Digital_PIN)[0]
        # Die Messtemperatur muss zwischen 0 und 50C liegen, sonst ist der Sensor defekt
        if 0 < humidity <= 95:
            self.Status = 1
            self.Messwert = str(humidity)
        elif not humidity:
            self.Status = 0
            self.Messwert = 0
        else:
            self.Status = 2
            self.Messwert = 0

        sensor_information = {"Name": self.Sensorname,
                              "SEN_ID": self.SEN_ID,
                              "Status": self.Status,
                              "Messwert": str(self.Messwert)}
        json_data = json.dumps(sensor_information)
        self.senden(json_data)

    def mikrofon(self):
        if self.sensorcheck_analog():
            self.Status = 1
            self.bus.write_byte(self.address, self.Analog_PIN)
            analog_wert = self.bus.read_byte(self.address)

            Digital_Wert = GPIO.input(self.Digital_PIN)
            if Digital_Wert == 1 and analog_wert < 255:
                sensor_information = {"Name": self.Sensorname,
                                      "SEN_ID": self.SEN_ID,
                                      "Status": self.Status,
                                      "Messwert": "TRUE"}
                json_data = json.dumps(sensor_information)
                self.senden(json_data)
                return

            elif Digital_Wert == 1 and analog_wert == 255:
                self.Status = 2
                sensor_information = {"Name": self.Sensorname,
                                      "SEN_ID": self.SEN_ID,
                                      "Status": self.Status,
                                      "Messwert": 0}
                json_data = json.dumps(sensor_information)
                self.senden(json_data)
                return
            else:
                return

        else:
            self.Status = 0
            sensor_information = {"Name": self.Sensorname,
                                  "SEN_ID": self.SEN_ID,
                                  "Status": self.Status,
                                  "Messwert": 0}
            json_data = json.dumps(sensor_information)
            self.senden(json_data)
            return

    def lichtsensor(self):
        if self.sensorcheck_analog():
            self.bus.write_byte(self.address, self.Analog_PIN)
            analog_wert = self.bus.read_byte(self.address)
            if 20 < analog_wert <= 145:
                self.Messwert = "TRUE"
                self.Status = 1
            else:
                self.Messwert = "FALSE"
                self.Status = 1

            sensor_information = {"Name": self.Sensorname,
                                  "SEN_ID": self.SEN_ID,
                                  "Status": self.Status,
                                  "Messwert": self.Messwert}
            json_data = json.dumps(sensor_information)
            self.senden(json_data)
        else:
            self.Messwert = 0
            self.Status = 2
            sensor_information = {"Name": self.Sensorname,
                                  "SEN_ID": self.SEN_ID,
                                  "Status": self.Status,
                                  "Messwert": self.Messwert}
            json_data = json.dumps(sensor_information)
            self.senden(json_data)

            return

    def lichtschranke(self):
        # Eventgesteuertes Ereigniss wird mit der fallenden Flanke ausgeloest
        GPIO.add_event_detect(self.Digital_PIN, GPIO.FALLING, callback=self.eventhandler, bouncetime=100)

    def schocksensor(self):
        # Eventgesteuertes Ereigniss wird mit der fallenden Flanke ausgeloest
        GPIO.add_event_detect(self.Digital_PIN, GPIO.FALLING, callback=self.eventhandler, bouncetime=100)

    def senden(self, json_data):
        s = socket.socket()
        host = '192.168.178.1'
        port = 12345
        try:
            s.connect((host, port))
            s.sendto(json_data.encode('utf-8'), (host, port))
            s.close()
        except socket.error:
            print("Server nicht erreichbar!")
            return