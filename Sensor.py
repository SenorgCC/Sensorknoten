from Adafruit_ADS1x15 import ADS1x15
from time import sleep

import time, signal, sys, os, math
import RPi.GPIO as GPIO

import socket
import json

class Sensor:
    # Dictionary für die Zuweisung von ID und Sensorname
    #Sensorliste = {1: "Temperatursensor",
    #              2: "Luftfeuchtigkeit",
    #              3: "Flammensensor",
    #              4: "Lichtschranke",
    #              5: "Mikrofon",
    #              6: "Lichtsensor"
    #              7: "Schocksensor"}

    def __init__(self, SEN_ID, Analog_PIN, Digital_PIN):
        self.SEN_ID = SEN_ID
        self.Sensorname = socket.gethostname()
        self.Messwert=""
        self.Status=0
        self.Analog_PIN = Analog_PIN
        self.Digital_PIN = Digital_PIN


    def init_messung(self):
        GPIO.setmode(GPIO.BCM)
        GPIO.setwarnings(False)
        delayTime = 0.5
        ADS1115 = 0x01
        self.gain = 4095
        self.sps = 250
        self.adc_channel = self.Analog_PIN
        self.adc =ADS1x15(ic=ADS1115)
        GPIO.setup(self.Digital_PIN, GPIO.IN, pull_up_down = GPIO.PUD_OFF)

    # Auf der Leitung liegt immer eine gewisse spannung, im Bereich von 300 - 400 mV, diese muss ausgegrenzt werden
    def sensorcheck_analog(self):
        if self.adc.readADCSingleEnded(self.adc_channel, self.gain, self.sps) > 450:
            return True
        else:
            return False

    def flammensensor(self):
        if self.SensorCheck_Analog():
            self.Status = 1

            Analog_Wert = self.adc.readADCSingleEnded(self.adc_channel, self.gain, self.sps)
            Digital_Wert = GPIO.input(self.Digital_PIN)

            if Digital_Wert == 1 and Analog_Wert < 3250 :
                sensor_information = {"Name": self.Sensorname,
                                      "SEN_ID": self.SEN_ID,
                                      "Status": self.Status,
                                      "Messwert": str(Digital_Wert)}
                json_data = json.dumps(sensor_information)
                self.senden(json_data)
                return
            #TODO: Genauen Ruhespannungwert des Flammensensors nachschauen! 3300 ist nicht genau
            elif Digital_Wert == 1 and Analog_Wert == 3300 :
                self.Status = 2
                #TODO: Abstimmung welche Daten bei defektem Sensor gesendet werden sollen
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

    def temperatur(self):

    def luftfeuchtigkeit(self):

    def mikrofon(self):
        #TODO: mikrofon funktioniert eigentlich wie ein flammensensor ! Anschauen Wann er Daten senden soll
        self.flammensensor()
    def lichtsensor(self):
    def lichtschranke(self):
    def schocksensor(self):
        #TODO: Erste idee muss net stimmen! Überprüfen!
        GPIO.add_event_detect(self.GPIO_PIN, GPIO.FALLING, callback = verarbeitungsFkt, bouncetime=100)
        def verarbeitungsFkt():
            self.Status = 1
            sensor_information = {"Name": self.Sensorname,
                                  "SEN_ID": self.SEN_ID,
                                  "Status": self.Status,
                                  "Messwert": "TRUE"}
            json_data = json.dumps(sensor_information)
            self.senden(json_data)


    def senden(self,json_data):
        s = socket.socket()
        host = '192.168.178.1'
        #TODO: Anstendigen Port aussuchen !
        port = 12345
        s.connect((host, port))
        s.sendto(json_data.encode('utf-8'), (host, port))
        #TODO: Überlegen, ob bei Flammensensor ACK angebracht wäre
        s.close()
