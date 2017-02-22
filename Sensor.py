from Adafruit_ADS1x15 import ADS1x15
from time import sleep

import time, signal, sys, os, math
import RPi.GPIO as GPIO

import socket
import json

class Sensor:
    # Dictionary für die Zuweisung von ID und Sensorname
    Sensorliste = {0: "Temperatursensor",
                   1: "Flammensensor",
                   2: "Microphon",
                   3: "Erschuetterungssensor",
                   4: "DHT11",
                   5: "Lichtschranke"}

    def __init__(self, Sensor_ID, Digital_PIN):
        self.Sensor_ID = Sensor_ID
        self.Sensor_Name = self.Sensorliste[Sensor_ID]
        self.Digital_PIN = Digital_PIN

    def init_Messung(self):
        GPIO.setmode(GPIO.BCM)
        GPIO.setwarnings(False)
        delayTime = 0.5
        ADS1115 = 0x01
        gain = 4095
        sps = 250
        adc_channel = 0
        adc =ADS1x15(ic=ADS1115)
        GPIO.setup(self.Digital_PIN, GPIO.IN, pull_up_down = GPIO.PUD_OFF)

    #def FlammensensorMessung(self)

