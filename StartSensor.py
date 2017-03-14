from sensor import Sensor
import time
# Dieses Programm dient zum Initialisieren und Steuern von Sensoren
# Initialisierung des Sensors
# Sensor(SEN_ID, Analog_PIN, Digital_PIN)
# Zuweisung der Analoganschluesse fuer den ADWandler

A0 = 0x40
A1 = 0x41
A2 = 0xA2
A3 = 0xA3
# Inialisierung der Sensoren
# DHT11 - Luftfeuchtigkeit und Temperatur
sensor1 = Sensor(1, None, 25)
sensor2 = Sensor(2, None, 25)
# Flammensensor KY-026
sensor3 = Sensor(3, A1, 17)
# Lichtschranke KY-010
sensor4 = Sensor(4, None, 24)
# Mikrofon KY-038
sensor5 = Sensor(5, A0, 18)
# Lichtsensor KY-018
sensor6 = Sensor(6, A2, None)
# Schocksensor TAP-Module
sensor7 = Sensor(7, None, 5)

# Initialisierung eventgesteuerte Sensoren
sensor3.add_event_mikrofon()
sensor4.lichtschranke()
sensor5.add_event_flammensensor()
sensor7.schocksensor()

counter = 0

try:
    while True:
        sensor5.mikrofon()
        sensor3.flammensensor()
        if counter == 2:
            sensor6.lichtsensor()
        if counter == 4:
            sensor1.temperatur()
            sensor2.luftfeuchtigkeit()
            counter = 0
        counter += 1
        time.sleep(2)

except KeyboardInterrupt:
    print("KeyBoard Interrupt!")
    print("Cleaning up GPIO")
    sensor1.cleanup()
    sensor2.cleanup()
    sensor3.cleanup()
    sensor4.cleanup()
    sensor5.cleanup()
    sensor6.cleanup()
    sensor7.cleanup()
    print("Programm terminated!")